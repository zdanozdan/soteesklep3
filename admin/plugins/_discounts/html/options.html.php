<?php
/**
* @version    $Id: options.html.php,v 2.2 2004/12/20 17:59:44 maroslaw Exp $
* @package    discounts
*/
global $discounts_config;
@include_once ("config/auto_config/discounts_config.inc.php");

include_once ("include/forms.inc.php");
$forms = new Forms;

if (empty($item['default_discount'])) {
    if ((! empty($discounts_config->default_discount)) && (empty($_POST['item']))) {
        $item['default_discount']=$discounts_config->default_discount;
    }
}
$forms->open("options.php","");
$forms->text("default_discount",@$item['default_discount'],$lang->discounts_options["default_discount"],2);
$forms->button_submit("submit",$lang->edit_submit);
$forms->close();
?>
