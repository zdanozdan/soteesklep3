<?php
/**
 * Dodaj nowego uzytkownika do bazy userow. Nadaj mu id.
 *
 * \@global string $global_prv_key klucz prywatny klienta
 * @return int $id id uzytkownika z tabeli users
 *
 * @author m@sote.pl
 * @version $Id: insert_user.inc.php,v 2.11 2006/01/31 14:05:48 krzys Exp $
* @package    users
 */

if (! $global_secure_test==true) {
    die ("Forbidden");
}
/**
* Dodaj klasê obs³ugi kodowania danych.
*/
require_once("include/my_crypt.inc");
$crypt =& new MyCrypt;

if (! empty($_REQUEST['form'])) {
    $form=$_REQUEST['form'];
} else {
    $theme->go2main();
    exit;   
}


// przygotuj dane do wpisania do bazy danych
$password=md5($form['password']);
// $login koduj kluczem z md5($config->salt)
$pub_key=md5($config->salt);

$crypt_login=$crypt->endecrypt($pub_key,$form['login'],"");

// sprawdz czy taki user juz nie istnieje
if ($form_check->check_login($form['login'])==false) {
    // nie ma takiego usera
    // pobierz aktualna date
	$date_add=date("Y-m-d");
    $query="INSERT INTO users (crypt_login,crypt_password,date_add,record_version,id_basket,id_wishlist) VALUES (?,?,?,'30',?,?)";
    $prepared_query=$db->PrepareQuery($query);
    if ($prepared_query) {
    	// start basket & wishlist ->init
		// szuflujemy obecnymi katalogiami zeby lokalne includy koszyka byly dostepne dla skryptow
		$old_dir=getcwd();
		$path_to_basket=$DOCUMENT_ROOT."/go/_basket/";
		chdir($path_to_basket);
		require_once("./include/my_ext_basket.inc.php");
		$basket=& new My_Ext_Basket();
		$wishlist=& new My_Ext_Basket('wishlist');
		$wishlist->init();
		$basket->init();
		$basket->_key="";
		$wishlist->_key="";
		chdir($old_dir);
    	// end basket & wishlist ->init
		$basket->_new_db_basket();
		$wishlist->_new_db_basket();
		$wishlist->_save_to_db();
		$basket->_save_to_db();
        $db->QuerySetText($prepared_query,1,$crypt_login);
        $db->QuerySetText($prepared_query,2,$password);
        $db->QuerySetText($prepared_query,3,$date_add);
        $db->QuerySetText($prepared_query,4,$basket->_id_basket);
        $db->QuerySetText($prepared_query,5,$wishlist->_id_basket);
        $basket->register();
        $wishlist->register();
        $result=$db->ExecuteQuery($prepared_query);
        if ($result!=0) {
            // odczytaj numer ID dodanego uzytkwonika
            $query="SELECT max(id) FROM users";
            $result1=$db->Query($query);
            if ($result1!=0) {
                $num_rows=$db->NumberOfRows($result1);
                if ($num_rows>0) {
                    $var=$config->dbtype."_maxid";
                    $max=$config->$var;
                    $global_id_user=$db->FetchResult($result1,0,$max);
                    // zapisz w bazie id uzytkwonika, jesli global_id_user>0, to znaczy, ze user jest zalogowany
                    $sess->register("global_id_user",$global_id_user);
                } else die ($lang->users_add_error);
            } else die ($db->Error());
        } else die ($db->Error());
    } else die ($db->Error());
} else {
    // uzytkownik zostal dodany juz do bazy, odczytaj id uzytkownika z bazy
    // prawdopodobnie wywolano reload
    if (! empty($_SESSION['global_id_user'])) {
        $global_id_user=$_SESSION['global_id_user'];
    }
}

?>
