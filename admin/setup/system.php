<?php
/**
 * Formularz wyboru dancyh instalacji, rodzaj instalacji, system itp.
 *
 * @author m@sote.pl
 * @version $Id: system.php,v 2.6 2005/12/22 10:30:00 lukasz Exp $
 *
 * \@verified 2004-03-16 m@sote.pl
* @package    setup
 */

$global_database=false; // wylaczenie podwojnego sprawdzania autoryzacji
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../include/head.inc");
global $_ERROR;
require_once ("./include/test_php.inc.php");

// naglowek
include_once ("themes/base/base_theme/head_setup.html.php");

include ("./html/system.html.php");


// naglowek
include_once ("themes/base/base_theme/foot_setup.html.php");

// stopka
include_once ("include/foot.inc");
?>
