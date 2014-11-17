<?php
/**
*  Funkcje pomocnicze, zwi±zane z prezentacj± danych o transakcji
*
* @author  m@sote.pl
* @version $Id: order_func.inc.php,v 1.7 2005/12/12 13:27:54 lukasz Exp $
* @package    users
*/

/**
* Element formularza, status platnosci
*
* @param string $user_id user_id statusu
*/
function show_status($user_id) {
    global $db,$lang;
    
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
                $name=$lang->users_order_status_undefined;
            }
        } else die ($db->Error());
    } else die ($db->Error());
    return $name;
}

function show_select_order($label,$id=-1) {
    global $db;
    global $lang;
    
    $str="<SELECT name=$label>";
    if ($id==-1) {
        $str.="<OPTION selected value=''>$lang->all\n";
    }
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
                    if($user_id == $id ) {
                        $sel="selected";
                    } else {
                        $sel="";
                    }
                    $str.="<OPTION $sel value=$user_id> $name\n";
                }
            } else {
                $str="";
            }
        } else die ($db->Error());
    } else die ($db->Error());
    $str.="</SELECT>";
    
    return $str;
}

/**
* Odczytan nazwy statusow z tabeli order_status
*
* @author m@sote.pl
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
} // end get_status_names

/**
* Poka¿ produkty do transakcji
*
* @param int $order_id id transakcji
* @return none
*/
function show_products($order_id) {
    global $db,$lang,$config;
    
    $query="SELECT * FROM order_products WHERE order_id=?";
    $prepared_query=$db->PrepareQuery($query);
    if ($prepared_query) {
        $db->QuerySetText($prepared_query,1,$order_id);
        $result=$db->ExecuteQuery($prepared_query);
        if ($result!=0) {
            $num_rows=$db->NumberOfRows($result);
            print "<table align=\"center\" width=\"770\" cellspacing=\"2\" cellpadding=\"2\" border=\"0\" class=\"block_1_basket\">\n";
            //print "<tr bgcolor=\"".$config->theme_config['colors']['body_background']."\">\n";
 	    print "<tr bgcolor=\"#e0e0e0\">\n";
            //print "<th>".$lang->order_basket['user_id']."</th>\n";
            print "<th>".$lang->order_basket['name']."</th>\n";
            print "<th>".$lang->order_basket['price_brutto']."</th>\n";
            print "<th>".$lang->order_basket['num']."</th>\n";
            print "<th>".$lang->order_basket['sum']."</th>\n";
            print "</tr>\n";
            if ($num_rows>0) {
                for ($i=0;$i<$num_rows;$i++) {
                    product_row($result,$i);
                }
            }
            print "</table>\n";
        } else die ($db->Error());
    } else die ($db->Error());
} // end show_products()

/**
* Wyswietl rekord transakcji
*
* @param mixed $result wynik zapytania z bazy danych
* @param int   $i      numer wiersza wyniku zapytania z bazy danych
* @return none
*/
function product_row($result,$i) {
    global $db,$config;
    global $shop;
    global $lang;
	$shop->currency();
	global $rec;
    $num=$db->FetchResult($result,$i,"num");
    $price_brutto=$db->FetchResult($result,$i,"price_brutto");
    $points_value=$db->FetchResult($result,$i,"points_value");
    $sum_points=$num*$points_value;
    $sum=$num*$shop->currency->price($price_brutto);
    print "<tr>";

    $user_id_main = $db->FetchResult($result,$i,"user_id_main");
    $item_href = "<a href=\"$config->url_prefix/?id=$user_id_main\">".$db->FetchResult($result,$i,"name")."</a>";

    print "<td>".$item_href."</td>";
    //print "<td>"; "<a href=\"\">".$db->FetchResult($result,$i,"name")."</a>"; print "</td>";
    if ($price_brutto!=0) {
	    print "<td align=\"center\">"; print $shop->currency->price($price_brutto)." ".$shop->currency->currency; print "</td>";
    } else if ($rec->data['points']==1) {
    	print "<td align=\"center\">$points_value $lang->points_unit</td>";
    } else print "<td></td>";
    print "<td align=\"center\">"; print $num; print "</td>";
    if ($price_brutto!=0) {
	    print "<td align=\"center\">"; print $sum." ".$shop->currency->currency; print "</td>";
    } else if ($rec->data['points']==1) {
    	print "<td align=\"center\">$sum_points $lang->points_unit</td>";
    } else print "<td></td>";
    print "</tr>";
} // end product_row()

?>
