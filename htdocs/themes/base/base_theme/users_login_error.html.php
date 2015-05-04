<!-- users_login_error.html.php --><?php
/**
* @version    $Id: users_login_error.html.php,v 1.1 2006/09/27 21:53:26 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/
?>
<div class="alert alert-error">
   <?php print $lang->users_login_error."&nbsp;".$lang->users_login_error_advice;?>
</div>
<?php
// wyswietl formularz logowania
$this->theme_file("users.html.php");
?>
