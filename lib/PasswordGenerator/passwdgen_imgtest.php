<?php
/***
* This is a example for the PasswordGenerator Class.
* This demonstrates how a password can be shown as an image
* Also semi-tempest resistant, with random text position,
* and nifty gray color which should difuse tempest emissions
* Created By: Flinn Mueller (flinn AT activeintra DOT net)
* Last Updated: 5/01/02
* Modified By: Kevin Gilbertson (kevin@gilbertsonconsulting.com)
* Last Updated: 5/15/02
***/

require_once("PasswordGenerator.php");

$Password = new PasswordGenerator(8, 12);
$RandPassword = $Password->getImgPassword();

?>