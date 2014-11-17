<?php
/**
* @version    $Id: orders_filter.html.php,v 1.1 2006/09/27 21:53:21 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/

global $config, $order_count, $total_sum, $rake_sum, $lang, $_REQUEST;
$form = @$_REQUEST['form'];
?>
<br>
<?php
echo $lang->users_partners['order_count'] . ": <b>" . $order_count . "</b>&nbsp;&nbsp;&nbsp;";
echo $lang->users_partners['total_sum'] . ": <b>" . $total_sum . "</b>&nbsp;&nbsp;&nbsp;";
echo $lang->users_partners['rake_sum'] . ": <b>" . $rake_sum . "</b>&nbsp;&nbsp;&nbsp;";


?>
<BR>
<br>
<form action="/go/_users/orders.php" method="POST">
    <b><?php echo $lang->users_partners['from']; ?></b> <?php echo $lang->users_partners['format']; ?>:
    <select name="form[dd_from]">
    <?php
    for ($i = 1; $i <= 31; $i++) {
        $v = $i;
        if(strlen($v) == 1)
            $v = '0' . $v;
        $selected = '';
        if ($v == @$form['dd_from'])
            $selected = 'selected';
        echo "
        <option value=$v $selected>$v</option>
        ";
    }
    ?>
    </select>
    -
    <select name="form[mm_from]">
    <?php
    for ($i = 1; $i <= 12; $i++) {
        $v = $i;
        if(strlen($v) == 1)
            $v = '0' . $v;
        $selected = '';
        if ($v == @$form['mm_from'])
            $selected = 'selected';
        echo "
        <option value=$v $selected>$v</option>
        ";
    }
    ?>
    </select>
    -
    <select name="form[yyyy_from]">
    <?php
    $y = date('Y');
    if(empty($form['yyyy_from']))
        $form['yyyy_from'] = 2006;
    for ($i = $y - 10; $i <= $y; $i++) {
        $v = $i;
        $selected = '';
        if ($v == @$form['yyyy_from'])
            $selected = 'selected';
        echo "
        <option value=$v $selected>$v</option>
        ";
    }
    ?>
    </select>
    &nbsp;&nbsp;&nbsp;
    <b><?php echo $lang->users_partners['to']; ?></b> <?php echo $lang->users_partners['format']; ?>:
    <select name="form[dd_to]">
    <?php
    $d = date('d');
    if(empty($form['dd_to']))
        $form['dd_to'] = $d;
    for ($i = 1; $i <= 31; $i++) {
        $v = $i;
        if(strlen($v) == 1)
            $v = '0' . $v;
        $selected = '';
        if ($v == @$form['dd_to'])
            $selected = 'selected';
        echo "
        <option value=$v $selected>$v</option>
        ";
    }
    ?>
    </select>
    -
    <select name="form[mm_to]">
    <?php
    $m = date('m');
    if(empty($form['mm_to']))
        $form['mm_to'] = $m;
    for ($i = 1; $i <= 12; $i++) {
        $v = $i;
        if(strlen($v) == 1)
            $v = '0' . $v;
        $selected = '';
        if ($v == @$form['mm_to'])
            $selected = 'selected';
        echo "
        <option value=$v $selected>$v</option>
        ";
    }
    ?>
    </select>
    -
    <select name="form[yyyy_to]">
    <?php
    $y = date('Y');
    if(empty($form['yyyy_to']))
        $form['yyyy_to'] = 2006;
    for ($i = $y - 10; $i <= $y; $i++) {
        $v = $i;
        $selected = '';
        if ($v == @$form['yyyy_to'])
            $selected = 'selected';
        echo "
        <option value=$v $selected>$v</option>
        ";
    }
    ?>
    </select>
    &nbsp;
    <input type="submit" value="<?php echo $lang->users_partners['confirm']; ?>">
</form>