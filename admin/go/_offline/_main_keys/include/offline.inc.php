<?php
/**
 * Aktualizacja off-line cennika, wyswietlenie statusu realizacji zadania
 *
 * @author  m@sote.pl
 * @modified by rdiak@sote.pl
 * @version $Id: offline.inc.php,v 1.2 2004/12/20 17:58:35 maroslaw Exp $
* @package    offline
* @subpackage main_keys
 */

require_once ("themes/stream.inc.php");
require_once ("./include/error.inc.php");
require_once ("./include/load.inc.php");
require_once ("./include/category.inc.php");

global $lang;

if($config->offline_data_type == "csv") {
    require_once ("./include/Parser/csv.inc.php");
} elseif($config->offline_data_type == "dbf") {
    require_once ("./include/Parser/dbf.inc.php");
} elseif($config->offline_data_type == "xml") {
    require_once ("./include/Parser/xml.inc.php");
}


$load=new OfflineLoad;
//nowy obiekt typu OfflineEncode
$encode=new OfflineEncode;
//nowy obiekt typu OfflineError
$error=new OfflineError;
//nowy obiekt typu OfflineCategory;
$category=new OfflineCategory;
//nowy obiekt typu Parser
$parser=new OfflineCSV;
//ladujemy plik i zwracamy dane z pliku w postaci tablicy tablic
$record=$parser->load_file();
//print "<pre>";
//print_r($record);
//print "</pre>";

$stream = new StreamTheme;

$stream->legend();
$stream->title_500();


flush();

// sprawdz czy aktualizacja ostatnia byla przerwana
$file_lock="$DOCUMENT_ROOT/tmp/offline_lock.php";
$last_num=-1;
if  (file_exists($file_lock)) {
    // ostatnia aktualizacja byla przerwana
    $fd=fopen($file_lock,"r");
    $last_num=fread($fd,filesize($file_lock));
    fclose($fd);
} 
$status=true;
$k=1;
// ile rekordow jest do zaladowania
$count=count($record);
//print "<pre>";
//print_r($record);
//print "</pre>";

for ($i=0;$i<$count;$i++) {
    if ($i>$last_num) {
        //wywolaj funkcje z klasy sprawdzajacej i ladujacej dane do bazy
        $x=$load->load_record($record[$i],$i);
        if ($x==1) {
            //ok
            $stream->line_green();
        } elseif($x==2) {
            // blad podczas sprawdzania typow danych
            $status=false;
            $stream->line_blue();
        } elseif($x==3) {
            $status=false;
            // blad podczas ³adowania do bazy danych
            $stream->line_red();
        } elseif($x==4) {
            $status=false;
            // blad podczas ³adowania do bazy danych
            $stream->line_fiol();
        } else {
            $status=false;
            $stream->line_sel();
        }
        // end blok
    } else {
        $stream->line_green();
    }
    $k++;
    if ($k==500) {
        $k=0;
        print "<br>";     
    }
    
    // zapisz w pliku $file_lock kolejny numer aktualizacji rekordu
    $data=$i."\n";
    $fd=fopen($file_lock,"w+");
    fwrite($fd,$data,strlen($data));
    fclose($fd);
    
    // wyswietl dane na STDOUT
    flush();  
} // end for


// jesli po wywolaniu aktualizacji plik bedzie istnial, to oznacza to, ze aktualizacja zostala przerwana
// i ze przy kolejnej aktualizacji powinna sie pojawic opcja dokonczenia przerwanej aktualizacji
$category->load_category();
//print $status;
if($status) {
    print "<br><br><center> $lang->offline_update_ok </center><br>";
} else {
    print "<br><br><center> $lang->offline_update_error </center><br>";
}
print $lang->offline_record_added." - ".$load->record_add."<br>";
print $lang->offline_record_updated." - ".$load->record_update."<br>";
print $lang->offline_record_deleted." - ".$load->record_delete."<br>";    
if  (file_exists($file_lock)) {
unlink($file_lock);
} 
?>
