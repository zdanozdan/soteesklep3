<?php


class interiaConfig {
	var $interia_shop_id="";
	var $interia_password="";
	var $interia_server="soap.zakupy.interia.pl";
	var $interia_rpc="/category.cgi";
	var $interia_message="/products.cgi";
	var $interia_port="80";
	var $interia_transaction="/put_info.php";
	var $interia_category=array(
                '0'=>"Muzyka",
                );
	var $interia_test_server="soap.developer.neutron-it.com";
	var $interia_partner_name="interia";
	var $interia_load="product";

} // end class interiaConfig
$interia_config = new interiaConfig;
?>