<?php
/**
* @version    $Id: head.html.php,v 2.30 2005/12/12 15:10:48 krzys Exp $
* @package    themes
* @subpackage redball
* \@lang
*/
global $global_wishlist_count;
?>
<HTML>
<HEAD>
<title><?php print @$config->google['title'];?></title>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=<?php print $config->encoding;?>">
<meta NAME="Keywords" CONTENT="<?php print @$config->google['keywords'];?>">
<meta NAME="Description"  CONTENT="<?php print @$config->google['description'];?>">
<LINK rel="stylesheet" href="<?php $this->img("_style/style.css");?>" type="text/css">
<style type="text/css">
<?php $this->theme_file("_common/style/style.css");?>
</style>
<script>
<?php $this->theme_file("_common/javascript/script.js");?>
</script>
</HEAD>
<?php
global $prefix, $config;
?>
<BODY onload="Init()" bgcolor="<?php echo $config->theme_config['colors']['body_background']; ?>" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" link="#000000" vlink="#000000" alink="#000000">
<?php $this->google();?>
<CENTER>
  <TABLE width="760" border="0" cellspacing="0" cellpadding="0">
    <TR> 
      <TD> 
        <TABLE width="760" border="0" cellspacing="0" cellpadding="0"
            background="<?php $this->img($prefix . $config->theme_config['head']['background-image']);?>">
          <TR> 
            <TD width="0"><IMG src="<?php $this->img($prefix . $config->theme_config['head']['logo']);?>"></TD>
            <TD width="100%" style="color: <?php echo $config->theme_config['colors']['header_font']; ?>"
	    valign="bottom"
	    align="right" class="grey" style="color: <?php echo $config->theme_config['colors']['header_font']; ?>"><B>
        <A style="color: <?php echo $config->theme_config['colors']['header_font']; ?>" href="/" class="grey">HOME</A>
        <?php 
        if (((@$config->cd!=1)&&(@$config->catalog_mode==0))||((@$config->catalog_mode==1) && (@$config->catalog_mode_options['users']==1))){?>
        &nbsp;&#183;&nbsp;<B><A style="color: <?php echo $config->theme_config['colors']['header_font']; ?>" href="/go/_users/index.php" class="grey"><?php print strtoupper($lang->head_my_account); ?></A>
        <?php }?>
        &nbsp;&#183;&nbsp;<B><A style="color: <?php echo $config->theme_config['colors']['header_font']; ?>" href="/go/_promotion/?column=promotion" class="grey"><?php print strtoupper($lang->head_promotions); ?></A>
        &nbsp;&#183;&nbsp;</B><B><A style="color: <?php echo $config->theme_config['colors']['header_font']; ?>" href="/go/_promotion/?column=newcol" class="grey"><?php print strtoupper($lang->head_news); ?></A>
        </B>&nbsp;&#183;&nbsp;<B><A style="color: <?php echo $config->theme_config['colors']['header_font']; ?>" href="/go/_files/?file=about_company.html" class="grey"><?php print strtoupper($lang->head_about_company);?> 
	    </A></B>&nbsp;&#183;&nbsp;<B><A style="color: <?php echo $config->theme_config['colors']['header_font']; ?>" href="/go/_files/?file=terms.html" class="grey"><?php print strtoupper($lang->head_terms);?></A></B>
	    &nbsp;&#183;&nbsp;<B><A style="color: <?php echo $config->theme_config['colors']['header_font']; ?>" href="/go/_files/?file=contact.html" class="grey"><?php print strtoupper($lang->head_contact);?></A></B>
           <?php
           if (in_array("market",$config->plugins)){
               print "&nbsp;&#183;&nbsp;<B><a style=\"color: " . $config->theme_config['colors']['header_font'] . "\" href=/plugins/_market/ class=grey>".strtoupper($lang->head_market)."</a></B>";
           }
           ?> 
           &nbsp;&nbsp;&nbsp;&nbsp;
             </TD>
          </TR>
        </TABLE>
      </TD>
    </TR>
    <TR> 
      <td background="<?php $this->img($prefix . $config->theme_config['head']['bar']);?>"  valign="middle">
        <table width="100%" cellpadding="0" cellspacing="0" border="0" valign="middle">
            <tr>
              <TD align="left" ><IMG src="<?php $this->img($prefix . $config->theme_config['head']['bar']);?>"></TD>
              <TD align="right" valign="middle">
                <?php 
                global $config, $prefix;
                // sprawdzenie czy jezyk jest aktywny
                if (in_array("multi_lang",$config->plugins)) {
                    $this->showFlags();
                }?>

                &nbsp;
              </TD>
            </tr>
        </table>
      </td>
    </TR>
  </TABLE>
</CENTER>
<CENTER>
  <TABLE width="760" border="0" cellspacing="0" cellpadding="0">
 <TR>
 <TD align=left style='padding-top:5px;padding-bottom:5px;'><?php $this->search_form("horizontal");?>
 </TD>
 <TD align=center>

 </TD>
 <TD align=right>
    <?php
      // jesli user jest zalogowany, to pokaz login zalogowanego uzytkownika
      global $_SESSION;
      if ((! empty($_SESSION['global_id_user'])) && (! empty($_SESSION['global_login']))) {
          print "<a href=$config->url_prefix/go/_users/index.php>".$lang->users_login.": <b>".$_SESSION['global_login']."</b></a>, ";    
      }
        if ($config->users_online) {
        include_once ("include/online.inc");
        print "$lang->head_users_online: ".$online->check_users_online();
        }
    ?>
 </TD>
 <?php 
    if ($config->catalog_mode==0){ 
    ?> 
 <TD ALIGN=RIGHT>
   <nobr><a href="/go/_users/new.php"><?php print ($lang->head_register); ?></a>&nbsp;&#149;&nbsp;<a href=/go/_basket/><?php print $lang->head_your_basket ;?>: <?php print $this->basketAmount();?></a>&nbsp;&#149;&nbsp;<a href=/go/_basket/index3.php><nobr><?php print $lang->head_wishlist ;?>: <?php print $global_wishlist_count;?></nobr
 </TD>

   <?php } ?>
 </TR>
</TABLE>
<br />
