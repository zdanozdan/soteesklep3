<?php
/**
* Formularz dot. wprowadzenia nowego numeru PIN.
* 
* @author  m@sote.pl
* @version $Id: pin.html.php,v 2.2 2004/12/20 17:57:50 maroslaw Exp $
* @package    admin_users
* @subpackage pin
*/

/**
* Obs³uga generowania formularza.
*/
include_once ("include/forms.inc.php");
$forms = new Forms;

$forms->open("index.php","");
$forms->password("pin",@$item['pin'],$lang->pin_names["pin"],16);
$forms->password("new",@$item['new'],$lang->pin_names["new"],16);
$forms->password("new2",@$item['new2'],$lang->pin_names["new2"],16);
$forms->button_submit("submit",$lang->pin_change);
$forms->close();
?>
