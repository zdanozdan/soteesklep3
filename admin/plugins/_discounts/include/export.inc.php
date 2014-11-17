<?php
/**
 * Eksport danych o rabatch z tabeli discounts do pliku config/auto_config/discounts.inc.php
 *
 * @author  m@sote.pl
 * \@modified_by p@sote.pl (happy hour)
 * @version $Id: export.inc.php,v 2.9 2004/12/20 17:59:45 maroslaw Exp $
* @package    discounts
 */


if (@$__secure_test!=true) die ("Bledne wywolanie");

global $discounts_config;
require_once ("./include/discounts.inc.php");
$discounts_obj = new Discounts;

// odczytaj id kategorii i producenta oraz rabaty
// generuj tablice $discount_producer, $discount_cat, $discount zawierajace odpowiednie rabaty
$tab_discount_producer=array();
$tab_discount_cat=array();
$tab_discount=array();
$comm=1;

$query="SELECT idc,id_producer,discount_cat,discount_producer,discount FROM discounts 
           WHERE discount_cat!='' OR discount_producer!='' OR discount!=''";

$result=$db->Query($query);
if ($result!=0) {
    $num_rows=$db->NumberOfRows($result);
    
    if ($num_rows>0) {
        $i=0;
        while ($i<$num_rows) {
            $id_producer=$db->Fetchresult($result,$i,"id_producer");
            $idc=$db->FetchResult($result,$i,"idc");
            $discount_producer=$db->FetchResult($result,$i,"discount_producer");
            $discount_cat=$db->FetchResult($result,$i,"discount_cat");
            $discount=$db->FetchResult($result,$i,"discount");
            
            if (! empty($discount_producer)) {
                $tab_discount_producer[$id_producer]=$discount_producer;
            }
            if (! empty($discount_cat)) {
                $tab_discount_cat[$idc]=$discount_cat;
            }
            if (! empty($discount)) {
                $tab_discount[$idc."+".$id_producer]=$discount;
            }
            $i++;
        } // end while() 
    }
} else die ($db->Error());

// odczytaj domyslne rabaty dla grup klientow
$default_discounts=array();
$discounts_groups=array();
$discounts_groups_public=array();

// start happy hour
$discounts_start_time=array();
$discounts_end_time=array();
// end happy hour

$query="SELECT user_id,default_discount,group_name,public,start_date,end_date FROM discounts_groups WHERE user_id>0 ORDER BY user_id";
$result=$db->Query($query);
if ($result!=0) {
    $num_rows=$db->NumberOfRows($result);
    if ($num_rows>0) {
        for ($i=0;$i<$num_rows;$i++) {
            $group_user_id=$db->FetchResult($result,$i,"user_id");
            $group_discount=$db->Fetchresult($result,$i,"default_discount");
            $group_name=$db->Fetchresult($result,$i,"group_name");
            $public=$db->Fetchresult($result,$i,"public");
            
            // start happy hour
            $start_date=$db->Fetchresult($result,$i,"start_date");
            $end_date=$db->Fetchresult($result,$i,"end_date");
            // end happy hour
            
            $default_discounts[$group_user_id]=$group_discount;
            $discounts_groups[$group_user_id]=$group_name;
            $discounts_groups_public[$group_user_id]=$public;
            
            // start happy hour
            if (!empty($start_date)) {
                $discounts_start_date[$group_user_id]=$start_date;
            } else  $discounts_start_date[$group_user_id]=0;
            
            if (!empty($end_date)) {
                $discounts_end_date[$group_user_id]=$end_date;
            } else  $discounts_end_date[$group_user_id]=0;
            // end happy hour
            
        } // end for
    }
} else die ($db->Error());

// DEBUG
// print "<pre>";
// print_r($tab_discount_producer);
// print_r($tab_discount_cat);
// print_r($tab_discount);
// print_r($discounts_groups_public);
// print_r($discounts_start_date);
// print_r($discounts_end_date);
// print "</pre>";

// start happy hour
if (in_array("happy_hour",$config->plugins)) {
    
    // obsluga generowania pliku konfiguracyjnego uzytkownika
    require_once("include/gen_user_config.inc.php");
    global $database;
    
    // wyciagnij identyfikator grupy Happy hour z bazy
    $happy_hour_id=$database->sql_select("user_id","discounts_groups","group_name=Happy hour");
    
    // jesl istnieje identyfikator 
    if (! empty($happy_hour_id)) {
        $gen_config->gen(array("happy_hour"=>$happy_hour_id
                               )
                         );
    }
    
}
// end happy hour

// generuj pliki konfiguracyjne
require_once ("./include/gen_config.inc.php");

reset($discounts_groups);
while (list($user_id,$group_name) = each($discounts_groups)) {
    $check=1;   // grupy rabatowe istanieja
    $gen_config->config_file=$user_id."_discounts_config.inc.php";
    
    // wybierz z listy rabatow tylko rabaty dla danej grupy rabatowej
    $new_tab_discount_producer=array();
    reset($tab_discount_producer);
    while (list($key,$val) = each($tab_discount_producer)) {          
        // odczytaj odpowiedni rabat dla grupy (rabaty sa zapisane w formacie "grupa|rabat;")
        $my_val=$discounts_obj->get_discount($val,$user_id);         
        $new_tab_discount_producer[$key]=$my_val;
    } // end while
    
    $new_tab_discount_cat=array();
    reset($tab_discount_cat);
    while (list($key,$val) = each($tab_discount_cat)) {          
        $my_val=$discounts_obj->get_discount($val,$user_id);         
        $new_tab_discount_cat[$key]=$my_val;
    } // end while
    
    $new_tab_discount=array();
    reset($tab_discount);
    while (list($key,$val) = each($tab_discount)) {          
        $my_val=$discounts_obj->get_discount($val,$user_id);         
        $new_tab_discount[$key]=$my_val;
    } // end while
    
    // generuj plik konfiguracyjny w config/auto_config/discounts/*
    $comm=$gen_config->gen(array("producer"=>$new_tab_discount_producer,
                                 "category"=>$new_tab_discount_cat,
                                 "category_producer"=>$new_tab_discount,
                                 "default_discounts"=>$default_discounts,
                                 "discounts_groups"=>$discounts_groups,
                                 "discounts_groups_public"=>$discounts_groups_public,
                                 "discounts_start_date"=>$discounts_start_date,
                                 "discounts_end_date"=>$discounts_end_date
                                 )
                           );
}

if ($comm==0) {
    print "<p><center>$lang->discounts_export_ok</center>";
} else print "<p><center>$lang->discounts_export_error</center>";

?>
