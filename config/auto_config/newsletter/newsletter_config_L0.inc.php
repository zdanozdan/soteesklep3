<?php


class ConfigNewsletter {
	var $newsletter_group="www";
	var $newsletter_sender="sklep@mikran.pl";
	var $newsletter_head="Dzie� dobry !";
	var $newsletter_info_add="Dzi�kujemy za zapisanie si� do naszego biuletynu informacyjnego.Co kilka tygodni, b�dziemy do Ciebie wysy�a� nasz biuletyn  z najnowszymi informacjami o nowo�ciach, promocjach i innych ciekawostkach z naszej oferty.";
	var $newsletter_info_del="Dzi�kujemy za uczestnictwo w naszym biuletynie informacyjnym.By�o nam milo, �e co kilka tygodni mogli�my  do Ciebie wysy�a� nasz biuletyn z najnowszymi informacjami o nowo�ciach, promocjach i innych ciekawostkach z naszej oferty";
	var $newsletter_foot_add="Prosimy o potwierdzenie Twojej rejestracji przez naci�ni�cie poni�szego linku:";
	var $newsletter_foot_del="Prosimy o potwierdzenie Twojej decyzji w wyrejestrowaniu  przez naci�ni�cie poni�szego linku:";
	var $newsletter_foot="Je�li nie chcesz otrzymywa� od nas informacji, kliknij na poni�szy link, aby si� wyrejestrowa�.";

} // end class ConfigNewsletter
$config_newsletter = new ConfigNewsletter;
?>