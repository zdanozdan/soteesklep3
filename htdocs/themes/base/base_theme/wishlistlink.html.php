<!-- wishlistlink.html.php -->

<?php
/**
* Skr�cona informacja o zawarto�ci koszyka: ilo�� produkt�w, warto�� zam�wienia
*
* @author lech@sote.pl
* @version $Id: wishlistlink.html.php,v 1.1 2006/09/27 21:53:26 tomasz Exp $
*
* @todo zmiani� nazw� pliku na basket_link.html.php
* @package    themes
* @subpackage base_theme
*/
?>

<a href=/go/_basket/index3.php>
<?php
global $lang, $global_wishlist_count;
print $lang->head_wishlist ;
?>: 
<?php 
print $global_wishlist_count;
?>
</a>
