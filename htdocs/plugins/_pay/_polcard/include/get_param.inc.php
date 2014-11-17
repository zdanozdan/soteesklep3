<?php
/**
* Funkcja get_param wykorzystywana m.in. adv_confirm.php
*
* @author  m@sote.pl
* @version $Id: get_param.inc.php,v 1.2 2004/12/20 18:02:10 maroslaw Exp $
* @package    pay
* @subpackage polcard
*/

/**
* Odczytaj parametry przekazane na POST
*
* @param string $param nazwa parametru
* @return string warto¶æ parametru $param
*/
function get_param($param) {
    if (! empty($_POST[$param])) {
        return substr($_POST[$param],0,1024);              // ograniecznie wartosci do najdluszego mozliwego parametru
    } else return '';
} // end get_param()
?>
