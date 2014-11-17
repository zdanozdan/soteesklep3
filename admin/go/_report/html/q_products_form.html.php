<?php
/**
* Formularz - raport produktów
*
* @author  lech@sote.pl
* @version $Id: q_products_form.html.php,v 1.5 2004/12/20 17:59:03 maroslaw Exp $
* @package    report
*/
global  $lang;

$date_data      = @$this->form_data["date_data"];
$amount_data    = @$this->form_data["amount_data"];
$category_data  = @$this->form_data["category_data"];
$producer_data  = @$this->form_data["producer_data"];

?>
<table>
<form action="/go/_report/?report=q_products" method="POST">
<tr>
    <td align="right"><?php print $lang->report_from; ?>:</td>
    <td><?php
            if($date_data[0]['m'] == '')
                $date_data[0]['m'] = sprintf("%02d", date('m') - 1);
            /**
            * Element formularza
            */
            include("./html/input_date.html.php");
        ?></td>
    <td align="right"><?php print $lang->report_to; ?>:</td>
    <td><?php
            /**
            * Element formularza
            */
            include("./html/input_date.html.php");?></td>
</tr>
<tr>
    <td align="right"><?php print $lang->report_producer; ?>:</td>
    <td><?php
            /**
            * Element formularza
            */
            include("./html/input_producer.html.php");?></td>
    <td align="right"><?php print $lang->report_category; ?>:</td>
    <td><?php
            /**
            * Element formularza
            */
            include("./html/input_category.html.php");?></td>
</tr>
<tr>
    <td align="right"><?php print $lang->report_show;?></td>
    <td><?php
            /**
            * Element formularza
            */
            include("./html/input_amount.html.php");?><?php print $lang->report_first;?></td>
    <td align="right" colspan="2"><input type=submit value="<?php print $lang->report_show;?>" class="date"></td>
</tr>
</form>
</table>
<?php
$this->form_data["date_data"]       = @$date_data;
$this->form_data["amount_data"]     = @$amount_data;
$this->form_data["category_data"]   = @$category_data;
$this->form_data["producer_data"]   = @$producer_data;

?>
