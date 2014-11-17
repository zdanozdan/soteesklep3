<?php
/**
* Dodaj nowy rekord do tabeli promotions wykonaj komende SQL dodanie rekordu do bazy
*
* @author  m@sote.pl
* \@global  string $table nazwa tabeli do ktorej dodajemy rekord
* \@template_version Id: insert.inc.php,v 2.3 2003/07/11 15:48:09 maroslaw Exp
* @version $Id: insert.inc.php,v 1.4 2004/12/20 18:00:45 maroslaw Exp $
* @return  int $this->id
* @package    promotions
*/

if (@$this->secure_test!=true) die ("Bledne wywolanie");

global $db;

require_once ("include/my_crypt.inc");
$my_crypt = new MyCrypt;

// dodaj rekord
// config
$query="INSERT INTO promotions (name,active,discount,code1,code2,code3,code4,code5,code6,code7,code8,code9,code10,amount,short_description,description,photo,active_code,lang) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
// end

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,@$this->data['name']);
    $db->QuerySetText($prepared_query,2,@$this->data['active']);
    $db->QuerySetText($prepared_query,3,@$this->data['discount']);
    for ($i=4;$i<14;$i++) {
        $db->QuerySetText($prepared_query,$i,$my_crypt->endecrypt("",@$this->data['code'.($i-3)]));
    }
    $db->QuerySetText($prepared_query,14,@$this->data['amount']);
    $db->QuerySetText($prepared_query,15,@$this->data['short_description']);
    $db->QuerySetText($prepared_query,16,@$this->data['description']);
    $db->QuerySetText($prepared_query,17,@$this->data['photo']);
    $db->QuerySetText($prepared_query,18,@$this->data['active_code']);
    $db->QuerySetText($prepared_query,19,@$this->data['lang']);
    // end
    
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        // odczytaj numer id dodanego rekordu
        $query="SELECT max(id) FROM $table";
        $result_id=$db->Query($query);
        if ($result_id!=0) {
            $insert_info=$lang->promotions_record_add;
            $num_rows=$db->NumberOfRows($result_id);
            if ($num_rows>0) {
                $var=$config->dbtype."_maxid";
                $this->id=$db->FetchResult($result_id,0,$config->$var);
            } else die ("Bledne dodanie rekordu");
        } else die ($db->Error());
    } else die ($db->Error());
} else die ($db->Error());
?>
