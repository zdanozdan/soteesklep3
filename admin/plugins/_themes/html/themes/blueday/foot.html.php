<?php
/**
* @version    $Id: foot.html.php,v 1.4 2005/01/18 16:08:39 lechu Exp $
* @package    themes
*/
global $__start_page, $prefix;
if ($__start_page==true) {
?>
<?php
}
?>
<table width="760" border="0" cellspacing="0" cellpadding="0" align="center">
    <TR>
        <td width="100%" bgcolor="<?php echo $tc['colors']['color_3']; ?>"><img src="<?php echo ''; ?>" width="1" height="1"></td>
    </TR>
    <TR>
        <td width="100%" bgcolor="<?php echo $tc['colors']['color_2']; ?>"><img src="<?php echo ''; ?>" width="1" height="4"></td>
    </TR>
    <TR>
        <td width="100%" bgcolor="<?php echo $tc['colors']['color_3']; ?>"><img src="<?php echo ''; ?>" width="1" height="1"></td>
    </TR>
  <tr> 
    <td align="center" bgcolor="<?php echo $tc['colors']['color_1']; ?>" height="15" style='color: <?php echo $tc['colors']['base_font']; ?>'>
        <A HREF="/" style='color: <?php echo $tc['colors']['base_font']; ?>'>
      <?php print $lang->head_home;?>
      </A> | <A HREF="#" style='color: <?php echo $tc['colors']['base_font']; ?>'> 
      <?php print $lang->head_promotions;?>
      </A> | <A HREF="#" style='color: <?php echo $tc['colors']['base_font']; ?>'> 
      <?php print $lang->head_news;?>
      </A> | <A HREF="#" style='color: <?php echo $tc['colors']['base_font']; ?>'> 
      <?php print $lang->head_about_company;?>
      </A> | <A HREF="#" style='color: <?php echo $tc['colors']['base_font']; ?>'> 
      <?php print $lang->head_terms;?>
      </A> | <A HREF="#" style='color: <?php echo $tc['colors']['base_font']; ?>'> 
      <?php print $lang->head_basket;?>
      </A> | <A HREF="#" style='color: <?php echo $tc['colors']['base_font']; ?>'> 
      <?php print $lang->head_help;?>
      </A> |</td>
  </tr>
    <TR>
        <td width="100%" bgcolor="<?php echo $tc['colors']['color_3']; ?>"><img src="<?php echo ''; ?>" width="1" height="1"></td>
    </TR>
</table>
</body>
</html>
