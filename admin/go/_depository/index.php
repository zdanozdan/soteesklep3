<?php
/**
 * Magazyn
 * 
 * @author lech@sote.pl
 * @version $Id: index.php,v 1.2 2006/03/01 08:31:56 lechu Exp $
 * @package    depository
 */


$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
include_once ("../../../include/head.inc");


// config
$sql="
SELECT
    d.id AS id,
    d.user_id_main AS user_id_main,
    m.id AS id_main,
    m.name_L" . $config->lang_id . " AS name_main,
    d.num AS num,
    d.min_num AS min_num,
    (d.num - d.min_num) AS diff,
    d.id_deliverer AS id_deliverer
FROM depository d, main m
    WHERE
    d.user_id_main = m.user_id
ORDER BY id";
$bar=$lang->depository_list_bar;
require_once ("./include/list_th.inc.php");


$res_deliveres = $mdbd->select("id,name", "deliverers", "1=1", array(), '', 'array');
$deliverers = array();

if(!empty($res_deliveres) && (is_array($res_deliveres))) {
    for ($i = 0; $i < count($res_deliveres); $i++) {
        $deliverers[$res_deliveres[$i]['id']] = $res_deliveres[$i]['name'];
    }
}
$__dump_all = true;
$list_th=list_th();
// end

// naglowek
$theme->head();
$theme->page_open_head();

require_once ("include/list.inc.php");
   
$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
