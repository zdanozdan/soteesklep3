<?php
/**
 * Odczytaj liczbe punktow uzytkwonika
 *
 * @param int $global_id_user id uzytkwonika z tabeli users
 * @return int $global_points liczba pubktow uzytkownika
* @version    $Id: get_points.inc.php,v 2.5 2005/12/09 13:55:54 lukasz Exp $
* @package    users
 */
$global_points=0;
$global_points_reserved=0;
$query="SELECT points,points_reserved FROM users_points WHERE id_user=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetInteger($prepared_query,1,$global_id_user);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) {         
            $global_points=$db->FetchResult($result,0,"points");
            $global_points_reserved=$db->FetchResult($result,0,"points_reserved");
        } else $global_points=0;
    } else die ($db->Error());
} else die ($db->Error());
?>
