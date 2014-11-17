<?php
/**
* @version    $Id: head.html.php,v 1.12 2005/12/12 11:50:36 krzys Exp $
* @package    themes
* @subpackage grayday
*/
?>
<HTML>
<HEAD>
<title><?php print @$config->google['title'];?></title>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=<?php print $config->encoding;?>">
<meta NAME="Keywords" CONTENT="<?php print @$config->google['keywords'];?>">
<meta NAME="Description"  CONTENT="<?php print @$config->google['description'];?>">
<LINK rel="stylesheet" href="<?php $this->img("_style/style.css");?>" type="text/css">
<style>
<?php $this->theme_file("_common/style/style.css");?>
</style>
<script>
<?php $this->theme_file("_common/javascript/script.js");?>
</script>
</HEAD>
<?php
global $prefix;
?>
<BODY onload="Init()" bgcolor="<?php echo $config->theme_config['colors']['body_background']; ?>" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php $this->google();?>
<CENTER>
  <TABLE width="760" border="0" cellspacing="0" cellpadding="0">
    <TR> 
      <TD width="100%"> 
        <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width=100% background="<?php $this->img($prefix . $config->theme_config['head']['background-image']);?>">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                        <td width=0 valign="bottom"><IMG src="<?php $this->img($prefix . $config->theme_config['head']['logo']);?>" ></td>
                        <td width="100%">&nbsp;</td>
                        <td width="0" valign="bottom"></td>
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
                        <td width="0"><img src="<?php $this->img($prefix . $config->theme_config['head']['main_menu']['img']['left']);?>"></td>
                        <td width="100%" background="<?php $this->img($prefix . $config->theme_config['head']['main_menu']['img']['center']);?>">&nbsp;</td>
                        <td width="0" background="<?php $this->img($prefix . $config->theme_config['head']['main_menu']['img']['center']);?>">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <td width="0"><img src="<?php $this->img($prefix . $config->theme_config['head']['main_menu']['img']['separator']); ?>"></td>
                                <td nowrap>&nbsp;&nbsp;&nbsp;<B><A style="color: <?php echo $config->theme_config['colors']['header_font']; ?>" href="/" class="grey">Home</A></B>&nbsp;&nbsp;&nbsp;</td>
                                    
                                <?php        
                                if (((@$config->cd!=1)&&(@$config->catalog_mode==0))||((@$config->catalog_mode==1) && (@$config->catalog_mode_options['users']==1))){
                                ?>
                                <td width="0"><img src="<?php $this->img($prefix . $config->theme_config['head']['main_menu']['img']['separator']); ?>"></td>
                                <td nowrap>&nbsp;&nbsp;&nbsp;<B><A style="color: <?php echo $config->theme_config['colors']['header_font']; ?>" href="/go/_users/index.php" class="grey"><?php print $lang->head_my_account; ?></A></B>&nbsp;&nbsp;&nbsp;</td>
                                <?php
                                }
                                ?>
                                
                                <td width="0"><img src="<?php $this->img($prefix . $config->theme_config['head']['main_menu']['img']['separator']); ?>"></td>
                                <td nowrap>&nbsp;&nbsp;&nbsp;<B><A style="color: <?php echo $config->theme_config['colors']['header_font']; ?>" href="/go/_promotion/?column=promotion" class="grey"><?php print $lang->head_promotions; ?></A></B>&nbsp;&nbsp;&nbsp;</td>
                                <td width="0"><img src="<?php $this->img($prefix . $config->theme_config['head']['main_menu']['img']['separator']); ?>"></td>
                                <td nowrap>&nbsp;&nbsp;&nbsp;<B><A style="color: <?php echo $config->theme_config['colors']['header_font']; ?>" href="/go/_promotion/?column=newcol" class="grey"><?php print $lang->head_news; ?></A></B>&nbsp;&nbsp;&nbsp;</td>
                                <td width="0"><img src="<?php $this->img($prefix . $config->theme_config['head']['main_menu']['img']['separator']); ?>"></td>
                                <td nowrap>&nbsp;&nbsp;&nbsp;<B><A style="color: <?php echo $config->theme_config['colors']['header_font']; ?>" href="/go/_files/?file=about_company.html" class="grey"><?php print $lang->head_about_company;?></A></B>&nbsp;&nbsp;&nbsp;</td>
                                <td width="0"><img src="<?php $this->img($prefix . $config->theme_config['head']['main_menu']['img']['separator']); ?>"></td>
                                <td nowrap>&nbsp;&nbsp;&nbsp;<B><A style="color: <?php echo $config->theme_config['colors']['header_font']; ?>" href="/go/_files/?file=terms.html" class="grey"><?php print $lang->head_terms;?></A></B>&nbsp;&nbsp;&nbsp;</td>
                                <td width="0"><img src="<?php $this->img($prefix . $config->theme_config['head']['main_menu']['img']['separator']); ?>"></td>
                                <td nowrap>&nbsp;&nbsp;&nbsp;<B><A style="color: <?php echo $config->theme_config['colors']['header_font']; ?>" href="/go/_files/?file=contact.html" class="grey"><?php print $lang->head_contact;?></A></B>&nbsp;&nbsp;&nbsp;</td>
                                <td width="0"><img src="<?php $this->img($prefix . $config->theme_config['head']['main_menu']['img']['separator']); ?>"></td>
                                <?php
                                if (in_array("market",$config->plugins)){
                                ?>
                                <td nowrap>&nbsp;&nbsp;&nbsp;<B><a style="color: <?php echo $config->theme_config['colors']['header_font']; ?>" href=/plugins/_market/ class=grey><?php print $lang->head_market;?></A></B>&nbsp;&nbsp;&nbsp;</td>
                                <td width="0"><img src="<?php $this->img($prefix . $config->theme_config['head']['main_menu']['img']['separator']); ?>"></td>
                                <?php
                                }
                                ?>
                                <td nowrap>&nbsp;&nbsp;&nbsp;</td>
                            </table>
                        </td>
                        <td width="0"><img src="<?php $this->img($prefix . $config->theme_config['head']['main_menu']['img']['right']);?>"></td>
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
 <TD align=left width=170 bgcolor="<?php echo $config->theme_config['colors']['color_1']; ?>">&nbsp;
 </TD>
 <TD align=left width=1 bgcolor="<?php echo $config->theme_config['colors']['input_border']; ?>"><img src="<?php $this->img(''); ?>" width="1" height="1"></TD>
 <TD align=left width=19>&nbsp;
 </TD>
 <TD width="380">
    <table border="0" width="380" cellpadding="0" cellspacing="0" style="margin-top: 4px; margin-bottom: 8px;">
        <tr>
            <td width="50%" align="left">
                <?php
                // jesli user jest zalogowany, to pokaz login zalogowanego uzytkownika
                global $_SESSION;
                if ((! empty($_SESSION['global_id_user'])) && (! empty($_SESSION['global_login']))) {
                    print "<a href=$config->url_prefix/go/_users/index.php>".$lang->users_login.": <b>".$_SESSION['global_login']."</b></a>, ";
                }
                if ($config->users_online==1){
                    include_once ("include/online.inc");
                    print "$lang->head_users_online: ".$online->check_users_online();
                }
                ?>
            </td>
            <td width="50%" align="right">
                <?php
                if (in_array("multi_lang",$config->plugins)) {
                    $this->showFlags();
                }
                ?>
            </td>
        </tr>
    </table>
 </TD>
 <TD align=left width=14 >&nbsp;
 </TD>
 <TD align=left width=1 bgcolor="<?php echo $config->theme_config['colors']['input_border']; ?>"><img src="<?php $this->img(''); ?>" width="1" height="1"></TD>
 <TD align=left width=175 bgcolor="<?php echo $config->theme_config['colors']['color_1']; ?>">&nbsp;
 </TD>
 </TR>
</TABLE>
