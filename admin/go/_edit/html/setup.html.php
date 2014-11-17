<?php
/**
* Formularz konfiguracji opcji zwi±zanych z edycj± produktu
*
* @author  m@sote.pl
* @verison $Id: setup.html.php,v 2.3 2004/12/20 17:58:01 maroslaw Exp $
*
* \@verified 2004-03-15 m@sote.pl
* @version    $Id: setup.html.php,v 2.3 2004/12/20 17:58:01 maroslaw Exp $
* @package    edit
*/
require_once ("include/forms.inc.php");

$forms = new Forms;

$forms->open("setup.php");
print "<input type=hidden name=id value=".$_REQUEST['id'].">\n";                // przekaz id produktu
$forms->checkbox("netto",@$item['netto'],$lang->edit_setup_form['netto']);
$forms->button_submit("",$lang->update);
$forms->close();
?>
