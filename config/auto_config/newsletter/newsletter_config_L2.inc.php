<?php


class ConfigNewsletter {
	var $newsletter_group="www";
	var $newsletter_sender="nobody@localhost";
	var $newsletter_head="Hallo !";
	var $newsletter_info_add="Vielen Dank dass Du unser Newsletter erhalten m�chtest. Jede 2-3 Woche versenden wir an Dich unser Bulletin mit neuesten Informationen �ber Neuigkeiten, Sonderangebote und anderen interessannten Themen .";
	var $newsletter_info_del="Vielen Dank , dass Du Empf�nger unseres Newsletters warst. Es war uns angenehm Dir ein Mal in 2-3 Wochen unser Bulletin mit  neuesten Informationen �ber Neuigkeiten, Sonderangebote und anderen interessannten Themen , zu versenden.";
	var $newsletter_foot_add="Bitte best�tige Deine Registrierung . Klicke diesen Link:";
	var $newsletter_foot_del="Bitte best�tige Deine Entscheidung �ber  den Austritt.  Klicke diesen Link:";

} // end class ConfigNewsletter
$config_newsletter = new ConfigNewsletter;
?>