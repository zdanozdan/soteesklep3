<?php
/**
* @version    $Id: newsletter_info.html.php,v 1.2 2004/12/20 18:02:28 maroslaw Exp $
* @package    newsletter
*/
global $_REQUEST;
$email=my(@$_REQUEST['email']);
?>
<center>
<p>

<?php print $lang->newsletter_info;?>
<form action=index.php>
<input type=text name=email size=30 value='<?php print $email;?>'>
<input type=submit value='<?php print $lang->newsletter_add;?>'>
</form>
</center>
