<?php
/**
 * Formularz edycji rekordu
 *
 * \@global string $action [index.php|edit.php]
 * \@global bool   $__edit true - edycja rekordu, false - dodanie rekordu
 * 
 * @author  pmalinski@sote.pl 
 * @version $Id: edit.html.php,v 1.4 2006/01/20 10:10:35 lechu Exp $
* @package    partners
 */

global $__edit; 

include_once ("include/forms.inc.php");
$forms = new Forms;

// wygeneruj nowe ID jesli $this->id jest puste
if (@empty($this->id)) {
    include_once ("./include/next_id.inc.php");
    $this->id=NextID::next("partners");
}

$forms->open($action,@$this->id);

// jesli jest to edycja rekordu wylacz partner_id i przekaz hidden'a
if (! empty($__edit)) {
    $forms->text("partner_id",@$rec->data["partner_id"],$lang->partners_cols["partner_id"],16,1);
    $forms->hidden("partner_id",@$rec->data["partner_id"]);
} else $forms->text("partner_id",@$rec->data["partner_id"],$lang->partners_cols["partner_id"],16);

$forms->text("name",@$rec->data["name"],$lang->partners_cols["name"],16);
$forms->text("www",@$rec->data["www"],$lang->partners_cols["www"],16);
$forms->text("email",@$rec->data["email"],$lang->partners_cols["email"],16);
$forms->text("rake_off",@$rec->data["rake_off"],$lang->partners_cols["rake_off"],16);
$forms->text("login",@$rec->data["login"],$lang->partners_cols["login"],16);
$forms->text("password",@$rec->data["password"],$lang->partners_cols["password"],16);

$forms->button_submit("submit_form",$lang->edit_submit);

$forms->close();


?>
