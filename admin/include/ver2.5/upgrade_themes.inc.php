<?php
/**
* Interfejs aktualizacji tematów z wersji 2.5 do formatu danych w 3.0
*
* @author r@sote.pl
* @version $Id: upgrade_themes.inc.php,v 1.12 2004/12/20 17:59:27 maroslaw Exp $
* @package    admin_include
*/

/**
* @package upgrade
* @subpackage 2.5->3.0
*/
require_once ("include/ftp.inc.php");

class UpgradeThemes {

	var $themes='mayer'; 		// nazawa tematu ktory upgradujemy.
	var $path='';				// sciezka do katalogu z tematami
	var $data=array(
	"record_row.html.php"=>array(
	'$this->info();
        $this->basket();'=>'print "<TABLE><TR>";
		print "<TD>".$this->recInfo($rec->data["id"],$rec)."</TD>";
		print "<TD>".$this->recBasket($rec->data["id"],$rec)."</TD>";
		print "</TR></TABLE>";',

	'<?php $this->ask4price($rec->data[\'name\']);?>'=>'',
	'available ($rec->data[\'id_available\']);'=>'global $available;
	    print $available->get($rec->data[\'id_available\'],$rec,"string");',	
	'<?php print $rec->data[\'price_brutto\']."&nbsp;".$config->currency;?>'=>'<?php global $shop; if ($this->checkView("price",$rec)) print $this->print_price($rec)." ".$shop->currency->currency;?>',
	'print $rec->data[\'price_brutto\']'=>'global $shop; if ($this->checkView("price",$rec)) print $this->print_price($rec)." ".$shop->currency->currency',

	),

	"info.html.php"=>array(
	'$this->info'=>'$this->recInfo($rec->data["id"],$rec)',
	'available ($rec->data[\'id_available\']);'=>'global $available;
	    print $available->get($rec->data[\'id_available\'],$rec,"string");',
	'$this->basket_f();'=>'$this->recBasket($rec->data["id"],$rec);',



	),


	"record_row_short.html.php"=>array(
	'$this->info()'=>'$this->recInfo($rec->data["id"],$rec)',
	'$this->basket()'=>'$this->recBasket($rec->data["id"],$rec)',
	'<?php $this->ask4price($rec->data[\'name\']);?>'=>'',
	'<b>Cena: <?php print $rec->data[\'price_brutto\']."&nbsp;".$config->currency;?></B>'=>'<?php global $shop; if ($this->checkView("price",$rec)) print "<B>CENA:".$this->print_price($rec)." ".$shop->currency->currency."</B>";?>',
	),

	"info_price.html.php"=>array(
	'$this->basket_f();'=>'$this->recBasket($rec->data["id"],$rec);',
	),

	"left.html.php"=>array(
	'$rand_prod->show_products("promotion",3);'=>'$rand_prod->show_products("promotion",$config->random_on_page[\'promotion\']);',
	'$rand_prod->show_products("newcol",2);'=>'$rand_prod->show_products("newcol",$config->random_on_page[\'newcol\']);',
	'$rand_prod->show_products("bestseller",3);'=>'$rand_prod->show_products("bestseller",$config->random_on_page[\'bestseller\']);',
	'$this->bar($lang->left_choose_category);
$this->theme_file("desktop_open_bar.html.php",array("width"=>"180"));'=>'$this->win_top($lang->left_choose_category,180,1,1);',
	'$this->theme_file("desktop_open_bar.html.php",array("width"=>"180"));'=>'$this->win_top(\'\',180,0,1);',
	'$this->theme_file("desktop_close.html.php");'=>'$this->win_bottom();',

	),

	"right.html.php"=>array(
	'$rand_prod->show_products("promotion",3);'=>'$rand_prod->show_products("promotion",$config->random_on_page[\'promotion\']);',
	'$rand_prod->show_products("newcol",2);'=>'$rand_prod->show_products("newcol",$config->random_on_page[\'newcol\']);',
	'$rand_prod->show_products("bestseller",3);'=>'$rand_prod->show_products("bestseller",$config->random_on_page[\'bestseller\']);',
	'$this->file("newsletter_window.html","");'=>'
global $config;
//sprawdzenie czy opcja newsletter jest wybrana przez administratora
if ($config->newsletter==1){
    $this->newsletter();
print "<br />\n";
}',
	'$this->bar($lang->right_news);
$this->theme_file("desktop_open_bar.html.php",array("width"=>"180"));'=>'$this->win_top($lang->bar_title["newcol"],180,1,1);',
	'$this->theme_file("desktop_open_bar.html.php",array("width"=>"180"));'=>'$this->win_top(\'\',180,0,1);',
	'$this->theme_file("desktop_close.html.php");'=>'$this->win_bottom();',

	),

	"main.html.php"=>array(
	'@include_once ("plugins/_newsedit/include/newsedit.inc.php");
if (is_object(@$newsedit)) {
    $newsedit->show_list();
}'=>'if ($config->newsedit==1){
    @include_once ("plugins/_newsedit/include/newsedit.inc.php");
    if (is_object(@$newsedit)) {
        $newsedit->show_list();
                              }
    }',
	),
	"head.html.php"=>array(),
	);

	/**
	* Konstruktor
	*/
	function UpgradeThemes() {
		global $DOCUMENT_ROOT;
		global $_REQUEST;

		$this->path="$DOCUMENT_ROOT/../htdocs/themes/base";
		if(! empty($_REQUEST['title_theme'])) {
			$this->themes=$_REQUEST['title_theme'];
		} else {
			if(empty($this->themes)) {
				print "<font color=red> Nie podano tematu</font><br>";
				return false;
			}
		}
		$this->_setAdd();
		return true;
	} // end UpgradeThemes()

	/**
	* G³ówna funkcja wykonujaca upgrade tematów
	* @return bool
	*/
	function upgradeAction() {
		if($this->_upgradeConfig()) {
			$this->_upgradeFile();
		}
		return true;
	} // end updateAction

	function _setAdd() {
		$this->data['head.html.php']=$this->data['head.html.php']+array('<LINK rel="stylesheet" href="/themes/base/base_theme/_style/style.css"'=>'<LINK rel="stylesheet" href="/themes/base/'.$this->themes.'/_style/style.css"');

		//		$this->data['head.html.php']=$this->data['head.html.php']+array('style.css"'=>'fsdfsdfsd'.$this->themes.'fgjg');
		return true;
	}

	/**
	* Dopisz do configa aktualizowany temat
	* @return bool
	*/
	function _upgradeConfig() {
		global $DOCUMENT_ROOT;
		global $config;
		global $ftp;
		// jesli temat nie ma w tablicy $config to nie ma co robic
		if(!array_key_exists($this->themes, $config->themes)) {
			require_once("include/gen_user_config.inc.php");
			$config->themes=$config->themes+array($this->themes=>$this->themes);
			$config->theme=$this->themes;
			$ftp->connect();
			$gen_config->gen(array(
			"themes"=>$config->themes,
			"theme"=>$config->theme,
			)
			);

			$config->themes=$config->themes;
			$config->theme=$config->theme;
			$ftp->close();
		}
		if(!array_key_exists($this->themes, $config->editable_themes)) {
			require_once("include/gen_user_config.inc.php");
			$config->editable_themes=$config->editable_themes+array($this->themes=>$this->themes);
			$ftp->connect();
			$gen_config->gen(array(
			"editable_themes"=>$config->editable_themes,
			)
			);
			$config->editable_themes=$config->editable_themes;
			$ftp->close();
		}
		$ftp->connect();
		// za³ó¿ katalog z nowym tematem
		$ftp->mkdir("$config->ftp_dir/admin/plugins/_themes/html/themes/$this->themes");
		// wywo³aj funkcjê kopiowania plików
		$this->_cp("$config->ftp_dir/admin/plugins/_themes/html/themes/blue","$config->ftp_dir/admin/plugins/_themes/html/themes/$this->themes","$DOCUMENT_ROOT/plugins/_themes/html/themes/blue");
		$ftp->close();
		return true;
	} // end updateConfig
	
	/**
	* Kopiuj temat 
	* @return bool
	*/
	function _cp($wf, $wto,$wwd){        // it moves $wf to $wto
		global $config;
		global $ftp;
		$arr=$this->_ls_a($wf);
		foreach ($arr as $fn){
			if($fn){
				$fl="$wf/$fn";
				$fl1="$wwd/$fn";
				$flto="$wto/$fn";
				//print $fl;
				if($ftp->chdir("$fl")) {
					$ftp->mkdir($flto);
					$this->_cp($fl,$flto,$fl1);
				} else {
					$ftp->put("$fl1","$wto",$fn);
				}
			}
		}
		return true;
	} // end _cp

	/**
	 * Stworz liste plików 
	 * @return bool
	 */
	function _ls_a($wh) {
		global $ftp;
		$files_array=$ftp->nlist($wh);
		foreach($files_array as $key=>$value) {
			preg_match("/([^\s\/]+)$/",$value,$tab);
			$files_array[$key]=$tab[0];
		}
		print "<pre>";
		//print_r($files_array);
		print "</pre>";
		return $files_array;
	} // end _ls_a


	/**
	* Aktualizuj wszystkie dane klientów
	* @return bool
	*/
	function _upgradeFile() {
		global $DOCUMENT_ROOT;
		global $ftp;
		global $config;

		$dir=$this->path."/".$this->themes;
		if (is_dir($dir)) {
			foreach($this->data as $key=>$value) {
				$file=$dir."/".$key;
				$file1=$DOCUMENT_ROOT."/tmp/new_".$key;
				if (file_exists($file)) {
					$fd = fopen ($file, "rb");
					$contents = fread ($fd, filesize ($file));
					fclose ($fd);
					if(is_array($value)) {
						foreach($value as $key1=>$value1) {
							$contents=str_replace($key1,$value1,$contents);
						}
					}
					$fd = fopen ($file1, "w");
					fwrite($fd, $contents);
					fclose ($fd);
					$ftp->connect();

					$ftp->put($file1,"$config->ftp_dir/htdocs/themes/base/$this->themes",$key);
					$ftp->close();
					print "Plik <b> :: $key </b>  w temacie <b>$this->themes ::</b> zosta³ zmieniony.<br>";
				} else {
					print "<font color=red> Plik który ma byæ zmieniony:: $file w temacie <b>$this->themes</b> nie istnieje.</font><br>";
				}
			}
		} else {
			print "<font color=red> Brak katalogu z tematem</font><br>";
			return false;
		}
		return true;
	} // end _upgradeFile
} // end class 	UpgradeThemes
