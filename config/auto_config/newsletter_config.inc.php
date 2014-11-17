<?php
/**
* @version    $Id: newsletter_config.inc.php,v 2.3 2004/12/20 18:01:29 maroslaw Exp $
* @package    default
*/


class ConfigNewsletter {
	var $newsletter_group="www";
	var $newsletter_sender="nobody@localhost";
	var $newsletter_head="Dzieñ dobry!";
	var $newsletter_info_add="Dziêkujemy za zapisanie siê do naszego biuletynu informacyjnego.Co kilka tygodni, bêdziemy do Ciebie wysy³aæ nasz biuletyn  z najnowszymi informacjami o nowo¶æciach, promocjach i innych ciekawostkach z naszej oferty.";
	var $newsletter_info_del="Dziêkujemy za uczestnictwo w naszym biuletynie informacyjnym.Bylo nam milo, ¿e co kilka tygodni moglismy  do Ciebie wysy³aæ nasz biuletyn z najnowszymi informacjami o nowo¶ciach, promocjach i innych ciekawostkach z naszej oferty";
	var $newsletter_foot_add="Prosimy o potwierdzenie Twojej rejestracji przez naci¶niêcie poni¿szego linku:";
	var $newsletter_foot_del="Prosimy o potwierdzenie Twojej decyzji w wyrejestrowaniu  przez naci¶niêcie poni¿szego linku:";

} // end class ConfigNewsletter
$config_newsletter = new ConfigNewsletter;
?>
