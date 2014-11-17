<?php


class MyConfig extends AutoConfig{
	var $db=array(
                'nobody_dbuser'=>"%EF%7B%C2%22%16%CBy%85",
                'nobody_dbpassword'=>"%F8v%C8%3E%12%CE%17%86l",
                'admin_dbuser'=>"%23%80%28%95%16%A59%FE",
                'admin_dbpassword'=>"4%8D%22%89%12%A0W%FD%2A",
                'dbhost'=>"%F1c%C5%7E%1A%CCM%C6%3E%B8k%D9%7F%06%BB%25%83%0E6u%D7%5E%9F%2B",
                'dbname'=>"%EF%7B%C2%22%16%CBy%85",
                );
	var $ftp=array(
                'ftp_host'=>"soteadmin.mikran.nazwa.pl",
                'ftp_user'=>"mikran",
                'ftp_password'=>"%14%AD%22%89%12%A0W%FD%2A",
                'ftp_dir'=>"/soteesklep3",
                );
	var $salt="f37e02d876032f4335ceb2c97a4b831c";
	var $md5_pin="6c35083f355f10ab32ebed269a58169e";
	var $license=array(
                'nr'=>"2006-0605-0001-3631-6459-5785",
                'who'=>"Mikran S.C",
                );
	var $auth_sign=array(
                '4e91ba4e243d0ee1672ca86e226e44d7'=>"mikran_1",
                '2df8ce7d317c7d89dfa95be7695d2de0'=>"tomasz",
                );
	var $config_setup=array(
                'type'=>"simple",
                'os'=>"linux",
                'host'=>"internet",
                );
	var $order_points="22";
	var $available=array(
                '6'=>"na zamówienie",
                '8'=>"dostêpny z magazynu",
                );
	var $currency_data=array(
                '1'=>"1",
                '2'=>"4.12",
                '5'=>"0.1157",
                '3'=>"3.22",
                );
	var $currency_name=array(
                '1'=>"PLN",
                '2'=>"EUR",
                '5'=>"RUB",
                '3'=>"USD",
                );
	var $category=array(
                'type'=>"standard",
                'openall'=>"0",
                );
	var $stats=array(
                'url'=>"",
                );
	var $merchant=array(
                'name'=>"Mikran S.C",
                'addr'=>"Mickiewicza 7",
                'tel'=>"0618475858",
                'fax'=>"0618484457",
                'nip'=>"783-10-08-373",
                'bank'=>"73 1090 1359 0000 0000 3501 9352",
                );
	var $order_email="sklep@mikran.pl";
	var $from_email="sklep@mikran.pl";
	var $newsletter_email="";
	var $www="www.sklep.mikran.pl";
	var $currency="PLN";
	var $cd_setup=array(
                'cd'=>"0",
                'IP'=>"",
                'price'=>"",
                'hurt'=>"",
                );
	var $theme="green";
	var $themes_active=array(
                'blue'=>"on",
                'green'=>"on",
                );
	var $record_row_type_default="long";
	var $producers_category_filter="yes";
	var $google=array(
                'keywords'=>"protetyka stomatologia ortodoncja",
                'title'=>"mikran.pl - sklep - najwiêkszy wybór materia³ów do protetyki,stomatologii,ortodoncji i dezynfekcji. Sprawd¼ nas !",
                'description'=>"Materia³y do protetyczne,stomatologiczne,ortodontyczne, do profilaktyki, wype³nieñ, protetyki, ortodoncji, stomatlogii, dezynfkcji. Instrumenty, narzêdzia, akcesoria srodki do dezynfekcji, sterylizacji, ochrony. Dla pracowni materia³y do wykonywania uzupe³nieñ protetycznych ruchomych i sta³ych. Narzêdzia i instrumenty do modelowania i obróbki wykonywanych prac. ",
                );
	var $price_type="netto/brutto";
	var $products_on_page=array(
                'long'=>"10",
                'short'=>"40",
                );
	var $image=array(
                'max_size'=>"300",
                'min_size'=>"115",
                );
	var $main_order_default="name_L0";
	var $vat_confirm="1";
	var $id_start_orders_default="243";
	var $newsedit_columns_default="1";
	var $lang="pl";
	var $lang_id="0";
	var $lang_active=array(
                'en'=>"1",
                'de'=>"1",
                'pl'=>"1",
                );
	var $currency_lang_default=array(
                'pl'=>"1",
                'en'=>"3",
                'de'=>"2",
                'cz'=>"4",
                'ru'=>"5",
                );
	var $category_multi="1";
	var $newsedit="1";
	var $newsletter="1";
	var $currency_show_form="0";
	var $cyfra_photo="1";
	var $basket_photo="0";
	var $htdocs_lang="pl";
	var $pay_method_active=array(
                '1'=>"1",
                '11'=>"1",
                '12'=>"0",
                '3'=>"1",
                '20'=>"0",
                '101'=>"0",
                '2'=>"1",
                '21'=>"1",
                '5'=>"1",
                '8'=>"1",
                '81'=>"1",
                );
	var $random_on_page=array(
                'promotion'=>"2",
                'newcol'=>"3",
                'bestseller'=>"2",
                );
	var $themes=array(
                'redball'=>"redball",
                'blueball'=>"blueball",
                'red'=>"red",
                'blue'=>"blue",
                'green'=>"green",
                'brown'=>"brown",
                'blueday'=>"blueday",
                'grayday'=>"grayday",
                'bluelight'=>"bluelight",
                'pinklight'=>"pinklight",
                );
	var $fields="";
	var $editable_themes=array(
                'blue'=>"blue",
                'redball'=>"redball",
                'blueday'=>"blueday",
                'grayday'=>"grayday",
                'bluelight'=>"bluelight",
                'pinklight'=>"pinklight",
                );
	var $admin_lang="pl";
	var $in_category_down="2";
	var $catalog_mode="0";
	var $rss_link="0";
	var $happy_hour="2";
	var $country_select=array(
                'AT'=>"1",
                'BE'=>"1",
                'BA'=>"1",
                'BG'=>"1",
                'HR'=>"1",
                'CY'=>"1",
                'CZ'=>"1",
                'DK'=>"1",
                'EE'=>"1",
                'FI'=>"1",
                'FR'=>"1",
                'GR'=>"1",
                'ES'=>"1",
                'NL'=>"1",
                'IE'=>"1",
                'IS'=>"1",
                'LI'=>"1",
                'LT'=>"1",
                'LU'=>"1",
                'LV'=>"1",
                'MT'=>"1",
                'DE'=>"1",
                'NO'=>"1",
                'PL'=>"1",
                'PT'=>"1",
                'RU'=>"1",
                'RO'=>"1",
                'CS'=>"1",
                'SK'=>"1",
                'SI'=>"1",
                'US'=>"1",
                'SE'=>"1",
                'CH'=>"1",
                'UA'=>"1",
                'VA'=>"1",
                'HU'=>"1",
                'GB'=>"1",
                'IT'=>"1",
                );
	var $langs_symbols=array(
                '0'=>"pl",
                '1'=>"en",
                '2'=>"de",
                '3'=>"cz",
                '4'=>"ru",
                );
	var $langs_names=array(
                '0'=>"Polski",
                '1'=>"English",
                '2'=>"Deutsch",
                '3'=>"Cestina",
                '4'=>"Russkij",
                );
	var $langs_active=array(
                '0'=>"1",
                '1'=>"0",
                '2'=>"0",
                '3'=>"0",
                '4'=>"0",
                );
	var $langs_encoding=array(
                '0'=>"052|iso-8859-2",
                '1'=>"018|iso-8859-1",
                '2'=>"031|iso-8859-1",
                '3'=>"015|iso-8859-2",
                '4'=>"000|utf-8",
                );
	var $users_online="0";
	var $unit="kg";
	var $id_shop="0";
	var $ssl="0";
	var $catalog_mode_options=array(
                'currency'=>"0",
                'users'=>"0",
                'newsletter'=>"0",
                'newsedit'=>"0",
                );
	var $ranking1_max_length="5";
	var $ranking2_max_length="5";
	var $ranking1_enabled="1";
	var $ranking2_enabled="1";
	var $depository=array(
                'show_unavailable'=>"1",
                'general_min_num'=>"5",
                'update_num_on_action'=>"on_paid",
                'return_on_cancel'=>"1",
                'available_type_to_hide'=>"6",
                'display_availability'=>"1",
                );
	var $basket_ext="0";
	var $basket_wishlist=array(
                'prod_ext_info'=>"0",
                );
	var $show_user_id="0";

} // end class MyConfig
$config = new MyConfig;
?>
