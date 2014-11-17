<?php
/**
 * Lista rekordow tabeli edit_category
 * 
 * @author  m@sote.pl
 * \@template_version Id: index.php,v 2.2 2003/06/14 21:59:37 maroslaw Exp
 * @version $Id: category2.php,v 1.3 2005/01/20 14:59:22 maroslaw Exp $
* @package    edit_category
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php

if (ereg("^[0-9]+$",@$_REQUEST['deep'])) {
    $deep=$_REQUEST['deep'];
} else $deep=1;
$__deep=&$deep;

$WHERE="";
if (($deep>1) && (! empty($_REQUEST['idc']))) {
    // dodaj WHERE
    // TODO
}

$deep=addslashes($deep);

// config
$sql="SELECT * FROM category$deep $WHERE ORDER BY id";
$bar=$lang->edit_category_list_bar;
require_once ("./include/list_th.inc.php");
$list_th=list_th();
// end

// naglowek
$theme->head();
$theme->page_open_head();

require_once ("include/list.inc.php");

include_once ("./html/info.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
