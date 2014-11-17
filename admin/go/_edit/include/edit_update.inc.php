<?php
/**
* Aktualizaja danych produtku
*
* @author m@sote.pl
* @version $Id: edit_update.inc.php,v 2.33 2006/01/23 14:49:41 scalak Exp $
*
* \@verified
* @package    edit
* \@lang
*/

if ($global_secure_test!=true) {
    die ("Forbidden");
}

require_once ("include/price.inc");
$my_price = new MyPrice;

// odczytaj dane z formularza
if (! empty($_POST['item'])) {
    $item=&$_POST['item'];
} else {
    die ("Forbidden: Unknown item");
}

// odczytaj dane z formularza
if (! empty($_REQUEST['item2'])) {
    $item2=&$_REQUEST['item2'];
}

// jesli zalaczono zdjecie, to wstaw nazwe tego zdjecia do bazy
if (! empty($item_upload['photo'])) {
    $item['photo']=$item_upload['photo'];
}

// start pdf & flash:
// jesli zalaczono Flash'a, to wstaw nazwe tego zdjecia do bazy
if (isset($item_upload['flash'])) {
    $item['flash']=$item_upload['flash'];
    $item['flash_html']=@$item_upload['flash_html'];
}

// jesli zalaczono PDF'a, to wstaw nazwe tego zdjecia do bazy
if (isset($item_upload['pdf'])) {
    $item['pdf']=$item_upload['pdf'];
}

// jesli zalaczono plik *.doc, to wstaw nazwe tego pliku do bazy
if (isset($item_upload['doc'])) {
    $item['doc']=$item_upload['doc'];
}
// end pdf & flash & doc:




// sprawdz czy wybrano jakas wartosc z elementow select
if (! empty($item2['producer'])) {
    $item['producer']=$item2['producer'];
}
if (! empty($item2['category1'])) {
    $item['category1']=$item2['category1'];
}
if (! empty($item2['category2'])) {
    $item['category2']=$item2['category2'];
}
if (! empty($item2['category3'])) {
    $item['category3']=$item2['category3'];
}
if (! empty($item2['category4'])) {
    $item['category4']=$item2['category4'];
}
if (! empty($item2['category5'])) {
    $item['category5']=$item2['category5'];
}

$item['category1'] = str_replace("\"", "''", $item['category1']);
$item['category2'] = str_replace("\"", "''", $item['category2']);
$item['category3'] = str_replace("\"", "''", $item['category3']);
$item['category4'] = str_replace("\"", "''", $item['category4']);
$item['category5'] = str_replace("\"", "''", $item['category5']);

// aktualizuj tabele kategorii i producentow, odczytaj id kategorii i producenta
require_once ("./include/edit.inc.php");
$edit_p = new EditProduct;
$edit_p->updateCategory($item);
$edit_p->updateProducer($item);

// sprawdz czy zmieniono cene, jesli nie to odczytaj dane pelne ze wszsytkimi miejscami po przecinku
require_once ("include/check_price_netto_brutto.inc.php");

// Sprawdz czy wprowadzono walute. Waluta jest przekazywana takze jako price_currency, ale dodatkwoo jest
// przekazywana zmienna id_currency, ktora sluzy do rozpoznania waluty i przelicznienia ceny
// do pola $item['price_brutto'] wprowadzamy obliczona na podstawie kursu waluty kwote brutto zakupu
// if (in_array("currency",$config->plugins)) {
    if (! empty($item['id_currency'])) {
        
        // start oblicz: cene brutto wg. kursu waluty
        $id_currency=&$item['id_currency'];
        $currency_val=$config->currency_data[$id_currency];
        
        // sprawdz jaka cene przekazano, netto, czy brutto
        if ($item['price_nb']=="netto") {
            $price_netto=$currency_val*$item['price_currency'];
            $item['price_currency']=$item['price_currency'];
            $price_brutto=$my_price->netto2brutto($price_netto,$item['vat'],false);
        } else {
            $price_brutto_currency=$item['price_currency'];
            $price_netto_currency=$my_price->brutto2netto($item['price_currency'],$item['vat'],false);
            $price_netto=$currency_val*$price_netto_currency;
            $price_brutto=$price_brutto_currency*$currency_val;
            $item['price_currency']=$price_netto_currency;
        }
        // end oblicz:
        
        if ($price_brutto>0) {
            $item['price_brutto']=$price_brutto;
        }
    } // end if (! empty($item['id_currency']))
