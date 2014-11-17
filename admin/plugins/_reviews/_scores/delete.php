<?php
/**
 * PHP Template:
 * Usun rekordy z tabeli reviews
 * 
 * @author m@sote.pl
 * @version $Id: delete.php,v 1.4 2006/05/04 12:53:50 lechu Exp $
* @package    reviews
* @subpackage scores
 */

// naglowek php
$global_database=true; $global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");
// end naglowek php


// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->scores_bar);
print "<p>";

$del_arr = @$_REQUEST['del'];
// usuñ oceny w main przy produktach
if(is_array($del_arr) && (count($del_arr) > 0)) {
    while (list($score_id, $val) = each($del_arr)) {
        if(!empty($val)) {
            $res = $mdbd->select("id_product", "scores", "id=?", array($score_id => "int"), '', "array");
            $prod_id = @$res[0]['id_product'];
            echo "[$prod_id]";
            if(!empty($prod_id)) {
                $mdbd->update("main", "user_score = NULL", "id=?", array($prod_id => "int"));
            }
        }
    }
}

// usun zaznaczone rekordy
require_once("include/delete.inc.php");
$delete = new Delete;
$delete->delete_all("scores","id");

$theme->page_open_foot();

$theme->foot();

// stopka php
include_once ("include/foot.inc");
// end stopka php
?>
