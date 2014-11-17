<?php
/**
 * Edycja punktow klienta.
 *
 * @author  krzys@sote.pl
 * @version $Id: points.php,v 1.2 2005/10/24 15:00:21 krzys Exp $
 *  @package    users
 */ 

// odczytaj laczna wartosc zakupow klienta
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/ 
require_once ("../../../include/head.inc");
if (! empty($_REQUEST['id'])) {
	$id=$_REQUEST['id'];
	$global_id_user=$id;
} else {
	die ("Bledne wywolanie");
}

// wyciagnij dane z tablicy users
$query="SELECT * FROM users WHERE id=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
	$db->QuerySetInteger($prepared_query,1,$id);
	$result=$db->ExecuteQuery($prepared_query);
	if ($result!=0) {
		$num_rows=$db->NumberOfRows($result);
		if ($num_rows>0) {
			// odczytaj wlasciowasi transakcji
			require_once("./include/query_rec.inc.php");
		} else {
			$theme->back();
			die ("Brak danych klienta");
		}
	} else die ($db->Error());
} else die ($db->Error());
// koniec wyciagania

// odkoduj zakodowane dane
/*
* Dodaj obs³ugê kodowania.
*/
require_once ("include/my_crypt.inc");
$rec->data['login']=$my_crypt->endecrypt("",$rec->data['crypt_login'],"de");
$rec->data['name']=$my_crypt->endecrypt("",$rec->data['crypt_name'],"de");
$rec->data['surname']=$my_crypt->endecrypt("",$rec->data['crypt_surname'],"de");
// koniec kodowania


if (! empty($_REQUEST['form'])){
$points_form=$_REQUEST['form'];
is_numeric($points_form['points']);

if (!empty($points_form['points']) && !empty($points_form['points'])){
require_once ("include/points.inc");
$add=new Points();
// obliczenie punktow
if ($points_form['action']=='add'){
$new_points_add=@$global_points+$points_form['points'];
}elseif ($points_form['action']=='decrease'){
$new_points_add=@$global_points-$points_form['points'];
}
// dodanie historii punktow
$add->add_history($id,$points_form['points'],$points_form['action'],$points_form['description'],'','');
// weryfikacja punktow uzytkownika
$add->add_points($id,$new_points_add);
print $lang->user_points['points_verified_ok'];
}else{
print $lang->user_points['points_verified_no'];
}
}
include ("./include/get_points.inc.php");
$theme->head_window();
// menu w edycji danych
include_once ("./include/menu_edit.inc.php");
$theme->bar($lang->bar_title["users_points"]." : ".$rec->data['name']." ".$rec->data['surname']);
include_once ("./html/points.html.php");

$theme->foot_window();
include_once ("include/foot.inc");
?>   
 