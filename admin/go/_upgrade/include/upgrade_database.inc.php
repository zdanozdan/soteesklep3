<?php
/**
* Aktualizacja bazy danych, z do³±czonych plików do upgrade'u
* Pliki znajduj± siê w podkatalogu sql/upgrade_30005.mysql itp.
*
* @author  m@sote.pl
* @version $Id: upgrade_database.inc.php,v 1.6 2006/01/11 11:41:41 lukasz Exp $
*
* \@global string $version_pkg np. 30004 numer pakietu
* @package    upgrade
*/

// definicja dodatkowych instrukcji sql
$name_upgrade_sql="upgrade_$version_pkg";
$file_upgrade_sql="$DOCUMENT_ROOT/../sql/".$name_upgrade_sql.".mysql";

if (file_exists($file_upgrade_sql)) {
    $fd=fopen($file_upgrade_sql,"r");
    $query=trim(fread($fd,filesize($file_upgrade_sql)));
    fclose($fd);
    
    $tab=preg_split("/\;[\n]+/",$query);$error_db=0;
    foreach ($tab as $query) {
        $result=$db->query($query);
        if ($result==0) {
            print $db->error();print "<br />\n";
            $error_db=1;
        }
    }
    if ($error_db==0) print "<b>".$lang->upgrade_database_updated."<b><p />\n";
}

?>
