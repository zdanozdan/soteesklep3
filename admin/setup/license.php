<?php
/**
* Wy¶wietl licencje sklepu
*
* @author m@sote.pl
* @version $Id: license.php,v 2.11 2005/04/12 09:59:58 maroslaw Exp $
*
* \@verified 2004-03-16 m@sote.pl
* @package    setup
*/

// naglowek
$global_database=false; // wylaczenie podwojnego sprawdzania autoryzacji
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../include/head.inc");

@include_once ("lang/_$global_lang/lang.inc.php");
@include_once ("./lang/_$global_lang/lang.inc.php");

// naglowek
include_once ("themes/base/base_theme/head_setup.html.php");

include_once ("./html/setup_frame.html.php");

if (! empty($_REQUEST['lang'])) {
    $global_lang=$_REQUEST['lang'];
    $sess->register("global_lang",$global_lang);
}

// naglowek
include_once ("themes/base/base_theme/foot_setup.html.php");

// stopka
include_once ("include/foot.inc");
?>