<?php
/**
 * Przedstaw dane XML w formacie HTML
* @version    $Id: xml2html.inc.php,v 2.3 2004/12/20 17:59:18 maroslaw Exp $
* @package    users
 */
class OrderXML2HTML {
    /**
     * Opis zamowienia
     *
     * @param string $xml opis zamowienia w formacie XML
     * @return string opis zamowienia w formacie HTML
     */
    function xml_description($xml) {
        global $lang;

        $o="";
        $xml=ereg_replace("&","",$xml);
        $parser = xml_parser_create();
        xml_parse_into_struct($parser,$xml,$values,$tags);
        xml_parser_free($parser);

        $o.="<table border=1 width=100%>\n";
        $o.="<tr>\n";
        $o.="<th><nobr>".$lang->order_basket['name']."</nobr></th>\n";
        $o.="<th><nobr>".$lang->order_basket['options']."</nobr></th>\n";
        $o.="<th><nobr>".$lang->order_basket['user_id']."</nobr></th>\n";
        $o.="<th><nobr>".$lang->order_basket['price_netto']."</nobr></th>\n";
        $o.="<th><nobr>".$lang->order_basket['vat']."%</nobr></th>\n";
        $o.="<th><nobr>".$lang->order_basket['num']."</nobr></th>\n";
        $o.="<th><nobr>".$lang->order_basket['price_brutto']."</nobr></th>\n";
        $o.="<th><nobr>".$lang->order_basket['sum']."</nobr></th>\n";

        reset($values);
        foreach ($values as $index) {
            $tag=$index['tag'];
            $type=$index['type'];
            $level=$index['level'];
            if (! empty($index['value'])) $value=$index['value'];
            else $value='';

#            print "value=$value tag=$tag type=$type level=$level<BR>";

            $level=$index['level'];
            if (($level==2) && ($type=="open")) {
                $o.="<tr>\n";
            }
            if (($level==3) && ($type=="complete")) {
                $o.="<TD align=center>$value</TD>";
            }
            if (($level==1) && ($type=="close")) {
                $o.="</tr>\n";
            }            
        } // end foreach
        $o.="</table>\n";

        return $o;
    } // end xml_description()

    /**
     * Dane zamawiajacego
     *
     * @param string $xml opis danych zamawiajacego w formacie XML
     * @return string opis danych zamawiajacego (biling, adres korespondencyjny/wyslyki) w formacie HTML
     */
    function xml_user($xml) {
        global $lang;

        $o="";        
        $xml=ereg_replace("&","",$xml);
        $parser = xml_parser_create();
        xml_parse_into_struct($parser,$xml,$values,$tags);
        xml_parser_free($parser);
       
        $o.="<table border=1 width=100%>\n";
        foreach ($values as $index) {
            $tag=$index['tag'];
            $type=$index['type'];
            if (! empty($index['value'])) $value=$index['value'];
            else $value='';
            $level=$index['level'];
            if (($type=="open") && ($tag=="BILLING") && ($level==2)) {
                $o.="<tr><td valign=top width=50%>\n";
                $o.="<b>$lang->order_billing</b><hr>";
            }
            if (($type=="open") && ($tag=="COR") && ($level==2)) {
                $o.="</td></tr><tr><td valign=top width=50%>\n";
                $o.="<b>$lang->order_cor</b><hr>";
            }
            if (($type=="close") && ($tag=="COR") && ($level==2)) {
                $o.="</td></tr>\n";
            }
            if ($type=="complete") {
                switch ($tag) {
                case "street_n2":
                        if (! empty($value)) {
                            $o.="/$value";
                        }
                    break;
                default:
                    $lower_tag=strtolower($tag);                    
                    $o.="<b>".$lang->order_form_name[$lower_tag]."</b>: $value";
                    break;
                }
                switch($tag) {
                case "street": $o.=" ";break;
                case "street_n1": $o.=" ";break;
                default: $o.="<br>";break;
                }
            } 
        } // end foreach
        $o.="</table>\n";

        return $o;
    } // end xml_user()
} // end class OrderXML2HTML

?>
