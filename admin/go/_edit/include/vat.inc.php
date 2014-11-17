<?php
/**
 * Wyswietl liste <select ...> z wartosciami VAT z tabeli vat
 * 
 * \@global array $rec->data dane produktu: vat
 * 
 * @author  m@sote.pl
 * @version $Id: vat.inc.php,v 2.3 2004/12/20 17:58:06 maroslaw Exp $
 *
 * \@verified 2004-03-16 m@sote.pl
* @package    edit
 */

if (@$__secure_test!=true) die ("Forbidden");

$db_vat=false;$tab_vat=array();
$query="SELECT vat FROM vat ORDER BY vat";
$result=$db->Query($query);
if ($result!=0) {
    $num_rows=$db->NumberOfRows($result);
    if ($num_rows>0) {
        $db_vat=true;
        $i=0;
        while ($i<$num_rows) {
            $vat=$db->FetchResult($result,$i,"vat");
            if ((ereg("^[0-9]+$",$vat)) && ($vat>=0) && ($vat<=99)) {                
                array_push($tab_vat,$vat);
            }
            $i++;
        } // end while
    }
} else die ($db->Error());

if ($db_vat==true) {
    print "<select name=item[vat]>\n";
    reset($tab_vat);
    foreach ($tab_vat as $vat) {
        if ($vat==my(@$rec->data['vat'])) {
            print "<option value='".$vat."' selected>$vat</option>\n";
        } else {
            print "<option value='".$vat."'>$vat</option>\n";
        }
    } 
    print "</select>\n";
} else {
    print "<input type=text size=4 name=item[vat] value='".my($rec->data['vat'])."'>\n";
}

?>
