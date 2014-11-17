<?php
/**
 * Obs³uga punktów
 * 
 * @author krzys@sote.pl
 * @package include
 */

class Points {

	/**
     * Dodanie rekordu historii punktów.
     *
     * @param int    $id_user_points
     * @param int    $points
     * @param string $type
     * @param string $description 
     * @param int    $order_id
     * @param int 	 $user_id_main
     *
     * @return bool true - OK, false 
     */

	function add_history($id_user_points,$points,$type,$description,$order_id='',$user_id_main='') {
		global $db;
		$query="INSERT INTO users_points_history (id_user_points,points,type,
												  description,order_id,user_id_main)
				VALUES (?,?,?,
				        ?,?,?)
				 ";
		$prepared_query=$db->PrepareQuery($query);
		if ($prepared_query) {
			$db->QuerySetText($prepared_query,1,$id_user_points);
			$db->QuerySetText($prepared_query,2,$points);
			$db->QuerySetText($prepared_query,3,$type);
			$db->QuerySetText($prepared_query,4,$description);
			$db->QuerySetText($prepared_query,5,$order_id);
			$db->QuerySetText($prepared_query,6,$user_id_main);
			$result=$db->ExecuteQuery($prepared_query);
			if ($result==0) {
				die ($db->Error());
			}
		} else {
			die ($db->Error());
		}

		return;
	} // end add_history()



	/**
    * Zmiana punktow uzytkownikowi
    *
    * @param int    $id_user_points
    * @param int    $points
    * 
    * @return bool true - OK, false 
    */
	function add_points($id_user_points,$points,$points_reserved='-') {
		global $db;
		// sprawdz czy w tabeli jest juz wpis dla uzytkownika
		if ($points_reserved=='-') {
			$update_reserved=false;
		} else $update_reserved=true;
		$query="SELECT id FROM users_points WHERE id_user=?";
		$prepared_query=$db->PrepareQuery($query);
		if ($prepared_query) {
			$db->QuerySetInteger($prepared_query,1,$id_user_points);
			$result=$db->ExecuteQuery($prepared_query);
			if ($result!=0) {
				$num_rows=$db->NumberOfRows($result);
				if ($num_rows>0) $update=true;
				else $update=false;
			} else die ($db->Error());
		} else die ($db->Error());

		// sprawdz czy jest to aktualizacja punktow, czy dodanie nowego wpisu do tabeli
		if ($update==false) {
			// nie ma wpisu w tabeli users_points, dodaj nowy wpis
			$query="INSERT INTO users_points (id_user,points) VALUES (?,?)";
			$prepared_query=$db->PrepareQuery($query);
			if ($prepared_query) {
				$db->QuerySetInteger($prepared_query,1,$id_user_points);
				$db->QuerySetInteger($prepared_query,2,$points);
				$result=$db->ExecuteQuery($prepared_query);
			} else die ($db->Error());
		} else {
			// aktualizuj dane
			if ($update_reserved) {
				$query="UPDATE users_points SET points=?,points_reserved=? WHERE id_user=?";
				$prepared_query=$db->PrepareQuery($query);
				if ($prepared_query) {
					$db->QuerySetInteger($prepared_query,1,$points);
					$db->QuerySetInteger($prepared_query,2,$points_reserved);
					$db->QuerySetInteger($prepared_query,3,$id_user_points);
					$result=$db->ExecuteQuery($prepared_query);
				} else die ($db->Error());
			} else {
				$query="UPDATE users_points SET points=? WHERE id_user=?";
				$prepared_query=$db->PrepareQuery($query);
				if ($prepared_query) {
					$db->QuerySetInteger($prepared_query,1,$points);
					$db->QuerySetInteger($prepared_query,2,$id_user_points);
					$result=$db->ExecuteQuery($prepared_query);
				} else die ($db->Error());
			}
		} // end if ($update==false)
		return;
	} // end decrease


}

$points =& new Points;
?>