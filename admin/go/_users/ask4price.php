<?php
/**
 * Edycja danych klienta.
 *
 * @author  m@sote.pl lech@sote.pl
 * @version $Id: ask4price.php,v 1.2 2005/06/30 12:26:11 lechu Exp $
* @package    users
* \@ask4price
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

// wywolano aktualizacje ponktow
if (! empty($_POST['update_points'])) {
    require_once("include/update_user_points.inc.php");
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

$user_query = '';
if (!empty($_REQUEST['id'])) {
    $user_id = $_REQUEST['id'];
    $user_query = " AND id_users=$user_id";
}

global $mdbd;
$res = $mdbd->select("request_id,id_users,name_company,email,MIN(date_add),active", "ask4price", "1=1$user_query", array(), "GROUP BY request_id ORDER BY request_id DESC", "array");


$theme->bar($lang->ask4price_bar." : ".$rec->data['name']." ".$rec->data['surname']);

?>
<br>
<center>
<table cellpadding="3" cellspacing="1" bgcolor="Black">
    <tr bgcolor="White">
        <td><b><?php echo $lang->ask4price_request_id; ?></b></td>
        <td><b><?php echo $lang->ask4price_name_company; ?></b></td>
        <td><b><?php echo $lang->ask4price_email; ?></b></td>
        <td><b><?php echo $lang->ask4price_logged; ?></b></td>
        <td><b><?php echo $lang->ask4price_date_add; ?></b></td>
        <td><b><?php echo $lang->ask4price_sent; ?></b></td>
        <td><b><?php echo $lang->ask4price_edit; ?></b></td>
        <td><b><?php echo $lang->ask4price_delete; ?></b></td>
    </tr>
<?php

reset($res);
for ($i = 0; $i < count($res); $i++) {
    if(!empty($res[$i]['request_id'])) {
        if($res[$i]['id_users'] != 0)
            $logged = $res[$i]['id_users'];
        else
            $logged = $lang->ask4price_not_logged;
            
        if($res[$i]['active'] == 1)
            $sent = "<span style='color: red;'>" . $lang->no . "</span>";
        else
            $sent = $lang->yes;
    ?>
    <tr bgcolor="White">
        <td><?php echo $res[$i]['request_id'] ;?></td>
        <td><?php echo $res[$i]['name_company'] ;?></td>
        <td><?php echo $res[$i]['email'] ;?></td>
        <td><?php echo $logged ;?></td>
        <td><?php echo $res[$i]['MIN(date_add)'] ;?></td>
        <td><?php echo $sent ;?></td>
        <td><a href="/go/_ask4price/edit.php?id=<?php echo $res[$i]['request_id'] ;?>" onclick="window.open('', 'window3', 'width=700, height=550, status=0, toolbar=0, resizable=1, scrollbars=1')" target="window3"><?php echo $lang->ask4price_edit ;?></a></td>
        <td><a href="/go/_ask4price/delete2.php?id=<?php echo $res[$i]['request_id'] ;?>" onclick="window.open('', 'window3', 'width=300, height=200, status=0, toolbar=0, resizable=1, scrollbars=1')" target="window3"><?php echo $lang->ask4price_delete ;?></a></td>
    </tr>
<?php
    }
}

?>
</table>
</center>

<?php
$theme->foot_window();
include_once ("include/foot.inc");
?>
