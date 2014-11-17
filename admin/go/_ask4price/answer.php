<?php
/**
 * Zapytanie o cenê
 * 
 * @author lech@sote.pl
 * @version $Id: answer.php,v 1.2 2005/06/30 12:24:17 lechu Exp $
* @package    ask4price
* \@ask4price
 */
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
include_once ("../../../include/head.inc");
require_once ("lib/Mail/MyMail.php");

$from = $config->order_email;  // od kogo
$to = $_REQUEST["email"];
$subject = @$_REQUEST["subject"];
$content = @$_REQUEST["content"];
$reply = $from;
if (empty($subject)) {
    $theme->head_window();
    echo "<center>";
    echo $lang->ask4price_no_subject;
    echo "<br><br>";
    echo "<button onclick='history.go(-1)'>" . $lang->back . "</button>";
    echo "</center>";
    $theme->foot_window();
    include_once ("include/foot.inc");
}
else {
    $mail = new MyMail;
    
    if($mail->send($from,$to,$subject,$content,$reply)){
        $message = $lang->ask4price_send_ok;
        
        $request_id = $_REQUEST["request_id"];
        $content = addslashes($content);
        $subject = addslashes($subject);
        $content = "\n\n************************\n[" . date("Y-m-d, H:i:s") . "]\n" . 
        $lang->ask4price_subject . ": " . $subject . "\n\n" . $content;
        $mdbd->update("ask4price", "active=0, date_update=NOW(), answer='$content'", "request_id=?", array($request_id => "int"));
    }
    else {
        $message = $lang->ask4price_send_error;
    }
    
    $theme->head_window();
    
    ?>
    <center>
    <table width="100%" height="100%">
        <tr>
            <td width="100%" height="100%" align="center" valign="middle">
                <?php echo $message; ?><br><br>
                <button onclick="window.close()"><?php echo $lang->ask4price_close; ?></button>
            </td>
        </tr>
    </table>
    </center>
    <script>
        window.opener.history.go(0);
    </script>
    <?php
    
    $theme->foot_window();
    
    
    // stopka
    include_once ("include/foot.inc");
}
?>