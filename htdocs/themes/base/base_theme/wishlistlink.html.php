<!-- wishlistlink.html.php -->

<?php
/**
* Skrócona informacja o zawarto¶ci koszyka: ilo¶æ produktów, warto¶æ zamówienia
*
* @author lech@sote.pl
* @version $Id: wishlistlink.html.php,v 1.1 2006/09/27 21:53:26 tomasz Exp $
*
* @todo zmianiæ nazwê pliku na basket_link.html.php
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
