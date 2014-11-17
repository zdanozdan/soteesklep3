<?php
/**
 * PHP Template:
 * Lista rekordow tabeli discounts
 * 
 * @author m@sote.pl
 * \@template_version Id: index.php,v 1.3 2003/02/06 11:55:15 maroslaw Exp
 * @version $Id: index.php,v 2.11 2005/01/20 14:59:49 maroslaw Exp $
* @package    discounts
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php

require_once ("include/metabase.inc");

// sprawdz czy wybrano jakas grupe rabatowa z listy
if (ereg("^[0-9]+$",@$_REQUEST['discount_group'])) {
    $__discount_group=$_REQUEST['discount_group'];  
    if (! ereg("^[0-9]+$",$__discount_group)) die ("Forbidden discount_group");
    // zapisz wybrana grupe w sesji
    $sess->register("__discount_group",$__discount_group);
} elseif (! empty($_SESSION['__discount_group'])) {
    $__discount_group=$_SESSION['__discount_group'];
}
// end7

require_once ("./include/discounts.inc.php");
$discounts = new Discounts;

// wywolaj aktualizacje listy rekordow
if (! empty($_REQUEST['update'])) {
    include_once ("update_list.inc.php");
}


// config
$sql="SELECT * FROM discounts WHERE active=1 GROUP BY idc,idc_name,producer_name  ORDER BY idc_name ";
$bar=$lang->discounts_list_bar;

// dodaj submit pod lista rekordow
$__submit=true;   
$__row_type="all";  // przekaz typ prezentacji rekordu (same kategorie "catetegory", sami producenci "producer", jedno i drugie "all"
$__action="update_delete.php";
$__select_action="index.php";
require_once ("./include/list_th.inc.php");
$list_th=list_th();
// end

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/choose_group.inc.php");
require_once ("include/list.inc.php");

// zapisz wyswietlone pola formularza z rabatem
$sess->register("__mem_form",$__mem_form);  

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
