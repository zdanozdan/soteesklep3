<?php
/**
 * Dodaj recenzje do tabeli reviews
 *
 * @author  piotrek@sote.pl
 * \@global  string $table nazwa tabeli do ktorej dodajemy rekord
 * @version $Id: insert.inc.php,v 1.8 2005/10/20 06:43:00 krzys Exp $
 * @return  int $this->id
 *
 * @public
* @package    reviews
 */

if (@$__secure_test!=true) die ("Bledne wywolanie");

require_once ("include/metabase.inc");
require_once ("lib/SDConvertText/class.SDConvertText.php");


// identyfikator produktu zdefiniowany przez uzytkownika
if (! empty($_REQUEST['user_id'])) {        
    $user_id=urldecode($_REQUEST['user_id']);                
} else die ("Forbidden");                         

if (! empty($_REQUEST['id'])) {
    $id=$_REQUEST['id'];                          // identyfikator produktu
} else die ("Forbidden");

$score=$form['score'];                            // ocena
$description=$form['description'];                // recenzja

// start czysty tekst bez znacznikow
if (empty($ct)) {
    $ct = new SDConvertText;
}

$allowed_tags=array('<br>','<a>');                // zezwol tylko na takie znaczniki
$desc=$ct->dropHTML($description,$allowed_tags);  // przefiltruj tekst i pozostaw tylko dozwolone znaczniki
// stop czysty tekst bez znacznikow

$author=$form['author'];						  //autor
$author_id=@$form['author_id'];                     //id autora (gdy klient jest zalogowany)
$IP=$_SERVER['REMOTE_ADDR'];                      // adres ip oceniajacego
$my_date=date("Y-n-j");                           // aktualna data

// suma kontrolna potrzebna do zabezpieczenia przed ponownym dodaniem tego samego rekordu do tabeli reviews
$md5_review=md5($id.$user_id.$IP.$my_date);

// sprawdzamy czy istnieje nasz produkt w bazie
$check_id=$database->sql_select("id","main","id=$id");       

if(! empty($check_id)) {

    if (empty($author)) $author=$lang->reviews_anonymous;   // jesli nie podano autora wyswetl Anonimowy
    
    $query="INSERT INTO reviews (id_product,user_id,description,date_add,state,score,author,md5,lang,author_id) VALUES (?,?,?,?,?,?,?,?,?,?)";
    
    $prepared_query=$db->PrepareQuery($query);
    if ($prepared_query) {
        
        $db->QuerySetText($prepared_query,1,$id);
        $db->QuerySetText($prepared_query,2,$user_id);
        $db->QuerySetText($prepared_query,3,$desc);
        $db->QuerySetText($prepared_query,4,$my_date);
        $db->QuerySetText($prepared_query,5,0);
        $db->QuerySetText($prepared_query,6,$score);
        $db->QuerySetText($prepared_query,7,$author);
        $db->QuerySetText($prepared_query,8,$md5_review);
        $db->QuerySetText($prepared_query,9,$config->lang);
        $db->QuerySetText($prepared_query,10,@$author_id);
        
        $result=$db->ExecuteQuery($prepared_query);
        
        if ($result!=0) {
            include_once("insert_score.inc.php");       // dodanie oceny do tabeli scores
            print "<BR>";
            print $lang->reviews_send_ok;
        } else {
            print "<BR>";
            print $lang->reviews_send_ok_again;
        }
    } else die ($db->Error());
} else {
    print $lang->reviews_no_product;
    $theme->back();
}

?>
