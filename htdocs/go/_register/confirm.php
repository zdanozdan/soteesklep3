<?php
/**
 * Skrypt odpowiedzialny za automatyczne potwierdzenie transakcji przez klienta - pobranie
 * id_transakcji za pomoca linku i ustawienie pola confirm=1 w  bazie danych  
 * @param int $trans - zmienna numer transakcji odczytywana z linku klienta 
 * 
 * @author piotrek@sote.pl
 * @version $Id: confirm.php,v 2.4 2005/01/20 15:00:18 maroslaw Exp $
* @package    register
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
include_once ("../../../include/head.inc");

// naglowek
if(empty($__open_head)){
  $theme->head(); 
}

//sprawdzanie czy istnieje zmienna $trans i $code
if ((! empty($_GET['trans']))&&(! empty($_GET['code']))) {
    $id_trans=$_GET['trans'];
    $code=$_GET['code'];
    } else {
    // informacja, ze cos nie tak z linkiem 
    $theme->theme_file('_register/confirm_error.html.php');
    $theme->foot();
    // wychodzimy z programu
    exit();
}

//sprawdzenie czy zmienna trans jest typu integer
if (ereg("[0-9]",$id_trans)) {
} else { 
     $theme->theme_file('_register/confirm_error.html.php');
     $theme->foot();
     exit();
}

//sprawdzenie czy klient chce zatwierdzic swoja transakcje
//suma kontrolna klienta
$client_sign=$code;
//suma kontrolna serwera
$server_sign=md5($id_trans.$config->salt);

if ($client_sign!=$server_sign) {
    //wyswietlenie komunikatu - bledny numer transakcji
    $theme->theme_file('_register/confirm_error3.html.php');
    $theme->foot();
    exit();
}

//sprawdzamy czy podany numer transakcji istnieje w bazie
$query="SELECT order_id,confirm_user FROM order_register WHERE order_id=?";

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetInteger($prepared_query,1,$id_trans);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        //sprawdzenie ile istnieje rekordow
        $num_rows=$db->NumberOfRows($result);
        //jesli nie dostaniemy rekordu
        if ($num_rows==0) {
            //wyswietl informacje: nie ma takiej transakcji w bazie danych
            $theme->theme_file('_register/confirm_error1.html.php');
            $theme->foot();
            exit();
        }
        //sprawdzenie statusu confirm_user 
        $confirm_user=$db->FetchResult($result,0,"confirm_user");
        if ($confirm_user==1) {
            //wyswietlenie informacji ,ze transakcja juz zostala potwierdzona
            $theme->theme_file('_register/confirm_error2.html.php');
            $theme->foot();
            exit();
        }
    } else die ($db->Error());
} else die ($db->Error());

//wpisanie do pola confirm tabeli order_register wartosci 1 - status potwierdzenia zamowienia
$query="UPDATE order_register SET confirm_user=1 WHERE order_id=?";

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetInteger($prepared_query,1,$id_trans);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $theme->theme_file('_register/confirm_ok.html.php');
        $theme->foot();
    } else die ($db->Error());
} else die ($db->Error());          
    
// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
