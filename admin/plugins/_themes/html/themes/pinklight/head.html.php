<?php
/**
* @version    $Id: head.html.php,v 1.7 2005/03/14 14:10:20 lechu Exp $
* @package    themes
* \@lang
*/
global $prefix;
?>
<CENTER>
  <TABLE width="760" border="0" cellspacing="0" cellpadding="0" bgcolor="<?php echo $tc['colors']['body_background']; ?>">
    <TR> 
      <TD> 
        <TABLE width="760" border="0" cellspacing="0" cellpadding="0"
            id='tc[head][background-image]' <?php echo $design_mode; ?>
	        background="<?php echo $prefix . $tc['head']['background-image'];?>">
          <TR> 
            <TD width="0"><IMG id='tc[head][logo]' <?php echo $design_mode; ?> src="<?php echo $prefix . $tc['head']['logo'];?>"></TD>
            <TD width="100%" valign="bottom"
	           align="right" class="grey">&nbsp;
             </TD>
          </TR>
        </TABLE>
      </TD>
    </TR>
    <TR> 
      <td valign="middle">
        <table width="100%" cellpadding="0" cellspacing="0" border="0" valign="middle">
          <tr>
            <td colspan="2" >&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" bgcolor="<?php echo $tc['colors']['color_3'];?>"><img width="1" height="1"></td>
          </tr>
          <tr>
            <TD height="25" width="650" bgcolor="<?php echo $tc['colors']['color_2'];?>" valign="middle"
        	    align="left" class="grey">&nbsp;&nbsp;
                                        <A style="color:<?php echo $tc['colors']['base_font']; ?>;" href=#  onclick='void(0);'><? echo $lang->head_home; ?></A>
                &nbsp;&#149;&nbsp;&nbsp;<A style="color:<?php echo $tc['colors']['base_font']; ?>;" href=# onclick='void(0);'><?php print ($lang->head_my_account); ?></A>
                &nbsp;&#149;&nbsp;&nbsp;<A style="color:<?php echo $tc['colors']['base_font']; ?>;" href=# onclick='void(0);'><?php print ($lang->head_promotions); ?></A>
                &nbsp;&#149;&nbsp;&nbsp;<A style="color:<?php echo $tc['colors']['base_font']; ?>;" href=# onclick='void(0);'><?php print ($lang->head_news); ?></A>
                &nbsp;&#149;&nbsp;&nbsp;<A style="color:<?php echo $tc['colors']['base_font']; ?>;" href=# onclick='void(0);'><?php print ($lang->head_about_company);?></A>
                &nbsp;&#149;&nbsp;&nbsp;<A style="color:<?php echo $tc['colors']['base_font']; ?>;" href=# onclick='void(0);'><?php print ($lang->head_terms);?></A>
                &nbsp;&nbsp;&nbsp;&nbsp;
            </TD>
            <TD align="right" valign="middle" bgcolor="<?php echo $tc['colors']['color_2'];?>">
                &nbsp;
            </TD>
          </tr>
          <tr>
            <td colspan="2" bgcolor="<?php echo $tc['colors']['color_3'];?>"><img width="1" height="1"></td>
          </tr>
          <tr>
            <TD height="25" width="650" valign="middle"
        	    align="left" class="grey">&nbsp;&nbsp;
                                        <A style="color:<?php echo $tc['colors']['base_font']; ?>;" href=#  onclick='void(0);'><? echo $lang->head_register; ?></A>
                &nbsp;&#149;&nbsp;&nbsp;<A style="color:<?php echo $tc['colors']['base_font']; ?>;" href=# onclick='void(0);'><?php print ($lang->head_your_basket); ?></A>
                &nbsp;&nbsp;&nbsp;&nbsp;
            </TD>
            <TD align="right" valign="middle">
                &nbsp;
            </TD>
          </tr>
          <tr>
            <td colspan="2" bgcolor="<?php echo $tc['colors']['color_3'];?>"><img width="1" height="1"></td>
          </tr>
        </table>
      </td>
    </TR>
  </TABLE>
</CENTER>
<CENTER>
<br />
