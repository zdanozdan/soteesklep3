<?php
/**
* @version    $Id: left.html.php,v 1.10 2005/01/21 10:59:01 maroslaw Exp $
* @package    themes
* @subpackage base_theme
*/
global $buttons;
global $lang;
global $permf;
global $_SERVER;
?>

<?php 

if ($permf->check("products")) {
$this->desktop_open("100%"); 
    ?>
<form action=/go/_search/index.php method=get name=searchForm>
<table>
  <tr>
    <td valign="top">
      <input type=text name=query_words size=10><br />
      <!-- <a href="/go/_search/adv_search.php"><?php print $lang->advanced_search;?></a>-->
    </td>
    <td valign="top">
    <?php $buttons->button($lang->search,"\"javascript:document.searchForm.submit();\"");?></td>
    <!--<td><?php $buttons->button(">>","");?></td>-->
  </tr>
</table>
<?php $this->desktop_close(); ?>
<!--<input type=radio name=logic value=or checked>lub
<input type=radio name=logic value=and>i
<input type=checkbox name=logic_desc value=yes align=center>sprawdzaj opisy-->
</form>

<BR>
<?php
$buttons->button($lang->menu['add_product'],"/go/_edit/add.php onclick=\"open_window(840,600);\" target=window");
$buttons->button($lang->menu['all_products'],"/go/_category/all.php?1=1");
?>
<BR>

<?php $this->desktop_open("100%");?>
<?php 
// wstaw menu kategorii produktow
include_once ("include/category_show.inc");
print "<a href=/go/_edit_category/category1.php>$lang->edit_category >></a>";
?>
<?php  $this->desktop_close(); }?>

<?php
// wyswietl TIPSY
if (! empty($lang->tips)) {
    print "<BR>";
    $this->desktop_open();
    $this->tips($lang->tips);
    $this->desktop_close();
}

?>
