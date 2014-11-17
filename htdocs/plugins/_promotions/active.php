<?php
/**
 * Lista promocji w sklepie                |
 * 
 * @author m@sote.pl
 * @version $Id: active.php,v 1.3 2005/01/20 15:00:35 maroslaw Exp $
* @package    promotions
 */
 
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];
include_once ("../../../include/head.inc");

if (! empty($_REQUEST['code'])) {
    $code=$_REQUEST['code'];   
} else {
    include_once ("./index.php");
    exit;   
}

// naglowek
$theme->head();
$theme->page_open_head("page_open_1_head");

$theme->bar($lang->promotions_title);

$data=$mdbd->select("id,name,discount,amount,code1,code2,code3,code4,code5,code6,code7,code8,code9,code10","promotions","active=1 AND id=?",array(@$_REQUEST['id']=>"text"),"ORDER BY name LIMIT 1","auto");

require_once ("include/promotions.inc");
$promotions = new Promotions;
if ($promotions->checkCode($data,$code)) {
    $promotions->authTrue($data);
} else {
    $promotions->authfalse($data);
}

$theme->page_open_foot("page_open_1_foot");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
