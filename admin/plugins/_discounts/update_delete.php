<?php
/**
 * PHP Template:
 * Usun rekordy z tabeli discounts
 * 
 * @author m@sote.pl
 * @template_version Id: delete.php,v 1.3 2003/02/06 11:55:15 maroslaw Exp
 * @version $Id: update_delete.php,v 2.5 2005/01/20 14:59:50 maroslaw Exp $
 * @package soteesklep
 */

// naglowek php
$global_database=true; $global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php


// naglowek
$theme->head_window();

$theme->bar($lang->discounts_update_delete_bar);
print "<p>";

class UpdateList {
    var $secure_test=true;

    /**
     * Wysyolaj aktualizacje rabatow dla 
     *
     * @global array $__mem_form tablica z wartosciami rabatow przed wywolaniem aktualizacji
     */
    function update() {
        global $_REQUEST;
        global $__mem_form;

        // odczytaj rabaty w kategoriach
        if (! empty($_REQUEST['item_dc'])) {
            $item_dc=$_REQUEST['item_dc'];
        } else $item_dc=array();
        
        // odczytaj rabaty dla kategorii i producenta
        if (! empty($_REQUEST['item_dcp'])) {
            $item_dcp=$_REQUEST['item_dcp'];
        } else $item_dcp=array();

        // odczytaj rabaty dla producenta
        if (! empty($_REQUEST['item_p'])) {
            $item_p=$_REQUEST['item_p'];
        } else $item_p=array();
        

        // aktualizuj rabaty dla kategorii
        reset($item_dc);
        while (list($id__idc,$discount) = each ($item_dc)) {       
            // aktualizuj rabat jesli zmienila sie wartosc pola formularza okrelsajacego dany rabat
            if ($discount!=$__mem_form[$id__idc]) {
                $idt=split("__",$id__idc,2);
                if (ereg("^[0-9]+$",$idt[0])) {
                    $id=$idt[0];
                    
                    // emuluj wywolanie opcji edycji rekordu tak jak w edit.php               
                    if (! empty($idt[1])) {
                        $idct=split("_",$idt[1]);
                        $deep=sizeof($idct);
                        
                        $_REQUEST['id']=$id;                // id
                        $_REQUEST['deep']=$deep;            // deep                           
                        include ("./include/edit.inc.php"); // generuj nowe id dla odpowiedniego deep -> $_REQUEST['id']                       
                    } 
                    
                    // aktualizuj rekord
                    $this->id=$_REQUEST['id'];
                    $this->data['discount_cat']=$discount;
                    include ("./include/update.inc.php");
                }
            } // end if ($discount>0)
        } // end while
        
        // aktualizuj rabaty dla kategorii i producentow
        reset($item_dcp);
        while (list($id__idcp,$discount) = each ($item_dcp)) {       
            if ($discount!=$__mem_form[$id__idcp]) {
                $idt=split("__",$id__idcp,2);
                if (ereg("^[0-9]+$",$idt[0])) {
                    $this->id=$idt[0];
                    $this->data['discount']=$discount;
                    include ("./include/update_producer.inc.php");
                }
            } // end if ($discount>0)
        } // end while
        
        // aktualizuj rabaty dla producentow
        reset($item_p);
        while (list($id__p,$discount) = each ($item_p)) {       
            if ($discount!=$__mem_form[$id__p]) {
                $idt=split("__",$id__p,2);
                if (ereg("^[0-9]+$",$idt[0])) {
                    $this->id=$idt[0];
                    $this->data['discount_producer']=$discount;
                    include ("./include/update_producer.inc.php");
                }
            } // end if ($discount>0)
        } // end while

        return(0);
    } // end update()
} // end class UpdateList


// usun zaznaczone rekordy
require_once("include/delete.inc.php");
$delete = new Delete;
$delete->show_empty_info=false;           // nie pokazuj komunikatu o pustym koszu
$delete->delete_all("discounts","id");   // kasuj zaznaczone rekordy

// aktualizuj rabaty
$update_list = new UpdateList;
$update_list->update();

print "<center>".$lang->discounts_update_ok."</center>";


$theme->foot_window();

// stopka php
include_once ("include/foot.inc");
// end stopka php
?>
