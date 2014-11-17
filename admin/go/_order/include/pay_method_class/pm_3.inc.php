<?php
/**
* Aktualizacja transakcji dla platnosci z id_pay_method=3 tj. Polcard'y
*
* @author  m@sote.pl
* @version $Id: pm_3.inc.php,v 1.5 2004/12/20 17:58:59 maroslaw Exp $
* @package    order
*/

/**
* Dodatkowe metody zwi±zane z p³atno¶ci± PolCard (id_pay_method=3).
*
* @package order
* @subpackage polcard
*/
class PayMethodPolCard {
    /**
    * Aktualizuj dane zwiazane transakcja
    *
    * @param int $order_id id transakcji z tabeli order_register
    */
    function update($order_id) {
        return(0);
    } // end update()
} // end class PayMethod

$pay_method =& new PayMethodPolCard;

?>
