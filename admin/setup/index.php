<?php
/**
 * Program instalacyjny sklepu. G³ówne wywo³ania instalacji
 *
 * @author m@sote.pl
 * @version $Id: index.php,v 2.8 2005/02/01 15:04:43 maroslaw Exp $
 *
 * \@verified 2004-03-16 m@sote.pl
* @package    setup
 */
 
// naglowek
$global_database=false; // wylaczenie podwojnego sprawdzania autoryzacji
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../include/head.inc");

// naglowek
include_once ("themes/base/base_theme/head_setup.html.php");

// zapisz typ instalacji jesli jest przekazany jako parametr np. dla rebuild
if (! empty($_REQUEST['type'])) {
    $__type=$_REQUEST['type'];
    $sess->register("__type",$__type);
}

include_once ("./html/start.html.php");

// naglowek
include_once ("themes/base/base_theme/foot_setup.html.php");

// stopka
include_once ("include/foot.inc");
?>
