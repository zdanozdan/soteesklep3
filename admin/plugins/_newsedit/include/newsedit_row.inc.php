<?php
/**
* Odczytanie w³a¶ciwo¶ci newsa - na li¶cie.
*
* @author  m@sote.pl
* @version $Id: newsedit_row.inc.php,v 2.5 2004/12/20 18:00:11 maroslaw Exp $
*
* \@verified 2003-03-19 m@sote.pl
* @package    newsedit
*/

class Rec {
    var $data=array();
}

class NewsEditRow {
    
    /**
    * Odczytaj dane newsa i wy¶wietl wiersz na li¶cie
    *
    * @param  mixed $result            wynik zapytania z bazy danych
    * @param  int   $i                 ID newsa
    * \@global array $__newsedit_groups tablica z ID i nazw± aktualnej grupy newsów np. array("id"=>12,"name"=>"Pomoc")
    *
    * @return none 
    */
    function record($result,$i) {
        global $db;
        global $theme;
        global $__newsedit_groups;

        $rec = new Rec;
        $rec->data['id']=$db->FetchResult($result,$i,"id");
        $rec->data['date_add']=$db->FetchResult($result,$i,"date_add");
        $rec->data['active']=$db->FetchResult($result,$i,"active");
        $rec->data['subject']=$db->FetchResult($result,$i,"subject");        
        $rec->data['ordercol']=$db->FetchResult($result,$i,"ordercol");
        $rec->data['id_newsedit_groups']=$db->FetchResult($result,$i,"id_newsedit_groups");
        if (($rec->data['id_newsedit_groups']>0) &&  
        (! empty($__newsedit_groups[$rec->data['id_newsedit_groups']]))) {
            $rec->data['group']=$__newsedit_groups[$rec->data['id_newsedit_groups']];
        } else { 
            $rec->data['id_newsedit_groups']='';
            $rec->data['group']='';
        }
        
        $theme->newsedit_row($rec);
        return;
    } // end record()
} // end class NewsEditRow
?>
