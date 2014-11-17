<?php
/**
* @version    $Id: foot.html.php,v 1.4 2005/12/12 15:01:07 krzys Exp $
* @package    themes
* @subpackage bluelight
*/
?>
<br />
<br />
<?php
global $__start_page;
if ($__start_page==true) {
?>
<table width="760" align="center">
  <tr> 
    <td align="left"> 
    </td>
    <td align="right"> 
      <div align=right> 
        <?php $this->show_themes();?>
      </div>
    </td>
  </tr>
</table>
<?php
}
?>
<table width="760" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td bgcolor="<?php echo $config->theme_config['colors']['color_3'];?>"><img src="<?php $this->img("_img/mask.gif");?>" width="1" height="1"></td>
  </tr>
  <tr> 
    <td align="center" height="25" bgcolor="<?php echo $config->theme_config['colors']['color_2'];?>"><A HREF="/"><U> 
      <?php print $lang->foot_main_page;?>
      </U></A> | <A HREF="/go/_promotion/?column=promotion"><U> 
      <?php print $lang->foot_promotions;?>
      </U></A> | <A HREF="/go/_promotion/?column=newcol"><U> 
      <?php print $lang->foot_news;?>
      </U></A> | <A HREF="/go/_files/?file=about_company.html"><U> 
      <?php print $lang->foot_about;?>
      </U></A> | <A HREF="/go/_files/?file=terms.html"><U> 
      <?php print $lang->foot_terms;?>
      </U></A> 
      <?php
      if ($config->catalog_mode==0){ ?>
      | <A HREF="/go/_basket/"><U> 
      <?php print $lang->foot_basket_state;?>
      </U></A> 
      <?php
      }
      ?>
      | <A HREF="/go/_files/?file=help.html"><U> 
      <?php print $lang->foot_help;?>
      </U></A> |</td>
  </tr>
  <tr>
    <td bgcolor="<?php echo $config->theme_config['colors']['color_3'];?>"><img src="<?php $this->img("_img/mask.gif");?>" width="1" height="1"></td>
  </tr>
</table>
<?php $this->copyrightSOTE();?>
</body>
</html>
