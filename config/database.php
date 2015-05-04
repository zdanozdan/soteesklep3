<?php
/**
 * Konfiguracja i aktywacja dostepu do bazy danych (poprzez Metabase[typ:object])
 * 
 * @author  m@sote.pl
 * @version $Id: database.php,v 2.9 2005/04/26 09:20:42 maroslaw Exp $
 * @package soteesklep
 */

// jesli wywolano aktualizcje, to polacz sie z baza jako admin
require_once ("include/crypt_db.inc");                
$crypt_db  = new Crypt_DB;
$crypt_db->key=$config->salt;

if ($shop->admin) {
    // admin

    // @global string $__pin 
    require_once ("include/pin.inc.php");  // odczytaj pin i udostepnij go globalnie jako zmienna $__pin
    if (empty($__pin)) {
        header ("Location: http://".$_SERVER['HTTP_HOST'].@$config->admin_dir."/go/_auth/index.php");
        exit;
    }

    $crypt_db->secure_key=md5($config->salt.$__pin);
    $config->dbuser=$crypt_db->admin_user();
    $config->dbpass=$crypt_db->admin_password();

    // sprawdz czy wprowadzono poprawny login i haslo
    //include_once ("$DOCUMENT_ROOT/include/test_auth.inc.php");  
} else {
    // nobody
    $config->dbuser=$crypt_db->nobody_user();
    $config->dbpass=$crypt_db->nobody_password();
}
$config->dbhost=$crypt_db->host();


$error=MetabaseSetupDatabaseObject(array(
                                         "Host"=>$config->dbhost,
                                         "Type"=>$config->dbtype,
                                         "User"=>$config->dbuser,
                                         "Password"=>$config->dbpass,
                                         "Persistent"=>false,
                                         "IncludePath"=>"$DOCUMENT_ROOT/../lib/Metabase"),$db);
                                         
if (! empty($error)) {
    die ("Database setup error:  $error\n");
}

// Specyficzne elementy skladni zapytan itp. baz danych
// SQL PgSQL
$config->pgsql_maxid="max"; 
$config->pgsql_max_user_id="max";
$config->pgsql_sum_amount="sum";

// SQL MySQL
$config->mysql_maxid="max(id)";
$config->mysql_max_user_id="max(user_id)";
$config->mysql_sum_amount="sum(amount)";

// ustaw baze nazwe bazy danych
$db->SetDatabase($crypt_db->dbname());
//$db->SetDatabase("mikran");

// przekaza ustawienia demo
@$db->demo=@$config->demo;

// dodaj obsluge MetabaseData
require_once ("MetabaseData/MetabaseData.php");
$mdbd = new MetabaseData($db);

// nie wstawiaæ zakoñczenia PHP