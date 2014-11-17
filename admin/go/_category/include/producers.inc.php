<?php
/**
 * Lista producentow w danej kategorii
 *
 * @author  m@sote.pl
 * @version $Id: producers.inc.php,v 2.5 2004/12/20 17:57:55 maroslaw Exp $
* @package    category
 */

global $__producers;
if (empty($__producers)) {
    require_once ("config/tmp/producer.php");
}

class ProducerList {
    var $url="/go/_category/";
    var $data=array();          // tablica z listami producentow
    var $idc;                   // aktualna wartosc id kategorii $idc (lub $cidc)

    /**
     * Wyswietl liste producentow w danej kategorii z linkami
     */
    function show() {
        if ((empty($this->idc)) || (! ereg("^[id0-9_]+$",$this->idc))) return(0);        
        if (empty($this->data[$this->idc])) return(0);
        $producers=$this->data[$this->idc];
        reset($producers);        
        foreach ($producers as $producer) {
            $producer_name=key($producer);
            $producer_id=$producer[$producer_name];
            print "<a href=".$this->url."?idc=".$this->idc."&producer_id=$producer_id>";
            print "<u>$producer_name</u>";
            print "</a> ";
        } // end foreach
    } // end show()
} // end class ProducerList

$producer_list = new ProducerList;
$producer_list->data=@$__producers;
$producer_list->idc=$__get_idc;

?>
