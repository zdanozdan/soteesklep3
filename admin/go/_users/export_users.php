<?php
/**
* Lista wszystkich klientów w sklepie. Eksport do CSV
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];


require_once ("../../../include/head.inc");

/**
* Dodaj obs³uê kodowania.
*/
require_once ("include/my_crypt.inc");
$my_crypt =& new MyCrypt;
$my_crypt->gen_keys();

class RecordRow {
    
    /**
    * Odczytanie danych klienta oraz wywo³anie wy¶wietlenia wiersza na li¶cie.
    *
    * @param mixed $result wynik zapytania z bazy danych
    * @param int   $i      numer wiersza w zapytaniu SQL
    * @return none
    */
    function record($result,$i) {
        global $db;
        global $theme;
        global $rec;
        global $my_crypt;
        
        $rec->data['id']=$db->FetchResult($result,$i,"id");
        
        $crypt_login=$db->FetchResult($result,$i,"crypt_login");
        $crypt_name=$db->FetchResult($result,$i,"crypt_name");
        $crypt_surname=$db->FetchResult($result,$i,"crypt_surname");
        $crypt_email=$db->FetchResult($result,$i,"crypt_email");
        
        $decrypt_login=$my_crypt->endecrypt($my_crypt->pub_key,$crypt_login,"de");
        $decrypt_name=$my_crypt->endecrypt($my_crypt->pub_key,$crypt_name,"de");
        $decrypt_surname=$my_crypt->endecrypt($my_crypt->pub_key,$crypt_surname,"de");
        $decrypt_email=$my_crypt->endecrypt($my_crypt->pub_key,$crypt_email,"de");
        
        $rec->data['login']=&$decrypt_login;
        $rec->data['name']=&$decrypt_name;
        $rec->data['surname']=&$decrypt_surname;
        $rec->data['email']=&$decrypt_email;
        $rec->data['date_add']=$db->FetchResult($result,$i,"date_add");
        $rec->data['sales']=$db->FetchResult($result,$i,"sales");
        
        
        /**
        * Wy¶wietl wiersz z danymi u¿ytkwonika imiê, nazwisko, email.
        */
	if (strlen($rec->data['email'])) {
	print $rec->data['name']; print ' ';
	print $rec->data['surname']; print', ';
	print $rec->data['email'];
	print '</br>';
	}
        
        return;
    } // end record()
    
} // end class UsersRecordRow
?>

<?php

require_once ("lib/DBEdit-Metabase/DBEdit.inc");

class EmailsDbEdit extends DBEdit {

    function record_list($sql, $order_array = array()) {
        if (! empty($sql)) { $this->sql=$sql; }

	$this->_init_db();
        $this->get_table_from_sql($sql);            // odczytaj nazwe tabeli z zapytania SQL

	 $this->_init_record_row_obj();
        // odczytaj adres obiektu
        $record=$this->record_obj;

	// przygotuj zapytanie $this->sql do wykonania
        $prepared_query=$this->db->PrepareQuery($this->sql);
	if ($prepared_query) {
            // wykonaj zapytanie do bazy
            $result=$this->db->ExecuteQuery($prepared_query);
            $this->num_rows=$this->db->NumberOfRows($result);

	     for ($i=0; $i<$this->num_rows; $i++) {
                    if ($i==($this->num_rows-1)) $this->last_record_on_page=1;
                    $this->_record_row($result,$i);
             }
	}
    }
}


$dbedit = new EmailsDbEdit;
$dbedit->dbtype="mysql";
$dbedit->record_list("SELECT * FROM users WHERE order_data!=1 AND record_version='30' ORDER BY id DESC"); 

?>
