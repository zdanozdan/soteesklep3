<?php
/**
* Element formularza - "poka¿ n pierwszych pozycji"
*
* @author  lech@sote.pl
* @version $Id: input_amount.html.php,v 1.3 2004/12/20 17:59:01 maroslaw Exp $
* @package    report
*/

if((@$amount_data['amount'] == '') || (!is_numeric(@$amount_data['amount'])))
    $amount_data['amount'] = 100;

$amount_data['amount'] = round($amount_data['amount']);
?>
<input type=text name=amount_data[amount] value="<?php echo $amount_data['amount'];?>" class=date style="width: 80px; text-align: right;">
