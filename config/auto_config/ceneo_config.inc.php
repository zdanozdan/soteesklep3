<?php


class ceneoConfig {
	var $ceneo_shop_id="";
	var $ceneo_login="";
	var $ceneo_password="";
	var $ceneo_server="rentserver73.internet1.de";
	var $ceneo_message="/impexpceneo.asmx";
	var $ceneo_port="80";
	var $ceneo_category=array(
                '0'=>"Felgi",
                );
	var $ceneo_test_server="";
	var $ceneo_load="product";
	var $ceneo_partner_name="ceneo";

} // end class ceneoConfig
$ceneo_config = new ceneoConfig;
?>