<?php
/**
 * Lista promocji w sklepie                |
 * 
 * @author m@sote.pl
 * @version $Id: index.php,v 1.4 2005/01/20 15:00:35 maroslaw Exp $
* @package    promotions
 */
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];
include_once ("../../../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head("page_open_1_head");

$theme->bar($lang->promotions_title);

$data=$mdbd->select("id,name,short_description,photo","promotions","active=1 and lang=?",array($config->lang=>"text"),"ORDER BY name","array");

require_once ("include/promotions.inc");
$promotions = new Promotions;
$promotions->showList($data);

$theme->page_open_foot("page_open_1_foot");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
