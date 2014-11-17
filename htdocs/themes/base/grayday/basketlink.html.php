<?php
/**
* @version    $Id: basketlink.html.php,v 1.2 2004/12/20 18:02:43 maroslaw Exp $
* @package    themes
* @subpackage grayday
*/
    global $lang, $global_basket_amount, $global_basket_count, $config, $prefix;
print "<table align=\"center\" width=\"163\" bgcolor=\"" . $config->theme_config['colors']['color_4'] . "\" cellpadding=0 cellspacing=0 border=0>";
print "  <tr>";
print "    <td><div style='margin: 3px;'><nobr>";
    print '<b>' . $lang->head_your_basket ;?>: <?php print $global_basket_amount."</b> ".$config->currency;?><br>
<?php print $lang->head_products_count ;?>: <?php print $global_basket_count?><br>
    </span></nobr></td>
    <td valign="bottom" width="0" align="right"><nobr>
<a href=/go/_basket/>
<img src="<?php $this->img($prefix . $config->theme_config['icons']['basket']); ?>" border=0 style='border-width: 0px; margin-right: 5px; margin-top: 4px; margin-bottom: 4px;'>
</a>
<?php
print "    </nobr></td>";
print "  </tr>";
print "</table>";
?>
