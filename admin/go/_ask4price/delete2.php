<?php
/**
 * Zapytanie o cenê
 * 
 * @author lech@sote.pl
 * @version $Id: delete2.php,v 1.1 2005/06/30 12:24:17 lechu Exp $
* @package    ask4price
* \@ask4price
 */
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
include_once ("../../../include/head.inc");

if($_REQUEST['confirm'] == 1) {
    $res = $mdbd->delete("ask4price", "request_id=?", array($_REQUEST['request_id'] => "int"));
    $theme->head_window();
    ?>
    <script>
        window.opener.history.go(0);
        window.close();
    </script>
    <?php
}
else {

    $theme->head_window();
    
    ?>
    <form action="/go/_ask4price/delete2.php" method="POST">
    <input type="hidden" name="request_id" value="<?php echo $_REQUEST['id']; ?>">
    <input type="hidden" name="confirm" value="1">
    <center>
    <table width="100%" height="100%">
        <tr>
            <td width="100%" height="100%" align="center" valign="middle">
                <?php echo $lang->ask4price_delete_confirm; ?><br><br>
                <button type="button" onclick="window.close()"><?php echo $lang->no; ?></button>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <button type="button" onclick="this.form.submit()"><?php echo $lang->yes; ?></button>
            </td>
        </tr>
    </table>
    </center>
    </form>
    <?php
    
    $theme->foot_window();
}

// stopka
include_once ("include/foot.inc");
?>