<?php
/**
* @version    $Id: basketlink.html.php,v 1.2 2004/12/20 18:01:00 maroslaw Exp $
* @package    themes
*/
    global $lang, $global_basket_amount, $global_basket_count, $config, $prefix;
print "<table align=\"center\" width=\"163\" bgcolor=\"#D7D7D9\" cellpadding=0 cellspacing=0 border=0>";
print "  <tr>";
print "    <td><div style='margin: 3px;'>";
    print '<b>' . $lang->head_your_basket ;?>: <?php print $global_basket_amount."</b> ".$config->currency;?><br>
<?php print $lang->head_products_count ;?>: <?php print $global_basket_count?><br>
    </span></td>
    <td valign="bottom" width="0">
<a href=/go/_basket/>
<img src="<?php $this->img($prefix . $config->theme_config['icons']['basket']); ?>" border=0 style='border-width: 0px; margin-right: 2px; margin-top: 4px; margin-bottom: 4px;'>
</a>
<?php
print "    </td>";
print "  </tr>";
print "</table>";
?>
