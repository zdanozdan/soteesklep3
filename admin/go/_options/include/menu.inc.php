<?php
/**
* @version    $Id: menu.inc.php,v 2.9 2004/12/20 17:58:46 maroslaw Exp $
* @package    options
*/
print "<div align=right>";
$data=array($lang->options_menu["delivery"]=>"/go/_options/_delivery/index.php",
			$lang->options_menu["available"]=>"/go/_options/_available/index.php",
            $lang->options_menu["vat"]=>"/go/_options/_vat/index.php",
            );
if (in_array("currency",$config->plugins)) $data[$lang->options_menu["currency"]]="/plugins/_currency/";
$data[$lang->help]="/plugins/_help_content/help_show.php?id=23 onClick=\"open_window(300,500);\" target=window";

$buttons->menu_buttons($data);
print "</div>";
?>
