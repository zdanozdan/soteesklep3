<?php
/**
* @version    $Id: send_confirm.html.php,v 1.1 2006/09/27 21:53:26 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/
?>
<center>
<?php
global $__check;

if(! empty($__check)) {
    // sprawdz czy klient nie zmienil platnosci
    if($__check==1) {
        print $lang->register_send_confirm_ok_add_info;
    }
}
?>

<div class="alert alert-success" style="font-size:20px">
  <?php print $lang->register_send_confirm_ok; ?>
</div>

<?
// main_keys_online sprzedaz online
if (in_array("main_keys",$config->plugins)) {
    require_once ("go/_register/include/main_keys.inc.php");   
    $main_keys = new MainKeys;
    $main_keys->show();    
}

?>
</center>
