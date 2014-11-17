<div class="block_1"><?php
/**
* Tekst nad koszykiem, informacje wprowadzone z panelu + opcjonalnie link do za³±czenia zdjêæ i opisów do produktu.
*
* @author  m@sote.pl rp@sote.pl
* @version $Id: basket_up.html.php,v 1.1 2006/09/27 21:53:21 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/

$this->file("over_basket_text.html","");

// jesli w sklepie aktywna jest opcja zalaczania zdjec do produktow to wstaw link
global $config;

if ($config->basket_photo==1) {
    print "<br />\n";
    print "<div align=\"center\">\n";
    print "<a href=\"/go/_basket/_photo/index.php\" ";
    print "onclick=\"window.open('','window','width=700,height=350,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
    print " target=\"window\"><b>&nbsp;&raquo&nbsp;".$lang->basket_check_attach."&nbsp;&laquo&nbsp;</b></a>\n";
    print "</div>\n";
    print "<br />\n";
}

?>
