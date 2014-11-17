<?php
/**
 * Formularz edycji rekordu
 *
 * \@global string $action [index.php|edit.php]
 * \@global bool   $__edit true - edycja rekordu, false - dodanie rekordu
 * 
 * @author  m@sote.pl 
 * \@template_version Id: edit.html.php,v 2.7 2003/08/10 22:57:20 maroslaw Exp
 * @version $Id: edit.html.php,v 1.5 2005/02/16 09:44:13 maroslaw Exp $
* @package    promotions
 */

global $__edit; 
global $DOCUMENT_ROOT;

include_once ("include/forms.inc.php");
$forms =& new Forms;

require_once ("include/table.inc");

// wygeneruj nowe ID jesli $this->id jest puste
if (@empty($this->id)) {
    include_once ("./include/next_id.inc.php");
    $this->id=NextID::next("promotions");
}

$table =& new HTMLTable();
$table->openRow();
$table->openCol("width=70%");

$forms->open($action,@$this->id,"myForm","multipart/form-data");
if (@$__edit!=true) {
    $forms->text("id",@$this->id,$lang->promotions_cols["ID"],4);
} else {
    $forms->text("id",@$this->id,$lang->promotions_cols["ID"],4,1);
    $forms->hidden("id",$this->id);
}

if (empty($rec->data['lang'])) {
    $rec->data['lang']=$config->lang;
}

$forms->checkbox("active",@$rec->data["active"],$lang->promotions_cols["active"]);
$forms->select("lang",@$rec->data['lang'],$lang->lang,$config->languages_names,"none");
$forms->text("name",@$rec->data["name"],$lang->promotions_cols["name"],60);
$forms->file("photo",$lang->promotions_cols["photo"]);
$forms->hidden("photo2",@$rec->data['photo']);
$forms->text("discount",@$rec->data["discount"],$lang->promotions_cols["discount"],8);
// $forms->text("amount",@$rec->data["amount"],$lang->promotions_cols["amount"]." ($config->currency)",8);
$forms->text_area("short_description",@$rec->data['short_description'],$lang->promotions_cols['short_description'],5,60,"hard");
$forms->text_area("description",@$rec->data['description'],$lang->promotions_cols['description'],10,60,"hard");
// $forms->checkbox("active_code",@$rec->data["active_code"],$lang->promotions_cols["active_code"]);
for ($i=1;$i<=10;$i++) {
    $forms->text("code$i",@$rec->data["code$i"],$lang->promotions_cols["code"]." $i",16);   
}
$forms->button_submit("submit_form",$lang->edit_submit);
$forms->close();

$table->closeCol();
$table->openCol("width=30% valign=top");
if ((! empty($rec->data['photo']))  && (file_exists("$DOCUMENT_ROOT/photo/_promotions/".$rec->data['photo']))) {
    print "<img src=\"/photo/_promotions/".$rec->data['photo']."\" alt=''>\n";
}
$table->closeCol();
$table->closeRow();
$table->close();
?>
