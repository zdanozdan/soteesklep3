<?php
/**
* @version    $Id: record_row.html.php,v 1.9 2005/04/01 12:57:42 maroslaw Exp $
* @package    themes
* @subpackage base_theme
*/
$id=$rec->data['id'];

global $permf;
global $lang;
?>
<tr>
   <td>

   <?php
   if ($permf->check_link("/go/_edit/")) {
       print "<a href=/go/_edit/index.php?id=$id onclick=\"open_window(800,600)\" target=window><u>".$rec->data['user_id']."</a>\n";
   } 
   ?>
   </td>
   <td>
   <?php
   if ($permf->check_link("/go/_edit/")) {
       print "<a href=/go/_edit/index.php?id=$id onclick=\"open_window(800,600)\" target=window><u>".$lang->change_img."</a>\n";
   } 
   ?>
   </td>
   <td>

   <?php
   if ($permf->check_link("/go/_edit/")) {
       print "<a href=/go/_edit/index.php?id=$id onclick=\"open_window(840,600)\" target=window><u>".$rec->data['name']."</a>\n";
   } else {
       print $rec->data['name'];
   }
   ?>

   </td>
   <td>
   <?php print $rec->data['producer'];?>
   </td>
   <td>
   <?php print $rec->data['category1'];?>
   </td>
   <td>
   <?php
   print $this->price($rec->data['price_brutto'])."&nbsp;".$config->currency_name[$rec->data['id_currency']];
   ?>
   </td>
   <td>
   </td>
   <td>
   <?php
   global $DOCUMENT_ROOT;
   // sprawdz czy istnieje male zdjecie do produktu
   if (file_exists("$DOCUMENT_ROOT/../htdocs/photo/m_".$rec->data['photo'])) {
       print "<img src=/themes/base/base_theme/_img/b.gif width=10 height=10> ";
   }
   // sprawdz czy istnieje duze zdjecie do produktu
   if (file_exists("$DOCUMENT_ROOT/../htdocs/photo/m_".$rec->data['photo'])) {
       print "<img src=/themes/base/base_theme/_img/b.gif width=13 height=13>";
   }
   ?>
   </td>
   <?php
   global $__disable_trash,$permf;
   // jesli uzytkownik nie ma parw do edycji produtku, to nie zezwalaj na usuwanie produktow
   if (! $permf->check_link("/go/_edit/index.php")) $__disable_trash=true;
   if (@$__disable_trash!=true) {
   ?>
    <td>
   <nobr><input type=checkbox name=del[<?php print $id;?>]><?php print $lang->go2trash;?></nobr>
   </td>
   <?php
   }
   ?>
</tr>

<?php
global $__edit;
if (@$__edit!=true) {
    $this->lastRow(8);
}
?>
