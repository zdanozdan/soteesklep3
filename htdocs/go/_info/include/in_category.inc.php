<?php
/**
 * Wyswietl inne produkty z tej samej kategorii
 *
 * @author piotrek@sote.pl
 * @version $Id: in_category.inc.php,v 2.2 2004/12/20 18:01:40 maroslaw Exp $ 
 *
* @package    info
 */

$global_secure_test=true;
$global_database=true;

if (in_array("in_category",$config->plugins)) {      
    $in_category->show_category($rec);
}

?>
