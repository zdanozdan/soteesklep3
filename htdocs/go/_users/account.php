<?php
/**
 * Sprawdz stan swojego konta
 *
 * @author m@sote.pl
 * @version $Id: account.php,v 2.4 2005/10/20 06:40:52 krzys Exp $
* @package    users
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
require_once ("./include/points.inc.php");

// naglowek
$theme->head();
$theme->page_open_head("page_open_1_head");

if (! empty($_SESSION['global_id_user'])) {
	// uzytkownik jest zalogowany
	include("./include/menu.inc.php");
	$theme->bar($lang->bar_title['points']);
	$global_id_user=$_SESSION['global_id_user'];
	// pokaz liczbe punktow uzytkownika
	$points->show_user_points($global_id_user);

	$sql="SELECT * FROM users_points_history WHERE id_user_points=$global_id_user ORDER BY id DESC";
	$dbedit = new DBEdit;
	$dbedit->page_records=20;
	$dbedit->page_links=20;

	// ustal klase generujaca wiersz rekordu
	require_once("./include/points/trans.inc.php");

	// ustal funkcje generujaca wiersz rekordu
	$dbedit->start_list_element=$theme->points_list_th();
	$dbedit->record_class="TransRecordRow";
	$dbedit->dbtype=$config->dbtype;
	$dbedit->record_list($sql);

} else {
	// kaz uzytkownikowi zalogowac sie
	$theme->bar($lang->bar_title['account']);
	print "<p><center><a href=/go/_users/><u>$lang->users_log_in</u></a></center><p>";
}

$theme->page_open_foot("page_open_1_foot");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
