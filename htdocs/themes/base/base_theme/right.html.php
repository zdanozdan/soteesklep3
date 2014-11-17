<?php
/**
* @version    $Id: right.html.php,v 1.1 2006/09/27 21:53:26 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/
echo '<div id="right">';

echo '<div class="head_1">';
echo $lang->bar_title["newcol"];
echo '</div>';
echo '<div id="block_1">';
$rand_prod->show_products("newcol",$config->random_on_page['newcol']);
print "<br />\n";

echo '</div>';
global $config;
//sprawdzenie czy opcja newsletter jest wybrana przez administratora
if (((@$config->catalog_mode==0) && ($config->newsletter==1))||((@$config->catalog_mode==1)&&(@$config->catalog_mode_options['newsletter']==1))){
    $this->newsletter();

}




echo '<div class="head_1">';
echo $lang->bar_title["bestseller"];
echo '</div>';
echo '<div id="block_1">';
$rand_prod->show_products("bestseller",$config->random_on_page['bestseller']);
echo '</div>';

echo '<div class="head_1">';
echo @$lang->bar_title["info"];
echo '</div>';
echo '<div id="block_1">';
$this->file("right_window.html");
echo '</div>';


echo '</div>';

?>
