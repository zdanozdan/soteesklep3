<?php
/**
 * Odczytaj ilosc punktow uzytkownika
 *
 * \@global int $global_id_user
* @version    $Id: points.inc.php,v 2.4 2005/10/24 13:34:26 krzys Exp $
* @package    users
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

		// rabat
		global $_SESSION;
		if (! empty($_SESSION['__user_discount'])) {
			$discount=$_SESSION['__user_discount'];
			if (! (($discount>0) && ($discount<99))) {
				$discount=0;
			}
		} else $discount=0;
		// end rabat

		// wyswietl informacje o punktach
		$theme->theme_file("points.html.php",array("points"=>$points,"discount"=>$discount));

		return;
	} // end show_user_points()

} // end UserPoints

$points = new UserPoints;
?>
