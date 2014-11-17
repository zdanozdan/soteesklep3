<?php


class ConfigNewsletter {
	var $newsletter_group="www";
	var $newsletter_sender="nobody@localhost";
	var $newsletter_head="Hello Russia!";
	var $newsletter_info_add="We are honored to have you among our newsletter subscribers. We are to provide you periodically with some information about our latest products, new collections and promotions. You can always unsubscribe in order to cancel your newsletter account.";
	var $newsletter_info_del="This message is to announce the cancellation of your newsletter account. You can always sign in to start receiving our latest news again.";
	var $newsletter_foot_add="Confrm your subscryption of newsletter by clicking on the link given below, please: ";
	var $newsletter_foot_del="Confirm the cancellation of your newsletter account by clicking on this link, please:";

} // end class ConfigNewsletter
$config_newsletter = new ConfigNewsletter;
?>