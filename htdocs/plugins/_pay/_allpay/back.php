<?php
/**
 * Przekieruj uzytwkonika na strone confirm.php zamieniajac $SESSIONID na $session_id
 */

if (! empty($_REQUEST['sess_id'])) {
    $session_id=$_REQUEST['sess_id'];
 	if($_REQUEST['status'] != 'FAIL') {   
    	print "                                                                                                 
              <html>                                                                                                
                <head>                                                                                              
                  <META HTTP-EQUIV=\"refresh\" content=\"0; url=sess_confirm.php?sess_id=".$session_id."\">
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
