<?php
/**
 * Przekieruj uzytwkonika na strone confirm.php zamieniajac $SESSIONID na $session_id
 */

print "<pre>";
print_r($_REQUEST);
print "</pre>";
exit;
if (! empty($_REQUEST['SESSIONID'])) {
    $session_id=$_REQUEST['SESSIONID'];
    
    print "                                                                                                 
              <html>                                                                                                
                <head>                                                                                              
                  <META HTTP-EQUIV=\"refresh\" content=\"0; url=sess_confirm.php?sess_id=$session_id\">
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
