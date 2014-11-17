<?php
/**
* Ustawianie parametrów sesji za pomoca AJAX.
*
* @author  tomasz@mikran.pl
* @version $Id$
*/

$global_database=true;
require_once ("../../../include/head.inc");

global $sess;
if (!empty($_REQUEST['req_name']))
{
   if (!empty($_REQUEST['req_value']))
   {
      $sess->register($_REQUEST['req_name'],$_REQUEST['req_value']);
      print("Name: ".$_REQUEST['req_name'] . " Value: " . $_REQUEST['req_value']);
   }
}   
?>