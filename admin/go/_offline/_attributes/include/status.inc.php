<?php
/**
* Wyrzucanie bledów do pliku
*
* @author  rdiak@sote.pl
* @version $Id: status.inc.php,v 1.7 2005/01/18 09:20:21 scalak Exp $
* @package    offline
* @subpackage attributes
*/


/**
* Klasa Error2File
*
* @package offline
* @subpackage admin
*/
class Error2File{
    var $error_log_file="/tmp/error.log";
    var $max_errors=100000;    // maksymalna ilosc produktow (i bledow)
    
    /**
    * Wy¶wietl informcacje o b³êdach wygenerowanych podczak aktualizacji cennika. (m@sote.pl)
    * @return none
    */
    function error_log(){
        global $DOCUMENT_ROOT;
        global $lang;
        
        if ($fd=@fopen($DOCUMENT_ROOT.$this->error_log_file,"r")) {
            $filesize=filesize($DOCUMENT_ROOT.$this->error_log_file);
            if($filesize > 0) {
            	$errors=fread($fd,filesize($DOCUMENT_ROOT.$this->error_log_file));
            	$lines=split("\n",$errors,100000);
            	if(!empty($lines[0])) {
                	print "<table border=1>\n";
                	print "<tr><th>$lang->offline_date</th><th>$lang->offline_record</th><th>$lang->offline_record_info</th></tr>";
                	foreach ($lines as $line) {
                    	$data=split ("\t",$line,3);
                    	$date=@$data[0];
                    	$nr=@$data[1];
                    	$info=@$data[2];
                    	print "<tr><td valign=top><nobr>$date</nobr></td><td align=center valign=top><b>$nr</b></td><td valign=top>$info</td></tr>\n";
                	}
                	print "</table>\n";
            	} else {
                	print $lang->offline_no_error;
            	}
            } else {
                 print $lang->offline_no_error;
            }	
            fclose($fd);
        } else print $lang->offline_no_error;
        return;        
    } // error_log()
    
} // end class Data2SQL

$error2file =& new Error2File;
?>
