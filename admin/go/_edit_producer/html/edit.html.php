<?php
/**
 * Formularz edycji rekordu
 *
 * @author  m@sote.pl 
 * \@template_version Id: edit.html.php,v 2.6 2003/07/15 08:42:57 maroslaw Exp
 * @version $Id: edit.html.php,v 1.2 2004/12/20 17:58:12 maroslaw Exp $
* @package    edit_producer
 */

global $__edit; 

include_once ("include/forms.inc.php");
$forms = new Forms;

// wygeneruj nowe ID jesli $this->id jest puste
if (@empty($this->id)) {
    include_once ("./include/next_id.inc.php");
    $this->id=NextID::next("producer");
}

$forms->open($action,@$this->id);
$forms->text("id",@$this->id,$lang->edit_producer_cols["ID"],4,1);
$forms->hidden("id",$this->id);

$forms->text("producer",@$rec->data["producer"],$lang->edit_producer_cols["producer"],16);
if ($__edit==true) {
    $forms->checkbox("change_all",1,$lang->edit_producer_cols['change_all']);
}
$forms->button_submit("submit_form",$lang->edit_submit);
$forms->close();

?>
