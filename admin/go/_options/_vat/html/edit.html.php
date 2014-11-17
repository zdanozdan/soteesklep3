<?php
/**
 * PHP Template:
 * Formularz edycji rekordu
 *
 * @author m@sote.pl 
 * \@template_version Id: edit.html.php,v 2.1 2003/03/13 11:29:00 maroslaw Exp
 * @version $Id: edit.html.php,v 1.2 2004/12/20 17:58:43 maroslaw Exp $
* @package    options
* @subpackage vat
 */
 
include_once ("include/forms.inc.php");
$forms = new Forms;

$forms->open($action,@$this->id);
$forms->text("vat",@$rec->data["vat"],$lang->vat_cols["vat"],2);
$forms->button_submit("button_submit",$lang->vat_submit);
$forms->close();

?>
