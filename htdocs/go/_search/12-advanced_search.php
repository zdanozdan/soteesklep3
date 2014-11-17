<?php
$global_database=true;
$global_secure_test=true;
global $config;



$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
/**
* klasa obslugujaca sprawdzanie poprawnosci danych z formularzy
* @version FormCheck 3.x or higher
*/
require_once("include/form_check.inc");
require_once ("include/image.inc");
require_once ("include/description.inc");
require_once ("themes/include/buttons.inc.php");
require_once("config/auto_config/search_config.inc.php");
/**
* slownik z lokalizacja
*/
include_once("./lang/_pl/lang.inc.php");
/**
* dodatkowe klasa z funkcjami dla search
*/
include_once("./include/search.inc.php");
/**
* dane tymczasowe spersoanilizowane dla aktualnego serwisu
* (podlaczane opcjonalnie)
*/
@include_once("./tmp_data/data.inc.php");

$form_check=&new AdvSearch; 
$theme->form_check=&$form_check;

/**
* funkcje wykorzystane z klasy FormCheck
*/
$form_check->fun['name']="string_null";
$form_check->fun['phrase']="string_null";
$form_check->fun['color']="string_null";
$form_check->fun['price_min']="int_null";
$form_check->fun['price_max']="int_null";
$form_check->fun['size']="string_null";
$form_check->fun['bowl']="string_null";

/**
* komunikaty z bledami dla poszczegolnych funkcji FormCheck
*/
$form_check->errors=$lang->adv_search_errors;

/**
* sprawdz czy sa jakies dane wejsciowe
* jesli sa przekaz je do klasy FormCheck
* oraz do klasy theme aby wypelnic formularz danymi
* bo blednym wypelnieniu
*/
if(!empty($_REQUEST['form'])){
	$form=$_REQUEST['form'];
	$form_check->form=&$form;
	$theme->form=&$form;
}

global $config;
$lid = $config->lang_id;

if(@$_REQUEST['send_form']==1){    
    if($form_check->form_test()){        
        $theme->head();        
        if (empty($form['price_min'])) {
        	$form['price_min']="0";
        }
        if (empty($form['price_max'])) {
        	$form['price_max']="9999999999";
        }
        $_and=false;
        $sql = "SELECT * FROM main WHERE 1=1 ";
        $_and=true;
        
        reset($form);$form2=array();
        foreach ($form as $key=>$val) {
            $form2[$key]=addslashes($val);
            $form2[$key]=htmlentities($val);
        }
        $form=$form2;
        
        /**
        * zapytanie na podstawie danych z formularza
        */
        if(!empty($form['phrase'])){
            if($_and==true){
                $sql.="AND ";
                $_and=false;
            }
            $sql.="(name_L$lid LIKE '%".$form['phrase']."%' OR lower(xml_description_L$lid) like lower('%".$form['phrase']."%'))";
            $_and=true;
                        
        } else if(!empty($form['name'])){
            if($_and==true){
                $sql.="AND ";
                $_and=false;
            }
            $sql.="name_L$lid LIKE '%".$form['name']."%'";
            $_and=true;
        }
        // wprowadz ceny min i max uwzglednic waluty
        $__currency=$_SESSION['__currency'];
        $search_price=$config->currency_data[$__currency];
        
        if(!empty($form['price_min'])){
                if($_and==true){
            	$form['price_min']=$form['price_min']*$search_price;
                $sql.=" AND ";
                $_and=false;
            }
        if ($form['brutto_netto']==1){
        	$sql.="price_brutto > '".$form['price_min']."' ";
        	$_and=true;
        }else{
	        $sql.="price_currency > '".$form['price_min']."' ";
	        $_and=true;
    	}
        }
        if(!empty($form['price_max'])){
            if($_and==true){
            	$form['price_max']=$form['price_max']*$search_price;
                $sql.=" AND ";
                $_and=false;
            }
            if ($form['brutto_netto']==1){
            $sql.="price_brutto < '".$form['price_max']."' ";
            $_and=true;
            }else{
            $sql.="price_currency < '".$form['price_max']."' ";
            $_and=true;
            }     
        }
        
        
        if(!empty($form['size'])){
            if($_and==true){
                $sql.=" AND ";
                $_and=false;
            }
             $sql.="xml_options LIKE '%".$form['size']."%' ";
        	$_and=true;
	    }
	

        if(!empty($form['producer']) && $form['producer']!='opt'){
            if($_and==true){
                $sql.=" AND ";
                $_and=false;
            }
            $sql.="id_producer=".$form['producer'];
            $_and=true;
        }
        
        if(!empty($form['c1'])){
            if($_and==true){
                $sql.=" AND ";
                $_and=false;
            }
            $sql.="id_category1 = " . $form['c1'] . " ";
            $_and=true;
        }       

        if(!empty($form['c2'])){
            if($_and==true){
                $sql.=" AND ";
                $_and=false;
            }
            $sql.="id_category2 = " . $form['c2'] . " ";
            $_and=true;
        }
        if(!empty($form['c3'])){
            if($_and==true){
                $sql.=" AND ";
                $_and=false;
            }
            $sql.="id_category3 = " . $form['c3'] . " ";
            $_and=true;
        }
        if(!empty($form['c4'])){
            if($_and==true){
                $sql.=" AND ";
                $_and=false;
            }
            $sql.="id_category4 = " . $form['c4'] . " ";
            $_and=true;
        }
        if(!empty($form['c5'])){
            if($_and==true){
                $sql.=" AND ";
                $_and=false;
            }
            $sql.="id_category5 = " . $form['c5'] . " ";
            $_and=true;
        }
        /**
        * funkcja prezentujaca wynik zapytania w glownym oknie strony
        */
        include_once ("include/dbedit_list.inc");
        $dbedit =& new DBEditList;
        $dbedit->title="Wynik wyszukiwania zaawansowanego";
        $theme->page_open_object("show",$dbedit,"page_open");
        $theme->foot();        
    } else {        
        // naglowek
        $theme->head();
        $theme->page_open_head("page_open_2_head");
        include_once("./include/prepare_javascript.inc.php");
        include_once("./html/adv_search_form.html.php");     
        // stopka
        $theme->page_open_foot("page_open_1_foot");
        $theme->foot();
    }
} else {
    // naglowek
    $theme->head();
    $theme->page_open_head("page_open_2_head");
    include_once("./include/prepare_javascript.inc.php");
    include_once("./html/adv_search_form.html.php");       
    // stopka
    $theme->page_open_foot("page_open_1_foot");
    $theme->foot();
}
include_once ("include/foot.inc");
?>