<?php
/**
* @todo m@sote,pl->lech@sote.plprzeniesc ten kod do include, katalog html nie powinien zawierac skryptow,
*       jedynie elementy odpowiedzialene za wyglad
* @todo brak opisów kodu na biezaco tj blokow, nie wiadomo co kroa czesc robi
* @todo calsoc trzeba ujac w klase, odrebne funkcje nie sa dobrym rozwiazaniem
* @todo uzywaj wiecej spacji else{ powinno byc else {, podobnie ){ powinno by ) { itp., to poprawia
*       czytelnosc kodu, szcegolnie przy bardzo szybkim przegladaniu (patrz "PHP4 aplikacje" rozdzial
*       na poczatku dot. kodu)
* @version    $Id: edit_element.html.php,v 1.9 2004/12/20 18:00:57 maroslaw Exp $
* @package    themes
*/
require_once("include/php.inc.php");
require_once("./html/themes/config/config.inc.php");
require_once ("include/ftp.inc.php");

$rtc            = @$_REQUEST['tc'];
$element_id     = @$_REQUEST['element_id'];
$element_post   = @$_REQUEST['element_post'];
$thm            = @$_REQUEST['thm'];
$update_theme   = @$_REQUEST['update_theme'];

function parseTc($rtc, $value = '', $state = '') {
    global $tc;
    $tc_copy = $tc;
    if($value != '')
    $tc_ref =& $tc;
    if (is_array($rtc)) {
        while (is_array($rtc)) {
            $key=key($rtc);
            $rtc=$rtc[$key];
            if($value != '')
            $tc_ref =& $tc_ref[$key];
            $tc_copy = $tc_copy[$key];
        }
    }
    if($value != ''){
        if($state == '')
        $tc_ref = $value;
        else
        $tc_ref[$state] = $value;
    }
    return $tc_copy;
}
function array_values_recursive($ary){
    $lst = array();
    foreach( array_keys($ary) as $k ){
        $v = $ary[$k];
        if (is_scalar($v)){
            $lst[] = $v;
        }
        elseif(is_array($v)){
            $lst = array_merge($lst, array_values_recursive($v));
        }
    }
    return $lst;
}

$image = parseTc($rtc);

if($element_post == 1){
    
    $state = '';
    if(is_uploaded_file(@$_FILES['userfile']['tmp_name']))
    $uploaded_file = $_FILES['userfile'];
    
    if(is_uploaded_file(@$_FILES['userfile_out']['tmp_name'])){
        $uploaded_file = $_FILES['userfile_out'];
        $state = 'out';
    }
    if(is_uploaded_file(@$_FILES['userfile_over']['tmp_name'])){
        $uploaded_file = $_FILES['userfile_over'];
        $state = 'over';
    }
    
    if(is_uploaded_file(@$uploaded_file['tmp_name'])){
        move_uploaded_file($uploaded_file['tmp_name'], $DOCUMENT_ROOT . '/tmp/' . $uploaded_file['name']);
        if($state != '')
        $image = $image[$state];
        if(!is_array($image)){
            if(substr($image, 0, 4) != 'user')
            $image = 'user/' . $image;
            $filename = basename($uploaded_file['name']);
            $dirname = dirname($image);
            $fileentry = $dirname . '/' . $filename;
            parseTc($rtc, $fileentry, $state);
            // m@sote.pl 
            // $dirname = $DOCUMENT_ROOT . "/plugins/_themes/$prefix" . dirname($image);
            /* wskazeni docelowegokatalogu FTP powinno byc tworzone z wykorzystaniem zmeinej
               $config->ftp['ftp_dir'], bo nie wiemy jakie sa ustawienai FTPa, raz bedzie
               to sciezka zgodna z $DOCUMENT_ROOT innym razem bedzie to tylko /soteesklep2
               */
            $dirname = $config->ftp['ftp_dir']."/admin/plugins/_themes/$prefix" . dirname($image);
            // end
            
            
            // m@sote.pl
            //$dirname = $DOCUMENT_ROOT . "/plugins/_themes/$prefix" . dirname($image);            
            $dirname = $config->ftp['ftp_dir'] . "/admin/plugins/_themes/$prefix" . dirname($image);
            // end
            $local = $DOCUMENT_ROOT . '/tmp/' . $uploaded_file['name'];
            $ftp->connect();
            $ftp->put($local, $dirname, $filename);
            $ftp->close();
            unlink($local);
        }
        $php =& new PHPFile;
        $x= $php->genPHPFileValues('config', array('theme_config'=> $config->theme_config));
        // m@sote.pl
        // $dirname = $DOCUMENT_ROOT . "/plugins/_themes/html/themes/$thm/config/";
        $dirname = $config->ftp['ftp_dir'] . "/admin/plugins/_themes/html/themes/$thm/config/";
        // end
        $filename = "user_config.inc.php";
        $local = $DOCUMENT_ROOT . '/tmp/' . $filename;
        if (!$handle = fopen($local, 'w')) {
            echo "Nie mo¿na utworzyæ pliku ($local)";
            exit;
        }
        
        if (fwrite($handle, $x) === FALSE) {
            // @todo komunikaty tylko w lang !!!
            echo "Nie mo¿na pisaæ do pliku ($local)";
            exit;
        }
        fclose($handle);
        
//        echo "[$local, $dirname, $fileentry]";
        $ftp->connect();        
        $ftp->put($local, $dirname, $filename);
        $ftp->close();
        unlink($local);
        
        echo "
        <script>
            window.opener.location.reload();
            window.close();
        </script>
        ";
    }
}

