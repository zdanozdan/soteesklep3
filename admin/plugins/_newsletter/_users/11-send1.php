<?php
/**
* Wy¶lij wprowadzony newsletter na adresy e-mail z zaznaczonych grup.
*
* Skrypt dzia³a w trybie emulacji sesji z obs³ug± HTTP-Streaming.
* Klientowi pokazuje siê w nowym oknie pasek statusu, zmienij±cy siê on-line, odpowiadaj±cy
* ilo¶ci wys³anych maili.
*
* @author  rdiak@sote.pl
* @version $Id: send1.php,v 2.19 2006/03/03 07:52:57 krzys Exp $
*
* verified 2004-03-10 m@sote.pl
* @package    newsletter
* @subpackage users
*/

$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Naglowek skryptu.
*/
require_once ("../../../include/head_stream.inc.php");
require_once ("include/ftp.inc.php");
// obsluga generowania pliku konfiguracyjnego uzytkwonika
require_once("lib/Mail/MyMail.php");


$theme->head_window();
$theme->bar($lang->newsletter_sending);

// za³aduj legende
include_once("./html/newsletter_legend.html.php");
include_once("./include/newsletter_control.inc.php");

$control=new NewsletterControl;

require_once("themes/stream.inc.php");
$stream= new StreamTheme;
$stream->title_500();

// naglowek

if (! empty($_REQUEST['send'])) {
    $send=$_REQUEST['send'];
} else {
    $send=false;
}

if (! empty($_REQUEST['groups'])) {
    $groups=$_REQUEST['groups'];
    $where=" AND (";
    foreach($groups as $value) {
        $value=addslashes($value);
        $where.=" groups LIKE '%:".$value.":%' OR";
    }
    $where=ereg_replace("OR$",")",$where);
} else {
    $groups=false;
    $where=' AND groups is NULL';
}

if (! empty($_REQUEST['lang'])) {
    $lang_key=addslashes($_REQUEST['lang']);
    $where.=" AND lang='".$lang_key."' ";   
}
if ($lang_key=='pl'){
require_once("config/auto_config/newsletter/newsletter_config_L0.inc.php");
}
if ($lang_key=='en'){
require_once("config/auto_config/newsletter/newsletter_config_L1.inc.php");
}
if ($lang_key=='de'){
require_once("config/auto_config/newsletter/newsletter_config_L2.inc.php");
}
if ($lang_key=='cz'){
require_once("config/auto_config/newsletter/newsletter_config_L3.inc.php");
}
if ($lang_key=='ru'){
require_once("config/auto_config/newsletter/newsletter_config_L4.inc.php");
}

$send_mail=new MyMail;
if (empty($_POST['item']['subject'])) {
    die ($lang->newsletter_no_subject);
} else $subject=$_POST['item']['subject'];
if (empty($_POST['item']['message'])) {
    die ($lang->newsleter_no_body);
} else $message=$_POST['item']['message'];

// odczytaj adresy email z bazy
$query="SELECT id,email,status,active FROM newsletter WHERE active=1".$where;
$query=$control->checkQuery($query);
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) {
            // zapisz informacje o wysylanym newsletterze w bazie danych
            $control->saveInformation();
        	$k=1;
            print "<br>";
            $send_ok=0;
            $send_error=0;
            $send_leave=0;
            for($row=0;$row<$num_rows;$row++) {
                if( $row > 10000 ) {
                    break;
                }
                $content='';
                $id=$db->FetchResult($result,$row,"id");
                $email=$db->FetchResult($result,$row,"email");
                $status=$db->FetchResult($result,$row,"status");
                $active=$db->FetchResult($result,$row,"active");
                // jesli konto jest aktywne
                if($status == 1) {
                    include ("./html/newsletter_info.html.php");
                    $content.=$message."\n\n\n".$info;
                    // jesli wys³anie maila powiod³o sie to
                    if($control->checkOldEmail($email)) {
                    	if($send_mail->send($config_newsletter->newsletter_sender,$email,$subject,$content,"",@$_REQUEST['item']['type'])) {
                        	$control->saveEmailToFile($email);
                    		$stream->line_blue();
                        	flush();
                        	$send_ok++;
                    	} else {
                        	$stream->line_red();
                        	flush();
                        	$send_error++;
                    	}
                    }	
                } else {
                    $stream->line_green();
                    flush();
                    $send_leave++;
                }
                $k++;
                if ($k==500) {
                    $k=0;
                    print "<br>";
                }
            }
        } else {
            print "<center><br>$lang->newsletter_empty<br></center>";
            exit;
        }
    } else die ($db->Error());
} else die ($db->Error());

$control->endAction($send_ok,$send_error,$send_leave);
//za³aduj legende
include_once("./html/newsletter_end.html.php");

$theme->foot_window();
include_once ("include/foot.inc");
?>
