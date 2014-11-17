<?php
/**
* @version    $Id: configure.html.php,v 1.2 2005/12/09 10:44:07 scalak Exp $
* @package    dictionary
*/
print "<BR><CENTER>";
$theme->desktop_open("40%");
print "<div align=\"left\">";
/**
* Dodaj obs³ugê formularzy.
*/
require_once ("HTML/Form.php");
require_once ("include/metabase.inc");
global $config,$lang, $database;

$count=$database->sql_select("count(*)","order_register");
print "<div align='center'><nobr>".$lang->points_desc."</nobr></div><BR>";

$form =& new HTML_Form("configure.php","POST");
$form->addHidden("update","true");
$form->addText("configure[for_product]",$lang->points_form['for_product']." ".$config->currency,$config_points->for_product,5);
$form->addText("configure[for_recommend]",$lang->points_form['for_recommend'],$config_points->for_recommend,5);
$form->addText("configure[for_review]",$lang->points_form['for_review'],$config_points->for_review,5);

//if($count) {
  //  $form->addSelect("configure[for_type]",$lang->points_form['for_type'],$lang->points_type_sum,@$config_points->for_type,1,'',false,"disabled");
//} else {
unset($lang->points_type_sum[1]);    
$form->addSelect("configure[for_type]",$lang->points_form['for_type'],$lang->points_type_sum,@$config_points->for_type);
//}    

$form->addSubmit("submit",$lang->update);
$form->display();

$theme->desktop_close();
print "</div></CENTER>";
?>