// }  // end if (in_array("currency",$config->plugins))
// end


// start obsluga: ceny hurtowej (netto/brutto)
if ($item['price_2_nb']=="netto") {
    $item['price_brutto_2']=$my_price->netto2brutto($item['price_2'],$item['vat'],false);
} else  $item['price_brutto_2']=@$item['price_2'];
// end oblsuga:

// start jezeli produkt jest punktowy to nie ma ceny oraz wartosci vat
if (@$item['points']==1) {
	$item['price_currency']=0;
	$item['price_brutto']=0;
	$item['price_brutto_2']=0;
	$item['price_2']=0;
	$item['vat']=0;
	$item['xml_options2']="";
	$item['accessories']="";
}
// end
// magazyn
if(is_numeric($item['depository_num'])) {
    global $mdbd, $config;
    $res_depository = $mdbd->select("id", "depository", "user_id_main=?", array($item['user_id'] => 'text'), '', 'array');
    $min_num = $config->depository['general_min_num'];
    $num = (int)$item['depository_num'];
    $user_id_main = addslashes($item['user_id']);
    $id_deliverer = addslashes($item['deliverer_id']);
    if($mdbd->num_rows == 0) {
        $mdbd->insert("depository", "user_id_main, num, min_num, id_deliverer", "'$user_id_main', $num, $min_num, $id_deliverer");
    }
    else {
        $mdbd->update("depository", "num=$num, id_deliverer=$id_deliverer", "user_id_main=?", array($user_id_main => 'text'));
    }
    $res2 = $mdbd->select("user_id,num_from,num_to", "available", "1=1", array(), '', 'array');
    if(!empty($res2)) {
        $av_id = 0;
        reset($res2);
        while (($av_id == 0) && (list($key, $val) = each($res2))) {
            $a = $val['user_id'];
            $from = $val['num_from'];
            $to = $val['num_to'];
            if($to != '*') {
                if (($from <= $num) && ($num <= $to)) {
                    $av_id = $a;
                }
            }
            else {
                $last_id = $a;
            }
        }
        if($av_id == 0) {
            $av_id = $last_id;
        }
        $item['id_available'] = $av_id;
    }
}
// end magazyn

// aktualizuj dane produktu
$query="UPDATE main SET name_L0=?, price_brutto=?, id_currency=?,
                        vat=?, price_brutto_detal=?, photo=?,
                        producer=?, category1=?, category2=?,
                        category3=?, category4=?, category5=?,
                        id_producer=?, id_category1=?, id_category2=?,
                        id_category3=?, id_category4=?, id_category5=?,
                        main_page=?, newcol=?, promotion=?, bestseller=?,
                        price_brutto_2=?, id_available=?,
                        accessories=?, hidden_price=?, 
                        price_currency=?, discount=?,
                        max_discount=?,
                        main_keys_online=?,active=?,
                        pdf=?, flash=?, flash_html=?, doc=?, ask4price=?, status_vat=?, weight=?, link_url=?, link_name=?,
                        points=?, points_value=?, sms=?
        WHERE id=?";

