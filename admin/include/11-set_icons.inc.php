<?php
/**
* Utworz tabele z aktywnymi ikonkami dot. funkcji i sklepu i systemow platnosci
*
* @author  m@sote.pl
* @version $Id: set_icons.inc.php,v 2.32 2006/04/20 07:20:39 scalak Exp $
* @package    admin_include
*/

class SetIcons {
    
    /**
    * Dodaj ikone do tablicy, jesli user posiada odpowiednie uprawnienia
    *
    * @param addr   $tab  tablica z ikonkami
    * @param string $img  nazwa pliku graf. ikonki
    * @param string $link link do ktorego prowadzi ikonka
    * @param string $text opis ikonki
    *
    * @return bool  true element zostal dodany do tablicy, false w p.w.
    */
    function add(&$tab,$img,$link,$text) {
        global $permf,$theme;
        
        // sprawdz uprawnienia uzytkwonika
        if (! $permf->check_link($link)) return;
        
        $icon=$theme->icon($img,$link,$text);
        array_push($tab,$icon);
        
        return true;
    } // end add()
    
    /**
    * Generuj tablice z zaktywnymi ikonkami glownymi panelu
    *
    * @return array tablica z kodem wyswietlania komorek zawierajacych ikonki
    */
    function main() {
        global $config,$lang,$theme;
        
        // wyswietl desktop z ikonkami
        $icons=array();         // tabela z ikonkami, ktore beda wyswietlane
        
        $this->add($icons,"edit.png","/go/_wysiwyg/index.php",$lang->icons['text']);
        $this->add($icons,"newsedit.png","/plugins/_newsedit/index.php",$lang->icons['newsedit']);
        $this->add($icons,"offline.gif","/go/_offline/_main/index.php",$lang->icons['offline']);
        $this->add($icons,"opti.png","/go/_opt/index.php",$lang->icons['opt']);
        $this->add($icons,"clients.png","/go/_users/index.php",$lang->icons['customers']);
        $this->add($icons,"trans.gif","/go/_order/index.php",$lang->icons['orders']);
        $this->add($icons,"deliver.png","/go/_options/_delivery/index.php",$lang->icons['delivery']);
        
        if (in_array("newsletter",$config->plugins)) {
            if($config->nccp=="0x01f4")
                $this->add($icons,"lang.gif","/go/_lang_editor/index.php",$lang->icons["lang"]);
            else
                $this->add($icons,"lang.gif","/plugins/_dictionary/index.php",$lang->icons["lang"]);
        }
        
        $this->add($icons,"aable.gif","/go/_options/_available/",$lang->icons['availability']);
        
        if (in_array("currency",$config->plugins)) {
            $this->add($icons,"course.gif","/plugins/_currency/",$lang->icons['currency']);
        }
        
        if (in_array("newsletter",$config->plugins)) {
            $this->add($icons,"news.gif","/plugins/_newsletter/_users/index.php",$lang->icons['newsletter']);
        }
        
        if (in_array("discounts",$config->plugins)) {
            $this->add($icons,"discount.png","/plugins/_discounts/index.php",$lang->icons['discounts']);
        }
        
        $this->add($icons,"recommend.png","/plugins/_reviews/index.php",$lang->icons['reviews']);
        $this->add($icons,"partners.png","/plugins/_partners/index.php",$lang->icons['partners']);
        
        if (in_array("sales",$config->plugins)) {
            $this->add($icons,"sales.png","/plugins/_sales/index.php",$lang->icons['merchants']);
        } else {
            $this->add($icons,"vat.png","/go/_options/_vat/index.php",$lang->icons["vat"]);
        }
        
        if (in_array("stats_pro",$config->plugins)) {
            $this->add($icons,"stats.gif","/go/_report/index.php",$lang->icons['stats']);
        }
        
        if (in_array("main_keys",$config->plugins)) {
            $this->add($icons,"keys.png","/plugins/_main_keys/index.php",$lang->icons['main_keys']);
        }
        
        if (in_array("cd",$config->plugins)) {
            $this->add($icons,"cd.png","/plugins/_cd/index.php",$lang->icons['cd']);
        }
        
        $this->add($icons,"google.png","/go/_google/index.php",$lang->icons['google']);
        
        if (in_array("discounts",$config->plugins)) {
            $this->add($icons,"promo.gif","/plugins/_promotions/index.php",$lang->icons['promotions']);
            
            $this->add($icons,"help.gif","/go/_help/index.php",$lang->icons['help']);
        }
        
        $this->add($icons,"allegro.png","/plugins/_allegro/config.php",$lang->icons['allegro']);
        
        return $icons;
    } // end main()
    
