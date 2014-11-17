<?php
/**
* Dodatkowe funckje zwi±zane z tematami itp.
*
* @author  m@sote.pl
* @version $Id: theme.inc.php,v 1.8 2004/12/20 17:58:59 maroslaw Exp $
* @package    order
*/

/**
* Lokalna klasa obs³ugi tematów.
* @package order
* @subpackage order
*/
class ThemeLocal extends ThemePlugins {

    /**
     * Pokaz ikonke/oznaczenie statusu platnosci transakcji
     *
     * @param string $pay_status wartosc pola pay_status z tabeli order_register
     * @return none
     */
    function pay_status($pay_status) {
        switch ($pay_status) {
        case "000": $this->point("o");
            break;
        case "001": $this->point("b");
            break;
        case "002": $this->point("g");
            break;
        case "005": print "<img src=/themes/base/base_theme/_img/g_c.png width=10 height=10>";
            break; 
        case "010":$this->point("r");
            break;
        case "050": $this->point("black");
            break;   
        case "051": $this->point("rg");
            break;
        case "052":$this->point("r");
            break;
        case "053":$this->point("rblack");
            break;
        case "054":$this->point("rblack");
            break;
        }
        return(0);
    } // end pay_status()

    /**
     * Legenda - opis oznaczen na liscie transakcji
     */
    function legend() {
        global $lang,$config;

        if (! in_array("confirm_online",$config->plugins)) {
            return;   
        }
             
        print "<div align=left>\n";
        print $lang->order_legend.":<br>";
        print "<table>\n";
        print "<tr>\n";
        print "<td valign=top>\n";
        $this->point("o"); print " ".$lang->order_legend_desc['o']."<br>";
        $this->point("g"); print " ".$lang->order_legend_desc['g']."<br>";
        $this->point("b"); print " ".$lang->order_legend_desc['b']."<br>";
        $this->point("black"); print " ".$lang->order_legend_desc['black']."<br>";
        $this->point("rg"); print " ".$lang->order_legend_desc['rg']."<br>";
        $this->point("r"); print " ".$lang->order_legend_desc['r']."<br>";
        $this->point("rblack"); print " ".$lang->order_legend_desc['rblack']."<br>";
        print "</div>\n";
        print "</td>\n";
        print "<td valign=top>\n";
        print "<img src=/themes/base/base_theme/_img/clock.png>";print " ".$lang->order_legend_desc['clock']."<br>";
        print "<img src=/themes/base/base_theme/_img/attention.png>";print " ".$lang->order_legend_desc['attention']."<br>";
        print "<img src=/themes/base/base_theme/_img/attention2.png>";print " ".$lang->order_legend_desc['attention2']."<br>";     
        print "</td>\n";
        print "</tr>\n";
        print "</table>\n";
                
        return(0);
    } // end legend()
} // end class ThemeLocal

$theme = new ThemeLocal;
?>
