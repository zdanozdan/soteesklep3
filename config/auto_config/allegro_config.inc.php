<?php


class allegroConfig {
	var $allegro_login="";
	var $allegro_login_test="";
	var $allegro_password="";
	var $allegro_password_test="";
	var $allegro_web_api_key="";
	var $allegro_country_code="1";
	var $allegro_country_code_test="228";
	var $allegro_category=array(
                '0'=>"2",
                );
	var $allegro_category_test="";
	var $allegro_server="http://webapi.allegro.pl/uploader.php?wsdl";
	var $allegro_version="61012684";
	var $allegro_version_test="57975311";
	var $allegro_city="Poznañ";
	var $allegro_time=array(
                '0'=>"3",
                '1'=>"5",
                '2'=>"7",
                '3'=>"10",
                '4'=>"14",
                );
	var $allegro_states=array(
                '0'=>" -- Wybierz województwo -- ",
                '1'=>"dolno¶l±skie",
                '2'=>"kujawsko-pomorskie",
                '3'=>"lubelskie",
                '4'=>"lubuskie",
                '5'=>"³ódzkie",
                '6'=>"ma³opolskie",
                '7'=>"mazowieckie",
                '8'=>"opolskie",
                '9'=>"podkarpackie",
                '10'=>"podlaskie",
                '11'=>"pomorskie",
                '12'=>"¶l±skie",
                '13'=>"¶wiêtokrzyskie",
                '14'=>"warmiñsko-mazurskie",
                '15'=>"wielkopolskie",
                '16'=>"zachodniopomorskie",
                );
	var $allegro_trans=array(
                'seller'=>"Sprzedaj±cy pokrywa koszty transportu",
                'buyer'=>"Kupuj±cy pokrywa koszty transportu",
                );
	var $allegro_mode="true";
	var $allegro_state_select="0";

} // end class allegroConfig
$allegro_config = new allegroConfig;
?>