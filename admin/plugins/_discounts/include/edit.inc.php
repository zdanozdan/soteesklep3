<?php
/**
 * Skrypt generuje $_REQUEST['id'] dla rekordu odpowiadajacego danemu rabatowi
 * id jest generowane na podstawie idc i deep. Np. jesli mamy id=20 dla idc=1_2_4_12_34
 * i deep=2 to idc bedzie okreslone przez 1_2. System wyszukuje id dla idc=1_2 i podstawia
 * to id do wywolania $_REQUEST.
 *
 * @param int $_REQUEST['id']
 * @param int $_REQUEST['deep']
 *
 * @return int $_REQUEST['id'] - nowa wartosc id rekordu
 *
 * @author piotrek@sote.pl
 * \@template_version Id: insert.inc.php,v 1.3 2003/02/06 11:55:15 maroslaw Exp
 * @version $Id: edit.inc.php,v 2.5 2005/04/01 08:35:33 maroslaw Exp $
 *
* @package    discounts
 */

// if (@$this->secure_test!=true) die ("Bledne wywolanie");

global $db,$mydatabase;
global $__row_type;

require_once ("include/metabase.inc");
if (empty($mydatabase)) {
    $mydatabase = new my_Database;
}

$table=array("idc","idc_name","id_producer","producer_name");

// wyciagamy z bazy pola idc,idc_name,id_producer,producer_name - zapisane sa w tablicy
$return_table=$mydatabase->sql_select_multi_array($table,"discounts","id=$id");

$idc=@$return_table[0];
$idc_name=@$return_table[1];
$id_producer=@$return_table[2];

// badamy dlugosc idc_temp po to by mozliwe bylo porownanie z deep
#$idc_length=strlen($idc_temp);
$idc_temp=split("_",$idc,5);
$idc_length=sizeof($idc_temp);

// jesli deep=5 to musimy miec 4 znaki "_" jesli 4 - 3 znaki itd.
// zwiekszamy idc_length o 1 by latwiej moznabylo porownywac z deep
#$idc_length++;

// jesli idc_length=deep nic nie robimy - kliknieto na ostatnia podkategorie
// idc bedzie nie zmienione 
if ($idc_length!=$deep) {
    //w zaleznosci od $deep dostosowujemy idc
    $tidc=split("_",$idc,5); // tablice elementow idc
    $new_idc='';
    
    //skladam elemety idc w zaleznosci od deep
    for ($i=0;$i<$deep;$i++) {
        $new_idc.=@$tidc[$i]."_";
    }
        
    $new_idc=ereg_replace("_$","",$new_idc); //obcinam ostatni znak "_"
    
    //w zaleznosci od $deep dostosowujemy idc_name
    $tidc_name=split(" / ",$idc_name,5); // tablice elementow idc
    $new_idc_name='';
        
    //skladam elemety idc w zaleznosci od deep
    for ($i=0;$i<$deep;$i++) {
        $new_idc_name.=@$tidc_name[$i]." / ";
    }
    
    $new_idc_name=ereg_replace(" / $","",$new_idc_name); //obcinam ostatni znak " / "
    
} else {
    //idc i idc_name nie zmienione
    $new_idc=$idc;
    $new_idc_name=$idc_name;
}


//wyciagamy z tabeli discounts rekord id gdzie idc=new_idc
$id_temp=$mydatabase->sql_select("id","discounts","idc=$new_idc");

/* jesli rekord o idc=new_idc nie istnieje
 * wrzucamy go do bazy i wyciagamy jego id, ktore od tej pory jest przekazane globalnie dalej
 * w przeciwnym wypadku id pozostaje nie zmienione
 */
if (empty($id_temp)) {
    
    $query="INSERT INTO discounts (idc,idc_name,active) VALUES (?,?,?)";
    
    $prepared_query=$db->PrepareQuery($query);
    if ($prepared_query) {
        
        $db->QuerySetText($prepared_query,1,$new_idc);
        $db->QuerySetText($prepared_query,2,$new_idc_name);
        $db->QuerySetInteger($prepared_query,3,0);
        
        $result=$db->ExecuteQuery($prepared_query);
        if ($result!=0) {   
            //print "OK";
            //jest ok - rekord zostal dodany
        } else {
            //takie idc juz istnieje rekord nie zostal dodany
        }
    } else die ($db->Error());
    
    //wyciagam nowe (ostatnie  id) z bazy danych
    $new_id=$mydatabase->sql_select("max(id)","discounts","");
    
    //$id=$new_id;
    $_REQUEST['id']=$new_id;
} else {
    //$id=$id_temp;
    $_REQUEST['id']=$id_temp;
}

?>
