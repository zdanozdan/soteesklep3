<?php


class DiscountsConfig {
	var $producer=array(
                );
	var $category=array(
                '50_12261_256'=>"0",
                );
	var $category_producer=array(
                );
	var $default_discounts=array(
                '1'=>"2",
                '2'=>"5",
                '108'=>"8",
                '110'=>"10",
                );
	var $discounts_groups=array(
                '1'=>"Sta³y klient",
                '2'=>"Happy hour",
                '108'=>"Max rabat 8%",
                '110'=>"Max rabat 10%",
                );
	var $discounts_groups_public=array(
                '1'=>"0",
                '2'=>"0",
                '108'=>"1",
                '110'=>"1",
                );
	var $discounts_start_date=array(
                '1'=>"0",
                '2'=>"2005-12-12;20:00",
                '108'=>"0",
                '110'=>"0",
                );
	var $discounts_end_date=array(
                '1'=>"0",
                '2'=>"2005-12-12;21:00",
                '108'=>"0",
                '110'=>"0",
                );

} // end class DiscountsConfig
$discounts_config = new DiscountsConfig;
?>