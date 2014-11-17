<?php 
/**
* G³ówna strona dla Google.
*
* @author  m@sote.pl
* @version $Id: main.html.php,v 1.1 2005/08/08 14:16:05 maroslaw Exp $
* @package themes
* @subpackage google
*/
global $google_config;

print "<h3>".$google_config->keywords[0]."</h3>\n";
?>

<ul>
  <li><?php print $lang->google_files;?>
   <ul>
<!--   <li><a href=/html/><?php print $lang->head_promotions;?></a></li>
   <li><a href=#><?php print $lang->head_news;?></a></li>
-->
   <li><a href="/html/html_terms.html"><?php print $lang->head_terms;?></a></li>
   <li><a href="/html/html_about_company.html"><?php print $lang->head_about_company;?></a></li>
   <li><a href="/html/html_contact.html"><?php print $lang->head_contact;?></a></li>
   <li><a href="/html/html_about_shop.html"><?php print $lang->head_about_shop;?></a></li>
   <li><a href="/html/html_help.html"><?php print $lang->head_help;?></a></li>
  </ul>
 </li>
  <?php
  print "<li><a href=\"/html/index.html\">$lang->google_product_list</a></li>\n";
  ?>

<?php
global $_SESSION, $GLOBALS;
require_once ("config/tmp/category.php");
$this->categoriesRecursive($__category,'','google');
?>
</ul>

<?php
print "<b>".$google_config->sentences[1]."</b><p />\n";
?>