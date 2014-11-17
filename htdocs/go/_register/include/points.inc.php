<?php
/**
 * Odczytaj ilosc punktow uzytkownika
 *
 * \@global int $global_id_user
* @version    $Id: points.inc.php,v 2.2 2004/12/20 18:01:46 maroslaw Exp $
* @package    register
 */

class UserPoints {
    /**
	 * Pokaz liczbe puktow uzytkownika
	 *
	 * @param int $id_user id uzytkownika z tabeli users
	 */
    function show_user_points($id_user) {
	    global $db;
        global $lang;
        global $theme;

        $points=0;
		$query="SELECT points FROM users_points WHERE id_user=?";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetInteger($prepared_query,1,$id_user);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    $points=$db->FetchResult($result,0,"points");
                } else $points=0;
            } else $theme->go2main();
        } else die ($db->Error());
        
       return $points;
    } // end show_user_points()
} // end UserPoints

$points = new UserPoints;
?>
