<?php
/**
 * Formularz edycji rekordu
 *
 * \@global string $action [index.php|edit.php]
 * \@global bool   $__edit true - edycja rekordu, false - dodanie rekordu
 * 
 * @author  m@sote.pl 
 * \@template_version Id: edit.html.php,v 2.7 2003/08/10 22:57:20 maroslaw Exp
 * @version $Id: edit.html.php,v 1.4 2004/12/20 18:00:00 maroslaw Exp $
* @package    main_keys
 */

global $__edit; 

include_once ("include/forms.inc.php");
$forms = new Forms;

// wygeneruj nowe ID jesli $this->id jest puste
if (@empty($this->id)) {
    include_once ("./include/next_id.inc.php");
    $this->id=NextID::next("main_keys");
}

$forms->open($action,@$this->id);

// zahaszowana edycja pola ID
//if (@$__edit!=true) {
//    $forms->text("id",@$this->id,$lang->main_keys_cols["ID"],4);
//} else {
    $forms->text("id",@$this->id,$lang->main_keys_cols["ID"],4,1);
    $forms->hidden("id",$this->id);
//}
// end

$forms->text("user_id_main",@$rec->data["user_id_main"],"<B>".$lang->main_keys_cols["user_id_main"]."</B>",16);
$forms->text("main_key",@$rec->data["main_key"],"<B>".$lang->main_keys_cols["main_key"]."</B>",60);
$forms->text("order_id",@$rec->data["order_id"],$lang->main_keys_cols["order_id"],8);
$forms->text("url",@$rec->data["url"],$lang->main_keys_cols["url"],48);
$forms->button_submit("submit_form",$lang->edit_submit);
$forms->close();

?>
