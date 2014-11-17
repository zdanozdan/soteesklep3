<?php
/**
* @version    $Id: upgrade.html.php,v 1.8 2006/02/28 12:05:16 lukasz Exp $
* @package    upgrade
*/
?>
<form action=index.php method=POST enctype="multipart/form-data">
<table>
  <tr>
    <td><?php print $lang->upgrade_get_info;?></td>
    <td><input type=file name=upgrade_pkg><input type=submit value="<?php print $lang->upload;?>"></td>
  </tr>
  <tr>
    <td><?php print $lang->upgrade_info_code;?></td>
    <td><input type=text name=upgrade_code></td>
  </tr>
</table>
</form>


<?php
/*
$cdbv =& new CheckDBVersion();
if ($cdbv->getDBVersion()=="2.x") {
?>
<form action=upgrade_25_themes.php method=POST>
<table>
  <tr>
    <td><?php print $lang->upgrade_name_theme;?></td>
    <td><input type=text name=title_theme size=20></td>
    <td><input type=submit value="<?php print $lang->upgrade_25_menu['themes'];?>"></td>
    </tr>
</table>
</form>
<?php
}
*/
?>
