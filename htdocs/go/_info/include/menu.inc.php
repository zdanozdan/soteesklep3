<?php
/**
* Menu w info
*
* @author   m@sote.pl piotrek@sote.pl
* @version $Id: menu.inc.php,v 1.1 2007/05/14 11:40:35 tomasz Exp $
*
* \@global  $__check_info sprawdzenie czy istnieje plik HTML (0 - brak, 1 - jest)
* \@global  object $rec   dane produktu z bazy $rec->data
* @package    info
*/

// klasa do encodingu urla
include_once ("include/encodeurl.inc");

$id=$rec->data['id'];

require_once ("themes/include/buttons.inc.php");
$buttons = new Buttons;


// sprawdz czy istnieja produkty z tej samej kategorii , jesli tak wyswietl je
// (jesli $check_in-category=0 - brak produktow)
require_once ("plugins/_info/_in_category/include/in_category.inc.php"); 
$check_in_category=@$in_category->check_product_in_category($rec);

$enc = new EncodeUrl;
$rewrite_name = $enc->encode_url_category($rec->data['name']);

// inne produkty z tej samej kateogrii
if ($check_in_category==1) {
   //$dat[$lang->info_menu['in_category']]="index.php?id=$id&item=1#menu";

   $dat[$lang->info_menu['in_category']]= "/inne/id" . $id . "/".$rewrite_name;
}
// akcesoria
if (! empty($rec->data['accessories'])) {
    $dat[$lang->info_menu['accessories']]="accessories.php?id=$id&item=2#menu";
}

// recenzje
if (in_array("reviews",$config->plugins)) {
   //   $dat[$lang->info_menu['reviews']]="reviews.php?id=$id&item=4#menu";

   $dat[$lang->info_menu['reviews']]= "/recenzje/id" . $id . "/".$rewrite_name;
   
   //$dat[$lang->info_menu['reviews']]= "/id" .$id ."/recenzje";

}

// pelny opis
$file_desc="$DOCUMENT_ROOT/products/".$rec->data['user_id'].".html.php";
if (file_exists($file_desc)) {
    $dat[$lang->info_menu['info']]="info.php?id=$id&item=3#menu";
}


//print "<div>\n";
$buttons->menu_buttons($dat);
//print "</div>\n";
?>
