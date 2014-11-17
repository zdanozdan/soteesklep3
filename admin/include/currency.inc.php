<?php
/**
* @version    $Id: currency.inc.php,v 2.4 2005/03/03 15:28:21 maroslaw Exp $
* @package    admin_include
*/
class Currency {
    /**
     * Element select z dostepnymi walutami
     *
     * @param id $default domyslna wartosc id waluty
     */
    function select_list($default='') {
        global $db,$config;
        $query="SELECT * FROM currency";
        $result=$db->Query($query);
        if ($result!=0) {
            $num_rows=$db->NumberOfRows($result);
            if ($num_rows>0) {            
                print "<select name=item[id_currency]>\n";
                for ($i=0;$i<$num_rows;$i++) {
                    $id=$db->FetchResult($result,$i,"id"); 
                    $currency_name=$db->FetchResult($result,$i,"currency_name");  
                    $currency_val=$db->FetchResult($result,$i,"currency_val");  
                    $val=$currency_val;                    
                    if ($val==1) $val="";
                    if ($id==$default) $sel="selected";
                    else $sel="";
                    if ($config->nccp=="0x1388") {
                        print "<option value='$id'$sel>$currency_name $val\n";                  
                    } elseif ($id==1) {
                        // dla wersji light, poka¿ tylko walute o id=1
                        print "<option value='$id'$sel>$currency_name $val\n";                  
                    }
                }
                print "</select>\n";
            } else {
                die ("Currency in database not found.");
            }
        } else {
            die ($db->Error());
        }
        return;
    }
}

$currency = new Currency;
?>
