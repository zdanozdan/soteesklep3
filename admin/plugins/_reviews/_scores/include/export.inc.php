<?php
/**
 * Eksport sredniej oceny danego produktu (tabela scores - srednia wyliczona z pol suma i liczba) do tabeli main  
 *
 * @author  piotrek@sote.pl
 * @version $Id: export.inc.php,v 1.2 2004/12/20 18:00:49 maroslaw Exp $
* @package    reviews
* @subpackage scores
 */

if (@$__secure_test!=true) die ("Bledne wywolanie");

require_once("include/metabase.inc");
$database = new my_Database;

// wyciagnij wszystko z tabeli scores
$query="SELECT * FROM scores";

$result=$db->Query($query);
if ($result!=0) {
    $num_rows=$db->NumberOfRows($result);
    if ($num_rows>0) {
        $i=0;
        while ($i<$num_rows) {              
            $id_product=$db->Fetchresult($result,$i,"id_product");                             // identyfikator produktu
            $score_amount=$db->FetchResult($result,$i,"score_amount");                         // suma ocen
            $scores_number=$db->FetchResult($result,$i,"scores_number");                       // liczba ocen 
            $score_average=$score_amount/$scores_number;                                       // obliczamy srednia 
            $score_average_cut=ereg_replace("^([0-9]+\.[0-9][0-9]).*$","\\1",$score_average);  // obcinamy do dwoch miejsc po przecinku
            
            // wrzucamy obcieta srednia do tabeli main (update)
            $data=array("user_score"=>"$score_average_cut"
                        );
            
            $update=$database->sql_update("main","id=$id_product",$data);
            if(!empty($update)) {
                $commit=1;
            } else { 
                $commit=0;
                print "<BR>$lang->scores_export_error_score$id_product";
            }
            
            $i++;
        } //end while
        if($commit==1) {
            print "<BR>$lang->scores_export_ok <B>$i</B> $lang->scores_export_ok1";     // wszystko jest OK
        } else { 
            print "<BR><font color=red>$lang->scores_export_error</font>";              // cos sie nie udalo
        }
        
    } else {
        print "<BR><font color=red>$lang->scores_export_no_score</font>";               // nie ma jeszcze zadnych ocen
    }
} else die ($db->Error());

?>
