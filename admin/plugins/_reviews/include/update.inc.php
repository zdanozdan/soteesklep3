<?php
/**
 * PHP Template:
 * Aktualizuj dane w tabeli scores i dodaj punkty jesli dodal recenzje uzytkownik zarejestrowany
 * 
 * @author m@sote.pl
 * \@modified_by krzys@sote.pl
 * @version $Id: update.inc.php,v 1.8 2005/10/25 09:54:42 krzys Exp $
* @package    reviews
 */
global $db;
global $config_points;



if (@$this->secure_test!=true) die ("Bledne wywolanie");

//odczytaj id transakcji
$id=$_REQUEST['id'];

// odczytaj jaki jest teraz status transakcji, czy jest zaplacona
// musimy wieziec, jaki status byl wczesniej, gdyz w ten sposob mozemy
// dowiedziec sie czy uzytwkonik zmienil status recenzji,
// na podstawie tej informacji bedziemy pozniej dodawac lub odejmowac pubkty dla uzytkownika

$query="SELECT state FROM reviews WHERE id=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
	$db->QuerySetInteger($prepared_query,1,$id);
	$result=$db->ExecuteQuery($prepared_query);
	if ($result!=0) {
		$num_rows=$db->NumberOfRows($result);
		if ($num_rows>0) {
			$before_state=$db->FetchResult($result,0,"state");
		} else exit;
	} else die ($db->Error());
} else die ($db->Error());

// wykonaj update

// config
$query="UPDATE reviews SET description=?, date_add=?, state=?, user_id=?, score=?, author=?, author_id=?, lang=? WHERE id=?";
// end

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {

	// config
	$db->QuerySetText($prepared_query,1,@$this->data['description']);
	$db->QuerySetText($prepared_query,2,$this->data['date_add']);
	$db->QuerySetText($prepared_query,3,@$this->data['state']);
	$db->QuerySetText($prepared_query,4,$this->data['user_id']);
	$db->QuerySetText($prepared_query,5,$this->data['score']);
	$db->QuerySetText($prepared_query,6,@$this->data['author']);
	$db->QuerySetText($prepared_query,7,@$this->data['author_id']);
	$db->QuerySetText($prepared_query,8,@$this->data['lang']);
	$db->QuerySetText($prepared_query,9,@$this->id);
	// end

	$result=$db->ExecuteQuery($prepared_query);
	if ($result!=0) {
		$update_info=$lang->reviews_edit_update_ok;
	} else die ($db->Error());
} else die ($db->Error());

// koniec update

//aktualny status
$state=@$rec->data['state'];
if (empty($state)){
	$state=0;
}
// id uzytkowika dodajcego recenzje
$author_id=@$rec->data["author_id"];
// id produktu
$user_id=@$rec->data["user_id"];


// wlacz obluge punktow, jesli zdefinowana zostala wartosc punktowa za recenzje
if ((!empty($author_id)) && ($config_points->for_review>0)){

	// odczytaj obecna liczbe punktow uzykownika
	$query="SELECT points FROM users_points WHERE id_user=?";
	$prepared_query=$db->PrepareQuery($query);
	if ($prepared_query) {
		$db->QuerySetInteger($prepared_query,1,$author_id);
		$result=$db->ExecuteQuery($prepared_query);
		if ($result!=0) {
			$num_rows=$db->NumberOfRows($result);
			if ($num_rows>0) {
				$current_points=$db->FetchResult($result,0,"points");
			}
		} else die ($db->Error());
	} else die ($db->Error());

	if ($before_state!=$state){
		if ($state==1){
			require_once ("include/points.inc");
			$add=new Points();
			// obliczenie punktow
			$new_points_review=@$current_points+$config_points->for_review;
			// dodanie historii punktow
			$add->add_history($author_id,$config_points->for_review,"add","review",'',$user_id);
			// weryfikacja punktow uzytkownika
			$add->add_points($author_id,$new_points_review);
		}else{
			require_once ("include/points.inc");
			$add=new Points();
			// obliczenie punktow
			$new_points_review=$current_points-$config_points->for_review;
			// dodanie historii punktow
			$add->add_history($author_id,$config_points->for_review,"decrease","review",'',$user_id);
			// weryfikacja punktow uzytkownika
			$add->add_points($author_id,$new_points_review);
		}
	}
}

?>