if($update_theme != 1){
    if(is_array($image)){
        $photo['out'] = $prefix . $image['out'];
        if(is_file($photo['out']))
        $photo['out'] = "<img src=\"" . $photo['out'] . "\">";
        else
        $photo['out'] = "<div style='background-color: white; font-weight: bold; font-style: italic;'>brak pliku</div>";
        
        $photo['over'] = $prefix . $image['over'];
        if(is_file($photo['over']))
        $photo['over'] = "<img src=\"" . $photo['over'] . "\">";
        else
        $photo['over'] = "<div style='background-color: white; font-weight: bold; font-style: italic;'>brak pliku</div>";
        
        // @todo ten element powinien byc w pliku html.php ale nie jako PHP tylko jako zwykly HTML z elementami PHP
        // NIE WOLNO! uztywac polskich sformuowac w plikach html php itp. uzywamy TYLKO langow!!! BARDZO WAZNE!!!        
        echo "
    <table bgcolor=#999999 cellpadding=5 border=0 cellspacing=0>
    <form action='action_edit.php' method=post enctype='multipart/form-data'>
    <input type=hidden MAX_FILE_SIZE=20000>
    <input type=hidden name=element_id value=$element_id>
    <input type=hidden name=popup value=1>
    <input type=hidden name=element_post value=1>
    <input type=hidden name=thm value=$thm>
    <input type=hidden name=$element_id value=1>
        <tr>
            <td bgcolor=white colspan=3>
                $lang->themes_current_graphics:<br>
            </td>
        </tr>
        <tr>
            <td bgcolor=white nowrap>$lang->themes_state 1:</td>
            <td background='img/background.gif' align=center valign=middle>
                " . $photo['out'] . "
            </td>
            <td bgcolor=white>
                <input type=file name=userfile_out>
            </td>
        </tr>
        <tr>
            <td bgcolor=white nowrap>$lang->themes_state 2:</td>
            <td background='img/background.gif' align=center valign=middle>
                " . $photo['over'] . "
            </td>
            <td bgcolor=white>
                <input type=file name=userfile_over>
            </td>
        </tr>
        <tr>
            <td bgcolor=white colspan=3>
                <input type=submit value=$lang->themes_approve>
            </td>
        </tr>
    </form>
    </table>
    ";
    }
    else{
        $photo = $prefix . $image;
        if(is_file($photo))
        $photo = "<img src=\"$photo\">";
        else
        $photo = "<div style='background-color: white; font-weight: bold; font-style: italic;'>brak pliku</div>";
        echo "
    <table bgcolor=#999999 cellpadding=5 border=0 cellspacing=0>
    <form action='action_edit.php' method=post enctype='multipart/form-data'>
    <input type=hidden MAX_FILE_SIZE=20000>
    <input type=hidden name=element_id value=$element_id>
    <input type=hidden name=popup value=1>
    <input type=hidden name=element_post value=1>
    <input type=hidden name=thm value=$thm>
    <input type=hidden name=$element_id value=1>
        <tr>
            <td bgcolor=white>
                $lang->themes_current_graphics:
            </td>
        </tr>
        <tr>
            <td background='img/background.gif' align=center valign=middle>
    ";
        print $photo;
        echo "
            </td>
        </tr>
        <tr>
            <td bgcolor=white>
                <input type=file name=userfile>
            </td>
        </tr>
        <tr>
            <td bgcolor=white>
                <input type=submit value=$lang->themes_approve>
            </td>
        </tr>
    </form>
    </table>
    ";
    }
}
else{
    $paths = array_values_recursive($config->theme_config);
    $ftp->connect();
    for($i = 0; $i < count($paths); $i++){
        if((substr($paths[$i], 0, 4) == 'user') && (is_file($prefix . $paths[$i]))){
            $local = $DOCUMENT_ROOT . '/plugins/_themes/' . $prefix . $paths[$i];
            $filename = basename($local);
            // m@sote.pl
            //$remote = dirname($DOCUMENT_ROOT . '/../htdocs/themes/base/' . strstr($prefix . $paths[$i], $thm)) . '/';
            $remote = dirname($config->ftp['ftp_dir'] . '/htdocs/themes/base/' . strstr($prefix . $paths[$i], $thm)) . '/';
            // end
            $ftp->put($local, $remote, $filename);
        }
    }
    
    // m@sote.pl
    //$ftp->put($DOCUMENT_ROOT . "/plugins/_themes/html/themes/$thm/config/user_config.inc.php", $DOCUMENT_ROOT . "/../htdocs/themes/base/$thm/config/", 'user_config.inc.php');
    $ftp->put($DOCUMENT_ROOT. "/plugins/_themes/html/themes/$thm/config/user_config.inc.php", $config->ftp['ftp_dir'] . "/htdocs/themes/base/$thm/config/", 'user_config.inc.php');
    // end 
    $ftp->close();
    
    echo "
    <div width=100% height=100% valign=middle align=center>
    <br><br>
    $lang->themes_page_updated
    <br><br>
        <button onclick='window.close()'>$lang->themes_window_close</button>
    </div>
    ";
}
?>
