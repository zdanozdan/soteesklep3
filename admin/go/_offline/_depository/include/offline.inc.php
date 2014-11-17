<?php
/**
* Aktualizacja off-line cennika, wyswietlenie statusu realizacji zadania
*
* @author  rdiak@sote.pl
* @version $Id: offline.inc.php,v 1.1 2005/12/22 11:41:23 scalak Exp $
* @package    offline
* @subpackage main
*/

/**
* Includowanie potrzebnych klas
*/
require_once ("themes/stream.inc.php");
require_once ("./include/error.inc.php");
require_once ("./include/load.inc.php");
require_once ("./include/category.inc.php");

global $lang;

if($config->offline_data_type == "csv") {
    include_once ("./include/Parser/csv.inc.php");
} elseif($config->offline_data_type == "dbf") {
    include_once ("./include/Parser/dbf.inc.php");
} elseif($config->offline_data_type == "xml") {
    include_once ("./include/Parser/xml.inc.php");
}

$load=new OfflineLoad;
//nowy obiekt typu OfflineEncode
$encode=new OfflineEncode;
//nowy obiekt typu OfflineError
$error=new OfflineError;
//nowy obiekt typu OfflineCategory;
$category=new OfflineCategory;
//nowy obiekt typu Parser
$parser=new Parser;
//ladujemy plik i zwracamy dane z pliku w postaci tablicy tablic
$record=$parser->load_file();


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

// jesli plik zostal zle sparsowany nie ma w nim tablulacji
if(empty($record)) {
    print "<br><center>".$lang->offline_file_errors['error_struct']."</center><br>";
    exit;
}

$db2=$db;
// ile rekordow jest do zaladowania
$count=count($record);
for ($i=0;$i<$count;$i++) {
    $db=$db2;
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
// wywolaj aktualizacje jednego produktu w kilku kategoriach
// $load->update_multi($record);
// wywolaj aktualizacje kategorii
//$category->load_category();
//print $status;
if($status) {
    print "<br><br><center>".$lang->offline_update_ok;
    if($load->error_add==5) { 
    	print $lang->offline_update_ok_but;
    }
	print "</center><br>";
} else {
    print "<br><br><center> $lang->offline_update_error </center><br>";
}
print $lang->offline_record_added." - ".$load->record_add."<br>";
print $lang->offline_record_updated." - ".$load->record_update."<br>";
print $lang->offline_record_deleted." - ".$load->record_delete."<br>";
if  (file_exists($file_lock)) {
    unlink($file_lock);
}
