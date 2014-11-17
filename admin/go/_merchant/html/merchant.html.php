<?php
/**
 * Wyswietlenie zmiany danych sprzedawcy
 *
 * @author  m@sote.pl
 * @version $Id: merchant.html.php,v 1.13 2004/12/27 14:24:53 krzys Exp $
* @package    merchant
 */

$forms = new Forms;
$theme->bar($lang->merchant_title,"100%");print "<BR>";
$theme->desktop_open("100%");

if ($config->demo=="yes") {
    $config->license['nr']="0000-0000-0000-0000-0000-0000";
}

print "<table border=0 align=\"left\" width=100%><tr><td>";
print "<table border=0 align=\"left\"><tr><td>";
$forms->open("license.php",'',"LicenseForm");
$forms->item=0;                      // nie dodawaj "item" do nazwy pola formularza, zostaw 'nazwa' zamiast 'item[nazwa]' 
$forms->hidden("update",true);
$forms->text("license[nr]",$config->license['nr'],$lang->merchant_license_nr,32);
$forms->text("license[who]",$config->license['who'],$lang->merchant_license_who,32);
$forms->button_submit("","$lang->change"); 
$forms->close();
print "</td></tr></table>";
print "</td></tr><tr><td>";
print "<table border=0 align=\"center\"><tr><td>";
$forms->open("index.php");
$forms->item=0;                      // nie dodawaj "item" do nazwy pola formularza, zostaw 'nazwa' zamiast 'item[nazwa]' 
$forms->hidden("update",true);
$forms->text("www",@$config->www,$lang->merchant['www'],30);
$forms->text("merchant[name]",@$config->merchant['name'],$lang->merchant['name'],30);
$forms->text("merchant[addr]",@$config->merchant['addr'],$lang->merchant['addr'],50);
$forms->text("merchant[tel]", @$config->merchant['tel'],$lang->merchant['tel'],30);
$forms->text("merchant[fax]", @$config->merchant['fax'],$lang->merchant['fax'],30);
$forms->text("merchant[nip]", @$config->merchant['nip'],$lang->merchant['nip'],16);
$forms->text("merchant[bank]", @$config->merchant['bank'],$lang->merchant['bank'],50);
$forms->text("order_email",@$config->order_email,$lang->merchant['order_email'],30);
$forms->text("from_email",@$config->from_email,$lang->merchant['from_email'],30);
if (in_array ("newsletter", $config->plugins)) {
    $newsletter_info=$lang->merchant['newsletter'];
    print "<tr><td align=right>";
    print $lang->merchant['newsletter_email'];
    print "</td><td>";
    print "<a href=/plugins/_newsletter/_users/config.php>$newsletter_info</a>";
    print "</td></tr>";
}

//$forms->text("newsletter_email",@$config->newsletter_email,$lang->merchant['newsletter_email'],30);
$forms->button_submit("",$lang->merchant_update);
$forms->close();
print "</td></tr></table><br>";
print "</td></tr></table>";
$theme->desktop_close();
?>
