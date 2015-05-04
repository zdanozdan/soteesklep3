<?php
/**
 * Odczytaj uprawnienia uzytkownika z bazy danych
 *
 * /@table admin_users      uzytkownik i typ
 * /@table admin_users_type prawa dla typu (grupy) uzytkownika
 *
 * /return
 * /@session array $__perm tablica z uprawnieniami uzytkownika
 * /@global  array $__perm
 *
 * @author  m@sote.pl
 * @version $Id: get_perm.inc.php,v 2.8 2005/03/24 10:31:04 maroslaw Exp $
* @package    auth
 */


if (@$__secure_test!=true) die ("Bledne wywolanie");
$__perm=array();

/** dodaj obsluge bazy danych bo /go/_auth.index.php domyslnie baza nie jest ladowana */
require_once "lib/Metabase/metabase_interface.php";
require_once "lib/Metabase/metabase_database.php";
require_once "config/database.php";

$db->soteSetModSQLOff();

$id_admin_users_type='';
$query="SELECT id,id_admin_users_type,login FROM admin_users WHERE login=? AND active=1";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
  $db->QuerySetText($prepared_query,1,$_SERVER['REMOTE_USER']);
  //$db->QuerySetText($prepared_query,1,'mikran_1');
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows==1) {
            $id_admin_users=$db->FetchResult($result,0,"id");
            $__id_admin_users=$id_admin_users;
            $sess->register("__id_admin_users",$__id_admin_users);
            $id_admin_users_type=$db->FetchResult($result,0,"id_admin_users_type"); 
            $login=$db->FetchResult($result,0,"login");
        }         
    } else die ($db->Error());
} else die ($db->Error());


// jesli uzytkwonik jest w bazie to odczytaj uprawnienia dla zdefiniowanej dla tego uzytkownika grupy
if (! empty($id_admin_users_type)) {
    $query="SELECT * FROM admin_users_type WHERE id=?";
    $prepared_query=$db->PrepareQuery($query);
    if ($prepared_query) {
        $db->QuerySetInteger($prepared_query,1,$id_admin_users_type);
        $result=$db->ExecuteQuery($prepared_query);
        if ($result!=0) {
            $num_rows=$db->NumberOfRows($result);
            if ($num_rows>0) {
                // odczytaj uprawnienia grupy wg. listy uprawnien z pliku config/auto_config/perm_config.inc.php
                include_once ("config/auto_config/perm_config.inc.php"); // return $coffig->admin_perm
                foreach ($config->admin_perm as $perm) {
		  $p_perm=$db->FetchResult($result,0,"p_$perm");
		   if ($p_perm==1) {
		     array_push($__perm,"$perm");
		   }
                } // end foreach
            } 
        } else die ($db->Error());
    } else die ($db->Error());
} // end if (! empty($id_admin_users))

if ($config->nccp=="0x1388") {
    array_push($__perm,"$config->nccp");
}

// zapisz uprawnienia uzytkownika w sesji
$sess->register("__perm",$__perm);

$db->soteSetModSQLOn();
?>
