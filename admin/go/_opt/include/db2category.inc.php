<?php 
require_once("include/ftp.inc.php");


class db2Category {
	private $catTree=array();
	private $processed=0;
	private $finished=false;
	private $where='active=1';
	/**
	 * Konstruktor klasy
	 *
	 * @param string $where dodatkowy warunek dla zapytania
	 * @param string $path sciezka zapisywanego pliku kategorii
	 * @param string $filename nazwa zapisywanego pliku kategorii
	 */
	public function __construct($where='',$path="/config/tmp", $filename="category.php") {
		global $config;

		$this->filename=$filename;

		$this->path=$path;

		if (!empty($where)) {
			$this->where.=" AND $where";
		}


	}

	public function optimize()
	{
		global $db, $lang, $stream;

	$sql="SELECT DISTINCT
			main.category1,main.id_category1,
			main.category2,main.id_category2,
			main.category3,main.id_category3,
			main.category4,main.id_category4,
			main.category5,main.id_category5 FROM main             
			LEFT JOIN category1 ON main.id_category1 = category1.id
            LEFT JOIN category2 ON main.id_category2 = category2.id
            LEFT JOIN category3 ON main.id_category3 = category3.id
            LEFT JOIN category4 ON main.id_category4 = category4.id
            LEFT JOIN category5 ON main.id_category5 = category5.id
            WHERE $this->where 
            ORDER BY
			category1.ord_num,main.category1,
            category2.ord_num,main.category2,
            category3.ord_num,main.category3,
            category4.ord_num,main.category4,
            category5.ord_num,main.category5
            ";

		$res=$db->Query($sql);
		
		$num_rows=$db->NumberOfRows($res);
		
		for ($i=0; $i < $num_rows; $i++)
		{
			for ($j=1; $j <= 5; $j++)
			{
				$row["category$j"]=$db->FetchResult($res, $i, "category$j");
				$row["id_category$j"]=$db->FetchResult($res, $i, "id_category$j");
			}
			$stream->line_green();
			flush();
			ob_flush();
			$this->createTree($this->catTree,$row);
		}
		$this->saveToFile();
	}

	public function saveToFile()
	{
		global $DOCUMENT_ROOT;

		$php_content="<?php global \$category,\$__category;\n\$category=".var_export($this->catTree,true).";\n\$__category=\$category;\n?>";

		if (!file_put_contents($DOCUMENT_ROOT."/tmp/".$this->filename,$php_content))
		echo "blad podczas tworzenia pliku!";
		else
		{
			global $config;
			$ftp=new FTP();
			$ftp->connect();
	
			$ftp->put($DOCUMENT_ROOT."/tmp/".$this->filename,$config->ftp['ftp_dir'].$this->path,$this->filename);
			@unlink($DOCUMENT_ROOT."/tmp/".$this->filename);
			unset($ftp);
		}
	}
	/**
	 * Tworzy drzewo kategorii od danego poziomu zagniezdzenia
	 *
	 * @param array $catTab tablica zawierajaca cale drzewo kategorii
	 * @param int $nestLevel poziom zagniezdzenia kategorii
	 * @return array zwraca tablice zawierajaca drzewo kategorii
	 */
	private function createCategory($catTab, $nestLevel)
	{
		$subCat=array();

		if ($this->checkCategory($catTab,$nestLevel))
		{
			$treeKey=$this->genTreeId($catTab, $nestLevel);
			$catName=$catTab['category'.$nestLevel];
			if ($this->checkCategory($catTab,$nestLevel+1))
			{
				if ($nestLevel==1)
				{
					$subCat=array($treeKey=>array("name"=>$catName,"elements"=>array()));
					$subCat[$treeKey]["elements"]=$this->createCategory($catTab,$nestLevel+1);
				}
				else
				{
					$subCat[0]=array($treeKey=>array("name"=>$catName,"elements"=>array()));
					$subCat[0][$treeKey]["elements"]=$this->createCategory($catTab,$nestLevel+1);
				}
			}
			elseif ($nestLevel==1)
			{
				$subCat=array($treeKey=>array("name"=>$catName,"elements"=>array()));
				$subCat[$treeKey]["elements"]=array();
			}
			else
			{
				$subCat[$catName]=$treeKey;
			}
		}

		return $subCat;
	}

	/**
	 * Tworzy drzewo kategorii
	 *
	 * @param array $catTree tablica zawierajaca cale drzewo kategorii
	 * @param array $catTab tablica kategorii danego produktu
	 * @param int $nestLevel poziom zagniezdzenia kategorii
	 */
	private function createTree(&$catTree, $catTab, $nestLevel=1)
	{
		$keyExists=false;
		if ($this->checkCategory($catTab,$nestLevel))
		{
			$treeKey=$this->genTreeId($catTab, $nestLevel);
			if (empty($catTree))
			{
				$catTree=$this->createCategory($catTab, $nestLevel);
			} else {
				foreach ($catTree as $key=>$val)
				{
					if (is_array($val))
					{
						if (is_numeric($key))
						{

							if (isset($val[$treeKey]))
							{
								$keyExists=true;
								$this->createTree($catTree[$key][$treeKey]["elements"],$catTab,$nestLevel+1);
							}
						}
						else
						if ($key==$treeKey)
						{
							$keyExists=true;
							$this->createTree($catTree[$key]["elements"],$catTab,$nestLevel+1);
						}
					}
					elseif ($val==$treeKey)
					{
						$keyExists=true;
						$catName=$catTab['category'.$nestLevel];
						$subCat=$this->createCategory($catTab, $nestLevel);

						if (isset($subCat[0][$treeKey]["elements"]) || isset($subCat[$treeKey]["elements"]))
						{
							unset($catTree[$key]);
							$catTree=array_merge($catTree,$subCat);
						}

					}
				}
			}

			if(!$keyExists)
			{

				$catTree=array_merge($catTree,$this->createCategory($catTab, $nestLevel));
			}

		}

	}
	/**
	 * Funkcja generuje odpowiednie ID kategorii dla danego poziomu zagniezdzenia
	 *
	 * @param array $catTab tablica kategorii danego produktu
	 * @param int $nestLevel poziom zagniezdzenia kategorii
	 * @return string zwraca ID kategorii
	 */
	private function genTreeId($catTab, $nestLevel=1)
	{
		$i=2;
		$treeId=$catTab['id_category1'];
		for (; $i <= $nestLevel && $this->checkCategory($catTab,$i); $i++)
		$treeId.='_'.$catTab['id_category'.$i];

		if ($i==2)
		return "id_".$treeId;

		return $treeId;
	}

	private function checkCategory($catTab,$nestLevel)
	{
		return isset($catTab['id_category'.$nestLevel]) && !empty($catTab['id_category'.$nestLevel]);
	}
}
?>