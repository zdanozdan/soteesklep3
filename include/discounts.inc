<?php
/**
 * Rabaty indywidualne dla klientow wg. kategorii, producentow itp.
 *
 * @author  m@sote.pl
 * \@verified_by p@sote.pl
 * @version $Id: discounts.inc,v 2.11 2004/12/20 18:02:52 maroslaw Exp $
* @package    include
 */

global $discounts_config;

// dane rabat w kategoriach i dla producentow
global $DOCUMENT_ROOT,$_SESSION;
$filed="$DOCUMENT_ROOT/../config/auto_config/discounts/".@$_SESSION['__id_discounts_groups']."_discounts_config.inc.php";

if ((! empty($_SESSION['__id_discounts_groups'])) && (file_exists($filed))) {
    include_once ($filed);
}

// emuluj rabat dla klienta
// $_SESSION['__user_discount']=7;
class Discounts {
    var $discount=0;
    
    /**
     * Oblicz rabat dla danego produktu
     * 
     * return
     * \@global float $this->discount wysokosc aktualnego rabatu, dot. produktu dla ktorego liczymy cene promocyjna
     * @return float rabat dla danego produktu
     */
    function gen($idc=-1,$id_producer=-1) {
        global $_SESSION;
        global $discounts_config;
        $this->discount=0;        // wyzeruj poprzedni rabat

        // rabat indywidualny klienta
        if (! empty($_SESSION['__user_discount'])) {
            $user_discount=$_SESSION['__user_discount'];
            $base_discount=$user_discount;
            $this->discount=$base_discount;
        } else $user_discount=0;       
        // end rabat indywidualny klienta
        
        // print "1. this->discount=$this->discount idc=$idc id_producer=$id_producer<BR>";
        
        // rabaty wg. kategorii i producenta
        $base_discount=0;
        $discount_from='';                    // DEBUG informacja skad nadano rabat
        
        if (! @empty($discounts_config->category_producer["$idc+$id_producer"])) {
            
            $base_discount=$discounts_config->category_producer["$idc+$id_producer"];
            $discount_from="category+producer";
            
        } elseif (! @empty($discounts_config->producer[$id_producer])) {
            // rabaty wg. producenta
            $base_discount=$discounts_config->producer[$id_producer];
            $discount_from="producer";
        } else {
            // rabaty wg. pelnej kategorii, lub kategorii nadrzednych
            
            $tmp_idc=split("_",$idc,5);$discount_idc='';
            if (! @empty($tmp_idc)) {            
                // sprawdz rabat dla kategorii
                for ($i=0;$i<5;$i++) {
                    if (empty($idc2)) {
                        $idc2=$tmp_idc[0];
                    } else {
                        if (! @empty($tmp_idc[$i])) {
                            $idc2.="_".$tmp_idc[$i];
                        }
                    }
                    if (! @empty($discounts_config->category[$idc2])) {
                        // rabat dla kategorii i producenta
                        $discount_category=$discounts_config->category[$idc2];
                        $base_discount=$discounts_config->category[$idc2];
                        $discount_from="category";
                    }
                } // end for
                
                if (! @empty($discounts_config->category["$idc2+$id_producer"])) {
                    $base_discount=$discounts_config->category["$idc2+$id_producer"];
                }
                
            } // end if (! empty($tmp_idc))                   
        } // end if

        // jesli nadano jakis rabat w kategorii lub wg prodiunetna to niech ten rabat bedzie nadrzednym rabatem w stusunku
        // do domyslnego rabatu dla grupy
        if ($base_discount>0) {
            $this->discount=$base_discount;
        } 
        
        $this->discount=number_format($this->discount,2,'.','');
        
        return $this->discount;
    } // end gen()    
    
} // end class Discounts

?>
