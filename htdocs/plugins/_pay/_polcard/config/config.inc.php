<?php
/**
* Konfiguracja PolCard. Dane certyfikatu CA Polcard do weryfikacji.
*
* @author  m@sote.pl
* @version $Id: config.inc.php,v 1.3 2004/12/20 18:02:09 maroslaw Exp $
* @package    pay
* @subpackage polcard
*/

$polcard_config->ssl=array("S_DN_O"  => "PolCard S.A.",
                           "S_DN_L"  => "WARSZAWA",
                           "S_DN_CN" => "post.polcard.com.pl",
                           "S_DN_C"  => "PL",
                           "I_DN_O"  => "Thawte Consulting cc",
                           "I_DN_CN" => "Thawte Server CA",
                           "I_DN_C"  => "ZA"
			  );
?>
