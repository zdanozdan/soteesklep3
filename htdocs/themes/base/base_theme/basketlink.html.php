<!-- -basketlink.html.php -->

<?php
/**
* Skr�cona informacja o zawarto�ci koszyka: ilo�� produkt�w, warto�� zam�wienia
*
* @author lech@sote.pl
* @version $Id: basketlink.html.php,v 1.1 2006/09/27 21:53:21 tomasz Exp $
*
* @todo zmiani� nazw� pliku na basket_link.html.php
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
