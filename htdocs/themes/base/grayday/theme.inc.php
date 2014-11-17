<?php
/**
* @version    $Id: theme.inc.php,v 1.3 2005/12/12 11:50:36 krzys Exp $
* @package    themes
* @subpackage grayday
*/
$config->base_theme="blueday";

class MyTheme extends Theme {
    //var $colors=array("light"=>"#111111",
    //                  "dark"=>"#999999");
    /**
    * Formularz wyszukiwania
    *
    * @param string $view rodzaj prezentacji fromularza wyszukiwania "vertical" - pionowo, "horizontal" - poziomo
    */
    function search_form($view="vertical"){
        global $lang;
        global $config, $prefix;
        
        // start plugin cd:
        if ($config->cd==1) return;
        // end plugin cd:ss
        
        if ($view=="vertical") $br="<BR>";
        else $br="";
        
              print "<table cellspacing=0 cellpadding=1 border=0>\n";
        print "  <form action=\"$config->url_prefix/go/_search/full_search.php\" method=\"get\" name=\"SearchForm\">\n";
        print "  <tr>\n";
        print "    <td colspan=2>\n";
        print $lang->search;
        print "    </td>\n";
        print "  </tr>\n";
        print "  <tr>\n";
        print "    <td><input type=\"text\" name=\"search_query_words\" style='width: 130px;'></td>\n";
        print "    <td><input type=\"image\" value=\"$lang->search\" src=\""; $this->img($prefix . $config->theme_config['layout_buttons']['search']); echo "\" border=0 style='border-width: 0px; margin-right: 11px;'></td>\n";
        print "  </tr>\n";
        print "<tr>";
        print "<td colspan=2>";
        print "<a href='/go/_search/advanced_search.php'>".@$lang->search_advanced."</a>";
        print "</td></tr>"; 
        print "  </form>\n";
        print "</table>\n";
    } // end search_form()
}

$theme =& new MyTheme;


?>
