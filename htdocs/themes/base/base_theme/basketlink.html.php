<!-- -basketlink.html.php -->

<?php
/**
* Skrócona informacja o zawarto¶ci koszyka: ilo¶æ produktów, warto¶æ zamówienia
*
* @author lech@sote.pl
* @version $Id: basketlink.html.php,v 1.1 2006/09/27 21:53:21 tomasz Exp $
*
* @todo zmianiæ nazwê pliku na basket_link.html.php
* @package    themes
* @subpackage base_theme
*/
?>

<a href=/go/_basket/><nobr>
<?php
global $lang, $global_basket_amount, $global_basket_count;
print $lang->head_your_basket ;?>: <?php print $global_basket_amount." ".$config->currency;
?>
</nobr></a>
