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
                '1037'=>"10",
                '1063'=>"10",
                '1065'=>"20",
                '1111'=>"8",
                '1186'=>"6",
                '1782'=>"10",
                '1817'=>"6",
                '3079'=>"20",
                '3080'=>"12",
                );
	var $discounts_groups=array(
                '1'=>"Sta³y klient",
                '2'=>"Happy hour",
                '1037'=>"MAC.RABAT 10",
                '1063'=>"Max rabat 10%",
                '1065'=>"Max rabat 20%",
                '1111'=>"Max rabat 8%",
                '1186'=>"Max Rabat 6%",
                '1782'=>"Grupa Rabatowa 10%",
                '1817'=>"Rabat 6%",
                '3079'=>"Rabat",
                '3080'=>"Max rabat 12%",
                );
	var $discounts_groups_public=array(
                '1'=>"0",
                '2'=>"0",
                '1037'=>"0",
                '1063'=>"0",
                '1065'=>"0",
                '1111'=>"0",
                '1186'=>"0",
                '1782'=>"0",
                '1817'=>"0",
                '3079'=>"0",
                '3080'=>"0",
                );
	var $discounts_start_date=array(
                '1'=>"0",
                '2'=>"2005-12-12;20:00",
                '1037'=>"0",
                '1063'=>"0",
                '1065'=>"0",
                '1111'=>"0",
                '1186'=>"0",
                '1782'=>"0",
                '1817'=>"0",
                '3079'=>"0",
                '3080'=>"0",
                );
	var $discounts_end_date=array(
                '1'=>"0",
                '2'=>"2005-12-12;21:00",
                '1037'=>"0",
                '1063'=>"0",
                '1065'=>"0",
                '1111'=>"0",
                '1186'=>"0",
                '1782'=>"0",
                '1817'=>"0",
                '3079'=>"0",
                '3080'=>"0",
                );

} // end class DiscountsConfig
$discounts_config = new DiscountsConfig;
?>