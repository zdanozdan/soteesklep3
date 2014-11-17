<?php
/**
 * Generuj SQL, zapytanie wyszukiwania transakcji
 *
 * @return string $sql
* @version    $Id: order_func.inc.php,v 1.2 2004/12/20 18:00:26 maroslaw Exp $
* @package    partners
 */

/**
 * Element formularza, status platnosci
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
          	  $name="niezdefiniowany";  
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


?>
