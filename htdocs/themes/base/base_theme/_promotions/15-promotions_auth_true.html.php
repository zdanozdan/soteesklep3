<?php
/**
* @version    $Id: promotions_auth_true.html.php,v 1.3 2004/12/20 18:02:29 maroslaw Exp $
* @package    promotions
*/
?>
PROMOTIONS2
<p>
<?php print $lang->promotions_auth_true;?>
<p>

<?php
global $shop;
$shop->basket();
if (! $shop->basket->isEmpty()) {
    $form = new HTML_Form("/go/_register/index.php","POST");
    $form->addSubmit("submit_proceed",$lang->promotions_go2basket);
    $form->display();
}
?>
