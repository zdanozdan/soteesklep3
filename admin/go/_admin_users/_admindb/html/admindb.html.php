<?php
/**
* Formularz z elementami do usuniêcia.
* Wybrane elementy (powi±zane z tabelami w bazie danych) zostan± usuniête z bazy.
*
* @author rdiak@sote.pl
* @version $Id: admindb.html.php,v 1.6 2004/12/20 17:57:49 maroslaw Exp $
* @package    admin_users
* @subpackage admindb
*/
?>

<br>
<?php
global $theme;
/**
* Generowanie formularzy.
* @ignore
*/
include_once ("include/forms.inc.php");
$forms =& new Forms;
?>

<?php print $lang->admindb_warning; ?>
<br><br>
<table align=center width=50% nowrap="nowrap" valign="top">
  <tr>
    <td>
      <fieldset>
      <legend><?php print $lang->admindb_title; ?></legend>
      <?php 
      $forms->open("index.php","");
      $forms->checkbox("main",@$item['main'],$lang->admindb_names["main"]);
      $forms->checkbox("mainand",@$item['mainand'],$lang->admindb_names["mainand"]);
      $forms->checkbox("users",@$item['users'],$lang->admindb_names["users"]);
      $forms->checkbox("order",@$item['order'],$lang->admindb_names["order"]);
      $forms->button_submit("submit",$lang->admindb_change);
      $theme->trashSubmitOnly();
      $forms->close();
      ?>
      </fieldset>
    </td>
  </tr>
</table>
