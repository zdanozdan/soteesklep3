<?php


class DiscountsConfig {
	var $producer=array(
                );
	var $category=array(
                );
	var $category_producer=array(
                );
	var $default_discounts=array(
                '1'=>"5",
                '2'=>"5",
                '3'=>"3",
                );
	var $discounts_groups=array(
                '1'=>"Sta³y klient",
                '2'=>"Happy hour",
                '3'=>"Grupa testowa 3%",
                );
	var $discounts_groups_public=array(
                '1'=>"0",
                '2'=>"0",
                '3'=>"1",
                );
	var $discounts_start_date=array(
                '1'=>"0",
                '2'=>"2005-12-12;20:00",
                '3'=>"0",
                );
	var $discounts_end_date=array(
                '1'=>"0",
                '2'=>"2005-12-12;21:00",
                '3'=>"0",
                );

} // end class DiscountsConfig
$discounts_config = new DiscountsConfig;
?>