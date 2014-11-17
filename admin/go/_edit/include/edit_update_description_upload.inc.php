<?php
/**
 * Wstawienie opisów z za³±czonych plików
 *
 * @author  m@sote.pl
 * @version $Id: edit_update_description_upload.inc.php,v 2.3 2004/04/29 11:40:20 scalak Exp $
 * @package admin
 * @subpackage edit
 *
 * @verified 2004-03-16 m@sote.pl
 */

/**
 * Obs³uga za³±czonych plików
 */
class FileUpload {
    var $error="";                       // komunikat o bledzie

    /**
    * Odczytaj zawarto¶æ za³±czonego pliku
    *
    * @param array &$var   tablica z danymi za³±czonego pliku
    * @global $this->error b³±dy wygenrowane podczas odczytu pliku
    * 
    * @return string zawarto¶c pliku    
    */
    function read_tmp_file(&$var) {
        global $config,$lang;
        
        $file_tmp_name=$var['tmp_name'];
        $file_size=$var['size'];
        $maxkb=intval($config->max_file_size/1000);
        if ($file_size>$config->max_file_size) {
            $this->error=$lang->edit_errors['file_to_big'].": ".$var['name'].". ".$lang->edit_errors['file_max'].": $maxkb";
            return;
        }
        
        $fd=fopen($file_tmp_name,"r");
        $o=fread($fd,filesize($file_tmp_name));
        fclose($fd);
        
        return $o;
    } // end read_tmp_file()
} // end class FileUpload

$upload = new FileUpload;

$item_upload=array();
// czy zalaczono plik opisu
if (! empty($_FILES['file_xml_description']['name'])) {
    $file_desc=$_FILES['file_xml_description'];
    $item_upload['xml_description']=$upload->read_tmp_file($file_desc);
}

// czy zalaczono plik opisu
if (! empty($_FILES['file_xml_short_description']['name'])) {
    $file_short_desc=$_FILES['file_xml_short_description'];
    $item_upload['xml_short_description']=$upload->read_tmp_file($file_short_desc);
}

?>