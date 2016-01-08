<?php
/**
 * Tworzenie sitemapy na podstawie wszystkich rekordów z bazy z podzia³em na kategorie 
 *
 * \@global  string $sql zapytanie SQL generujace elementy prezentowanych rekordow
 *
 * @author  tomasz@mikran.pl
 * @version $Id$
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

//error_reporting(E_ALL);

class DBFeedList extends DBEdit {

  function get_feed_categories($result,$i) {
    global $db;
    $cat_string = "";

    $c1 = $db->FetchResult($result,$i,"category1");

    if (strlen($c1) > 0)
      {
	$cat_string = $c1;

	$c2 = $db->FetchResult($result,$i,"category2");

	if (strlen($c2) > 0)
          {
	    $cat_string = $cat_string . " &gt; " . $c2;	    
	    $c3 = $db->FetchResult($result,$i,"category3");

	    if (strlen($c3) > 0)
	      {
                $cat_string = $cat_string . " &gt; " . $c3;
		$c4 = $db->FetchResult($result,$i,"category4");

                if (strlen($c4) > 0)
		  {
		    $cat_string = $cat_string . " &gt; " . $c4;
		    
		    $c5 = $db->FetchResult($result,$i,"category5");
                   
		    if (strlen($c5) > 0)
		      {
			$cat_string = $cat_string . " &gt; " . $c5;
		      }
		  }
	      }
          }
      }

    return $cat_string;
  }

    function prepare_feed($sql) 
    {
      global $db;
      $feed = array();
      
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

	  $enc = new EncodeUrl;

	  for ($i=0; $i<$this->num_rows; $i++) 
	    {
	      $item['title']=$db->FetchResult($result,$i,"name_L0");
	      $item['description']=strip_tags($db->FetchResult($result,$i,"xml_description_L0"));
	      $item['id']=$db->FetchResult($result,$i,"id");
	      $item['price']=$db->FetchResult($result,$i,"price_brutto");
	      $item['image']='http://www.sklep.mikran.pl/photo/'.$db->FetchResult($result,$i,"photo");
	      $item['link']='http://www.sklep.mikran.pl/id'.$item['id'].'/'.$enc->encode_url_category($item['title']);
	      $item['category']=$this->get_feed_categories($result,$i);
	      $item['sale_price']=$item['price'] - ($item['price'] * $db->FetchResult($result,$i,"discount")/100);
	      $feed[] = $item;
	    }

	  return $feed;
	}
        else 
	  {
	    die ("Error: $this->classname SQL error");
	  }
    }

    function feed() 
    {
      global $sql;
      global $_REQUEST,$_SERVER;
      global $config;
      global $DOCUMENT_ROOT;

      if (! empty($_REQUEST['sql'])) {
	die ("Forbidden. Empty SQL.");
      }
      
      $this->dbtype=$config->dbtype;
      
      return $this->prepare_feed($sql);
    } // end show()
    
} // end class DBFeedList
?>
