<?php
/**
 * Aktualizuj ilosc punktow uzytkownika
 *
 * \@global int $global_points punkty nadawane uzytkwonikowi
 * \@global int $global_id_user id uzytkwonika z tabeli users
 * \@global string $global_update_status informacja o wyniku aktualizacji (tekst)
 * \@global int $global_points aktualna liczba punktow uzytkownika
* @version    $Id: update_user_points.inc.php,v 2.2 2004/12/20 17:59:25 maroslaw Exp $
* @package    admin_include
 */

if (@$global_secure_test!=true) {
    die ("Bledne wywolanie");
}

if (! empty($_POST['id'])) {
    $id_user=&$_POST['id'];
}

if (! empty($_POST['form'])) {
    $form=&$_POST['form'];
    $points=$form['points'];
    $points=number_format($points,0,"","");
}

// sprawdz czy nie wywolano tego skryptu z globalnymi danymi uzytkwonika i punktow
if (! empty($global_points)) {
    $points=$global_points;
}

if (empty($points)) $points=0;

if (! empty($global_id_user)) {
    $id_user=$global_id_user;
}

if (empty($id_user)) {
    die ("Bledne wywolanie");
}

// sprawdz czy w tabeli jest juz wpis dla uzytkownika
$query="SELECT id FROM users_points WHERE id_user=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetInteger($prepared_query,1,$id_user);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) $update=true;
        else $update=false;
    } else die ($db->Error());
} else die ($db->Error());

// sprawdz czy jest to aktualiacja punktow, czy dodanie nowego wpisu do tabeli
if ($update==false) {
    // nie ma wpisu w tabeli users_points, dodaj nowy wpis
    $query="INSERT INTO users_points (id_user,points) VALUES (?,?)";
    $prepared_query=$db->PrepareQuery($query);
    if ($prepared_query) {
        $db->QuerySetInteger($prepared_query,1,$id_user);
        $db->QuerySetInteger($prepared_query,2,$points);
        $result=$db->ExecuteQuery($prepared_query);
        if ($result!=0) {
            // punkty zostaly poprawnie dodane
            $global_points=$points;
            // komunikat
            $global_update_status=$lang->edit_update_ok;
        } else die ($db->Error());
    } else die ($db->Error());
} else {
    // aktualizuj dane
    $query="UPDATE users_points SET points=? WHERE id_user=?";
    $prepared_query=$db->PrepareQuery($query);
    if ($prepared_query) {
        $db->QuerySetInteger($prepared_query,1,$points);
        $db->QuerySetInteger($prepared_query,2,$id_user);
        $result=$db->ExecuteQuery($prepared_query);
        if ($result!=0) {
            // punkty zostaly poprawnie zaktualizowane
            $global_points=$points;
            // komunikat
            $global_update_status=$lang->edit_update_ok;
        } else die ($db->Error());
    } else die ($db->Error());
} // end if ($update==false)

?>
