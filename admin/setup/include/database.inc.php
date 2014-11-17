<?php
/**
* Ustanow polaczenie z baza danych na podstawie wartosci wprowadzonych w formularzu instlacji
*
* @author  m@sote.pl
* @version $Id: database.inc.php,v 2.5 2004/12/20 18:01:16 maroslaw Exp $
*
* \@verified 2004-03-16 m@sote.pl
* @package    setup
*/

// dodaj obsluge bazy danych
require_once "lib/Metabase/metabase_interface.php";
require_once "lib/Metabase/metabase_database.php";

// odczytaj dane dpstepu do bazy z sesji
if (! empty($_SESSION['form'])) {
    $form=$_SESSION['form'];
} elseif (! empty($_POST['form'])) {
    $form=$_POST['form'];
} else die ($error->error);

$error=MetabaseSetupDatabaseObject(array(
"Host"=>$form['dbhost'],
"Type"=>$config->dbtype,
"User"=>$form['admin_dbuser'],
"Password"=>$form['admin_dbpassword'],
"Persistent"=>false,
"IncludePath"=>"$DOCUMENT_ROOT/../lib/Metabase"),$db);

if (! empty($error)) {
    die ($error);
}

// ustaw baze nazwe bazy danych
$db->SetDatabase($form['dbname']);

?>
