<?php
/**
* Funckje pomocnicze zwi±zane z transakcjami,
*
* @author  m@sote.pl
* @version $Id: order_func.inc.php,v 2.6 2005/12/12 14:10:37 scalak Exp $
* @package    order
*/

/**
* \@global string $sql
*/
/**
* Element formularza, status p³atno¶ci
*
* @param string $user_id ID statusu p³atno¶ci
* @return string nazwa statusu
*/
function show_status($user_id) {
	global $db;

	$query="SELECT name FROM order_status WHERE user_id=?";
	$prepared_query=$db->PrepareQuery($query);
	if ($prepared_query) {
		$db->QuerySetInteger($prepared_query,1,$user_id);
		$result=$db->ExecuteQuery($prepared_query);
		if ($result!=0) {
			$num_rows=$db->NumberOfRows($result);
			if ($num_rows>0) {
				$name=$db->FetchResult($result,0,"name");
			} else {
				$name=$lang->order_status_unknown;
			}
		} else die ($db->Error());
	} else die ($db->Error());
	return $name;
} // end show_status()

/**
* Poka¿ element SELECT formularza ze statusami patno¶ci
*
* @param string $label nazwa pola formularza
* @param int    $id    id domy¶lnie zaznaczonego pola
* @return string HTML
*/
function show_select_order($label,$id=-1) {
	global $db;
	global $lang;

	$str="<SELECT name=$label>";
	if ($id==-1) {
		$str.="<OPTION selected value=''>$lang->all\n";
	}
	$query="SELECT user_id,name,send_mail FROM order_status ORDER BY user_id";
	$prepared_query=$db->PrepareQuery($query);
	if ($prepared_query) {
		$result=$db->ExecuteQuery($prepared_query);
		if ($result!=0) {
			$num_rows=$db->NumberOfRows($result);
			if ($num_rows>0) {
				for($i=0;$i<$num_rows;$i++) {
					$name=$db->FetchResult($result,$i,"name");
					$send_mail=$db->FetchResult($result,$i,"send_mail");
					$user_id=$db->FetchResult($result,$i,"user_id");
					if ($send_mail==1) $ext="(".$lang->order_status_mail.")";
					else $ext='';
					if($user_id == $id ) {
						$sel="selected";
					} else {
						$sel="";
					}
					$str.="<option $sel value=$user_id> $name $ext</option>\n\n";
				}
			} else {
				$str="";
			}
		} else die ($db->Error());
	} else die ($db->Error());
	$str.="</SELECT>";

	return $str;
} // end show_select_order()

/**
* Odczytaj nazwy statusow z tabeli order_status
*
* @return array user_id=>name nazwa przyporzadkowana id statusu
*/
function read_status_names() {
	global $db;

	$status_names=array();

	$query="SELECT user_id,name FROM order_status ORDER BY user_id";
	$prepared_query=$db->PrepareQuery($query);
	if ($prepared_query) {
		$result=$db->ExecuteQuery($prepared_query);
		if ($result!=0) {
			$num_rows=$db->NumberOfRows($result);
			if ($num_rows>0) {
				for($i=0;$i<$num_rows;$i++) {
					$name=$db->FetchResult($result,$i,"name");
					$user_id=$db->FetchResult($result,$i,"user_id");
					$status_names[$user_id]=$name;
				}
			}
		} else die ($db->Error());
	} else die ($db->Error());

	return $status_names;
} // end get_status_names()

/**
* Odczytaj login klienta polecajacego produkt 
*
* @return array user_id= login klienta 
*/

function read_user_login($user_id) {
	global $db;
	require_once ("include/my_crypt.inc");

	$query="SELECT crypt_login FROM users WHERE id=$user_id";
	$prepared_query=$db->PrepareQuery($query);
	if ($prepared_query) {
		$result=$db->ExecuteQuery($prepared_query);
		if ($result!=0) {
			$num_rows=$db->NumberOfRows($result);
			if ($num_rows>0) {

				$crypt_login=$db->FetchResult($result,0,"crypt_login");
				$crypt =& new MyCrypt;
				$login=$crypt->endecrypt('',$crypt_login,'de');
			}
		} else die ($db->Error());
	} else die ($db->Error());

	return $login;
} // end get_status_names()


/**
 * sumowanie punktów jesli punkty sa przyznawane za wartosc punktowa produktow
 *
 */
function sum_points()
{
    global $_REQUEST;
    global $mdbd;

    $res2 = $mdbd->select("user_id_main,num,points_value", "order_products", "order_id=" . $_REQUEST['order_id'], array(), '', 'array');
    $sum=0;
    foreach($res2 as $key=>$value) {
        $sum+=$value['num'] * $value['points_value'];
    }
    return $sum;
} // end func sum_points

// od naliczonych punktów odejmujemy rabat dla danego klienta, ¿eby nie dosta³ ich za du¿o
// w mikran.pl ilosc punktów towaru = jego cena
// sum = points-points*discount
function check_apply_points_discount($points)
{
   global $mdbd;
   global $order_id;
   $sum=0;

   $session=$mdbd->select('data','order_session',"order_id='$order_id'");
   if (!empty($session)) 
   {
      $mySession=unserialize($session);

      //      print "DISCOUNT: ".$mySession['__user_discount']."<br>";

//       foreach ( $mySession as $key=>$val ) 
//       {
//          print "klucz:$key, value:$mySession[$key]\n    ";
//       }

      $discount = $mySession['__user_discount'];
      $points = round($points-$points*($discount/100));
   }

   return $points;
}

?>
