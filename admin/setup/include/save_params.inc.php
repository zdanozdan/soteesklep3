<?php
/**
* Zakoduj parametry, i zapisz je jako elementy obiektu dostepnego w sklepie pod zmienna $config
* Zapisz PIN, Nr licencji, SALT, oraz dane dostepu do bazy danych dla nobody i admina (lub tylko dla admina), i dane ftp
*
* \@global string  $__salt       losowy kod kodowania - sol
* \@global array() $config_setup konfiguracja instalacji
* \@global array   $form         dane instalacji (dostêpu do bazy, ftp, licencja, pin)
*
* @author  m@sote.pl
* @version $Id: save_params.inc.php,v 2.12 2005/04/13 14:13:00 maroslaw Exp $
*
* \@verified 2004-03-16 m@sote.pl
* @package    setup
*/

if (empty($form)) {
    die ("Forbidden: Unknown form");
}

// dane licencji
$license=array("nr"=>$form['license'],
"who"=>$form['license_who']);

$pin=$form['pin'];
$md5_pin=md5($pin);
if ((empty($config->salt)) || ($config->salt=="1234567890123467890123456789012")) {
    // generuj losowo salt
    $salt=md5(microtime().rand(1,10000));
} else $salt=$config->salt;
$__salt=&$salt;

// ustal klucze kodowania
$key=$salt;
$secure_key=md5($salt.$pin);

// start kodowanie hasla dostepu do ftp
require_once ("include/my_crypt.inc");
$my_crypt = new MyCrypt;

// zakodowane haslo dostepu do FTP
$pass = $secure_key;
$data = $form['ftp_password'];
$crypt_ftp_password=$my_crypt->endecrypt($pass, $data, "");

// dane FTP
$ftp_data=array("ftp_host"=>$form['ftp_host'],
"ftp_user"=>$form['ftp_user'],
"ftp_password"=>$crypt_ftp_password,
"ftp_dir"=>$ftp_dir);


// sprawdz czy podano usera nobody, jesli nie to usatw tego samego usera co admin
if (empty($form['nobody_dbuser'])) {
    $form['nobody_dbuser']=$form['admin_dbuser'];
    $form['nobody_dbpassword']=$form['admin_dbpassword'];
}
// end

// kodowanie hasla dostepu do bazy danych dla nobody
$nobody_dbuser=$my_crypt->endecrypt($key,$form['nobody_dbuser'],"");
$nobody_dbpassword=$my_crypt->endecrypt($key,$form['nobody_dbpassword'],"");
// end kodowanie hasla dostepu dla nobody


// kodowanie hasla dostepu do bazy danych dla admina
$admin_dbuser=$my_crypt->endecrypt($secure_key,$form['admin_dbuser'],"");
$admin_dbpassword=$my_crypt->endecrypt($secure_key,$form['admin_dbpassword'],"");
// end kodowanie hasla dostepu dla admina

// db host
$dbhost=$my_crypt->endecrypt($key,$form['dbhost'],"");

// nazwa bazy
$dbname=$my_crypt->endecrypt($key,$form['dbname'],"");

$db_acc=array("nobody_dbuser"=>$nobody_dbuser,
"nobody_dbpassword"=>$nobody_dbpassword,
"admin_dbuser"=>$admin_dbuser,
"admin_dbpassword"=>$admin_dbpassword,
"dbhost"=>$dbhost,
"dbname"=>$dbname);

// utworz tabela sum kontrolnych dostepu do panelu
$md5_password=md5($form['admin_dbpassword']);
$auth_sign=array(md5($form['admin_dbuser'])=>"admin");

// start zapisz dane w pliku konfiguracyjnym
require_once ("include/ftp.inc.php");
// r@sote.pl zapisanie w configu tablicy z polami tablicy main
if (! empty($_SESSION['__fields'])) {
    $fields=$_SESSION['__fields'];
} else $fields='';

// multi-shop
if ($_SESSION['config_setup']['type']=="multi") {
    require_once ("./include/multi_shop.inc.php");
    $multi_shop =& new Setup_MultiShop();
    $id_shop=$multi_shop->setID($license['nr']);
} else $id_shop=0;
// end

// obsluga generowania pliku konfiguracyjnego uzytkwonika
require_once("include/gen_user_config.inc.php");
$config->ftp_dir=$ftp_dir;$config->ftp['ftp_dir']=$ftp_dir;
$gen_config->ftp_user=$form['ftp_user'];
$gen_config->ftp_password=$form['ftp_password'];
$gen_config->ftp_host=$form['ftp_host'];
$gen_config->auth_from_db="no";                   // nie pobieraj danych dostepu do konta FTP z bazy
$gen_config->gen(array("db"=>$db_acc,"auth_sign"=>$auth_sign,"ftp"=>$ftp_data,"salt"=>$salt,"md5_pin"=>$md5_pin,"license"=>$license,"config_setup"=>$config_setup,"fields"=>$fields,"id_shop"=>$id_shop,"admin_lang"=>$config->lang));
// end


// start zapisz w bazie danych administratora, dezaktywuj aktualnych uzytkownikow
require_once ("./include/database.inc.php");
$query="UPDATE admin_users SET active=0";
if ($db->Query($query)) {
    // poprawna aktualizacja danych
} else die ($db->Error());

// sprawdz czy dany uzytkownik jest juz w bazie
$sql_type="insert";
$query="SELECT id FROM admin_users WHERE login=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$form['admin_dbuser']);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) {
            $sql_type="update";
            $id_admin_users=$db->FetchResult($result,0,"id");
        }
    } else die ($db->Error());
} else die ($db->Error());

if ($sql_type=="insert") {
    $query="INSERT INTO admin_users (login,password,id_admin_users_type,active) VALUES (?,?,?,?)";
} else {
    $query="UPDATE admin_users SET login=?,password=?,id_admin_users_type=?,active=? WHERE id=?";
}
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$form['admin_dbuser']);
    if (! empty($_REQUEST['form']['auth_password'])) {
        $db->QuerySetText($prepared_query,2,$form['auth_password']);
    } else {
        $db->QuerySetText($prepared_query,2,$db_acc['admin_dbpassword']);
    }
    $db->QuerySetText($prepared_query,3,1);                              // id=1 dla tabeli admin_users_type - superadmin
    $db->QuerySetInteger($prepared_query,4,1);
    if ($sql_type=="update") {
        $db->QuerySetInteger($prepared_query,5,$id_admin_users);
    }
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        // poprawnie dodany rekord
    } else die ($db->Error());
} else die ($db->Error());
// end

print "<B>".$lang->setup_ftp_save."</B><P>";
print "<table>\n";
print "<tr><td>".$lang->setup_crypt['keys']."</td><td>OK</td></tr>\n";
print "<tr><td>".$lang->setup_crypt['ftp']."</td><td>OK</td></tr>\n";
print "<tr><td>".$lang->setup_crypt['mysql']."</td><td>OK</td></tr>\n";
print "<tr><td>".$lang->setup_crypt['pin']."</td><td>OK</td></tr>\n";
print "<tr><td>".$lang->setup_crypt['license']."</td><td>OK</td></tr>\n";
if ($id_shop>0) {
    print "<tr><td>".$lang->setup_crypt['multi_shop']."</td><td>OK</td></tr>\n";
}
print "</table>\n";

print "<hr>";

// w zaleznosci od typu instalacji dokonaj dodatkowych operacji
switch ($config_setup['type']) {
    case "home.pl": include_once ("./include/home.pl.inc.php");
    break;
    default: include_once ("./include/default.inc.php");
    break;
} // end switch

print "<p>";
?>