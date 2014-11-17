<?php
/**
 * Edycja danych klienta.
 *
 * @author  m@sote.pl
 * @version $Id: edit.php,v 2.10 2005/12/27 10:02:32 lukasz Exp $
* @package    users
 */
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/ 
require_once ("../../../include/head.inc");
/**
* Dodaj obs³ugê kodowania.
*/
require_once ("include/my_crypt.inc");
/**
* Funkcje pomocnicze do Metabase.
*/
require_once ("include/metabase.inc");

$my_crypt = new MyCrypt;

if (! empty($_REQUEST['id'])) {
    $id=$_REQUEST['id'];
    $global_id_user=$id;
} else {
    die ("Bledne wywolanie");
}

// odczytaj klucz prywatny uzytkownika
require_once("./include/users_keys.inc.php");

// wywolano aktualizacje transakcji
if (@$_POST['update']==true) {
    require_once ("./include/users_update.inc.php");
}

$query="SELECT * FROM users WHERE id=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetInteger($prepared_query,1,$id);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) {
            // odczytaj wlasciowasi transakcji
            require_once("./include/query_rec.inc.php");            
        } else { 
            $theme->back();
            die ("Brak danych klienta");        
        }
    } else die ($db->Error());
} else die ($db->Error());

// odkoduj zakodowane dane
// dane bilingowe
$rec->data['login']=$my_crypt->endecrypt("",$rec->data['crypt_login'],"de");

$rec->data['name']=$my_crypt->endecrypt("",$rec->data['crypt_name'],"de");
$rec->data['surname']=$my_crypt->endecrypt("",$rec->data['crypt_surname'],"de");
$rec->data['email']=$my_crypt->endecrypt("",$rec->data['crypt_email'],"de");
$rec->data['firm']=$my_crypt->endecrypt($global_prv_key,$rec->data['crypt_firm'],"de");
$rec->data['street']=$my_crypt->endecrypt($global_prv_key,$rec->data['crypt_street'],"de");
$rec->data['street_n1']=$my_crypt->endecrypt($global_prv_key,$rec->data['crypt_street_n1'],"de");
$rec->data['street_n2']=$my_crypt->endecrypt($global_prv_key,$rec->data['crypt_street_n2'],"de");
$rec->data['postcode']=$my_crypt->endecrypt($global_prv_key,$rec->data['crypt_postcode'],"de");
$rec->data['city']=$my_crypt->endecrypt($global_prv_key,$rec->data['crypt_city'],"de");
$rec->data['country']=$my_crypt->endecrypt($global_prv_key,$rec->data['crypt_country'],"de");
$rec->data['phone']=$my_crypt->endecrypt($global_prv_key,$rec->data['crypt_phone'],"de");
$rec->data['nip']=$my_crypt->endecrypt($global_prv_key,$rec->data['crypt_nip'],"de");
$rec->data['user_description']=$my_crypt->endecrypt($global_prv_key,$rec->data['crypt_user_description'],"de");

// dane korepsondencyjne
$rec->data['cor_name']=$my_crypt->endecrypt($global_prv_key,$rec->data['crypt_cor_name'],"de");
$rec->data['cor_surname']=$my_crypt->endecrypt($global_prv_key,$rec->data['crypt_cor_surname'],"de");
$rec->data['cor_email']=$my_crypt->endecrypt($global_prv_key,$rec->data['crypt_cor_email'],"de");
$rec->data['cor_firm']=$my_crypt->endecrypt($global_prv_key,$rec->data['crypt_cor_firm'],"de");
$rec->data['cor_street']=$my_crypt->endecrypt($global_prv_key,$rec->data['crypt_cor_street'],"de");
$rec->data['cor_street_n1']=$my_crypt->endecrypt($global_prv_key,$rec->data['crypt_cor_street_n1'],"de");
$rec->data['cor_street_n2']=$my_crypt->endecrypt($global_prv_key,$rec->data['crypt_cor_street_n2'],"de");
$rec->data['cor_postcode']=$my_crypt->endecrypt($global_prv_key,$rec->data['crypt_cor_postcode'],"de");
$rec->data['cor_city']=$my_crypt->endecrypt($global_prv_key,$rec->data['crypt_cor_city'],"de");
$rec->data['cor_country']=$my_crypt->endecrypt($global_prv_key,$rec->data['crypt_cor_country'],"de");
$rec->data['cor_phone']=$my_crypt->endecrypt($global_prv_key,$rec->data['crypt_cor_phone'],"de");


// odczytaj laczna wartosc zakupow klienta
$query="SELECT sum(amount) FROM order_register WHERE id_users=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetInteger($prepared_query,1,$id);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $var_name=$config->dbtype."_sum_amount";
        $column=$config->$var_name;
        $rec->data['sum_amount']=$db->FetchResult($result,0,$column);
    } else die ($db->Error());
} else die ($db->Error());

if (empty($rec->data['sum_amount'])) {
    $rec->data['sum_amount']=0;
}

$theme->head_window();

// menu w edycji danych
include_once ("./include/menu_edit.inc.php");

$theme->bar($lang->bar_title["users_edit"]." : ".$rec->data['name']." ".$rec->data['surname']);
print @$global_update_status;
include_once ("./html/users_edit.html.php");

$theme->foot_window();
include_once ("include/foot.inc");
?>
