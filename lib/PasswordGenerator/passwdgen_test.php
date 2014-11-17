<?php
/***
* This is a test file for the PasswordGenerator Class.
* This class is designed to create random passwords to
* set up initial user accounts.
* sample at http://www.gilbertsonconsulting.com/test/passwdgen_test.php
***/
?>
<H4>Text Password</h4>

<?php

require_once("PasswordGenerator.php");
$Password = new PasswordGenerator(10, 20);

$RandPassword = $Password->getHTMLPassword();
print($RandPassword);


?>

<H4>Image Password</h4>
<img src="passwdgen_imgtest.php" />

<p>Please refresh your browser to see another password.</p>
