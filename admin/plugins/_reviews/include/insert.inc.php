<?php
/**
 * PHP Template:
 * Dodaj nowy rekord do tabeli reviews wykonaj komende SQL dodanie rekordu do bazy
 *
 * @author m@sote.pl
 * \@global string $table nazwa tabeli do ktorej dodajemy rekord
 * \@global string $__insert_info informacja o tym, ze udalo sie dodac rekord
 * @version $Id: insert.inc.php,v 1.6 2004/12/20 18:00:52 maroslaw Exp $
 * @return int $this->id
* @package    reviews
 */

if (@$this->secure_test!=true) die ("Bledne wywolanie");

require_once ("include/metabase.inc");
require_once ("lib/SDConvertText/class.SDConvertText.php");

global $db;
global $database;

if (! empty($_REQUEST['item']['user_id'])) {        
    $user_id=$_REQUEST['item']['user_id'];                
    $id=$database->sql_select("id","main","user_id=$user_id");
}                          

if (! empty($_REQUEST['item']['score'])) {
    $score=$_REQUEST['item']['score'];                         
}

if (! empty($_REQUEST['item']['description'])) {
    $description=$_REQUEST['item']['description'];
    // start czysty tekst bez znacznikow
    if (empty($ct)) {
        $ct = new SDConvertText;
    }
    
    $allowed_tags=array('<br>','<a>');                // zezwol tylko na takie znaczniki
    $desc=$ct->dropHTML($description,$allowed_tags);  // przefiltruj tekst i pozostaw tylko dozwolone znaczniki
    // stop czysty tekst bez znacznikow
}

if (! empty($_REQUEST['item']['author'])) {
    $author=$_REQUEST['item']['author'];                         
}

if (! empty($_REQUEST['item']['state'])) {
    $state=$_REQUEST['item']['state'];                         
}
 
$my_date=date("Y-n-j");                           // aktualna data

// sprawdzamy czy istnieje nasz produkt w bazie
$check_id=$database->sql_select("id","main","id=$id");       

if(! empty($check_id)) {
    
    $user_id=$database->sql_select("user_id","main","id=$id"); 
    
    if (empty($author)) $author=$lang->reviews_anonymous;  // jesli nie podano autora wyswietl Anonimowy
    
    // suma kontrolna potrzebna do zabezpieczenia przed ponownym dodaniem tego samego rekordu do tabeli reviews
    $md5_review=md5(@$id.@$user_id.@$desc.@$author.@$my_date);
    
    $query="INSERT INTO reviews (id_product,user_id,description,date_add,state,score,author,md5) VALUES (?,?,?,?,?,?,?,?)";
    
    $prepared_query=$db->PrepareQuery($query);
    if ($prepared_query) {
        
        $db->QuerySetText($prepared_query,1,@$id);
        $db->QuerySetText($prepared_query,2,@$user_id);
        $db->QuerySetText($prepared_query,3,@$desc);
        $db->QuerySetText($prepared_query,4,@$my_date);
        $db->QuerySetText($prepared_query,5,@$state);
        $db->QuerySetText($prepared_query,6,@$score);
        $db->QuerySetText($prepared_query,7,@$author);
        $db->QuerySetText($prepared_query,8,$md5_review);
        
        $result=$db->ExecuteQuery($prepared_query);
        
        if ($result!=0) {
            // odczytaj numer id dodanego rekordu
            $my_id=$database->sql_select("max(id)","reviews","");
            $this->id=$my_id;
            include_once("insert_score.inc.php");       // dodanie oceny do tabeli scores
            $__insert_info=$lang->reviews_send_ok;
        } else {
            print $lang->reviews_send_ok_again;
        }
    } else die ($db->Error());
} else {
    print $lang->reviews_no_product;
}

?>
