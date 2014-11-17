<?php
/**
* Formularz do wprowadzania danych produktu, zwi±zanych z indeksowaniem m.in. w googlach.
*
* @author  m@sote.pl
* @version $Id: google.html.php,v 2.2 2004/12/20 17:58:01 maroslaw Exp $
*
* \@global array $__item dane produktu z bazy
* \@global int   $__id   id edytowanego produktu
* @package    edit
*/

require_once ("HTML/Form.php");

if (! empty($__item)) {
    $item=&$__item;
} else $item=array();

$form =& new HTML_Form("google.php","POST","googleForm");
$form->addHidden("id",$__id);
$form->addText("item[title]",$lang->edit_google_cols['title'],@$item['title'],64);
$form->addText("item[description]",$lang->edit_google_cols['description'],@$item['description'],64);
$form->addText("item[keywords]",$lang->edit_google_cols['keywords'],@$item['keywords'],64);

$form->submitButtons=true;
$form->addSubmit("submit",$lang->update);

print "<center>\n";
$form->display();
print "</center>\n";
?>
