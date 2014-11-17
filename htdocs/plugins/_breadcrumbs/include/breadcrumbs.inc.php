<?php
/**
* Generowanie sciezki powrotu dla produktu albo kategorii.
*
* @author tomasz@mikran.pl
* @version $Id: breadcrumbs.inc.php,v 1.5 2007/05/14 12:23:50 tomasz Exp $
*/

/**
* Klasa zawieraj±ca funkcjê generowania sciezek.
*/
// klasa do encodingu urla
include_once ("include/encodeurl.inc");

class Breadcrumbs {

  /**
    * Funkcja zwaraca tytu³ linka kategorii.
    */
    function getBarTitle() {
       return $lang->current_location . " :" . '<a href="/">Strona g³ówna</a>';
    }

    /**
    * Funkcja zwaraca nazwe kategorii towaru w formacie 'c1 > c2 > ... cn' .
    */
    function getCategoriesSimple($rec) {
       $cat_string = "";
       if (strlen($rec->data['category1']) > 0)
       {
          $cat_string = $rec->data['category1'];

          if (strlen($rec->data['category2']) > 0)
          {
             $cat_string = $cat_string . " > " . $rec->data['category2'];

             if (strlen($rec->data['category3']) > 0)
             {
                $cat_string = $cat_string . " > " . $rec->data['category3'];

                if (strlen($rec->data['category4']) > 0)
                {
                   $cat_string = $cat_string . " > " . $rec->data['category4'];
                   
                   if (strlen($rec->data['category5']) > 0)
                   {
                      $cat_string = $cat_string . " > " . $rec->data['category5'];
                   }
                }
             }
          }
       }

       return $cat_string;
    }
    
    /**
    * Funkcja zwaraca link do kategorii.
    */

    function getCategories($rec) {
       $cat_string = '<a href="/">Strona g³ówna</a>';
       $enc = new EncodeUrl;
       if (strlen($rec->data['category1']) > 0)
       {
          $name = $enc->encode_url_category($rec->data['category1']);
          $id_1 = $rec->data['id_category1'];
          $cat_string = $cat_string . ' > <a href="/idc/id_' . $id_1 . '/'.$name . '">' . $rec->data['category1']."</a>";

          if (strlen($rec->data['category2']) > 0)
          {
             $name = $enc->encode_url_category($rec->data['category2']);
             $id_2 = $rec->data['id_category2'];
             $cat_string = $cat_string . ' > <a href="/idc/' . $id_1 . '_' . $id_2 . '/'.$name . '">' . $rec->data['category2']."</a>";

             if (strlen($rec->data['category3']) > 0)
             {
                $name = $enc->encode_url_category($rec->data['category3']);
                $id_3 = $rec->data['id_category3'];
                $cat_string = $cat_string . ' > <a href="/idc/' . $id_1 . '_' . $id_2 . '_' . $id_3 .'/'.$name . '">' . $rec->data['category3']."</a>";

                if (strlen($rec->data['category4']) > 0)
                {
                   $name = $enc->encode_url_category($rec->data['category4']);
                   $id_4 = $rec->data['id_category4'];
                   $cat_string = $cat_string . ' > <a href="/idc/' . $id_1 . '_' . $id_2 . '_' . $id_3 . '_' . $id_4 .'/'.$name . '">' . $rec->data['category4']."</a>";

                   if (strlen($rec->data['category5']) > 0)
                   {
                      $name = $enc->encode_url_category($rec->data['category5']);
                      $id_5 = $rec->data['id_category5'];
                      $cat_string = $cat_string . ' > <a href="/idc/' . $id_1 . '_' . $id_2 . '_' . $id_3 . '_' . $id_4 . '_' . $id_5 .'/'.$name . '">' . $rec->data['category5']."</a>";
                   }
                }
             }
          }
          
       }
       
       return $cat_string;
    } 
}

//$breadcrumbs =& new Breadcrumbs;
?>
