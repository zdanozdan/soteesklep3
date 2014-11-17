<?php
/**
 * Formularz edycji rekordu
 *
 * \@global string $action [index.php|edit.php]
 * \@global bool   $__edit true - edycja rekordu, false - dodanie rekordu
 * 
 * @author  m@sote.pl 
 * \@template_version Id: edit.html.php,v 2.7 2003/08/10 22:57:20 maroslaw Exp
 * @version $Id: edit.html.php,v 1.3 2004/12/20 17:59:55 maroslaw Exp $
* @package    main_keys
* @subpackage main_keys_ftp
 */

global $__edit; 
if ($__edit) $disable1=1;
else $disable1=0;

include_once ("include/forms.inc.php");
$forms = new Forms;

// wygeneruj nowe ID jesli $this->id jest puste
if (@empty($this->id)) {
    include_once ("./include/next_id.inc.php");
    $this->id=NextID::next("main_keys_ftp");
}

$forms->open($action,@$this->id);
if (@$__edit!=true) {
    $forms->text("id",@$this->id,$lang->main_keys_ftp_cols["ID"],4);
} else {
    $forms->text("id",@$this->id,$lang->main_keys_ftp_cols["ID"],4,1);
    $forms->hidden("id",$this->id);
}
$forms->text("ftp",@$rec->data["ftp"],"<B>".$lang->main_keys_ftp_cols["ftp"]."</B>",50);
$forms->text("user_id_main",@$rec->data["user_id_main"],"<B>".$lang->main_keys_ftp_cols["user_id_main"]."</B>",16,$disable1);
if ($disable1==1) {
    $forms->hidden("user_id_main",@$rec->data["user_id_main"]); 
}
$forms->checkbox("active",@$rec->data["active"],$lang->main_keys_ftp_cols["active"]);
$forms->checkbox("demo",@$rec->data["demo"],$lang->main_keys_ftp_cols["demo"]);
$forms->button_submit("submit_form",$lang->edit_submit);
$forms->close();

?>
