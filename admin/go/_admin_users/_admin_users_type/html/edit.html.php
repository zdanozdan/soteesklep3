<?php
/**
* Formularz edycji rekordu
*
* @author m@sote.pl
* @version $Id: edit.html.php,v 2.7 2004/12/20 17:57:47 maroslaw Exp $
* @package    admin_users
* @subpackage admin_users_type
*/

global $config;

/**
* Obs³uga generowania formularza.
*/
include_once ("include/forms.inc.php");
$forms = new Forms;

$forms->open($action,@$this->id);
$forms->text("type",@$rec->data["type"],$lang->admin_users_type_cols["type"]);

foreach ($config->admin_perm as $perm) {
    if (@$this->id!=1) {
        $forms->checkbox("p_$perm",@$rec->data["p_$perm"],$lang->admin_users_type_cols["p_$perm"]);
    } else {
        $forms->hidden("p_$perm","1");
    }
}

$forms->button_submit("submit",$lang->edit_submit);
$forms->close();

?>
