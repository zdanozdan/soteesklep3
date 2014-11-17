<?php
/**
* @version    $Id: polcard_error.html.php,v 2.3 2004/12/20 18:02:28 maroslaw Exp $
* @package    polcard
*/
global $__polcard_error; // info przekazane z PolCard'u
?>
<p>

<center>
<?php print $lang->polcard_error_info;?>
<p>
<font color=red><?php print $__polcard_error;?></font>

<p>
<a href=/go/_register/register2.php><u><?php print $lang->polcard_choose_pay_method;?></u></a>
</center>

<p>
