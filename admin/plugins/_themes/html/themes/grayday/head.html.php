<?php
/**
* @version    $Id: head.html.php,v 1.4 2005/03/14 14:10:04 lechu Exp $
* @package    themes
* \@lang
*/
?>
<LINK rel="stylesheet" href="html/themes/<?php echo $thm; ?>/_style/style.css" type="text/css">
<?php
global $prefix;
?>

<CENTER>
  <TABLE width="760" border="0" cellspacing="0" cellpadding="0" >
    <TR> 
      <TD width="100%"> 
        <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td id=tc[head][background-image] <?php echo $design_mode; ?> width=100% background="<?php echo $prefix . $tc['head']['background-image'];?>">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                        <td id=tc[head][logo] <?php echo $design_mode; ?> width=0 valign="bottom"><IMG src="<?php echo $prefix . $tc['head']['logo'];?>" ></td>
                        <td width="100%">&nbsp;</td>
                        <td width="0" valign="bottom">
                            <table cellspacing=0 cellpadding=1 border=0>
                                <tr>
                                    <td colspan=2 style='color: <?php echo $tc['colors']['base_font']; ?>'>
                                        <?php echo $lang->search; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="search_query_words" style='width: 135px; border-color: <?php echo $tc['colors']['input_border']; ?>; background-color: <?php echo $tc['colors']['input_background']; ?>;'></td>
                                    <td><img id=tc[layout_buttons][search] <?php echo $design_mode; ?> src="<?php echo $prefix . $tc['layout_buttons']['search']; ?>" ></td>
                                </tr>
                            </table>
                        </td>
                        </tr>
                    </table>
                </td>
            </tr>
          <TR>
            <td>&nbsp;</td> 
          </TR> 
          <TR> 
            <TD width="100%">
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="0" <?php echo $design_mode; ?> id=tc[head][main_menu][img][left] ><img src="<?php echo $prefix . $tc['head']['main_menu']['img']['left'];?>"></td>
                        <td width="100%"  <?php echo $design_mode; ?> id=tc[head][main_menu][img][center] background="<?php echo $prefix . $tc['head']['main_menu']['img']['center'];?>">&nbsp;</td>
                        <td width="0" background="<?php echo $prefix . $tc['head']['main_menu']['img']['center'];?>">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <td width="0"><img id=tc[head][main_menu][img][separator] <?php echo $design_mode; ?>  src="<?php echo $prefix . $tc['head']['main_menu']['img']['separator']; ?>"></td>
                                <td nowrap class="grey" style="color: <?php echo $tc['colors']['header_font']; ?>;">&nbsp;&nbsp;&nbsp;<B><? echo $lang->head_home; ?></B>&nbsp;&nbsp;&nbsp;</td>
                                <td width="0"><img id=tc[head][main_menu][img][separator] <?php echo $design_mode; ?>  src="<?php echo $prefix . $tc['head']['main_menu']['img']['separator']; ?>"></td>
                                <td nowrap class="grey" style="color: <?php echo $tc['colors']['header_font']; ?>;">&nbsp;&nbsp;&nbsp;<B><? echo $lang->head_my_account; ?></B>&nbsp;&nbsp;&nbsp;</td>
                                <td width="0"><img id=tc[head][main_menu][img][separator] <?php echo $design_mode; ?>  src="<?php echo $prefix . $tc['head']['main_menu']['img']['separator']; ?>"></td>
                                <td nowrap class="grey" style="color: <?php echo $tc['colors']['header_font']; ?>;">&nbsp;&nbsp;&nbsp;<B><? echo $lang->head_promotions; ?></B>&nbsp;&nbsp;&nbsp;</td>
                                <td width="0"><img id=tc[head][main_menu][img][separator] <?php echo $design_mode; ?>  src="<?php echo $prefix . $tc['head']['main_menu']['img']['separator']; ?>"></td>
                                <td nowrap class="grey" style="color: <?php echo $tc['colors']['header_font']; ?>;">&nbsp;&nbsp;&nbsp;<B><? echo $lang->head_news; ?></B>&nbsp;&nbsp;&nbsp;</td>
                                <td width="0"><img id=tc[head][main_menu][img][separator] <?php echo $design_mode; ?> src="<?php echo $prefix . $tc['head']['main_menu']['img']['separator']; ?>"></td>
                                <td nowrap class="grey" style="color: <?php echo $tc['colors']['header_font']; ?>;">&nbsp;&nbsp;&nbsp;<B><? echo $lang->head_about_company; ?></B>&nbsp;&nbsp;&nbsp;</td>
                                <td width="0"><img id=tc[head][main_menu][img][separator] <?php echo $design_mode; ?>  src="<?php echo $prefix . $tc['head']['main_menu']['img']['separator']; ?>"></td>
                                <td nowrap class="grey" style="color: <?php echo $tc['colors']['header_font']; ?>;">&nbsp;&nbsp;&nbsp;<B><? echo $lang->head_terms; ?></B>&nbsp;&nbsp;&nbsp;</td>
                                <td width="0"><img id=tc[head][main_menu][img][separator] <?php echo $design_mode; ?>  src="<?php echo $prefix . $tc['head']['main_menu']['img']['separator']; ?>"></td>
                                <td nowrap class="grey" style="color: <?php echo $tc['colors']['header_font']; ?>;">&nbsp;&nbsp;&nbsp;</td>
                            </table>
                        </td>
                        <td width="0"><img id=tc[head][main_menu][img][right]  <?php echo $design_mode; ?>  src="<?php echo $prefix . $tc['head']['main_menu']['img']['right'];?>"></td>
                    </tr>
                </table>
            </td>
          </TR>
        </TABLE>
      </TD>
    </TR>
  </TABLE>
</CENTER>
<CENTER>
  <TABLE width="760" border="0" cellspacing="0" cellpadding="0">
 <TR>
 <TD align=left width=170 bgcolor="<?php echo $tc['colors']['color_1']; ?>">&nbsp;
 </TD>
 <TD align=left width=1 bgcolor="<?php echo $tc['colors']['input_border']; ?>"><img width="1" height="1"></TD>
 <TD align=left width=19>&nbsp;
 </TD>
 <TD width="380">
    <table border="0" width="380" cellpadding="0" cellspacing="0" style="margin-top: 4px; margin-bottom: 8px;">
        <tr>
            <td width="50%" align="left">&nbsp;
            </td>
            <td width="50%" align="right">
            </td>
        </tr>
    </table>
 </TD>
 <TD align=left width=14 >&nbsp;
 </TD>
 <TD align=left width=1 bgcolor="<?php echo $tc['colors']['input_border']; ?>"><img src="<?php echo ''; ?>" width="1" height="1"></TD>
 <TD align=left width=175 bgcolor="<?php echo $tc['colors']['color_1']; ?>">&nbsp;
 </TD>
 </TR>
