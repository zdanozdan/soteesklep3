<?php
/**
* Formularz edycji rekordu
*
* \@global string $action [index.php|edit.php]
* \@global bool   $__edit true - edycja rekordu, false - dodanie rekordu
*
* @author  m@sote.pl
* \@template_version Id: edit.html.php,v 2.7 2003/08/10 22:57:20 maroslaw Exp
* @version $Id: edit.html.php,v 1.7 2004/12/20 18:00:06 maroslaw Exp $
*
* \@verified 2004-03-22 m@sote.pl
* @package    newsedit
* @subpackage newsedit_groups
*/

global $__edit;

include_once ("include/forms.inc.php");
$forms = new Forms;

// wygeneruj nowe ID jesli $this->id jest puste
if (@empty($this->id)) {
    include_once ("./include/next_id.inc.php");
    $this->id=NextID::next("newsedit_groups");
}

$forms->open($action,@$this->id);
if (@$__edit!=true) {
    $forms->text("id",@$this->id,$lang->newsedit_groups_cols["ID"],4);
} else {
    $forms->text("id",@$this->id,$lang->newsedit_groups_cols["ID"],4,1);
    $forms->hidden("id",$this->id);
}
$forms->text("name",@$rec->data["name"],$lang->newsedit_groups_cols["name"],16);

if (! empty($this->id)) {
    print "<tr>\n";
    print "<td align=right>".$lang->newsedit_groups_cols['url']."</td>\n";
    print "<td>/plugins/_newsedit/index.php?group=".@$this->id."</td>\n";
    print "</tr>\n";
}

//$forms->select("template_info",@$rec->data['template_info'],@$lang->newsedit_groups_cols["template_info"],array("1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5"),"-1");
//$forms->select("template_row",@$rec->data['template_row'],@$lang->newsedit_groups_cols["template_row"],array("1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5"),"-1");

$forms->checkbox("multi",@$rec->data['multi'],@$lang->newsedit_groups_cols['multi']);
$forms->button_submit("submit_form",$lang->edit_submit);
$forms->close();

?>
