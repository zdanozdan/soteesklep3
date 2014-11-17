<?php
/**
* Formularz do wprowadzania dodatkowych kategorii dla produktu.
*
* @author  m@sote.pl
* @version $Id: category.html.php,v 2.2 2004/12/20 17:57:59 maroslaw Exp $
*
* \@global array $__item dane produktu z bazy
* \@global int   $__id   id edytowanego produktu
* @package    edit
*/

require_once ("HTML/Form.php");

if (! empty($__item)) {
    $item=&$__item;
} else $item=array();

$form =& new HTML_Form("category.php","POST","categoryForm");
$form->addHidden("id",$__id);
$form->addText("item[category_multi_1]",$lang->edit_category_cols['category_multi_1'],@$item['category_multi_1'],64);
$form->addText("item[category_multi_2]",$lang->edit_category_cols['category_multi_2'],@$item['category_multi_2'],64);

$form->submitButtons=true;
$form->addSubmit("submit",$lang->update);

print "<center>\n";
$form->display();
print "</center>\n";
?>
