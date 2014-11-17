<?php
/**
 * Konfiguracja importu danych z EasyShop
 *
 * Definicje funkcji transferuj±cych i metod transformacji danych.
 * 
 * @author lukasz@sote.pl
 * @version $Id: easyshop-config.inc.php,v 1.1 2005/12/20 08:16:34 lukasz Exp $
 * @package importshop
 */

$this->config=array
(
/*      "users"=>array(
	    "key"=>"customer_no",             
		"table"=>"customer",              
 		"data"=>array(
 			"customer_no"=>"id",
 			"login"=>array("function"=>"crypt_login","field"=>"crypt_login"),
 			"created"=>"date_add",
 			"updated"=>"date_update",
 			"crypt_password"=>array("function"=>"crypt_time"),
 			"crypt_firm"=>array("function"=>"get_crypt_firm"),
 			"name"=>array("function"=>"encrypt","field"=>"crypt_name"),
 			"surname"=>array("function"=>"encrypt","field"=>"crypt_surname"),
 			"crypt_street"=>array("function"=>"get_crypt_street"),
 			"crypt_street_n1"=>array("function"=>"nothing"),
 			"crypt_street_n2"=>array("function"=>"nothing"),
 			"crypt_email"=>array("function"=>"crypt_email"),
 			"crypt_country"=>array("function"=>"crypt_country"),
 			"crypt_postcode"=>array("function"=>"crypt_postcode"),
 			"crypt_nip"=>array("function"=>"nothing"),
 			"record_version"=>array("function"=>"record_version"),
 			"crypt_city"=>array("function"=>"crypt_city"),
 			"crypt_phone"=>array("function"=>"crypt_phone"),
 			"comments"=>array("function"=>"encrypt","field"=>"crypt_ext_info"),
 			"crypt_cor_firm"=>array("function"=>"crypt_cor_firm"),
 			"crypt_cor_name"=>array("function"=>"crypt_cor_name"),
 			"crypt_cor_surname"=>array("function"=>"crypt_cor_surname"),
 			"crypt_cor_street"=>array("function"=>"crypt_cor_street"),
 			"crypt_cor_street_n1"=>array("function"=>"nothing"),
 			"crypt_cor_street_n2"=>array("function"=>"nothing"),
 			"crypt_cor_country"=>array("function"=>"crypt_country"),
 			"crypt_cor_postcode"=>array("function"=>"crypt_cor_postcode"),
 			"crypt_cor_phone"=>array("function"=>"crypt_cor_phone"),
 			"crypt_cor_email"=>array("function"=>"crypt_cor_email"),
	    ),
	),	
	*/
	"producer"=>array(
		"key"=>"id",
		"table"=>"product_manufacturer",
		"data"=>array(
			"id"=>"id",
			"manufacturer"=>"producer",
		),
	),
	"category"=>array(
		"key"=>"id",
		"table"=>"dict_category",
		"data"=>array(
			"id"=>array("function"=>"build_category"),
			"category1"=>array("function"=>"category1_next_name"),
		),
	),
	
	
	"category1"=>array(
		"key"=>"id",
		"table"=>"dict_category",
		"data"=>array(
			"id"=>"id",
			"name"=>"category1",
		),
	),
	
	
	"category2"=>array(
		"key"=>"id",
		"table"=>"dict_category",
		"data"=>array(
			"id"=>"id",
			"name"=>"category2",
		),
	),
	
	
	"category3"=>array(
		"key"=>"id",
		"table"=>"dict_category",
		"data"=>array(
			"id"=>"id",
			"name"=>"category3",
		),
	),
	
	
	"category4"=>array(
		"key"=>"id",
		"table"=>"dict_category",
		"data"=>array(
			"id"=>"id",
			"name"=>"category4",
		),
	),
	
	
	"category5"=>array(
		"key"=>"id",
		"table"=>"dict_category",
		"data"=>array(
			"id"=>"id",
			"name"=>"category5",
		),
	),
	
	
    "main"=>array(
	    "key"=>"product_no",             
		"table"=>"product",              
 		"data"=>array(
 		    "id"=>"id",
 		    "product_no"=>"user_id",
 		    "photo"=>array("function"=>"photo"),
 		    "description"=>"xml_short_description_L0",
 		    "xml_description_L0"=>array("function"=>"get_txt_attributes"),
 		    "promotion"=>array("function"=>"check_promotion"),
 		    "newcol"=>array("function"=>"check_newcol"),
 		    "bestseller"=>array("function"=>"check_bestseller"),
 		    "main_page"=>array("function"=>"check_main_page"),
 		    "visible"=>"active",
 		    "name"=>"name_L0",
 		    "manufacturer"=>array("function"=>"get_producer_name","field"=>"producer"),
 		    "id_producer"=>array("function"=>"get_producer_id"),
 		    "category1"=>array("function"=>"get_category1_name"),
 		    "id_category1"=>array("function"=>"get_id_category1"),			
 		    "category2"=>array("function"=>"get_category2_name"),
 		    "id_category2"=>array("function"=>"get_id_category2"),
 		    "category3"=>array("function"=>"get_category3_name"),
 		    "id_category3"=>array("function"=>"get_id_category3"),
 		    "category4"=>array("function"=>"get_category4_name"),
 		    "id_category4"=>array("function"=>"get_id_category4"),
 		    "category5"=>array("function"=>"get_category5_name"),
 		    "id_category5"=>array("function"=>"get_id_category5"),
 		    "price"=>"price_brutto",
            "vat"=>array("function"=>"getVat"),    
			"price_currency"=>array("function"=>"product_price_currency"),
			"hidden_price"=>array("function"=>"zero"),
			"ask4price"=>array("function"=>"zero"),
			"id_currency"=>array("function"=>"one"),
			"id_category_multi_1"=>array("function"=>"get_extra_cat1_path"),
			"category_multi_1"=>array("function"=>"get_extra_cat1_name"),
			"id_category_multi_2"=>array("function"=>"get_extra_cat2_path"),
			"category_multi_2"=>array("function"=>"get_extra_cat2_name"),
            ),
		),

	"reviews"=>array(
		"key"=>"id",
		"table"=>"opinie",
		"data"=>array(
			"id"=>"id",
			"prod_no"=>array("function"=>"review_get_product_id","field"=>"id_product"),
			"dlugi"=>array("function"=>"make_review_description","field"=>"description"),
			"data"=>"date_add",
			"zatwierdzone"=>array("function"=>"review_active","field"=>"state"),
			"ocena"=>array("function"=>"review_score","field"=>"score"),
			"imie"=>"author",
			"user_id"=>array("function"=>"reviews_prod_id"),
			"lang"=>array("function"=>"get_pl_lang"),
			"md5"=>array("function"=>"calc_md5"),
			),
		),
	"newsletter_groups"=>array(
		"key"=>"id",
		"table"=>"dict_subscription",
		"data"=>array(
			"id"=>"id",
			"user_id"=>array("function"=>"newsletter_groups_uid"),
			"name"=>"name",
			),
		),
	"newsletter"=>array(
		"key"=>"mail",
		"table"=>"subscription",
		"data"=>array(
			"mail"=>"email",
			"date_add"=>array("function"=>"newsletter_get_date"),
			"status"=>array("function"=>"newsletter_status"),
			"active"=>array("function"=>"newsletter_status"),
			"md5"=>array("function"=>"newsletter_md5"),
			"subscription"=>array("function"=>"newsletter_groups","field"=>"groups"),
			"lang"=>array("function"=>"get_pl_lang"),
			),
		),
);	
?>