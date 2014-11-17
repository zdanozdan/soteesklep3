<?php
/**
 * Generuj sume md5 na podstawie danych przekazanych przez GET lub POST
 *
 * \@global_request_md5 string suma kontrolna parametrow
 * @author m@sote.pl
 * @version $Id: request_md5.inc,v 2.2 2004/12/20 18:02:57 maroslaw Exp $
* @package    include
 */

if (! empty($sess)) {
    $md5_text='';
    if (! empty($_REQUEST)) {
        
        while (list($key,$val) = each ($_REQUEST)) {
            if (is_array($val)) {
                $md5_2='';
                while (list($key2,$val2) = each ($val)) {
                    $md5_2.=$key.$val2;
                }
                $val=md5($md5_2);
            }
            $md5_text.=$key.$val;        
        } // end while
        
        $global_request_md5=md5($md5_text);
    }
    
    if (! empty($_SESSION['global_request_md5'])) {
        $global_prev_request_md5=$_SESSION['global_request_md5'];
    } else $global_prev_request_md5='';
    
    // zapamietaj w sesji sume kontrolna parametrow wywolania
    // po to, zeby poznij moc sprawdzic, czy wywolano reload
    $sess->register("global_request_md5",$global_request_md5);
}

?>
