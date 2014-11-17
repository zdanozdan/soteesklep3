<?php


class ConfigNewsletter {
	var $newsletter_group="www";
	var $newsletter_sender="nobody@localhost";
	var $newsletter_head="Hallo !";
	var $newsletter_info_add="Vielen Dank dass Du unser Newsletter erhalten möchtest. Jede 2-3 Woche versenden wir an Dich unser Bulletin mit neuesten Informationen über Neuigkeiten, Sonderangebote und anderen interessannten Themen .";
	var $newsletter_info_del="Vielen Dank , dass Du Empfänger unseres Newsletters warst. Es war uns angenehm Dir ein Mal in 2-3 Wochen unser Bulletin mit  neuesten Informationen über Neuigkeiten, Sonderangebote und anderen interessannten Themen , zu versenden.";
	var $newsletter_foot_add="Bitte bestätige Deine Registrierung . Klicke diesen Link:";
	var $newsletter_foot_del="Bitte bestätige Deine Entscheidung über  den Austritt.  Klicke diesen Link:";

} // end class ConfigNewsletter
$config_newsletter = new ConfigNewsletter;
?>