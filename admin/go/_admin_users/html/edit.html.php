<?php
/**
* Formularz edycji rekordu, edycja danych u¿ytkwonika (administratora skelpu).
*
* @author m@sote.pl
* @version $Id: edit.html.php,v 2.6 2004/12/20 17:57:51 maroslaw Exp $
* @package    admin_users
*/

global $db;

/**
* Dodanie obs³ugi formularza.
*/
include_once ("include/forms.inc.php");
$forms = new Forms;

// odczytaj typy uzytkownikow wg id. z tabeli amdin_users_type
// return $__admin_users_type
include_once ("./include/admin_users_type.inc.php");

$forms->open($action,@$this->id);
$forms->text("login",@$rec->data["login"],$lang->admin_users_cols["login"],16);
//if (@$rec->data['id_admin_users_type']==1) {
//    $forms->password("password","",$lang->admin_users_cols["password"],16);
//} else {
$forms->hidden("password","");
//}


// start: w zaleznosci do rodzaju uzytkownika wyswietl odpowiendia liste typow uzytkownikow
if (@$rec->data['id_admin_users_type']==1) {
    $types[1]=$__admin_users_type[1];
}  else {
    // usun typ glownego admina z listy typow uzytkownikow
    $types=array();
    while (list($id,$type) = each($__admin_users_type)) {
        if ($id!=1) {
            $types[$id]=$type;
        }
    } // end while
}
// end

$forms->hidden("id",@$rec->data['id']);
$forms->password("new_password",@$rec->data["new_password"],$lang->admin_users_cols["new_password"],16);
$forms->password("new_password2",@$rec->data["new_password2"],$lang->admin_users_cols["new_password2"],16);
$forms->select("id_admin_users_type",@$rec->data['id_admin_users_type'],$lang->admin_users_cols["type"],$types,1);

if (! empty($rec->data['id'])) {
    // sprawdz czy nie jest to jedyny aktywny super admin
    global $mdbd;
    $ida=$mdbd->select("id","admin_users","id_admin_users_type=1 AND active=1 AND id!=?",
    array($rec->data['id']=>"int"),'LIMIT 1');
    if ($ida>0) {
        $forms->checkbox("active",@$rec->data['active'],$lang->admin_users_cols['active']);
    } else {
        // to jest ostatni super admin! nie zezwalaj na dezaktywancje tego konta
        $forms->hidden("active",1);
    }
} else {
    $forms->checkbox("active",@$rec->data['active'],$lang->admin_users_cols['active']);
}
$forms->button_submit("submit",$lang->edit_submit);
$forms->close();

?>
