<?php
/**
 * Klasa funckji zwiazanych z obsluga rabatow, odcyztywanie i przetwarzanie danych z tabeli discounts
 *
 * @author  m@sote.pl
 * @version $Id: discounts.inc.php,v 2.3 2004/12/20 17:59:45 maroslaw Exp $
* @package    discounts
 */

class Discounts {
    var $group=0;                 // domyslna grupa rabatowa wg tabeli discounts_groups

    /**
     * Kontruktor
     */
    function discounts() {
        global $_SESSION;
        if (ereg("^[0-9\.]+$",@$_SESSION['__discount_group'])) {
            $this->group=$_SESSION['__discount_group'];
        } 
        return(0);
    } // end discounts()

    /**
     * Odczytaj rabat dla danej grupy rabatowej
     *
     * @param string $discount wartosc pola zawierjacego zapisane rabaty i grupy 
     *                         format: grupa|rabat;grupa2|rabat2;...
     * @param string $group    grupa rabatowa
     *
     * @public
     */
    function get_discount($discount,$group=0) {
        if (! empty($group)) $this->group=$group;
        
        if (! ereg("^[0-9]+$",$this->group)) return (0);
        
        if ((! ereg(";",$discount)) && (ereg("^[0-9\.]+$",$discount))) {
            return $discount;
        }       

        $tab=split(";",$discount,1000);
        reset($tab);$val=0;$val0=0;
        foreach ($tab as $group_tab) {
            $tab2=split("\|",$group_tab,2);
            if ((@$tab2[0]>=0) && (@$tab2[1]>0)) {
                $discount_group=$tab2[0];
                $discount_value=$tab2[1];                
                if ($this->group==$discount_group) $val=$discount_value;
                if ($discount_group==0) $val0=$discount_value;
            }
        } // end foreach

        // jesli rabat nei jest zdefinicowany w grupie rabatowej to odczytaj rabat globalny dla danej kategorii/producenta
        if (! ($val>0)) {
            return $val0;
        }

        return $val;
    } // end get_discount()

    /**
     * Generuj rabat w formacie grupa|rabat;grupa2|rabat2;...
     *
     * @param string $discount     wartosc pola zawierjacego zapisane rabaty i grupy 
     *                             format: grupa|rabat;grupa2|rabat2;...
     * @param string $new_discount nowy rabat
     * @param string $group        grupa rabatowa
     *
     * @return string wartosc rabatow w formacie, kotre jest zapisywany do bazy np. dla grupy o id 2 i rabacie 5 zostanie
     *                zapisany ciag: 2|5 lub jesli wczesniej byl rabat dla grupy 4 o wartosci 9 to zostanie zapisana wartosc
     *                4|9;2|5;
     *
     * @public
     */
    function encode_discount($discount,$new_discount=0,$group='') {
        if (! empty($group)) $this->group=$group;
        if (! ereg("^[0-9]+$",$this->group)) return (0);        

        $o='';
        $tab=split("\;",$discount,1000);
        if ((! sizeof($tab))>1) $tab=array();

        if (sizeof($tab)>0) {
            $update=false; // sprawdzenie czy rabat dla danej grupy jest zdefiniowany w bazie
            foreach ($tab as $group_tab) {
               
                $tab2=split("\|",$group_tab,2);               
                if ((sizeof($tab2)==2)) {
                    $discount_group=$tab2[0];
                    $discount_value=$tab2[1];
                    if ($discount_group==$this->group) {
                        $discount_value=$new_discount;           // podstaw nowy rabat
                        $update=true;
                    }
                    if ($discount_value>=0) 
                        $o.="$discount_group|$discount_value;";
                }
            } // end foreach

            if ($update==false) {
                if ($new_discount>0) 
                    $o.=$this->group."|".$new_discount.";";                
            }

            return $o;

        }  else {
            if ($new_discount>0) 
                $o=$this->group."|".$new_discount.";";
            return $o;
        }
        
        return(0);
    } // end encode_discount()


} // end class Discounts
?>
