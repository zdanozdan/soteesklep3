<?php
/**
* Formularz - raport transakcji
*
* @author  lech@sote.pl
* @version $Id: q_transactions_form.html.php,v 1.5 2004/12/20 17:59:03 maroslaw Exp $
* @package    report
* @version $Id: q_transactions_form.html.php,v 1.5 2004/12/20 17:59:03 maroslaw Exp $
* @package report
*/
global $lang;

    $date_data          = @$this->form_data["date_data"];
    $amount_data        = @$this->form_data["amount_data"];
    $category_data      = @$this->form_data["category_data"];
    $producer_data      = @$this->form_data["producer_data"];
    $transaction_form   = @$this->form_data["transaction_form"];
    
    if (@$transaction_form['division'] == '')
        $transaction_form['division'] = 'd_1';
    if (@$transaction_form['values'] == '')
        $transaction_form['values'] = 1;
    $checked = array();
    $checked[$transaction_form['division']] = 'checked';
    $checked2 = array();
    $checked2[$transaction_form['values']] = 'checked';
?>
<script>
function SwitchDivs(divname)
{
    document.getElementById('d_1').style.display='none';
    document.getElementById('d_2').style.display='none';
    document.getElementById('d_3').style.display='none';
    document.getElementById(divname).style.display='inline';
}
</script>
<?php print $lang->report_transactions_head;?><br>
<table>
<form action="/go/_report/?report=q_transactions" method="POST">
<tr>
    <td nowrap>
        <input type="radio" name='transaction_form[division]' value=d_1 onclick='SwitchDivs("d_1")' <?php echo @$checked['d_1']; ?>>
        <?php print $lang->report_months;?>
    </td>
    <td>
        <div name='d_1' id='d_1'>
            <table>
                <tr>
                    <td align="right"><?php print $lang->report_from; ?>:</td>
                    <td><?php $no_day=1; if(@$date_data[0]['m'] == '') $date_data[0]['m'] = sprintf("%02d", date('m') - 1);
                    /**
                    * Element formularza
                    */
                    include("./html/input_date.html.php");?></td>
                    <td align="right"><?php print $lang->report_to; ?>:</td>
                    <td><?php
                    /**
                    * Element formularza
                    */
                    include("./html/input_date.html.php"); $no_day=0;?></td>
                </tr>
            </table>
        </div>
    </td>
</tr>
<tr>
    <td nowrap>
        <input type="radio" name='transaction_form[division]' value=d_2 onclick='SwitchDivs("d_2")' <?php echo @$checked['d_2']; ?>>
          <?php print $lang->report_days;?>
    </td>
    <td>
        <div name='d_2' id='d_2'>
            <table>
                <tr>
                    <td align="right"><?php print $lang->report_from; ?>:</td>
                    <td><?php if(@$date_data[2]['m'] == '') $date_data[2]['m'] = sprintf("%02d", date('m') - 1);
                    /**
                    * Element formularza
                    */
                    include("./html/input_date.html.php");?></td>
                    <td align="right"><?php print $lang->report_to; ?>:</td>
                    <td><?php
                    /**
                    * Element formularza
                    */
                    include("./html/input_date.html.php");?></td>
                </tr>
            </table>
        </div>
    </td>
</tr>
<tr>
    <td nowrap>
        <input type="radio" name='transaction_form[division]' value=d_3 onclick='SwitchDivs("d_3")' <?php echo @$checked['d_3']; ?>>
           <?php print $lang->report_hours;?>
    </td>
    <td>
        <div name='d_3' id='d_3'>
            <table>
                <tr>
                    <td align="right">&nbsp;</td>
                    <td><?php if(@$date_data[4]['m'] == '') $date_data[4]['m'] = sprintf("%02d", date('m') - 1);
                    /**
                    * Element formularza
                    */
                    include("./html/input_date.html.php");?></td>
                    <td align="right">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>
    </td>
</tr>
</table>
<?php print $lang->report_values; ?>:
<table>
<tr>
    <td nowrap>
        <input type="radio" name='transaction_form[values]' value=1  <?php echo @$checked2[1]; ?>>
       <?php print $lang->report_number; ?>
    </td>
</tr>
<tr>
    <td nowrap>
        <input type="radio" name='transaction_form[values]' value=2  <?php echo @$checked2[2]; ?>>
       <?php print $lang->report_values_sum; ?>
    </td>
</tr>
</table>
<table>
<tr>
    <td align="right" colspan="2"><input type=submit value="<?php print $lang->report_show;?>" class="date"></td>
</tr>
</form>
</table>
<script>
SwitchDivs('<?php echo $transaction_form['division']; ?>');
</script>
<?php
$this->form_data["date_data"]           = @$date_data;
$this->form_data["amount_data"]         = @$amount_data;
$this->form_data["category_data"]       = @$category_data;
$this->form_data["producer_data"]       = @$producer_data;
$this->form_data["transaction_form"]    = @$transaction_form;
?>
