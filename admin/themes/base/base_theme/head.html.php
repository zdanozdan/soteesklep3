<?php
/**
* @version    $Id: head.html.php,v 1.27 2006/03/28 08:57:55 maroslaw Exp $
* @package    themes
* @subpackage base_theme
* \@ask4price
*/
global $permf;
global $lang;
$onclick="onclick=\"window.open('','window','width=525,height=380,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
?>

<HTML>
<HEAD>
<TITLE><?php print $lang->head_update;?></TITLE>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-2">
<LINK rel="stylesheet" href="<?php $this->img("_style/style.css");?>">
</HEAD>

<SCRIPT language=JavaScript>
function open_window(width,height) {
    var my_window = window.open('', 'window', 'resizable=yes,scrollbars=1,height='+height+',width='+width, false);
    my_window.focus();
}
function open_menu(width,height) {
    var my_window = window.open('', 'menu', 'resizable=yes,scrollbars=1,height='+height+',width='+width, false);
    my_window.focus();
}
function open_new_window(width,height,name) {
    var my_window = window.open('', ''+name+'', 'resizable=yes,scrollbars=1,height='+height+',width='+width, false);
    my_window.focus();
}
</SCRIPT> 

<!-- przyklad wywolania -->
<!--<a href=index.php onclick="open_window(500,200);" target=window>test</a>-->
<!--<a href=index.php onclick="open_new_window(500,200,test);" target=test>test</a>-->

<body background="<?php $this->img("_img/background.gif");?>">

<!-- start MENU: na gorze, linki-->
<table cellspacing=0 cellpadding=0 width=100% align=center border=0>
<tr>
    
   <td align=right>   
   <?php $permf->a("<u>".$lang->admin_top_menu['merchant']."</u> |","/go/_merchant/index.php");?>
   <?php $permf->a("<u>".$lang->admin_top_menu['reports'].", ".$lang->admin_top_menu['stats']."</u> |","/go/_report/index.php");?>
   <?php 
   #$permf->a("<u>".$lang->admin_top_menu['stats']."</u> |","/plugins/_stats/index.php");
   ?>
   <?php $permf->a("<u>".$lang->admin_top_menu['themes']."</u> |","/plugins/_themes/index.php");?>
   <?php $permf->a("<u>".$lang->admin_top_menu['configure']."</u> |","/go/_main_configure/index.php");?>
   <?php $permf->a("<u>".$lang->admin_top_menu['admin']."</u> |","/go/_admin/index.php");?>
   <a href=/go/_auth/logout.php><u><?php print $lang->logout;?></u></a>
 </td>
  <td width=15> &nbsp; </td>
</tr>
</TABLE>
<!-- end MENU: -->

<table cellspacing=0 cellpadding=0 width=100% border=0 align=center border=0>
<tr>
      <td><a href=http://www.sote.pl target=sote><img src=<?php $this->img("_img/logo.gif");?> width="110" height="45" border=0></a></td>
      <td valign=bottom><?php $buttons->button("Start","/");?></td>
      <td valign=bottom>
      <?php 
      // $buttons->button("Menu","/menu.php onclick=\"open_menu(40,600)\" target=menu");
      ?>
      </td><td valign=bottom>
      <font size=+1>

<?php
global $config;

$text=$lang->icons['text'];
$opt=$lang->icons['opt'];
$customers=$lang->icons['customers'];
$orders=$lang->icons['orders'];
$options=$lang->icons['options'];
$import=$lang->icons['offline'];
$ask4price=$lang->icons['ask4price'];

print "<div align=right>";
if ($config->nccp==0x1388) {
    $tab=array(
    $text=>"/go/_wysiwyg/index.php",
    $import=>"/go/_offline/_main/index.php",
    $opt=>"/go/_opt/index.php",
    $customers=>"/go/_users/index.php",
    $orders=>"/go/_order/index.php",
    $ask4price=>"/go/_ask4price/index.php",
    // $options=>"/go/_options/index.php"
    );
    if (! empty($config->plugins)) {
        $tab[$lang->icons['options']]="/plugins/";
    }
    $tab[$lang->icons['docs']]="/go/_help/index.php";
    $buttons->menu_buttons($tab);
    
} elseif ($config->nccp==0x01f4) {
    $tab=array(
               $text=>"/go/_wysiwyg/index.php",
               $import=>"/go/_offline/_main/index.php",
               $opt=>"/go/_opt/index.php",
               $customers=>"/go/_users/index.php",
               $orders=>"/go/_order/index.php",
               $ask4price=>"/go/_ask4price/index.php",
               // $options=>"/go/_options/index.php"
               );
    if (! empty($config->plugins)) {
    	$tab[$lang->icons['plugins']]="/plugins/";
    }
    $tab[$lang->icons['docs']]="/go/_help/index.php";
    $buttons->menu_buttons($tab);
}

print "</div>";
?>

</td>
</tr>
</table>

<?php $this->desktop_open("100%","center");?>
