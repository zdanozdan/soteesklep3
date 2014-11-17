<?php
/**
 * Odczytaj liste typow uzytkownikow i ich id z tabeli admin_users_type i zapamietaj wynik w tablicy
 * Na podstawie tej tablicy beda wyswietlane nazwy typow uzytkownikow na liscie
 *
 * 
 * \@global array $__admin_users_types tablica nazw typow uzytkownikow wg. id
 *
 * @author  m@sote.pl
 * @version $Id: admin_users_type.inc.php,v 2.5 2004/12/20 17:57:52 maroslaw Exp $
* @package    admin_users
 */

global $db;
global $__admin_users_type;

// odczytaj liste typow uzytkownikow z tabeli admin_users_type
$__admin_users_type=array();
$query="SELECT id,type FROM admin_users_type ORDER BY type";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        $i=0;
        while ($i<$num_rows) {
            $type=$db->FetchResult($result,$i,"type");
            $id_admin_users_type=$db->FetchResult($result,$i,"id");
            if (! empty($type)){
                $__admin_users_type[$id_admin_users_type]=$type;
            }
            $i++;
        } // end for
    } else die ($db->Error());
} else die ($db->Error());

?>
