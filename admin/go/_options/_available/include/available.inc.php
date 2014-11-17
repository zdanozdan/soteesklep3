<?php
/**
 * Odczytaj dostepnosci z bazy danych i zapamietaj je w tablicy
 *
 * \@global array $global_available
* @version    $Id: available.inc.php,v 2.2 2004/12/20 17:58:41 maroslaw Exp $
* @package    options
* @subpackage available
 */

if (@$global_secure_test!=true) {
    die ("Bledne wywolanie");
}

$global_available=array();
$query="SELECT * FROM available";
$result=$db->Query($query);
if ($result!=0) {
    $num_rows=$db->NumberOfRows($result);
    if ($num_rows>0) {
        for ($row=0;$row<$num_rows;$row++) {
            $user_id=$db->FetchResult($result,$row,"user_id");
            $name=$db->fetchResult($result,$row,"name");
            if ((! empty($name)) && (! empty($user_id))) {
                $global_available[$user_id]=$name;
            }
        } // end for
    } // end if
} else die ($db->Error());

?>
