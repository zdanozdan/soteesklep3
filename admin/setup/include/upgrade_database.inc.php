<?php
/**
* @version    $Id: upgrade_database.inc.php,v 2.8 2005/02/04 13:01:38 maroslaw Exp $
* @package    setup
*/
require_once ("lib/Compare/db_compare.inc.php");

// definicja dodatkowych instrukcji sql
$data=array();

$compare =& new DatabaseCompare();
// ladujemy dodatkowe instrukcje sql
$compare->setAddFeatures($data);
// ustawiamy skad jest brana stara baza danych
$compare->setStatus("old","db");
// ustawiamy skad jest brana nowa baza danych
$compare->setStatus("new","file");
// ustawiamy nazwe starej bazy danych
$compare->setDbName("old",$_SESSION['form']['dbname']);
// ustawiamy nazwe nowej bazy danych
$compare->setDbName("new","soteesklep3");
// wy³±cz usuwanie tabel
$compare->setDrop(0);
// wykonujemy porownanie
$compare->action();
?>
