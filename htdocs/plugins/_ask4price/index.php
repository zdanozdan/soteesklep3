<?php
/**
 * Zapytaj o cenê
 *
 * @author lech@sote.pl
 * @version $Id: index.php,v 1.1 2005/06/29 08:37:41 lechu Exp $
* @package    ask4price
* \@ask4price
 */



$global_database=false;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
$ask4price_list = @$_SESSION['ask4price_list'];

// dodaj produkt do listy
if($_REQUEST['action'] == 'add') {
    $elem['id'] = $_REQUEST['id'];
    $elem['name'] = $_REQUEST['name'];
    $elem['producer'] = $_REQUEST['producer'];

    if (is_array($ask4price_list))
       reset($ask4price_list);
    $found = false;
    while((!$found) && (list($key, $val) = each($ask4price_list))) {
       if($val['id'] == $elem['id']) {
          $found = true;
        }     
    }
    if(!$found) {
        $ask4price_list[] = $elem;
        $sess->register('ask4price_list', $ask4price_list);
    }
}

// usuñ produkt z listy
if($_REQUEST['action'] == 'delete') {
    $del_id = $_REQUEST['id'];
    reset($ask4price_list);
    $removed = false;
    while((!$removed) && (list($key, $val) = each($ask4price_list))) {
        if($val['id'] == $del_id) {
            unset($ask4price_list[$key]);
            $sess->unregister('ask4price_list');
            $sess->register('ask4price_list', $ask4price_list);
            $removed = true;
            
        }
    }
}


$theme->theme_file("plugins/_ask4price/window.html.php");

include_once ("include/foot.inc");
?>
