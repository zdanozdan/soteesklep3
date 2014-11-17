<?php
/**
 * Aktualizacja tabeli z ocenami produktow (scores) 
 * Wrzucamy do tabeli scores id produktu, ocene i ilosc osob jakie ocenialo dany produkt
 * 1.Sprawdzamy czy jest w tabeli scores produkt o takim id:
 *   a) jesli nie ma dodajemy do tabeli id produktu, biezaca ocene i ilosc ocen=1 
 *   b) jesli jest
 *      b1) wyciagamy z bazy dotychczasowa ocene (score_amount) oraz ilosc ocen (scores_number)
 *      b2) do wyciagnietych wartosci dodajemy biezace
 *      b3) robimy update tabeli scores !Dodaj recenzje do tabeli reviews wykonaj komende SQL dodanie rekordu do bazy
 *
 * @author  piotrek@sote.pl
 * @version $Id: insert_score.inc.php,v 1.2 2004/12/20 18:00:52 maroslaw Exp $
 *
 * @public 
* @package    reviews
 */

//Ad.1
$check_id_product=$database->sql_select("id_product","scores","id_product=$id");

if (empty($check_id_product)) {
    // Ad a)
    // pola wykorzystane przy insercie
    $fields=array("id_product"=>"$id",                // id produktu  
                  "score_amount"=>"$score",           // ocena
                  "scores_number"=>"1"                // liczba ocen, dlatego 1 bo to pierwsza ocena :)
                  );
    $database->sql_insert("scores",$fields);
    
} else {
    // Ad b)
    // Ad b1)
    $score_amount=$database->sql_select("score_amount","scores","id_product=$id");         // dotychczasowa suma ocen
    $scores_number=$database->sql_select("scores_number","scores","id_product=$id");       // dotychczasowa ilosc ocen
    
    // Ad b2)
    $score_amount_new=$score_amount+$score;
    $scores_number_new=$scores_number+1;

    // Ad b3)
    $fields=array("score_amount"=>"$score_amount_new",     // nowa suma ocen
                  "scores_number"=>"$scores_number_new"    // nowa liczba ocen, powiekszona o 1
                  );
    $database->sql_update("scores","id_product=$id",$fields);
    
}

?>
