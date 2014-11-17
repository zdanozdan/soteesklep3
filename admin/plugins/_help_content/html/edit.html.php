<?php
/**
 * Formularz edycji rekordu
 *
 * \@global string $action [index.php|edit.php]
 * \@global bool   $__edit true - edycja rekordu, false - dodanie rekordu
 * 
 * @author  lech@sote.pl 
 * \@template_version Id: edit.html.php,v 2.7 2003/08/10 22:57:20 maroslaw Exp
 * @version $Id: edit.html.php,v 1.7 2005/01/14 15:42:19 krzys Exp $
* @package    help_content
 */

global $__edit; 

include_once ("include/forms.inc.php");
$forms = new Forms;

// wygeneruj nowe ID jesli $this->id jest puste
if (@empty($this->id)) {
    include_once ("./include/next_id.inc.php");
    $this->id=NextID::next("help_content");
}

$forms->open($action,@$this->id);
if (@$__edit!=true) {
    $forms->text("id",@$this->id,$lang->help_content_cols["ID"],4);
} else {
    $forms->text("id",@$this->id,$lang->help_content_cols["ID"],4,1);
    $forms->hidden("id",$this->id);
}
$forms->text("title",@$rec->data["title"],$lang->help_content_cols["title"],16);
$forms->text_area("html",@$rec->data["html"],$lang->help_content_cols["html"],10, 60);
$forms->text("title_en",@$rec->data["title_en"],$lang->help_content_cols["title_en"],16);
$forms->text_area("html_en",@$rec->data["html_en"],$lang->help_content_cols["html_en"],10, 60);
$forms->checkbox("parse", 0, $lang->help_content_cols["parse"]);
$forms->text("author",@$rec->data["author"],$lang->help_content_cols["author"],16);
$forms->button_submit("submit_form",$lang->edit_submit);
$forms->close();
?>
