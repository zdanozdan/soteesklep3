<?php
/**
* @version    $Id: wishlistlink.html.php,v 1.1 2005/12/09 15:44:33 lukasz Exp $
* @package    themes
* @subpackage blueday
*/
print "<br>";
    global $lang, $global_wishlist_count, $config, $prefix;
print "<table align=\"center\" width=\"163\" bgcolor=\"" . $config->theme_config['colors']['color_4'] . "\" cellpadding=0 cellspacing=0 border=0>";
print "  <tr>";
print "    <td><div style='margin: 3px;'><nobr>";
    print '<b>' . $lang->head_wishlist ;?><?php print "</b> ";?><br>
<?php print $lang->head_products_count ;?>: <?php print $global_wishlist_count;?><br>
    </span></nobr></td>
    <td valign="bottom" width="0" align="right"><nobr>
<a href=/go/_basket/index3.php>
<img src="<?php $this->img($prefix . $config->theme_config['icons']['wishlist']); ?>" border=0 style='border-width: 0px; margin-right: 5px; margin-top: 4px; margin-bottom: 4px;'>
</a>
<?php
print "    </nobr></td>";
print "  </tr>";
print "</table>";
?>
