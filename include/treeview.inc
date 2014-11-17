<?php
/**
 * Obsluga menu treeview
 *
 * @author  m@sote.pl
 * @version $Id: treeview.inc,v 2.3 2004/12/20 18:02:58 maroslaw Exp $
* @package    include
 */

global $__secure_test;
if (@$__secure_test!=true) die ("Forbidden");

class CategoryTreeview {

    /**
     * Pokaz kod JavaScript z danymi do menu treeview, dodaj sesje do linkow. Zmien sciezke do zdjec dla SV
     *
     * @param string $file plik zawierajacy dane do menu
     * @return int   0 - OK, -1 - nie ma pliku z danymi
     */
    function js_show_data_with_session($file) {
        global $sess;
        global $config;

        if ($fd=fopen($file,"r")) {
            $js_data=fread($fd,filesize($file));
            fclose($fd);

            $lines=preg_split("/\n/",$js_data,1000,PREG_SPLIT_NO_EMPTY);
            // dodaj do linkow sesje
            // linki postaci ....url")) zamieniamy na url&sess_id=11123456789567824576234567894567 itp.
            foreach ($lines as $line) {
                // sprawdz czy jest jakis parametr w url
                preg_match("/\/(.+)\"\)\)$/",$line,$matches);
                
                // linia zawiera definicje kategorii
                if (ereg("\?",@$matches[1])) $sep="&"; else $sep="?";
              
                if (ereg("ICONPATH",$line)) {
                    $line=ereg_replace("/lib/Treeview",$config->url_prefix."/lib/Treeview",$line);
                    print $line."\n";
                } else {  
                    $line=ereg_replace("\"))",$sep.$sess->param."=".$sess->id."\"))",$line);
                    $line=ereg_replace("/go/_category",$config->url_prefix."/go/_category",$line);
                    print $line."\n";
                }
            } // end foreach

            return(0);
        }
        return(-1);
    } // end js_show_data_with_session()
} // end class CategoryTreeview

?>
