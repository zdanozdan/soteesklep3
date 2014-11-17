<?php
/**
 * Aktualizuj w bazie warto¶æ xml_options
 *
 * @author m@sote.pl
 * @version $Id: edit_update_xml_options.inc.php,v 2.3 2004/12/20 17:58:04 maroslaw Exp $
 *
 * \@verified 2004-03-16 m@sote.pl
* @package    edit
 */

if ($global_secure_test!=true) {
    die ("Forbidden");
}

// odczytaj dane z formularza
if (! empty($_REQUEST['item'])) {
    $item=&$_REQUEST['item'];
} else {
    die ("Forbidden: Unknown item");
}

$query="UPDATE main SET xml_options=? WHERE id=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$item['xml_options2']);
    $db->QuerySetText($prepared_query,2,$id);

    $result=$db->ExecuteQuery($prepared_query);
    if ($result==0) {
        die ($db->Error());
    } 
} else {
    die ($db->Error());
}

?>
