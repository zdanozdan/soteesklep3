<?php
/**
* Odczytaj za³±czone pliki i zainstaluj je w odpowiednim miejscu i z odpowiedni± nazw±.
*
* @author  m@sote.pl
* @version $Id: upload_files.inc.php,v 1.1 2005/08/02 10:37:23 maroslaw Exp $
* @package google
*/

/**
* Obs³uga FTP
*/
require_once ("include/ftp.inc.php");

/**
* Zmiana kodowania znaków
*/
require_once ("ConvertCharset/ConvertCharset.class.php");

// zmieñ nazwe pliku styli na nazwê s³owa kluczowego
if (! empty($data_keywords[0])) {

    $ftp->connect();
    // za³±cz logo
    if (! empty($_FILES['item']['name']['logo'])) {

        // instaluj w htdocs
        $ftp->put($_FILES['item']['tmp_name']['logo'],$config->ftp['ftp_dir']."/htdocs/themes/base/google/_img/",$_FILES['item']['name']['logo']);
        
        // kopie instaluj w admin - do podgl±du
        $ftp->put($_FILES['item']['tmp_name']['logo'],$config->ftp['ftp_dir']."/admin/go/_google/html/_img/",$_FILES['item']['name']['logo']);

        $__logo=$_FILES['item']['name']['logo'];
    } else $__logo=$google_config->logo;


    
    // style - zmiana nazwy pliku
    if ((! empty($_REQUEST['item']['keyword_plain']))  &&
     ($google_config->keyword_plain!=$_REQUEST['item']['keyword_plain'])
     )
     {                
        $main_keyword_file=$_REQUEST['item']['keyword_plain'].".css";
        $ftp_subdir="/htdocs/themes/base/google/_style/";
        $style_dir=$DOCUMENT_ROOT."/..".$ftp_subdir;
        $style_file="$style_dir/style.css";
        
        $fd=fopen($style_file,"r");
        $style_data=fread($fd,filesize($style_file));
        fclose($fd);
        
        // zast±p .keyword_plain na slowo kluczowe w nazwie stylu
        $keyword_plain=$_REQUEST['item']['keyword_plain'];
        $keyword_plain=trim(ereg_replace(" ","_",$keyword_plain));        
        $style_data=ereg_replace("keyword_plain",$keyword_plain,$style_data);
        
        $file_tmp=$DOCUMENT_ROOT."/tmp/style_google.css";
        $fd=fopen($file_tmp,"w+");
        fwrite($fd,$style_data,strlen($style_data));
        fclose($fd);                        
                
        $ftp->put($file_tmp,$config->ftp['ftp_dir'].$ftp_subdir,$main_keyword_file);

    }
    $ftp->close();
}

?>