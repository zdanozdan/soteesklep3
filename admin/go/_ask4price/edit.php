<?php
/**
 * Zapytanie o cenê
 * 
 * @author lech@sote.pl
 * @version $Id: edit.php,v 1.1 2005/06/29 08:29:45 lechu Exp $
* @package    ask4price
* \@ask4price
 */
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
include_once ("../../../include/head.inc");
$theme->head_window();

$res = $mdbd->select("request_id,id_users,name_company,email,name,producer,prod_user_id,comments,answer", "ask4price", "request_id=?", array($_REQUEST['id'] => "int"), "ORDER BY prod_user_id", "array");

$user_data['id_users'] = $res[0]['id_users'];
$user_data['email'] = $res[0]['email'];
$user_data['name_company'] = $res[0]['name_company'];
$user_data['comments'] = $res[0]['comments'];
$user_data['answer'] = $res[0]['answer'];

if($res[0]['id_users'] != 0)
    $logged = $res[0]['id_users'];
else
    $logged = $lang->ask4price_not_logged;

$theme->bar($lang->ask4price_bar1);
echo "<br>";
echo "<b>" . $lang->ask4price_logged . "</b>: " . $logged . "<br>\n";
echo "<b>" . $lang->ask4price_name_company . "</b>: " . $user_data['name_company'] . "<br>\n";
echo "<b>" . $lang->ask4price_email . "</b>: " . $user_data['email'] . "<br>\n";
//echo "<b>" . $lang->ask4price_ . "</b>: " . $user_data[''] . "<br>\n";
?>
<br>
<center>
<table cellpadding="3" cellspacing="1" bgcolor="Black">
    <tr bgcolor="White">
        <td><b><?php echo $lang->ask4price_prod_user_id; ?></b></td>
        <td><b><?php echo $lang->ask4price_name; ?></b></td>
        <td><b><?php echo $lang->ask4price_producer; ?></b></td>
    </tr>
<?php

reset($res);

for ($i = 0; $i < count($res); $i++) {
?>
    <tr bgcolor="White">
        <td><?php echo $res[$i]['prod_user_id'] ;?></td>
        <td><?php echo $res[$i]['name'] ;?></td>
        <td><?php echo $res[$i]['producer'] ;?></td>
    </tr>
<?php    
}

?>
</table>
</center>

<?php
echo "<b>" . $lang->ask4price_comments . "</b>:<br>
<i>" . $user_data['comments'] . "</i><br>";
?>
<br>
<form action="/go/_ask4price/answer.php" method="POST">
<input type="hidden" name="email" value="<?php echo $user_data['email']; ?>">
<input type="hidden" name="request_id" value="<?php echo $_REQUEST['id']; ?>">
<center>

<table border="0" cellspacing="1" cellpadding="5">
    <tr>
        <td colspan="100%"><b><?php echo $lang->ask4price_answer ;?></b></td>
    </tr>
    <tr>
        <td><b><?php echo $lang->ask4price_to ;?>:</b></td>
        <td><?php echo $user_data['email']; ?></td>
    </tr>
    <tr>
        <td><b><?php echo $lang->ask4price_subject ;?>:</b></td>
        <td><input type="text" name="subject" style="width: 450px;"></td>
    </tr>
    <tr>
        <td colspan="100%"><b><?php echo $lang->ask4price_content ;?>:</b><br>
            <textarea name="content" style="width: 500px; height: 150px;"><?php echo $user_data['answer']; ?></textarea>
        </td>
    </tr>
    <tr>
        <td colspan="100%" align="right">
            <input type="submit" value="<?php echo $lang->ask4price_send; ?>">
        </td>
    </tr>
</table>

</center>
</form>

<?php
$theme->foot_window();


// stopka
include_once ("include/foot.inc");
?>