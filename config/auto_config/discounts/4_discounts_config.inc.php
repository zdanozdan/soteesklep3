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
                '4'=>"22",
                '110'=>"5",
                );
	var $discounts_groups=array(
                '1'=>"Sta³y klient",
                '2'=>"Happy hour",
                '4'=>"Tomasz 123",
                '110'=>"Zong",
                );
	var $discounts_groups_public=array(
                '1'=>"1",
                '2'=>"0",
                '4'=>"1",
                '110'=>"1",
                );
	var $discounts_start_date=array(
                '1'=>"0",
                '2'=>"2005-12-12;20:00",
                '4'=>"0",
                '110'=>"0",
                );
	var $discounts_end_date=array(
                '1'=>"0",
                '2'=>"2005-12-12;21:00",
                '4'=>"0",
                '110'=>"0",
                );

} // end class DiscountsConfig
$discounts_config = new DiscountsConfig;
?>