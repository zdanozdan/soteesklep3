<?php
/**
* Centrum konfiguracyjne - zbior wszystkich konfiuracji ze sklepu
*
* @author  krzys@sote.pl
* @version $Id: configure.html.php,v 1.24 2006/04/06 11:06:37 krzys Exp $
* @package configure
*/

global $config; 
$theme->bar($lang->configure_title,"100%");
print "<br>";
$theme->desktop_open("100%");
?>
<table border="0" cellpadding="2" cellspacing="2">
    <tr>
        <td width="100%">
            <?php print $lang->welcome_text;?><br /><br />
        <td>
    </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
    
    <tr align="left">    
        <td width=30%>
            <a href="/go/_configure/index.php"><u><?php print $lang->configuration; ?></u></a><br>
            <!-- <a href="/go/_configure/domains.php"><u><?php print $lang->configuration_domains;?></u></a></br /> -->
            <a href="/go/_configure/catalog_conf.php"><u><?php print $lang->catalog_conf; ?></u></a><br>
            <a href="/go/_points/configure.php"><u><?php print $lang->configuration_points; ?></u></a>
        </td>
       
        <td width=30%  valign="top"> 
            <b><?php print $lang->conf_title_modules;?></b><br><br>
            <?php if ($config->nccp=="0x1388"){ ?><a href="/plugins/_dictionary/configure.php"><u><?php print $lang->configuration_language; ?></u></a><br><?php }; ?>
            <a href="/plugins/_newsletter/_users/config.php"><u><?php print $lang->configuration_newsletter; ?></u></a><br>
            <a href="/plugins/_newsedit/configure.php"><u><?php print $lang->configuration_newsedit; ?></u></a><br>
            <a href="/go/_options/_delivery/config.php"><u><?php print $lang->configuration_country; ?></u></a><br>
            <a href="/go/_search/configure.php"><u><?php print $lang->configuration_search; ?></u></a><br>
        </td>
   
        <td width=30%  valign="top">
        <?php if ($config->nccp=="0x1388" && $config->admin_lang=='pl'){ ?>
            <b><?php print $lang->conf_title_partners;?></b><br><br>
            <a href="/plugins/_pasaz.onet.pl/config.php"><u><?php print $lang->configuration_onet; ?></u></a><br>
            <a href="/plugins/_pasaz.wp.pl/config.php"><u><?php print $lang->configuration_wp; ?></u></a><br>
            <a href="/plugins/_pasaz.interia.pl/config.php"><u><?php print $lang->configuration_interia; ?></u></a><br>
            <a href="/plugins/_ceneo.pl/config.php"><u><?php print $lang->configuration_ceneo; ?></u></a><br>
            <a href="/plugins/_allegro/config.php"><u><?php print $lang->configuration_allegro; ?></u></a>
        <?php }; ?>
        </td>
   </tr>
   <tr>
        <td colspan="3"><br></td>
   </tr>
   <tr>
        <td width="30%" valign="top">
        <?php if ($config->nccp=="0x1388"){ ?>
            <b><?php print $lang->conf_title_pay;?></b><br><br>
            <?php print $lang->conf_title_pay_on;?><br>
            <?php if ($config->admin_lang=='pl'){ ?>
            <u><a href="/plugins/_pay/_polcard/index.php"><?php print $lang->configuration_polcard;?></a></u><br>
            <u><a href="/plugins/_pay/_przelewy24/index.php"><?php print $lang->configuration_przelewy24;?></a></u><br>
            <?php } if ($config->admin_lang=='en'){ ?>
            <u><a href="/plugins/_pay/_paypal/index.php"><?php print $lang->configuration_paypal;?></a></u><br>
            <?php }; ?>
           
            <u><a href="/plugins/_pay/_platnoscipl/index.php"><?php print $lang->configuration_platnosciPL;?></a></u><br>
            <u><a href="/plugins/_pay/_ecard/index.php"><?php print $lang->configuration_ecard;?></a></u><br>
            <u><a href="/plugins/_pay/_allpay/index.php"><?php print $lang->configuration_allpay;?></a><u><br><br>
            P³atno¶ci off-line:<br>
             <u><a href="/plugins/_pay/_cardpay/info.php"><?php print $lang->configuration_cardpay;?></a></u><br>
        <?php }; ?>
            </td>
        <td valign="top" width=30%>
            <b><?php print $lang->conf_title_aspect;?></b><br><br>
            <u><a href="/plugins/_themes/index.php"><?php print $lang->configuration_themes;?></u><br>
            <u><a href="/plugins/_themes/category.php"><?php print $lang->configuration_category;?></a></u>
        </td>
   </tr>
       
</table>
<br />
<br />
<?php
$theme->desktop_close();
?>
