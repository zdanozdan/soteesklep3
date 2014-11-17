<?php
/**
* Zapisanie w pliku user_config.inc.php konfiguracji dot. domy¶lnego jêzyka w panelu.
* 
* @author  m@sote.pl
* @version $Id: lang.php,v 1.3 2005/04/18 09:11:51 lechu Exp $
* @package configure
*/
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../include/head.inc");
if ($config->nccp!="0x1388"){
    $theme->go2main("/");
}

/**
* Obs³uga generowania pliku konfiguracyjnego u¿ytkownika.
*/
require_once("include/gen_user_config.inc.php");

if (! empty($_REQUEST['configure'])) {
    $configure=$_REQUEST['configure'];
} 

// naglowek
$theme->head();
$theme->page_open_head();

$ftp->connect();
$gen_config->gen(array("admin_lang"=>$configure['admin_lang']));
$ftp->close();

$config->admin_lang=$configure['admin_lang'];

include_once ("./html/lang.html.php");
$theme->go2main("/index.php",2);

$theme->page_open_foot();

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>