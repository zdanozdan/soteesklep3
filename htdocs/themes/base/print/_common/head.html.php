<?php
/**
* @version    $Id: head.html.php,v 1.2 2005/08/10 09:52:43 krzys Exp $
* @package    themes
* @subpackage base_theme
* \@lang
* \@encoding
*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php print @$config->google['title'];?></title>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=<?php print $config->encoding;?>">
<meta NAME="Keywords" CONTENT="<?php print @$config->google['keywords'];?>">
<meta NAME="Description"  CONTENT="<?php print @$config->google['description'];?>">
<link rel="stylesheet" href="/themes/base/base_theme/_style/style.css" type="text/css">
<style type="text/css">
<?php $this->theme_file("_common/style/style.css");?>
</style>
<script>
<?php $this->theme_file("_common/javascript/script.js");?>
</script>

</head>
<body onload="Init()" bgcolor="<?php echo $config->theme_config['colors']['body_background']; ?>" text="#000000" link="#000000" vlink="#000000" alink="#000000">
<?php
global $prefix, $config;
?>
<center>
  <?php $this->google();?>
  <table width="760" border="0" cellspacing="0" cellpadding="0" align="center" background="<?php $this->path($prefix . $config->theme_config['head']['background-image']); ?>">
    <tr> 
      <td align="left">&nbsp;&nbsp;&nbsp;<a href="http://www.sote.pl" target="_blank"><img src="<?php $this->path($prefix . $config->theme_config['head']['logo']);?>" border="0"></a></td>
      <td align="right" valign="bottom"> 
        <table border="0" cellspacing="0" cellpadding="0" align="right">
          <tr> 
            <td width="10"><img alt="" src="<?php $this->path($prefix . $config->theme_config['head']['small_menu']['img']['left']);?>" width="10" height="13"></td>
            <td  align="center" background="<?php $this->path($prefix . $config->theme_config['head']['small_menu']['img']['center']); ?>"><a href="/go/_files/?file=contact.html"> 
              <?php print $lang->head_contact;?>
              </a>&nbsp;&#183;&nbsp;<a href="/go/_files/?file=about_shop.html"><?php print $lang->head_about_shop;?></a>
              <?php 
              if (@$config->catalog_mode==0){
               ?> 
              &nbsp;&#183;&nbsp;<a href="/go/_basket/"><?php print $lang->head_your_basket;?></a>
              <?php
              }
             ?>
              &nbsp;&#183;&nbsp;<a href="/go/_files/?file=help.html"><?php print $lang->head_help;?></a></td>
            <td align="right"><img alt="" src="<?php $this->path($prefix . $config->theme_config['head']['small_menu']['img']['right']);?>" width="10" height="13" /></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <table width="760" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr> 
      <td align="left" bgcolor="<?php print "$this->bg_bar_color";?>"><img alt="" src="<?php $this->path($prefix . $config->theme_config['head']['main_menu']['img']['left']);?>" width="29" height="29"></td>
      <td width="100%" align="center" bgcolor="<?php print "$this->bg_bar_color";?>" background="<?php $this->path($prefix . $config->theme_config['head']['main_menu']['img']['center']);?>"> 
        <?php $this->autoButtons();?>
      </td>
      <td align="right" bgcolor="<?php print "$this->bg_bar_color";?>"><img alt="" src="<?php $this->path($prefix . $config->theme_config['head']['main_menu']['img']['right']);?>" width="29" height="29"></td>
    </tr>
  </table>
  <table width="760" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr> 
      <td align="left"  width="200" bgcolor='<?php echo $config->theme_config['colors']['color_1'];?>'>&nbsp; 
        <?php
        // start plugin cd:
        global $config;
     
        if (((@$config->cd!=1)&&(@$config->catalog_mode==0))||((@$config->catalog_mode==1) && (@$config->catalog_mode_options['users']==1))){
            print "<a href=\"/go/_users/new.php\">$lang->head_register</a> | ";
            print "<a href=\"/go/_users/index.php\">$lang->head_my_account</a>";
        }
        // end plugin cd:
            ?>
      </td>
      <td align="center" bgcolor='<?php echo $config->theme_config['colors']['color_1'];?>' style="padding: 4px;"> 
        <?php
        // jesli user jest zalogowany, to pokaz login zalogowanego uzytkownika
        global $_SESSION;
        if ((! empty($_SESSION['global_id_user'])) && (! empty($_SESSION['global_login']))) {
            print "<a href=\"$config->url_prefix/go/_users/index.php\">".$lang->users_login.": <b>".$_SESSION['global_login']."</b></a>, ";
        }
        include_once ("include/online.inc");
        print "$lang->head_users_online: ".$online->check_users_online();
            ?>            
      </td>
      <td width="10" bgcolor='<?php echo $config->theme_config['colors']['color_1'];?>'>
      
      </td>
      <td bgcolor='<?php echo $config->theme_config['colors']['color_1'];?>' width="10">
        <nobr>
        
        <?php
        if (in_array("multi_lang",$config->plugins)) {
            $this->showFlags();
        }
        ?>
          
                     
        </nobr>
      </td>
      <td align="right" bgcolor='<?php echo $config->theme_config['colors']['color_1'];?>' width="200"> 
        <?php $this->date();?>
        &nbsp; </td>
    </tr>
  </table>
  <table width="760" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr> 
      <td align="left" style="padding: 4px"> 
        <nobr><?php $this->search_form("horizontal");?></nobr>
      </td>
      <td align="right" nowrap><nobr>
        <?php
        if (in_array("currency",$config->plugins)) {
            global $shop;
            $shop->currency();
            $shop->currency->currencyList();
        }
      
        ?>
      </nobr></td>
    <?php 
    if (@$config->catalog_mode==0){
    ?> 
    <td align="right" nowrap><nobr>
      <?php $this->ask4price();?>
    </nobr></td>
    <td align="right" style="padding: 4px"> 
        <table border="0" cellspacing="0" cellpadding="0" align="right">
          <tr> 
            <td align="right"><a href="/go/_basket/"> 
              <?php print $lang->head_in_basket.":&nbsp;";?>
              </a> </td>
            <td align="left"> 
              <?php print $this->basketAmount();?>
            </td>
            <td rowspan="2">&nbsp;</td>
            <td rowspan="2"><a href="/go/_basket/"><img alt="" src='<?php $this->path($prefix . $config->theme_config['icons']['basket']);?>' border="0"></a></td>
          </tr>
          <tr> 
            <td align="right"><nobr><a href="/go/_basket/"> 
              <?php print $lang->head_products_count.":&nbsp;";?>
              </a></nobr></td>
            <td align="left"> 
              <nobr><?php print $global_basket_count;?></nobr>
            </td>
        <?php } ?>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</center>
<br />
