<?php
/**
 * Lista producentow w danej kategorii
* @version    $Id: producers.inc.php,v 1.1 2007/03/25 17:59:21 tomasz Exp $
* @package    category
 */

require_once("config/tmp/producer.php");
include_once("include/lang_functions.inc");

class ProducerList {
    var $url="/go/_category/";
    var $data=array();          // tablica z listami producentow
    var $idc;                   // aktualna wartosc id kategorii $idc (lub $cidc)
    
    /**
     * Wyswietl liste producentow w danej kategorii z linkami
     */
    function show() {
        global $_SESSION;
        global $theme;

        // sprawdz czy jest zalaczony filtr producenta 
        if (! empty($theme->producer_filter_name)) {
            print LangF::translate($theme->producer_filter_name);
            return(0);
        }
        if ((empty($this->idc)) || (! ereg("^[id0-9_]+$",$this->idc))) 
           return(0);        
        
        $producers=@$this->data[$this->idc];
        if (! empty($producers)) 
        {
            reset($producers);        
            foreach ($producers as $producer) {
                $producer_name=key($producer);
                $producer_id=$producer[$producer_name];
                print "<a rel=\"nofollow\" href=".$this->url."?idc=".$this->idc."&producer_id=$producer_id>";
                print "<u>".LangF::translate($producer_name)."</u>";
                print "</a> ";
            } // end foreach
        } 

        return(0);
    } // end show()
} // end class ProducerList

global $__producers;
$producer_list = new ProducerList;
$producer_list->data=@$__producers;
$producer_list->idc=$__get_idc;

?>
