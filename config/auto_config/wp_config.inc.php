<?php


class wpConfig {
	var $wp_shop_id="";
	var $wp_mode="true";
	var $wp_login="";
	var $wp_password="";
	var $wp_server="wymianadanych.wp.pl";
	var $wp_rpc="/SOAPInterface/Zakupy/index.html";
	var $wp_message="/SOAPInterface/Zakupy/index.html";
	var $wp_port="80";
	var $wp_transaction="";
	var $wp_category=array(
                '0'=>"Muzyka",
                );
	var $wp_confirm_trans="";
	var $wp_test_server="wymianadanych.wp.pl";
	var $wp_load="product";
	var $wp_partner_name="wp";

} // end class wpConfig
$wp_config = new wpConfig;
?>