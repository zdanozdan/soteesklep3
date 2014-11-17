<?php
/**
 * PHP Template:
 * Lista rekordow tabeli discounts - kategorie
 * 
 * @author m@sote.pl
 * \@template_version Id: index.php,v 1.3 2003/02/06 11:55:15 maroslaw Exp
 * @version $Id: producers.php,v 2.8 2005/01/20 14:59:50 maroslaw Exp $
* @package    discounts
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php

require_once ("include/metabase.inc");

// config
$sql="SELECT * FROM discounts WHERE producer_name!='' GROUP BY producer_name, id_producer ORDER BY producer_name";

$bar=$lang->discounts_list_bar;
$__row_type="producer";
$__submit=true;
$__action="update_delete.php";
require_once ("./include/list_th.inc.php");


$list_th=list_th();


// naglowek
$theme->head();
$theme->page_open_head();

$__select_action="producers.php";
include_once ("./include/choose_group.inc.php");
require_once ("include/list.inc.php");

// zapisz wyswietlone pola formularza z rabatem
$sess->register("__mem_form",$__mem_form);   

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
