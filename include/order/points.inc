<?php
/**
 * Klasa aktualizuj�ca liczbe punkt�w klienta je�eli zam�wienie jest za punkty.
 *
 * @author lukasz@sote.pl
 * @since 3.5ALFA20
 * @version $Id: points.inc,v 1.1 2005/11/30 08:46:51 lukasz Exp $
 */
class Points_pay {
	/**
	 * Dodaj koszty bierzacego zamowienia do listy punktow klienta
	 *
	 * @param int $order_id - id zam�wienia do ktorego beda przypisane punkty
	 */
	function pay_with_points($order_id) {
		global $my_basket;
		global $mdbd;
		global $sess;
		global $lang;
		require_once("./include/points.inc.php");
		$my_points=&new UserPoints();
		require_once("include/points.inc");
		$points_history=&new Points();
		// id u�ytkownika
		$id_user=$_SESSION['global_id_user'];
		// ile punkt�w musimy zdj�� za to zam�wienie
		$points_reserved=$_SESSION['form']['points_reserved'];
		// pobieramy aktualn� liczbe punkt�w dost�pnych dla danego uzytkownika
		$points_avail=$my_points->show_user_points($id_user);
		$points_reserved_total=$mdbd->select('points_reserved','users_points','id_user=?',array($id_user=>"int"));
		$points_avail=$points_avail-$points_reserved;
		$points_reserved_total=$points_reserved_total+$points_reserved;
		// aktualizujemy dost�pne i zarezerwowane punkty
		$points_history->add_points($id_user,$points_avail,$points_reserved_total);
		$points_history->add_history($id_user,$points_reserved,'decrease',$lang->order_points_update,$order_id);
		// aktualizujemy sesje
		$form=$_SESSION['form'];
		$form['points']=$points_avail;
		$form['points_reserved']='0';
		$sess->register('form',$form);
	}
}
?>