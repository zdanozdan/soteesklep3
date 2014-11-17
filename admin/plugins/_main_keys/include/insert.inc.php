<?php
/**
 * Dodaj nowy rekord do tabeli main_keys wykonaj komende SQL dodanie rekordu do bazy
 *
 * @author  m@sote.pl
 * \@global  string $table nazwa tabeli do ktorej dodajemy rekord
 * \@template_version Id: insert.inc.php,v 2.3 2003/07/11 15:48:09 maroslaw Exp
 * @version $Id: insert.inc.php,v 1.4 2004/12/20 18:00:01 maroslaw Exp $
 * @return  int $this->id
* @package    main_keys
 */

if (@$this->secure_test!=true) die ("Bledne wywolanie");

global $db;

// dodaj rekord
// config

$query="INSERT INTO main_keys (user_id_main,main_key,order_id,url,main_key_md5) VALUES (?,?,?,?,?)";
// end

require_once ("include/my_crypt.inc");
$my_crypt = new MyCrypt;
// generuj link do pliku/opcjonalnie, ustaw $this->data['url']
require_once ("./include/url.inc.php");

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $crypt_main_key=$my_crypt->endecrypt("",$this->data['main_key']);           // koduj kod do produktu
        
    $db->QuerySetText($prepared_query,1,$this->data['user_id_main']);
    $db->QuerySetText($prepared_query,2,$crypt_main_key);
    $db->QuerySetText($prepared_query,3,$this->data['order_id']);    
    $db->QuerySetText($prepared_query,4,@$this->data['url']);    
    $db->QuerySetText($prepared_query,5,@$this->data['main_key_md5']);    
    // end

    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {        
        // odczytaj numer id dodanego rekordu
        $query="SELECT max(id) FROM $table";
        $result_id=$db->Query($query);
        if ($result_id!=0) {
            $insert_info=$lang->main_keys_record_add;
            $num_rows=$db->NumberOfRows($result_id);
            if ($num_rows>0) {
                $var=$config->dbtype."_maxid";
                $this->id=$db->FetchResult($result_id,0,$config->$var);
            } else die ("Bledne dodanie rekordu");
        } else die ($db->Error());        
    } else die ($db->Error());
} else die ($db->Error());
?>
