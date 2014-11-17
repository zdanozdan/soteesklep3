<?php
/**
* @version    $Id: foot.html.php,v 1.3 2004/12/29 13:42:01 krzys Exp $
* @package    themes
* @subpackage grayday
*/
?>
<table width="760" border="0" cellspacing="0" cellpadding="0" align="center">
    <TR>
        <td width="100%" bgcolor="<?php echo $config->theme_config['colors']['color_3']; ?>"><img src="<?php $this->img(''); ?>" width="1" height="1"></td>
    </TR>
    <TR>
        <td width="100%" bgcolor="<?php echo $config->theme_config['colors']['color_2']; ?>"><img src="<?php $this->img(''); ?>" width="1" height="4"></td>
    </TR>
    <TR>
        <td width="100%" bgcolor="<?php echo $config->theme_config['colors']['color_3']; ?>"><img src="<?php $this->img(''); ?>" width="1" height="1"></td>
    </TR>
  <tr> 
    <td align="center" bgcolor="<?php echo $config->theme_config['colors']['color_1']; ?>" height="15"><A HREF="/">
      <?php print $lang->foot_main_page;?>
      </A> | <A HREF="/go/_promotion/?column=promotion"> 
      <?php print $lang->foot_promotions;?>
      </A> | <A HREF="/go/_promotion/?column=newcol"> 
      <?php print $lang->foot_news;?>
      </A> | <A HREF="/go/_files/?file=about_company.html"> 
      <?php print $lang->foot_about;?>
      </A> | <A HREF="/go/_files/?file=terms.html"> 
      <?php print $lang->foot_terms;?>
      </A> 
      <?php 
      if ($config->catalog_mode==0){?>
      | <A HREF="/go/_basket/"> 
      <?php print $lang->foot_basket_state;?>
      </A>
      <?php } ?>
      | <A HREF="/go/_files/?file=help.html"> 
      <?php print $lang->foot_help;?>
      </A> |</td>
  </tr>
    <TR>
        <td width="100%" bgcolor="<?php echo $config->theme_config['colors']['color_3']; ?>"><img src="<?php $this->img(''); ?>" width="1" height="1"></td>
    </TR>
</table>
<?php $this->copyrightSOTE();?>
</body>
</html>
