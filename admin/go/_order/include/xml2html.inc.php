<?php
/**
* Przedstaw dane XML transakcji i uzytkwonika zamawiajacego w formacie HTML
* 
* @deprecated since 3.0 
*
* @author  m@sote.pls
* @version $Id: xml2html.inc.php,v 2.11 2004/12/20 17:58:58 maroslaw Exp $
* @ignore
* @package    order
*/

/**
* Rozmiar pól INPUT
* @ignore
*/
define ("INPUT_SIZE",24);

/**
* @ignore
* @package order
* @subpackage order
*/
class OrderXML2HTML {
    
    /**
    * @deprecated since 3.0
    */
    var $order_tab=array();
    
    /**
    * @deprecated since 3.0
    */
    var $user_tab=array();
    
    /**
    * @deprecated 3.0
    */
    function xml_description() {        
        return;
    } // end xml_description()
    
    /**
    * @deprecated since 3.0
    */
    function xml_user($xml) {
        return;
    } // end xml_user()
} // end class OrderXML2HTML

?>
