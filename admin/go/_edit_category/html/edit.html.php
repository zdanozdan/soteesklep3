<?php
/**
 * Formularz edycji rekordu
 *
 * @author  m@sote.pl 
 * \@template_version Id: edit.html.php,v 2.6 2003/07/15 08:42:57 maroslaw Exp
 * @version $Id: edit.html.php,v 1.4 2005/12/29 14:07:19 lechu Exp $
* @package    edit_category
 */

global $__edit; 
global $__deep;

include_once ("include/forms.inc.php");
$forms = new Forms;

// wygeneruj nowe ID jesli $this->id jest puste
if (@empty($this->id)) {
    include_once ("./include/next_id.inc.php");
    $this->id=NextID::next("category$__deep");
}

$forms->open($action,@$this->id);
$forms->text("id",@$this->id,$lang->edit_category_cols["ID"],4,1);
$forms->hidden("id",$this->id);
print "<input type=hidden name=deep value=$__deep>\n";

$forms->text("category",@$rec->data["category"],$lang->edit_category_cols["category"],16);
$forms->text("ord_num",@$rec->data["ord_num"],$lang->edit_category_cols["ord_num"],1);
if (@$__edit==true) {
    $forms->checkbox("change_all",1,$lang->edit_category_cols['change_all']);
}
$forms->button_submit("submit_form",$lang->edit_submit);
$forms->close();

?>
