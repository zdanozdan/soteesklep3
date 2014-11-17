<?php
/**
* @version    $Id: head.html.php,v 1.7 2005/03/14 14:10:35 lechu Exp $
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
            <TD width="100%"  valign="bottom"
	    align="right" class="grey"><B style="color: <?php echo $tc['colors']['header_font']; ?>;">
        <A style="color:<?php echo $tc['colors']['header_font']; ?>;" href=# class="grey" onclick='void(0);'><?php print strtoupper($lang->head_home); ?></A>
        &nbsp;&#183;&nbsp;<B><A style="color:<?php echo $tc['colors']['header_font']; ?>;" href=# class="grey" onclick='void(0);'><?php print strtoupper($lang->head_my_account); ?></A>
        &nbsp;&#183;&nbsp;<B><A style="color:<?php echo $tc['colors']['header_font']; ?>;" href=# class="grey" onclick='void(0);'><?php print strtoupper($lang->head_promotions); ?></A>
        &nbsp;&#183;&nbsp;</B><B><A style="color:<?php echo $tc['colors']['header_font']; ?>;" href=# class="grey" onclick='void(0);'><?php print strtoupper($lang->head_news); ?></A>
        </B>&nbsp;&#183;&nbsp;<B><A style="color:<?php echo $tc['colors']['header_font']; ?>;" href=# class="grey" onclick='void(0);'><?php print strtoupper($lang->head_about_company);?> 
	    </A></B>&nbsp;&#183;&nbsp;<B><A style="color:<?php echo $tc['colors']['header_font']; ?>;" href=# class="grey" onclick='void(0);'><?php print strtoupper($lang->head_terms);?></A></B>
           &nbsp;&nbsp;&nbsp;&nbsp;
             </TD>
          </TR>
        </TABLE>
      </TD>
    </TR>
    <TR> 
      <td id='tc[head][bar]' <?php echo $design_mode; ?> background="<?php echo $prefix . $tc['head']['bar'];?>"  valign="middle">
        <table width="100%" cellpadding="0" cellspacing="0" border="0" valign="middle">
            <tr>
              <TD align="left" ><IMG src="<?php echo $prefix . $tc['head']['bar'];?>"></TD>
              <TD align="right" valign="middle">
                &nbsp;
              </TD>
            </tr>
        </table>
      </td>
    </TR>
  </TABLE>
</CENTER>
<CENTER>
<br />
