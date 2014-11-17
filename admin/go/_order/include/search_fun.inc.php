<?php
/**
* Dodatkowe funkcje zwi±zane z wyszukiwaniem transakcji.
*
* @author  m@sote.pl
* @version $Id: search_fun.inc.php,v 2.4 2004/12/20 17:58:58 maroslaw Exp $
* @package    order
*/

/**
 * Przedstaw jako element formularza metody platnosci
 * 
 * @param string $name nazw pola formularza
 * @return none
 */
function show_pay_methods($name) {
    global $config;
    global $lang;

    print "<select name=$name>\n";
    print "<option value=''>$lang->all\n";
    reset($config->pay_method);
    while (list($id,$name) = each($config->pay_method)) {
        print "<option value=$id>$name\n";
    }    
    print "</select>";
    return;
} // end show_pay_method()

/**
 * Element formularza, status platnosci
 * 
 * @param string $name nazwa pola formularza
 * @return none
 */
function show_confirm($name) {
    global $config;
    global $lang;
   
    print "<select name=$name>\n";
    print "<option value=''>$lang->all\n";
    print "<option value=1>$lang->yes\n";
    print "<option value=0>$lang->no\n";
    print "</select>";

    return;
}
/**
 * Wyszukowanie po partnerach
 * 
 * @param string $name nazwa pola formularza
 * @return none
 */
function show_partner($name) {
	global $mdbd;
	global $lang;
	$data=$mdbd->select("partner_id,name","partners");
   	print "<select name=$name>\n";
        print "<option value=''>$lang->all\n";
   	foreach($data as $key=>$value) {
	     print "<option value=".$value['name'].">".$value['name']."\n";
 	} 
    print "</select>";
 	return; 	
}


?>
