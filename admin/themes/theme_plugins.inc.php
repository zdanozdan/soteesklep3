<?php
/**
 * Klasa zawierajaca pluginy rozszezajace klase ThemeAdmin
 *
 * @author m@sote.pl
 * $Id: theme_plugins.inc.php,v 2.12 2004/02/19 08:24:48 maroslaw Exp $
 */

class ThemePlugins extends ThemeAdmin {
    var $max_producer_chars="30";

    // --- start NewsEdit ---
    function newsedit_row(&$rec) {       
        global $config;
        global $DOCUMENT_ROOT;

        // nie wstawiac include_once, bo plik ma byc ladowany wiele razy!
        include ("$DOCUMENT_ROOT/plugins/_newsedit/html/newsedit_row.html.php");

        return;
    } // end delivery_row()

     
    function currency_row(&$rec) {
        global $config;
        global $DOCUMENT_ROOT;

        // nie wstawiac include_once, bo plik ma byc ladowany wiele razy!
        include ("$DOCUMENT_ROOT/plugins/_currency/html/currency_row.html.php");

        return;
    } // end currency_row()
    // --- end Currency ---

    // --- start Market ---
    function market_list_th() {
        global $lang;
        $o="<table align=center>";
        $o.="<tr bgcolor=$this->bg_bar_color_light><th>id</th><th>".$lang->market_cols['name']."</th><th>".$lang->market_cols['email']."</th><th>".$lang->market_cols['title']."</th><th>".$lang->market_cols['date_add']."</th><th>".$lang->go2trash."</th></tr>";
        return $o;

        return;
    } // end market_listh_th

    function market_row(&$rec) {
        global $config,$lang;
        global $DOCUMENT_ROOT;

        // nie wstawiac include_once, bo plik ma byc ladowany wiele razy!
        include ("$DOCUMENT_ROOT/plugins/_market/html/row.html.php");

        return;
    } // end market_row()
    // --- end Market ---


      
    function newsletter_users_row(&$rec) {
        global $config;
        global $DOCUMENT_ROOT;

        // nie wstawiac include_once, bo plik ma byc ladowany wiele razy!
        include ("$DOCUMENT_ROOT/plugins/_newsletter/_users/html/newsletter_row.html.php");

        return;
    } // end currency_row()
    
    function newsletter_row(&$rec) {
        global $config;
        global $DOCUMENT_ROOT;
        
        // nie wstawiac include_once, bo plik ma byc ladowany wiele razy!
        include ("$DOCUMENT_ROOT/plugins/_newsletter/html/newsletter_row.html.php");

        return;
    } // end currency_row()
    // --- end Currency ---
    function newsletter_groups_row(&$rec) {
        global $config;
        global $DOCUMENT_ROOT;
        
        // nie wstawiac include_once, bo plik ma byc ladowany wiele razy!
        include ("$DOCUMENT_ROOT/plugins/_newsletter/_groups/html/newsletter_row.html.php");
        
        return;
    } // end currency_row()

    
    // start partners
    
     /**
     * Nazwy elementow nad lista transakcji dla modulu partners
     */
    function order_list_partner_th() {
        global $__disable_trash;
        global $lang;

        $o="<table align=center>\n";
        $o.="<tr bgcolor=$this->bg_bar_color_light><th>ID</th>\n";
        $o.="<th>".$lang->order_list['date']."</th>\n";
        $o.="<th>".$lang->order_list['amount']."</th>\n";
        $o.="<th>".$lang->order_list['status']."</th>\n";
        $o.="<th>".$lang->order_list['payed']."</th>\n";
        $o.="<th>".$lang->order_list['payment']."</th>\n";
        $o.="<th>".$lang->order_list['partner_name']."</th>\n";
        $o.="<th>".$lang->order_list['partner_rake_off']."</th>\n";
        if (@$__disable_trash!=true) {
            $o.="<th>$lang->trash</th>";
        }
        $o.="</tr>\n";
        
        return $o;
    }

    /**
     * Wiersz prezentacji transakcji dla modulu partners   
     */
    function order_record_row_partners(&$rec) {       
        global $config;
        
        // nie wstawiac include_once, bo plik ma byc ladowany wiele razy!
        include ($this->theme_dir."order_record_row_partners.html.php");
        
        return;
    } // end order_record_row_partners()
    
    // end partners
    
    // -- start producers_category
    /**
     * Wyswietl liste producentow, zapamietaj wybranego przez usera producenta
     *
     * @global string $this->producer_filter_name nazwa producenta (filtru kategorii)
     */
    function producers_category() {
        global $lang;
        global $_REQUEST;
        global $__all_producers;
        
        if (empty($__all_producers)) {
            include_once("config/tmp/producer.php");
        }        
        
        global $_SESSION;
        
        // odczytaj kategorie dla danego producenta
        if (ereg("^[0-9]+$",@$_REQUEST['producer_filter'])) {
            $__producer_filter=$_REQUEST['producer_filter'];
        } elseif (ereg("^[0-9]+$",@$_SESSION['__producer_filter'])) {
            $__producer_filter=$_SESSION['__producer_filter'];
        } else {
            $__producer_filter='';
        }

        if (! empty($__all_producers)) {
            print "<form action=/index2.php method=GET name=producers>\n";
            print "<select name=producer_filter onChange=\"this.form.submit();\">\n";
            print "<option value='0'>$lang->producer_select</option>\b";
            while (list($producer,$id_producer) = each($__all_producers)) {
                if ($__producer_filter==$id_producer) {
                    $selected=" selected";
                    $this->producer_filter_name=$producer;
                    
                } else $selected="";
                
                if (strlen($producer)>$this->max_producer_chars) $producer=substr($producer,0,$this->max_producer_chars)."...";
                print "<option value='$id_producer'$selected>$producer</option>\n";
            }
            print "</select>\n";
            print "</form>\n";
        }
        return(0);
    } // end producers_category()
    // -- end  producers_category
    
}  // end class ThemePlugins;

$theme = new ThemePlugins;

?>