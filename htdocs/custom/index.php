<?php 
$global_database=true;  
$DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];  
include_once ("../../include/head.inc"); 
  
// naglowek  
$theme->head(); 
$theme->theme_file("mail_form.html.php");
// stopka  
$theme->foot();  
include_once ("include/foot.inc"); 
?> 