if (empty($item['id_currency'])) $item['id_currency']=1;
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$item['name']);
    $db->QuerySetText($prepared_query,2,$item['price_brutto']);
    $db->QuerySetText($prepared_query,3,$item['id_currency']);
    $db->QuerySetText($prepared_query,4,$item['vat']);
    $db->QuerySetText($prepared_query,5,$item['price_brutto_detal']);
    $db->QuerySetText($prepared_query,6,$item['photo']);
    $db->QuerySetText($prepared_query,7,$item['producer']);
    $db->QuerySetText($prepared_query,8,$item['category1']);
    $db->QuerySetText($prepared_query,9,$item['category2']);
    $db->QuerySetText($prepared_query,10,$item['category3']);
    $db->QuerySetText($prepared_query,11,$item['category4']);
    $db->QuerySetText($prepared_query,12,$item['category5']);
    $db->QuerySetText($prepared_query,13,$item['id_producer']);
    $db->QuerySetText($prepared_query,14,$item['id_category1']);
    $db->QuerySetText($prepared_query,15,$item['id_category2']);
    $db->QuerySetText($prepared_query,16,$item['id_category3']);
    $db->QuerySetText($prepared_query,17,$item['id_category4']);
    $db->QuerySetText($prepared_query,18,$item['id_category5']);
    $db->QuerySetText($prepared_query,19,@$item['main_page']);
    $db->QuerySetText($prepared_query,20,@$item['newcol']);
    $db->QuerySetText($prepared_query,21,@$item['promotion']);
    $db->QuerySetText($prepared_query,22,@$item['bestseller']);
    $db->QuerySetText($prepared_query,23,@$item['price_brutto_2']);
    $db->QuerySetText($prepared_query,24,@$item['id_available']);
    $db->QuerySetText($prepared_query,25,@$item['accessories']);
    $db->QuerySetText($prepared_query,26,@$item['hidden_price']);
    $db->QuerySetText($prepared_query,27,@$item['price_currency']);
    $db->QuerySetText($prepared_query,28,@$item['discount']);
    $db->QuerySetText($prepared_query,29,@$item['max_discount']);
    $db->QuerySetText($prepared_query,30,@$item['main_keys_online']);
    
    $db->QuerySetText($prepared_query,31,@$item['active']);
    
    // start flash & pdf & doc
    $db->QuerySetText($prepared_query,32,@$item['pdf']);
    $db->QuerySetText($prepared_query,33,@$item['flash']);
    $db->QuerySetText($prepared_query,34,@$item['flash_html']);
    $db->QuerySetText($prepared_query,35,@$item['doc']);
    // end flash & pdf & doc
    
    $db->QuerySetText($prepared_query,36,@$item['ask4price']);
    $db->QuerySetText($prepared_query,37,@$item['status_vat']);
    $db->QuerySetText($prepared_query,38,@$item['weight']);
    $db->QuerySetText($prepared_query,39,@$item['link_url']);
    $db->QuerySetText($prepared_query,40,@$item['link_name']);
    $db->QuerySetText($prepared_query,41,@$item['points']);
    $db->QuerySetText($prepared_query,42,@$item['points_value']);
    $db->QuerySetText($prepared_query,43,@$item['sms']);
    
    $db->QuerySetText($prepared_query,44,$id);
    
    $result=$db->ExecuteQuery($prepared_query);
    if ($result==0) {
        die ($db->Error());
    }
} else {
    die ($db->Error());
} // end if

if (@$item['points']=="1"){
$xml_options='0';
 $query="UPDATE main SET xml_options=? WHERE id=?";
    $prepared_query=$db->PrepareQuery($query);
    if ($prepared_query) {
        $db->QuerySetText($prepared_query,1,$xml_options);
        $db->QuerySetInteger($prepared_query,2,$id);
        $result=$db->ExecuteQuery($prepared_query);
        if ($result!=0) {
            // xml_options zostalo poprawnie zaktualizowane
        } else die ($db->Error());
}
}else{
// jesli uzytkownik wprowadzil skrocna wartosc xml_options, to nadpisz wartosc z bazy
$xml_options=@$item['xml_options2'];
if (! empty($item['xml_options'])) {
    $xml_options=$item['xml_options'];
    $query="UPDATE main SET xml_options=? WHERE id=?";
    $prepared_query=$db->PrepareQuery($query);
    if ($prepared_query) {
        $db->QuerySetText($prepared_query,1,$item['xml_options']);
        $db->QuerySetInteger($prepared_query,2,$id);
        $result=$db->ExecuteQuery($prepared_query);
        if ($result!=0) {
            // xml_options zostalo poprawnie zaktualizowane
        } else die ($db->Error());
    } else die ($db->Error());
} // end if
}
?>
