<?php
/**
 * Lista zapytañ o cenê
 * 
 * @author lech@sote.pl
 * @version $Id: index.php,v 1.2 2005/06/30 12:24:17 lechu Exp $
* @package    ask4price
* \@ask4price
 */
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
include_once ("../../../include/head.inc");
/*
$user_query = '';
if (!empty($_REQUEST['id'])) {
    $user_id = $_REQUEST['id'];
    $user_query = " AND id_users=$user_id";
}
*/

$sql="SELECT request_id, id_users, name_company, email, MIN(date_add), active FROM ask4price WHERE 1=1 GROUP BY request_id ORDER BY request_id DESC";

$bar=$lang->ask4price_bar;
require_once ("./include/list_th.inc.php");
$list_th=list_th();

// naglowek

// zaznacz wszystkie produkty
/*
global $mdbd;
$res = $mdbd->select("request_id,id_users,name_company,email,MIN(date_add),active", "ask4price", "1=1$user_query", array(), "GROUP BY request_id ORDER BY request_id DESC", "array");
*/

$theme->head();
$theme->page_open_head();

require_once ("include/list.inc.php");
/*
$theme->bar($lang->ask4price_bar);
?>
<br>
<center>
<table cellpadding="3" cellspacing="1" bgcolor="Black">
    <tr bgcolor="White">
        <td><b><?php echo $lang->ask4price_request_id; ?></b></td>
        <td><b><?php echo $lang->ask4price_name_company; ?></b></td>
        <td><b><?php echo $lang->ask4price_email; ?></b></td>
        <td><b><?php echo $lang->ask4price_logged; ?></b></td>
        <td><b><?php echo $lang->ask4price_date_add; ?></b></td>
        <td><b><?php echo $lang->ask4price_sent; ?></b></td>
        <td><b><?php echo $lang->ask4price_edit; ?></b></td>
        <td><b><?php echo $lang->ask4price_delete; ?></b></td>
    </tr>
<?php

reset($res);

for ($i = 0; $i < count($res); $i++) {
    if(!empty($res[$i]['request_id'])) {
    
        if($res[$i]['id_users'] != 0)
            $logged = $res[$i]['id_users'];
        else
            $logged = $lang->ask4price_not_logged;
            
        if($res[$i]['active'] == 1)
            $sent = "<span style='color: red;'>" . $lang->no . "</span>";
        else
            $sent = $lang->yes;
    ?>
    <tr bgcolor="White">
        <td><?php echo $res[$i]['request_id'] ;?></td>
        <td><?php echo $res[$i]['name_company'] ;?></td>
        <td><?php echo $res[$i]['email'] ;?></td>
        <td><?php echo $logged ;?></td>
        <td><?php echo $res[$i]['MIN(date_add)'] ;?></td>
        <td><?php echo $sent ;?></td>
        <td><a href="/go/_ask4price/edit.php?id=<?php echo $res[$i]['request_id'] ;?>" onclick="window.open('', 'window3', 'width=700, height=550, status=0, toolbar=0, resizable=1, scrollbars=1')" target="window3"><?php echo $lang->ask4price_edit ;?></a></td>
        <td><a href="/go/_ask4price/delete.php?id=<?php echo $res[$i]['request_id'] ;?>" onclick="window.open('', 'window3', 'width=300, height=200, status=0, toolbar=0, resizable=1, scrollbars=1')" target="window3"><?php echo $lang->ask4price_delete ;?></a></td>
    </tr>
    <?php
    }
}

?>
</table>
</center>
<?php
*/
$theme->page_open_foot();

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
