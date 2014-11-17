<?php
/**
 * Lista promocji w sklepie                |
 * 
 * @author m@sote.pl
 * @version $Id: info.php,v 1.3 2005/01/20 15:00:35 maroslaw Exp $
* @package    promotions
 */
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];
include_once ("../../../include/head.inc");

if ((empty($_REQUEST['id'])) || (! ereg("^[0-9]+$",$_REQUEST['id']))) {
    include_once ("./index.php");
    exit;
}

$data=$mdbd->select("id,name,description,photo","promotions","active=1 AND id=?",array(@$_REQUEST['id']=>"text"),"ORDER BY name LIMIT 1","auto");

if (empty($data['id'])) {
    include_once ("./index.php");
    exit;
}

// naglowek
$theme->head();
$theme->page_open_head("page_open_1_head");

$theme->bar($lang->promotions_title);

require_once ("include/promotions.inc");
$promotions = new Promotions;
$promotions->info($data);

$theme->page_open_foot("page_open_1_foot");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
