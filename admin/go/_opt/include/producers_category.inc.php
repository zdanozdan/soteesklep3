<?php
/**
 * Generuj tablice z danymi kategorii dla poszczegolnych producentow. Dane te beda wykorzystane
 * do generowania kategorii produktow danego producenta.
 *
 * \@global  object $db2c     obiekt klasy DB2Category
 * \@global  object $treeview obiekt klasy Treeview
 *
 * @author  m@sote.pl
 * @version $Id: producers_category.inc.php,v 1.1 2008/08/11 16:42:17 tomasz Exp $
* @package    opt
 */

if (@$__secure_test!=true) die ("Forbidden");
if (empty($db2c)) die ("Forbidden: db2c");

$producers_tab=array(); // lista producentow i ich ID np. array("Intel"=>"1","HP"=>"2","IBM"=>"7",...)

$query="SELECT id_producer,producer FROM main WHERE producer!='' AND id_producer>0 GROUP BY id_producer,producer ORDER BY producer LIMIT 1000";
$result=$db->Query($query);
if ($result!=0) {
    $num_rows=$db->NumberOfRows($result);
    if ($num_rows>0) {
        $i=0;
        while ($i<$num_rows) {
            $id_producer=$db->Fetchresult($result,$i,"id_producer");
            $producer=$db->FetchResult($result,$i,"producer");
            if (! empty($producer)) {
                $producers_tab[$producer]=$id_producer;
            }
            $i++;
        } // end while
    } // end if
} else die ($db->Error());

// aktualizuj kategorie
require_once ("db2category.inc.php");

if (! empty($producers_tab)) {
    while (list($producer,$id_producer) = each($producers_tab)) {
        if (! empty($id_producer)) {
            $WHERE="id_producer=$id_producer";            
            // generuj plik(tablice PHP) z kategoriami dla producentow
            $db2c = new db2Category($WHERE,"config/tmp/producers",$id_producer."_category.php");
			$db2c->optimize();
            //$db2c->update_category_file("config/tmp/producers",$id_producer."_category.php","tmp/category.php",$WHERE);
        }

        // generuj plik JS z danymi dla menu Treeview
        if ((! empty($treeview)) && (! empty($id_producer))) {
        	
            $treeview->update_category_files("producers",$id_producer);            
        } // end if

    } // end while
} // end if

?>
