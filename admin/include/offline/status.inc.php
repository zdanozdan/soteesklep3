<?php
/**
 * Funkcja PHP zwiazane z obsluha data2sql
* @version    $Id: status.inc.php,v 1.2 2004/12/20 17:59:26 maroslaw Exp $
* @package    admin_include
 */
class Data2SQL{ 
    var $error_log_file="/tmp/error.log";
    var $max_errors=100000;    // maksymalna ilosc produktow (i bledow)

    function error_log(){
        global $DOCUMENT_ROOT;
	global $lang;
	
        $fd=fopen($DOCUMENT_ROOT.$this->error_log_file,"r");
        $errors=fread($fd,filesize($DOCUMENT_ROOT.$this->error_log_file));
        $lines=split("\n",$errors,100000);
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
        fclose($fd);
    }
}

$data2sql = new Data2SQL;

?>
