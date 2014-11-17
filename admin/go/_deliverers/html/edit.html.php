<?php
/**
 * Formularz edycji rekordu
 *
 * @global string $action [index.php|edit.php]
 * @global bool   $__edit true - edycja rekordu, false - dodanie rekordu
 * 
 * @author  lech@sote.pl 
 * @template_version Id: edit.html.php,v 2.7 2003/08/10 22:57:20 maroslaw Exp
 * @version $Id: edit.html.php,v 1.1 2005/11/18 15:29:06 lechu Exp $
 * @package soteesklep 
 */

global $__edit; 

include_once ("include/forms.inc.php");
$forms = new Forms;

// wygeneruj nowe ID jesli $this->id jest puste
if (@empty($this->id)) {
    include_once ("./include/next_id.inc.php");
    $this->id=NextID::next("deliverers");
}

$forms->open($action,@$this->id);
if (@$__edit!=true) {
    $forms->text("id",@$this->id,$lang->deliverers_cols["ID"],4);
} else {
    $forms->text("id",@$this->id,$lang->deliverers_cols["ID"],4,1);
    $forms->hidden("id",$this->id);
}
$forms->text("name",@$rec->data["name"],$lang->deliverers_cols["name"],16);
$forms->text("email",@$rec->data["email"],$lang->deliverers_cols["email"],16);
$forms->button_submit("submit_form",$lang->edit_submit);
$forms->close();

?>