    /**
    * Generuj tablice z zaktywnymi ikonkami zwiazanymi z systemami platnosci, pasazami itp.
    *
    * @return array tablica z kodem wyswietlania komorek zawierajacych ikonki
    */
    function orders() {
        global $config,$lang,$theme,$permf;
        
        $icons=array();
        
        if (! $permf->check("all")) return $icons;
        
        if (in_array("polcard",$config->plugins)) {
            $this->add($icons,"polcard.gif","/plugins/_pay/_polcard/index.php","PolCard:<br /> karty p³atnicze");
        } else {
            $this->add($icons,"l_polcard.jpg","#","PolCard");
        }
        
        
        if ($config->nccp==0x1388) {
            @include_once ("config/auto_config/przelewy24_config.inc.php");
            if (! empty($przelewy24_config)) {
                $this->add($icons,"przelewy24.gif","/plugins/_pay/_przelewy24/index.php","Przelewy24:<br /> Inteligo, mBank, WBK, ...");
            }
        }

        if ($config->nccp==0x1388) {
            @include_once ("config/auto_config/platnosciPL_config.inc.php");
            if (! empty($platnosciPL_config)) {
                #$this->add($icons,"platnosci.png","/plugins/_pay/_platnosciPL/index.php","PlatnosciPL:<br /> MultiBank, mBank, BZWBK, ...");
            }
        }
        
        if (in_array("ecard",$config->plugins)) {
            $this->add($icons,"ecard.png","#","eCard");
        }
        
        if (in_array("mbank",$config->plugins)) {
            $this->add($icons,"mbank.png","#","mBank");
        }
        
        if (in_array("payu",$config->plugins)) {
            $this->add($icons,"payu.png","#","PayU");
        }
        
        if (in_array("inteligo",$config->plugins)) {
            $this->add($icons,"inteligo.png","#","Inteligo");
        }
        
        if (in_array("payback",$config->plugins)) {
            $this->add($icons,"payback.png","#","PayBack.pl");
        }
        if (in_array("pasaz.onet.pl",$config->plugins)) {
            $this->add($icons,"m_onet.gif","/plugins/_pasaz.onet.pl","Pasa¿ Onet");
        }
        if (in_array("pasaz.wp.pl",$config->plugins)) {
            $this->add($icons,"wp.gif","/plugins/_pasaz.wp.pl","Pasa¿ WP");
        } else {
            //$this->add($icons,"l_wp.png","#","Pasa¿ WP");
        }
        if (in_array("pasaz.interia.pl",$config->plugins)){
            $this->add($icons,"interia.gif","/plugins/_pasaz.interia.pl","Pasa¿ Interia.pl");
        }
        return $icons;
        
    } // end orders()
    
    /**
    * Ustaw ikonky dot. platnosci zagranicznych
    *
    * @return array tablica z danymi ikon
    */
    function ordersEn() {
        global $config,$lang,$theme,$permf;
        $icons=array();
        if (! $permf->check("all")) return $icons;
        if ((in_array("paypal",$config->plugins)) && ($config->admin_lang!="pl")) {
           $this->add($icons,"paypal_logo.png","/plugins/_pay/_paypal","PayPal.com");
        }
        return $icons;
    } // end ordersEn()
    
}  // end class SetIcons

?>
