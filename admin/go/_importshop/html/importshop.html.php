<?php
/**
* Formularz z elementami do usuniêcia.
* Wybrane elementy (powi±zane z tabelami w bazie danych) zostan± usuniête z bazy.
*
* @author rdiak@sote.pl
* @version $Id: importshop.html.php,v 1.5 2005/06/15 09:34:06 maroslaw Exp $
* @package    admin_users
* @subpackage importshop
*/

/**
* Generowanie formularzy.
* @ignore
*/
include_once ("include/forms.inc.php");
$forms =& new Forms;

if(empty($_REQUEST['item']['host'])) {
	$_REQUEST['item']['host']='localhost';
}
if(empty($_REQUEST['item']['port'])) {
	$_REQUEST['item']['port']='3306';
}

?>
<br />
<?php print $lang->importshop_warning; ?>

<br><br>
<table align=center width=50% nowrap="nowrap" valign="top">
  <tr>
    <td>
      <fieldset>
      <?php print $lang->importshop_info_db; ?><p />
      <?php print @$this->error_dbconnect;?>
      <legend><?php print $lang->importshop_title; ?></legend>
      <?php 
      $forms->open("index.php","");
      $forms->select("type","",$lang->importshop_names["type"],$this->_convert,"1");
      $forms->text("host",@$_REQUEST['item']['host'],$lang->importshop_names["host"]);
      $forms->text("database",@$_REQUEST['item']['database'],$lang->importshop_names["database"]);
      $forms->text("port",@$_REQUEST['item']['port'],$lang->importshop_names["port"]);
      $forms->text("login",@$_REQUEST['item']['login'],$lang->importshop_names["login"]);
      $forms->password("password",@$_REQUEST['item']['password'],$lang->importshop_names["password"]);
      $forms->button_submit("submit",$lang->importshop_change);
      $forms->close();
      ?>
      </fieldset>
    </td>
  </tr>
</table>
