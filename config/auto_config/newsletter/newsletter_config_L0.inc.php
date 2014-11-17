<?php


class ConfigNewsletter {
	var $newsletter_group="www";
	var $newsletter_sender="sklep@mikran.pl";
	var $newsletter_head="Dzieñ dobry !";
	var $newsletter_info_add="Dziêkujemy za zapisanie siê do naszego biuletynu informacyjnego.Co kilka tygodni, bêdziemy do Ciebie wysy³aæ nasz biuletyn  z najnowszymi informacjami o nowo¶ciach, promocjach i innych ciekawostkach z naszej oferty.";
	var $newsletter_info_del="Dziêkujemy za uczestnictwo w naszym biuletynie informacyjnym.By³o nam milo, ¿e co kilka tygodni mogli¶my  do Ciebie wysy³aæ nasz biuletyn z najnowszymi informacjami o nowo¶ciach, promocjach i innych ciekawostkach z naszej oferty";
	var $newsletter_foot_add="Prosimy o potwierdzenie Twojej rejestracji przez naci¶niêcie poni¿szego linku:";
	var $newsletter_foot_del="Prosimy o potwierdzenie Twojej decyzji w wyrejestrowaniu  przez naci¶niêcie poni¿szego linku:";
	var $newsletter_foot="Je¶li nie chcesz otrzymywaæ od nas informacji, kliknij na poni¿szy link, aby siê wyrejestrowaæ.";

} // end class ConfigNewsletter
$config_newsletter = new ConfigNewsletter;
?>