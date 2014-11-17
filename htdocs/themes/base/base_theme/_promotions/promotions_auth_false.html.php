PROMOTIONS5<?php
/**
* @version    $Id: promotions_auth_false.html.php,v 1.2 2004/12/20 18:02:29 maroslaw Exp $
* @package    promotions
*/
?>
<p>
<?php print $lang->promotions_auth_false;?>
<?php
$form = new HTML_Form("/go/_register/index.php","POST");
$form->addSubmit("submit_proceed",$lang->promotions_go2basket);
$form->display();
?>
