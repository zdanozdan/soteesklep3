<?php
/**
* Sprawd¼, czy s± nowe aktualizacje do programu.
*
* @author  m@sote.pl
* @version $Id: check_new_upgrade.php,v 1.13 2006/08/16 10:21:21 lukasz Exp $
* @package    upgrade
*/

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu2.inc.php");
$theme->bar($lang->upgrade_check_new_version_title);

$file_version="$DOCUMENT_ROOT/../VERSION";
$fd=fopen($file_version,"r");
$my_version=trim(fread($fd,filesize($file_version)));
fclose($fd);

$my_upgrades=$mdbd->select("version","`upgrade`",1,array(),"ORDER BY id DESC","ARRAY");
$upgrades_installed=array();   // lista zainstalowanych  w sklepie upgradeow (liczby calkowite)
if (! empty($my_upgrades)) {
    foreach ($my_upgrades as $myu) {
        if (! empty($myu['version'])) $upgrades_installed[]=$myu['version'];
    }
}

// pobierz dostêpne aktualizacje dla wskazanej wersji
require_once ("HTTP/Client.php");
$http =& new HTTP_Client();
$http->get("http://www.sote.pl/plugins/_bugs/check_new_upgrade_35.php?version=$my_version&lang=$config->lang");
$data_serial=$http->_responses[0]['body'];
$data=@unserialize(trim(@$data_serial));

// poka¿ jakie komunikaty zwraca skrypt po stronie repozytorium ttp://www.sote.pl/plugins/_bugs/check_new_upgrade_31.php
// print "<pre>";print_r($data_serial);print "</pre>";

if (! empty($data)) {

    // odczytaj maksylmalne numery pakietow aktualizacyujnych dla poszczegolnych grup gid
    $gidb=array();          // baza maksymalnych numerow pakietow dla danej grupy gid=>nr
    $id_gidb=array();       // przypisanie gid do id pakietu id=>gid
    $id_name=array();       // przypisanie gid do id pakietu id=>name
    $id_short_desc=array(); // przypisanie gid do id pakietu id=>short_desc
    $upgrades2install=array();
    foreach ($data as $upgr) {
        if ((empty($gidb[$upgr['gid']])) || ($upgr['id']>$gidb[$upgr['gid']]))  {
            $gidb[$upgr['gid']]=$upgr['id'];
        }
        $id_gidb[$upgr['id']]=$upgr['gid'];
        $id_name[$upgr['id']]=$upgr['name'];
        $id_short_desc[$upgr['id']]=$upgr['short_desc'];
        if (@$upgr['id']>@$upgrades2install[$upgr['gid']]) {
            // znaleziono nowsz± aktualizacjê
            $upgrades2install[$upgr['gid']]=$upgr['id'];
        }
    }

    print "<p />\n";

    // odczytaj gid dla kazdego zainstalowanego pakietu i zapamietaj w relacji gid=>id
    // oznaczajacej zainstalowane pakiety dla danego gid
    reset($upgrades_installed);$installed_gid=array();
    foreach ($upgrades_installed as $id_installed) {
        if (! empty($id_gidb[$id_installed])) {
            // jesli w systemie jest zainstalowanych kilka aktualizacji dla tego samego gid
            // zapamietaj najwyzszy numer
            if ($id_installed>@$installed_gid[$id_gidb[$id_installed]]) {
                $installed_gid[$id_gidb[$id_installed]]=$id_installed;
            }
        }
    }

    // sprawdz czy numery pakietow aktualizacyjnych dla danej grupy sa > od zainstalowanych
    // jesli tak, to wyswietl info o pakiecie do zainstalowania; pokaz pakiety nie zainstalowane
    reset($upgrades2install);$_info=false;
    foreach ($upgrades2install as $gid=>$id) {
        if ($id>@$installed_gid[$gid]) {
            // znaleziono nowsz± aktualizacje dla danej grupy pakietów aktualizacyjnych (maj±cych ten sam numer gid)
            if (! $_info) {
                print $lang->upgrade_to_install.":<p />\n";
                $_info=true;
            }
            print "<li>";
            print "<b>".$id_name[$id]."</b> ".$id_short_desc[$id];
            print "</li>\n";
        }
    } // end foreach
}

if (! @$_info) {
    print ereg_replace("{VERSION}",$my_version,$lang->upgrade_new_not_found);
}

print "<p />\n";

$theme->page_open_foot();
// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
