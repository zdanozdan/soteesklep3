<?php
/**
 * Formularz edycji rekordu
 *
 * @global string $action [index.php|edit.php]
 * @global bool   $__edit true - edycja rekordu, false - dodanie rekordu
 * 
 * @author   
 * @template_version Id: edit.html.php,v 2.7 2003/08/10 22:57:20 maroslaw Exp
 * @version $Id: edit.html.php,v 1.5 2005/11/28 15:48:53 lechu Exp $
 * @package soteesklep 
 */

global $__edit, $mdbd; 

include_once ("include/forms.inc.php");
$forms = new Forms;

// wygeneruj nowe ID jesli $this->id jest puste
if (@empty($this->id)) {
    include_once ("./include/next_id.inc.php");
    $this->id=NextID::next("depository");
}

$forms->open($action,@$this->id);
if (@$__edit!=true) {
    $forms->text("id",@$this->id,$lang->depository_cols["ID"],4);
} else {
    $forms->text("id",@$this->id,$lang->depository_cols["ID"],4,1);
    $forms->hidden("id",$this->id);
}

if(!isset($rec->data["min_num"]))
    $min_num = $config->depository['general_min_num'];
else
    $min_num = $rec->data["min_num"];

    
$res = $mdbd->select("id,name", "deliverers", "1=1", array(), '', 'array');
$deliverers = array();
$deliverers[0] = "---";
if(!empty($res) && (is_array($res))) {
    for ($i = 0; $i < count($res); $i++) {
        $deliverers[$res[$i]['id']] = $res[$i]['name'];
    }
}
else {
    $deliverers = '';
}

$forms->text("user_id_main",@$rec->data["user_id_main"],$lang->depository_cols["user_id_main"],16);
$forms->text("num",@$rec->data["num"],$lang->depository_cols["num"],4);
$forms->text("min_num",$min_num,$lang->depository_cols["min_num"],4);
//$forms->text("id_deliverer",@$rec->data["id_deliverer"],$lang->depository_cols["deliverer"],16);
if(!empty($deliverers)) {
    $forms->select("id_deliverer", @$rec->data["id_deliverer"], $lang->depository_cols["deliverer"], $deliverers, "no_action");
}
else {
    if(!is_numeric(@$rec->data["id_deliverer"])) {
        $rec->data["id_deliverer"] = 0;
    }
    $forms->hidden("id_deliverer", @$rec->data["id_deliverer"]);
}
$forms->button_submit("submit_form",$lang->edit_submit);
$forms->close();

?>