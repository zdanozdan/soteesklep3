<?php
/**
 * Dodaj nowy rekord do tabeli main_keys_ftp wykonaj komende SQL dodanie rekordu do bazy
 *
 * @author  m@sote.pl
 * \@global  string $table nazwa tabeli do ktorej dodajemy rekord
 * \@template_version Id: insert.inc.php,v 2.3 2003/07/11 15:48:09 maroslaw Exp
 * @version $Id: insert.inc.php,v 1.3 2004/12/20 17:59:56 maroslaw Exp $
 * @return  int $this->id
* @package    main_keys
* @subpackage main_keys_ftp
 */

if (@$this->secure_test!=true) die ("Bledne wywolanie");

global $db;

// dodaj rekord
// config
$query="INSERT INTO main_keys_ftp (ftp,active,user_id_main,demo) VALUES (?,?,?,?)";
// end

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,@$this->data['ftp']);
    $db->QuerySetText($prepared_query,2,@$this->data['active']);
    $db->QuerySetText($prepared_query,3,@$this->data['user_id_main']);
    $db->QuerySetText($prepared_query,4,@$this->data['demo']);
    // end

    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {        
        // odczytaj numer id dodanego rekordu
        $query="SELECT max(id) FROM $table";
        $result_id=$db->Query($query);
        if ($result_id!=0) {
            $insert_info=$lang->main_keys_ftp_record_add;
            $num_rows=$db->NumberOfRows($result_id);
            if ($num_rows>0) {
                $var=$config->dbtype."_maxid";
                $this->id=$db->FetchResult($result_id,0,$config->$var);
            } else die ("Bledne dodanie rekordu");
        } else die ($db->Error());        
    } else die ($db->Error());
} else die ($db->Error());
?>
