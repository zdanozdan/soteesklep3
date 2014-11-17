<?php
/**
 * Usun produkt i kategorie, jesli wybrany produkt, jest ostatnim produktem z danej kategorii
 *
 * @author  m@sote.pl
 * @version $Id: delete.inc.php,v 2.7 2005/03/29 10:27:13 lechu Exp $
 * @package soteesklep
 * \@lang
 */

class Delete {    

    /**
     * Usun pusta kategorie
     * @deprecated since 3.0
     */
    function del_cat($column,$id_column) {
       retrun;
    } // end del_cat()
    
    /**
     * Usun produkt.
     * Konstruktor
     *
     * @param int $id id usuwanego produktu
     */
    function delete($id="") {
        global $lang,$db;
        global $ftp;
        global $DOCUMENT_ROOT;
        global $config;
        $lang_id = @$config->lang_id;

        if (empty($id)) return;
        
        $query="SELECT user_id,name_L$lang_id,producer,price_brutto,id_category1,id_category2,id_category3,id_category4,id_category5,id_producer
                       FROM main WHERE id=?";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,$id);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    $user_id=$db->FetchResult($result,0,"user_id");
                    $name=$db->FetchResult($result,0,"name");
                    $producer=$db->FetchResult($result,0,"producer");
                    $price_brutto=$db->FetchResult($result,0,"price_brutto");

                    $id_columns['id_producer']=$db->FetchResult($result,0,"id_producer");
                    $id_columns['id_category1']=$db->FetchResult($result,0,"id_category1");
                    $id_columns['id_category2']=$db->FetchResult($result,0,"id_category2");
                    $id_columns['id_category3']=$db->FetchResult($result,0,"id_category3");
                    $id_columns['id_category4']=$db->FetchResult($result,0,"id_category4");
                    $id_columns['id_category5']=$db->FetchResult($result,0,"id_category5");

                    // usun produkt
                    $query="DELETE FROM main WHERE id=?";
                    $prepared_query=$db->PrepareQuery($query);
                    if ($prepared_query) {
                        $db->QuerySetText($prepared_query,1,$id);
                        $result=$db->ExecuteQuery($prepared_query);
                        if ($result!=0) {
                            print "&nbsp; &nbsp; $name $producer $price_brutto - ".$lang->deleted."<br>";
                        } else die ($db->Error());
                    } else die ($db->Error());
                    
                    // usun opis html do produktu, jesli taki opis istnieje
                    if (file_exists("$DOCUMENT_ROOT/../htdocs/products/$user_id.html.php")) {
                        $ftp->connect();  // polacz sie dopiero wtedy, kiedy jest choc jeden opis html do usuniecia
                        $ftp->delete($config->ftp['ftp_dir']."/htdocs/products","$user_id.html.php");
                    }
                    
                } else {
                    print $lang->delete_not_found." id=$id<BR>";
                } 
            } else die ($db->Error());
        } else die ($db->Error());
        
        return(0);
    } // end delete

} // end class Delete

$delete = new Delete;
?>