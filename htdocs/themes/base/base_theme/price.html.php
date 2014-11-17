<?php
/**
 * Prezentacja ceny produktu
 *
 * @author  m@sote.pl
 * @version $Id: price.html.php,v 1.1 2006/09/27 21:53:22 tomasz Exp $
* @package    themes
* @subpackage base_theme
 */

global $rec;
global $my_xml_options;

// jesli jest zalaczony modul hidden_price i produkt ma zaznaczona flage nie pokazuj ceny
// lub jesli nie ma modulu hidden price - ustawienie domyslne
if (((in_array("hidden_price",$config->plugins)) && ($rec->data['hidden_price']!=1)) || 
    (! in_array("hidden_price",$config->plugins))) 
{
    print $lang->record_price_brutto;

    if (! empty($rec->data['base_discount'])) {            
        print " ($lang->discount: ".$rec->data['base_discount']."%)\n";
    } 

    // cena brutto
    print ": <B>".$rec->data['price_brutto']."&nbsp;".$config->currency."</B>\n";


    // cena netto
    print "(".$lang->record_price_netto.": ".$rec->data['price_netto'].")<br />\n";        
   
    // start cena detaliczna: jesli nie ma rabatu to pokaz przekreslona cene detaliczna produktu
    if (empty($rec->data['base_discount'])) {            
        print " $lang->info_price_detal: <font color=red><strike>".$rec->data['price_brutto_detal']."</strike></font>\n";
    }
    // end cena detaliczna:

    // start cena w walucie:
    if (in_array("currency",$config->plugins)) {
        if ($rec->data['id_currency']!=1) {
            print $rec->data['price_currency_netto']."&nbsp;".$rec->data['currency'];
        }
    }
    // end cena w walucie:

    // start koszyk: wyswietl formularz koszyka + opcje
    print "<table cellspacing=0 cellpadding=0>\n";
    print "<tr>\n";
    print "\t<td>$lang->basket_add</td><td width=10>&nbsp;</td>\n";
    print "<td>\n";
    print "\t<form action=/go/_basket/index.php>\n";
    $this->basket_f();
    print "\t<p>";
    $my_xml_options->show();
    print "\t</form>\n";
    print "</td>\n";
    print "</tr>\n";
    print "</table>\n";
    // end koszyk:

} else {
    // zapyaj o cene produku
    $this->ask4price($rec->data['name']);
}
