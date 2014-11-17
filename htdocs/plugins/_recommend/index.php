<?php
/**
 * Poleæ produkt znajomemu
 *
 * @author piotrek@sote.pl
 * @version $Id: index.php,v 1.5 2005/10/20 06:43:00 krzys Exp $
* @package    recommend
 */
$global_database=false;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

$theme->theme_file("plugins/_recommend/recommend_form.html.php");
include_once ("include/foot.inc");
?>
