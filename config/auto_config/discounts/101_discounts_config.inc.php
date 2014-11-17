<?php


class DiscountsConfig {
	var $producer=array(
                );
	var $category=array(
                );
	var $category_producer=array(
                );
	var $default_discounts=array(
                '1'=>"2",
                '2'=>"5",
                '101'=>"0",
                '102'=>"10",
                '103'=>"22",
                '104'=>"5",
                '105'=>"0",
                '106'=>"10",
                '107'=>"10",
                );
	var $discounts_groups=array(
                '1'=>"Sta³y klient",
                '2'=>"Happy hour",
                '101'=>"Brak rabatu",
                '102'=>"Do Pozycji",
                '103'=>"Do Dokumentu",
                '104'=>"Zwyk³y upust 5%",
                '105'=>"Upust za p³atno¶æ gotówk±",
                '106'=>"Rabat Testowy",
                '107'=>"Moja grupa 10%",
                );
	var $discounts_groups_public=array(
                '1'=>"1",
                '2'=>"0",
                '101'=>"1",
                '102'=>"1",
                '103'=>"1",
                '104'=>"1",
                '105'=>"1",
                '106'=>"1",
                '107'=>"1",
                );
	var $discounts_start_date=array(
                '1'=>"0",
                '2'=>"2005-12-12;20:00",
                '101'=>"0",
                '102'=>"0",
                '103'=>"0",
                '104'=>"0",
                '105'=>"0",
                '106'=>"0",
                '107'=>"0",
                );
	var $discounts_end_date=array(
                '1'=>"0",
                '2'=>"2005-12-12;21:00",
                '101'=>"0",
                '102'=>"0",
                '103'=>"0",
                '104'=>"0",
                '105'=>"0",
                '106'=>"0",
                '107'=>"0",
                );

} // end class DiscountsConfig
$discounts_config = new DiscountsConfig;
?>