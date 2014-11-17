<?php
/** 
 * Copyright (c) 1999-2004 SOTE www.sote.pl                             
 *
 * SOTEeSKLEP - program do prowadzenia sklepu internetowego. 
 * Program objety jest licencja SOTE.                                           
 *
 * Niniejszy plik odpowiada wywolaniu glownej strony sklepu.            
 *
 *
 * @author  m@sote.pl
 * @version $Id: index.php,v 1.1 2007/11/29 14:11:51 tomasz Exp $
 * @package    default
 */

$global_database=true;

require_once ("../../../include/head.inc");

// naglowek
$theme->head();

include("./include/error.inc.php");

$error = new ErrorMessage;
//$error->show();
$theme->page_open_object("show",$error,"page_open");

// stopka
$theme->foot();
include_once ("include/foot.inc");

?>