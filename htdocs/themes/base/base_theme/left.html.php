<div id="left">
<?php
/**
* @version    $Id: left.html.php,v 1.1 2006/09/27 21:53:21 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/

//echo '<div id="block_search">';
//$this->search_form("horizontal");
//echo '</div>';
echo '<div class="head_1">';
echo $lang->left_choose_category;
echo '</div>';
echo '<div class="block_category">';
include_once ("include/category_show.inc");
echo '</div>';

echo '<div class="head_1">';
//echo $lang->bar_title["infoline"];
echo 'Mikran Team';
echo '</div>';
echo '<div id="block_1">';
$this->file("infoline.html");
echo '</div>';

echo '<div class="head_1">';
echo $lang->bar_title["katalog"];
echo '</div>';
echo '<div id="block_1">';
echo '<a title="Przeglądaj lub pobierz teraz nasz katalog w formacie PDF" href="/katalog-mikran-do-pobrania"><img src="/katalog_pdf/mikran_katalog.jpg" width="170px" alt="Przegladaj lub pobierz katalog w formacie PDF"/><h2>Przegladaj lub pobierz katalog w formacie PDF</h2></a>';
echo '</div>';

   //echo '<div class="head_1">';
   //echo $lang->bar_title["info"];
   //echo '</div>';
   //echo '<div id="block_1">';
   //$this->file("left_window.html");
   //echo '</div>';

//echo '<div class="head_1">';
//echo $lang->bar_title["bestseller"];
//echo '</div>';
//echo '<div id="block_1">';
//$rand_prod->show_products("bestseller",$config->random_on_page['bestseller']);
//echo '</div>';


global $config;
//sprawdzenie czy opcja newsletter jest wybrana przez administratora
if (((@$config->catalog_mode==0) && ($config->newsletter==1))||((@$config->catalog_mode==1)&&(@$config->catalog_mode_options['newsletter']==1))){
    $this->newsletter();

}


?>


</div>
