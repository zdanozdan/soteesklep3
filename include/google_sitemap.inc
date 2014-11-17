<?php
/**
 * Tworzenie sitemapy na podstawie wszystkich rekordów z bazy z podziałem na kategorie 
 *
 * \@global  string $sql zapytanie SQL generujace elementy prezentowanych rekordow
 *
 * @author  tomasz@mikran.pl
 * @version $Id: sitemap_list.inc,v 1.1 2007/04/16 14:48:40 tomasz Exp $
* @package    include
 */

// dodaj klase DBEdit
require_once ("lib/DBEdit-Metabase/DBEdit.inc");
require_once ("include/record_row.inc");
require_once ("include/image.inc");

// dostepnosc towaru (funkcja wyswietlajaca nformacje o dostepnosci)
require_once ("include/available.inc");

// wybor sortowania, funkcje
@include_once ("include/order_by_list.inc");

// klasa do encodingu urla
include_once ("include/encodeurl.inc");

global $DOCUMENT_ROOT;
global $shop;

$file = "$DOCUMENT_ROOT/../config/tmp/category.php";
$file_include = "config/tmp/category.php";

if ((file_exists($file)) || ($shop->home)) {
    include_once($file_include);
}

//error_reporting(E_ALL);


class DBGoogleSitemap extends DBEdit {
    var $title=""; // naglowek listy wyswietlany jako "$theme->bar($title);" nad lista
    var $cat_list = array();
    var $items_map = array();
    var $url_category_prefix = "/go/_category/?idc=";
    var $url_item_prefix = "/go/_info/?id=";

    function items_list($sql) {
        global $db;

        $this->_init_db();
        $this->get_table_from_sql($sql);            // odczytaj nazwe tabeli z zapytania SQL

        if (empty($this->page)) {$this->page=1;}

        if (! empty($sql)) { $this->sql=$sql; }

        // ustaw sortowanie listy
        $this->_set_sql_order();

        // wykonaj zapytanie o liczbe rekordow w zapytaniu SQL np." SELECT count(id) FROM main"
        $this->_set_number_of_records();

        // przygotuj zapytanie $this->sql do wykonania
        $prepared_query=$this->db->PrepareQuery($this->sql);
        if ($prepared_query) 
        {
            // wykonaj zapytanie do bazy
            $result=$this->db->ExecuteQuery($prepared_query);
            $this->num_rows=$this->db->NumberOfRows($result);

            // jesli nie ma rekorow to wyswietl info i zakoncz funkcje

            if ($this->num_rows > 1)
            {
               // lista rekordow
               for ($i=0; $i<$this->num_rows; $i++) 
               {
                  $name = $db->FetchResult($result,$i,"name_L0");
                  $id1 = $db->FetchResult($result,$i,"id_category1");
                  $id2 = $db->FetchResult($result,$i,"id_category2");
                  $id3 = $db->FetchResult($result,$i,"id_category3");
                  $id4 = $db->FetchResult($result,$i,"id_category4");
                  $id5 = $db->FetchResult($result,$i,"id_category5");
                  
                  $id_string = $id1;
                  if ($id2 > 0)
                  {
                     $id_string = $id_string . "_" . $id2;
                     if ($id3 > 0)
                     {
                        $id_string = $id_string . "_" . $id3;
                        if ($id4 > 0)
                        {
                           $id_string = $id_string . "_" . $id4;
                           if ($id5 > 0)
                           {
                              $id_string = $id_string . "_" . $id5;
                           }
                        }
                     }
                  }

                  $id = $db->FetchResult($result,$i,"id");

                  if (!isset($this->items_map[$id_string]))
                  {
                     $this->items_map[$id_string] = array($name." :id=".$id);
                  }
                  else
                  {
                     $items_map = $this->items_map[$id_string];
                     $items_map[] = $name." :id=".$id;
                     $this->items_map[$id_string] = $items_map;
                  }
               }
            }
        } 
        else 
        {
           die ("Error: $this->classname SQL error");
        }

	//	print_r($this->items_map);
        
        return(0);
    } // end record_list()

