<?php
/**
* Edycja danych adresu e-mail.
*
* @author m@sote.pl
* @version $Id: edit.php,v 2.9 2005/01/20 15:00:00 maroslaw Exp $
*
* verified 2004-03-09 m@sote.pl
* @package    newsletter
* @subpackage users
*/

$global_database=true;
$global_secure_test=true;
/**
* Naglowek skryptu.
*/
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");
require_once ("include/metabase.inc");

// zaznaczenie, ktore grupy zostaly wybrane dla danego adresu e-mail
if (! empty($_REQUEST['groups'])) {
    $groups=$_REQUEST['groups'];
    $str=":";
    foreach($groups as $value){
        $str.=$value.":";
    }
    $_POST['item']['groups']=$str;
}

$theme->head_window();

$theme->bar($lang->newsletter_users_bar);
$table=$database->sql_select_data_array("user_id","name","newsletter_groups","");

require_once("include/mod_table.inc.php");
$mod_table = new ModTable;
$mod_table->update("newsletter","newsletter",array("email"=>"alias1"),
$lang->newsletter_form_errors
);

$theme->foot_window();

include_once ("include/foot.inc");
?>
