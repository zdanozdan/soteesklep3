<?php
/**
 * Przekieruj uzytwkonika na strone confirm.php zamieniajac $SESSIONID na $session_id
* @version    $Id: confirm_false.php,v 1.2 2004/12/20 18:02:02 maroslaw Exp $
* @package    pay
* @subpackage ecard
 */

if (! empty($_REQUEST['SESSIONID'])) {
    $session_id=$_REQUEST['SESSIONID'];
    print "                                                                                                 
              <html>                                                                                                
                <head>                                                                                              
                  <META HTTP-EQUIV=\"refresh\" content=\"0; url=sess_confirm_false.php?session_id=$session_id\">          
                </head>                                                                                             
              <html>                                                                                                
          "; 
} else {
    print "                                                                                                 
              <html>                                                                                                
                <head>                                                                                              
                  <META HTTP-EQUIV=\"refresh\" content=\"0; url=error.php\">
                </head>                                        
              <html>
          "; 
}
?>