    function read(&$category,$level=1) 
    {
/*	foreach($category as $c)
	{
	  print_r($c);
	print "<br>ssssssssssssssssssss<br>";
	}
	die();*/
       while (list($key,$val) = each($category)) 
       {
          $id=$key;
          $name=$val['name'];
          $name=LangFunctions::f_translate($name);  //przetlumacz slowo bazowe
          $elements=@$val['elements'];

          $this->cat_list[] = $name." :ID=".$id." :level=".$level;
          if (isset($this->items_map[$id]))
          {
             foreach ($this->items_map[$id] as $value) 
             {
                $this->cat_list[] = $value;
             }
          }

          // przejrzyj elementy poszczgolnych kategorii 1 poziomu, zdefiniowanych jako odzeilne rekordy tablicy $category
          if (! empty($elements)) 
          {
             while (list($key,$item) = each($elements)) 
             {
                if (is_array($item)) 
                {
                   $this->read($item,$level+1);
                } 
                else 
                {
                   // dany element jest lisciem
                   
                   // utworz parametry przekazywane do dodawanego elementu menu
                   $id=$item;
                   $name=$key;
                   $name=LangFunctions::f_translate($name);  //przetlumacz slowo bazowe

                   $l = $level+1;
                   $this->cat_list[] = $name." :ID=".$id." :level=".($level+1);
                   if (isset($this->items_map[$id]))
                   {
                      foreach ($this->items_map[$id] as $value) 
                      {
                         $this->cat_list[] = $value;
                      }
                   }
                }
             }
          } 
       }       
    }
    
    function category() {
       global $category;
       $this->read($category);
       
    }

// $category['id_111']=array("name"=>"Dezynfekcja i Higiena","elements"
//                           =>array("Dezynfekcja powierzchni i narzędzi"
//                                   =>"111_1404","Dezynfekcja rąk i skóry"
//                                   =>"111_1403","Dozowniki , podajniki, pojemniki"
//                                   =>"111_1397","Kompresy"
//                                   =>"111_1439","Kubki"
//                                   =>"111_1392","Maseczki"
//                                   =>"111_1388","Rękawiczki"
//                                   =>"111_1370","Serwety,ręczniki"
//                                   =>"111_1365","Slinociągi , ssaki"
//                                   =>"111_1438","Torebki i rękawy"
//                                   =>"111_1429","Waciki,wałeczki,lignina"
//                                   =>"111_1420"));


    function getMapAsArray()
    {
       $level = 0;
       $cat_id = "";
       $column = true;
       $count=0;
       $sitemap = array();

       foreach ($this->cat_list as $key => $value) 
       {           
          ++$count;
          //Najpierw szukamy poziomu zagłębienia dla danego elementu
          if (ereg(":level=([0-9])",$value,$regs)) 
          {
             $level_replace = $regs[0];
             $level = $regs[1];
             if (ereg(":ID=([0-9_]*)|:ID=(id_[0-9]*)",$value,$regs)) 
             {
//	print $key.'=>'.$value.'<br>';       
                $cat_id = "";
                $cat_id_replace = $regs[0];
                if (!empty($regs[1]))
                {
                   $cat_id = $regs[1];
                }
                else
                {
                   $cat_id = $regs[2];
                }
                
                $final = str_replace($level_replace,"",$value);
                $final = str_replace($cat_id_replace,"",$final);

                $enc = new EncodeUrl;
                $rewrite_name = $enc->encode_url_category($final);

                $href="/idc/$cat_id/$rewrite_name";
//		print $href.'<br>';

                //need ... to show menu level
                //$level_dots = "";
                //for ($a=0;$a<$level;$a++)
                 //  $level_dots = $level_dots . ".";

                //write menu to the file
                //fwrite($fh, $level_dots . $final . "|" . $href . "|" . "$cat_id|#0 |+" . "\r\n");              

                //for ($i=1; $i<=$level; $i++)
                 //  echo "&nbsp &nbsp ";
                //echo "<span id=\"l$level\"><a href=\"$href\">$final</a></span><br>";
		$sitemap[] = $href;
             }
          }
          if (ereg(":id=([0-9]*)",$value,$regs)) 
          { 
             $to_remove = array(".");
             $to_replace = array(" ", "/", ",", ";", "+", ":");

             $final = str_replace($regs[0],"",$value);

             $enc = new EncodeUrl;
             $encoded = $enc->encode_url_category($final);

             $href = "<a href=\"/id".$regs[1]."/".$encoded."\"" . " title=\"$title\">";
       
	     $sitemap[] = "/id".$regs[1]."/".$encoded;
	     //$sitemap[] = "/photo/".$regs[1].".jpg";
          }
       }

	return $sitemap;
    }

    /**
     * Przedstaw liste rekordow w postaci listy DBEdit
     *
     * \@global string $sql zapytanie SQL przejkazywane do DBEdit
     * \@global array  $_REQUEST 
     * 
     * @return none
     */
    function get() {
        global $sql;
        global $_REQUEST,$_SERVER;
        global $config;
        global $theme;
        global $DOCUMENT_ROOT;

        if (! empty($_REQUEST['sql'])) {
            die ("Forbidden. Empty SQL.");
        }

        $this->dbtype=$config->dbtype;

        $this->items_list($sql);
         $this->category();
        return $this->getMapAsArray();
    } // end show()

} // end class DBSiteMapList
?>
