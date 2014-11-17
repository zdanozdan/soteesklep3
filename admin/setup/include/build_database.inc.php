<?php
/**
* Zbuduj strukture bazy danych na podstawie pliku soteesklep2/sql/soteesklep2.mysql
*
* @author  m@sote.pl
* @version $Id: build_database.inc.php,v 2.15 2006/05/10 10:00:45 lechu Exp $
*
* \@verified 2004-03-16 m@sote.pl
* @package    setup
*/
// zmienna globalna ktora informuje o tym czy jest upgrade bazy danych czy tez nowa instalalcja
global $__file;
global $config;

// odczytaj plik soteesklep2.mysql i usun z niego komentarze
if($__file) {
    $file="$DOCUMENT_ROOT/../sql/soteesklep3_".$config->lang.".mysql";
} else {
    $file="$DOCUMENT_ROOT/tmp/diff.mysql";
}
$fd=fopen($file,"r");
$sql=fread($fd,filesize($file));
fclose($fd);

// pomiñ komentarze SQL
$sql_lines = explode("\n",$sql); // jest duzo szybsze niz split()
//$sql_lines=split("\n",$sql);
$sql2='';
foreach ($sql_lines as $line) {
    if (! ereg("^\-\-\-",$line)) $sql2.=$line."\n";
}

$sql_com=preg_split("/;\n[\s]*/",$sql2);
print "<b>$lang->setup_create_db</b><p>\n";
print "<table>\n";$i=0;$tables=array();
foreach ($sql_com as $query) {
    if (ereg("CREATE TABLE",$query)) {
        preg_match("/CREATE TABLE \`([a-zA-Z0-9|_]+)\` /",$query,$matches);
        $table=@$matches[1];
        $i++;
        $tables[]=$table;
    } else $table='';
    $result=$db->Query($query);
    if ($result!=0) {
        if (! empty($table)) {
            print "<tr><td>$i</td><td>$lang->setup_create_table</td><td>$table</td><td>$lang->setup_create_table_ok</td></tr>\n";
        }
    } else {
        if ((! empty($table)) && ($table!="soteesklep_install_test")) {
            print "<tr><td>$i</td><td>$lang->setup_create_table</td><td>$table</td><td><font color=red>$lang->setup_create_table_error</font></td></tr>\n";
        }
    }
} // end foreach
print "</table>\n";

// zeruj indeksy je¶li tabele s± puste
/*
reset($tables);
foreach ($tables as $table) {
    $query2="SELECT * FROM $table LIMIT 1";
    $result2=$db->query($query2);
    if ($result2!=0) {
        $num_rows2=$db->numberOfRows($result2);
        if ($num_rows2==0) {
            $query3="DELETE from $table";
            $result3=$db->query($query3);
            print "clean index table $table <br>";
        }
    }
}
*/
// end

?>
