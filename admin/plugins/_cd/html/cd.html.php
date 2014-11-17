<?php
/**
* Obsluga modulu CD - wy¶wietlenie wybrania opcji aktywowanie generowania wersji CD
*
* @author  m@sote.pl
* @version $Id: cd.html.php,v 1.4 2004/12/20 17:59:29 maroslaw Exp $
* @package    cd
*/

$price_brutto_set=0;
$price_netto_set=0;
if ($config->cd_setup['price']=="netto") {
    $price_netto_set=1;
} else $price_brutto_set=1;


$theme->bar($lang->cd_title);
print "<center>\n<p>\n";
$form  = new HTML_Form("index.php","cdForm","POST");
$form->addHidden("update","true");
$form->addCheckBox("item[cd]",$lang->cd_active." (<b>".$_SERVER['REMOTE_ADDR']."</b>)",@$config->cd_setup['cd']);
$form->addRadio("item[price]",$lang->cd_price_type['brutto'],'brutto',$price_brutto_set);
$form->addRadio("item[price]",$lang->cd_price_type['netto'],'netto',$price_netto_set);
$form->addCheckBox("item[hurt]",$lang->cd_price_type['hurt'],@$config->cd_setup['hurt']);
$form->addSubmit("submit",$lang->update);
$form->display();

$theme->desktop_open("50%");
print $lang->cd_desc;
$theme->desktop_close();

print "</center>\n";
?>
