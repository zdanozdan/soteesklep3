<?php
/**
* @version    $Id: config.inc.php,v 2.5 2004/12/20 18:01:28 maroslaw Exp $
* @package    default
*/

class AutoConfig extends Config {
    var $dbname="soteesklep123";
	var $dbhost="192.168.1.234";
	var $dbuser="esotesklep026";
	var $dbpass="has44wtbx";
	var $ftp_user="sklep2";
	var $ftp_host="192.168.2.33";
	var $ftp_dir="/home/sklep2";
}

$config = new AutoConfig;

?>
