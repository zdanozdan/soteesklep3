<?php
/**
* Kojnfiguracja newsedit
*
* @author krzys@sote.pl
* @version $Id: configure.php,v 2.3 2005/01/20 14:59:56 maroslaw Exp $
*
*
* @package    newsedit
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head();

// lista grup newsow
include_once ("include/menu_top.inc.php");

//include_once ("../include/menu.inc.php");
include_once ("./include/menu.inc.php");
$theme->bar($lang->newsedir_conf_bar);

/**
* Obs³uga generowania pliku konfiguracyjnego u¿ytkownika.
*/
require_once("include/gen_user_config.inc.php");

if (! empty($_REQUEST['configure'])) {
    $configure=$_REQUEST['configure'];
}
// zapisz dane w pliku konfiguracyjnym usera
if (! empty($_REQUEST['update'])) {
    $ftp->connect();

    // config

    if (empty($configure['newsedit'])) $configure['newsedit']=0;
    else $configure['newsedit']=1;

    if (empty($configure['rss_link'])) $configure['rss_link']=0;
    else $configure['rss_link']=1;

    $gen_config->gen(array(
    "newsedit"=>$configure['newsedit'],
    "rss_link"=>$configure['rss_link'],
    "newsedit_columns_default"=>$configure['newsedit_columns_default'],
    )
    );
    $ftp->close();
    $config->newsedit=$configure['newsedit'];
    $config->rss_link=$configure['rss_link'];
    $config->newsedit_columns_default=$configure['newsedit_columns_default'];

    // end config
}

include_once ("./html/configure.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>