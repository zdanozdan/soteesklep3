<?php
/**
 * Sprawdz nccp (liczbê produktów)
 *
 * @author  m@sote.pl
 * @version $Id: add_nccp.inc.php,v 2.4 2005/01/31 07:43:12 maroslaw Exp $
 *
 * \@verified 2004-03-15 m@sote.pl
* @package    edit
 */

if ($global_secure_test!=true) {
    die ("Forbidden");
}

$db->soteSetModSQLOff();
$query="SELECT id FROM main";
$result=$db->Query($query);
if ($result!=0) {
    $num_rows=$db->NumberOfRows($result);
    if ($num_rows>$config->nccp) {
        print $lang->nccp_error;
        $theme->back();
        die();
    }
} else die ($db->Error());
$db->soteSetModSQLOn();
?>
