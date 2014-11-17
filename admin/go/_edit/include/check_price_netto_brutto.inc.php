<?php
/**
* Sprawdzenie czy cena zostala zmeiniona. Jesli nie to odczytujemy dane z ukrytych pol.
* Chodzi o unikniecie b³êdow zwi±zanych z zaokraglaniem do 2 miejsc po przecinku. W ukrytych polach
* s± warto¶ci z wieloma miejscami po przecinku i je¶li cena nie zosta³a jawnie zmeiniona, to domy¶lnie
* przyjmujemy te warto¶ci. Dzieki temu przy zmianach netto/brutto i aktualizacji produktu nie ma przek³amaæ cenowych.
*
* @author  m@sote.pl
* @version $Id: check_price_netto_brutto.inc.php,v 2.3 2004/12/20 17:58:02 maroslaw Exp $
* @package    edit
*/

/**
* Sprawdz czy zmieniono cene
* @param array  $item tablica z danymi z forlmuarza
* @param string $field nazwa pola (w form,ularzu powinny byc pola dla $field="price_currency": 
*                      price_currency price_currency_short(ta sama wartosc co price_currency)
*                      i price_currency_long (pelna wartosc bez zaokraglenia)
* @return float poprwana cena
*/

/*
function read_edit_price($item,$field) {
    $price=$item[$field];
    $price_long=$item[$field."_long"];
    $price_short=$item[$field."_short"];
    if ($price==$price_short) {
        return $price_long;
    } else return $price;
} // read_edit_price()

$item['price_currency']=read_edit_price($item,"price_currency");
$item['price_brutto_detal']=read_edit_price($item,"price_brutto_detal");
*/
?>
