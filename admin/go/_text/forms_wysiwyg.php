<?php
/**
 * Plik po¶rednicz±cy w edycji WYSIWYG
 *
 * Plik pobiera obiekt pola textarea, wpisuje jego warto¶æ do w³asnego formularza, a nastêpnie
 * wysy³a ten formularz do skryptu wywo³uj±cego edytor WYSIWYG. Po zatwierdzeniu pracy w WYSIWYG,
 * jej wynik zostaje przepisany do ¼ród³owego pola textarea, sam edytor zostaje zamkniêty.
 * 
 * @author  lech@sote.pl
 * @version $Id: forms_wysiwyg.php,v 1.6 2005/01/20 14:59:40 maroslaw Exp $
* @package    text
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../include/head.inc");

$textareaname = $_REQUEST['textareaname'];
$action = $_REQUEST['action'];
if($action == 'open_window'){
    echo "
    <html>
    <body>
    <form name=frm1 id=frm1 action=forms_wysiwyg.php method=post>
    <input type=hidden name=action value=post_names>
    <input type=hidden name=textareaname value='$textareaname'>
    <input type=hidden name=val_content id=val_content value=''>
    </form>
    
    <script>
        var frm = document.getElementById('frm1');
        var trgt_val = frm.val_content;
        src_val = window.opener.document.getElementById('$textareaname').value;
        trgt_val.value = src_val;
        frm.submit();
    </script>
    </body>
    </html>
    ";
}
//print_r($_REQUEST);
if($action == 'post_names'){
    $in_html = $_REQUEST['val_content'];
    /*
    print '[';
    print $in_html;
    print ']';
    print '[';
    print urldecode($in_html);
    print ']';
    */
/*
    $in_html = str_replace('@amp;', '&', $in_html);
    $in_html = str_replace('@hash;', '#', $in_html);

    $in_html = str_replace('@at;', '@', $in_html);//na koñcu!
*/

    require_once("WYSIWYG/wysiwyg.inc.php");
    global $config;
    $wysiwyg =& new Wysiwyg($config->lang);
    $wysiwyg->Editor($in_html, 'html_out',"forms_wysiwyg.php?action=post_values&textareaname=$textareaname");
}
if($action == 'post_values'){
    //    echo addslashes(str_replace("\n", '', $_REQUEST['html_out']));
    //$_REQUEST['html_out']=addslashes($_REQUEST['html_out']);
    $html_out = str_replace("\r\n", "&lf;", $_REQUEST['html_out']);
    $html_out = str_replace("\n", "&lf;", $html_out);
    $html_out = str_replace("\n", "&lf;", $html_out);
    $html_out = addslashes($html_out);
    echo "
    <script>
        window.opener.document.getElementById('$textareaname').value='" . $html_out . "';
        exp_lf = /&lf;/gi;
        oStr = new String(window.opener.document.getElementById('$textareaname').value);
        window.opener.document.getElementById('$textareaname').value = oStr.replace(exp_lf, '\\n');
        window.close();
    </script>
    ";
}
require_once ("include/foot.inc");
?>
