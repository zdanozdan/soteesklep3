<?php
/**
* @version    $Id: newsletter_config.inc.php,v 2.3 2004/12/20 18:01:29 maroslaw Exp $
* @package    default
*/


class ConfigNewsletter {
	var $newsletter_group="www";
	var $newsletter_sender="nobody@localhost";
	var $newsletter_head="Dzie� dobry!";
	var $newsletter_info_add="Dzi�kujemy za zapisanie si� do naszego biuletynu informacyjnego.Co kilka tygodni, b�dziemy do Ciebie wysy�a� nasz biuletyn  z najnowszymi informacjami o nowo��ciach, promocjach i innych ciekawostkach z naszej oferty.";
	var $newsletter_info_del="Dzi�kujemy za uczestnictwo w naszym biuletynie informacyjnym.Bylo nam milo, �e co kilka tygodni moglismy  do Ciebie wysy�a� nasz biuletyn z najnowszymi informacjami o nowo�ciach, promocjach i innych ciekawostkach z naszej oferty";
	var $newsletter_foot_add="Prosimy o potwierdzenie Twojej rejestracji przez naci�ni�cie poni�szego linku:";
	var $newsletter_foot_del="Prosimy o potwierdzenie Twojej decyzji w wyrejestrowaniu  przez naci�ni�cie poni�szego linku:";

} // end class ConfigNewsletter
$config_newsletter = new ConfigNewsletter;
?>
