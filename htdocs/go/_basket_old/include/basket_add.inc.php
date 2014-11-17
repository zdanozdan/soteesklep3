<?php
/**
* Dodaj produkt do koszyka.
*
* Skrypt powoduje dodanie do koszyka produktu o ID ($_REQUEST['id']). Sprawdzane s± opcje produktu i na tej podstawie
* dodawany jest nowy produkt, lub ilo¶æ danego produktu w koszyku zmienia siê (je¶li wszystkie parametry opcji siê 
* zgadzaj±).<br />
* Skrypt obs³uguje tak¿e dodawanie produktów na podstawie atrybutów.
*
* <br /><br />
* \@global string $global_request_m5       suma konktrolna przekazywanych parametrów<br />
* \@global string $global_prev_request_md5 poprzednia suma kontrolna (z poprzedniego wywo³ania strony)<br />
* \@global array  $__add_basket_category   tablica z danymi kategorii i producenta dodawanego do koszyka produktu<br /
* \@session array $products_lang_name tablica id=>array(de=>de_name,en=>en_name) tablica z t³umaczeniami nazw produktów z koszyka<br />
*
* @author  m@sote.pl
* @version $Id: basket_add.inc.php,v 2.32 2006/05/12 14:31:55 lukasz Exp $
*
* @todo dodaæ obs³ugê dodawania okre¶lonej ilo¶ci produktów do koszyka przez wykorzystanie parametru "num", dodaæ obs³uge enduser'ow±
* @package    basket
* \@lang
*/

/**
* Definiuj warto¶c okre¶laj±c±, ¿e na stronie prezentacji systemów p³atno¶ci, mog± pokazaæ siê tylko
* p³atno¶ci z wiarygodn± autoryzacj± on-line. Dotyczy sprzeda¿y kodów/plików itp. on-line.
*/
define ("PAY_METHOD_ONLINE",1);

global $config;
// nie zezwalaj na bezposrednie wywolanie tego pliku
if ((empty($global_secure_test)) || (! empty($_REQUEST['global_secure_test']))) {
    die ("Forbidden");
}

$reload=false;
if (! empty($global_prev_request_md5)) {
    if ($global_prev_request_md5==$global_request_md5) {
        // wywolano reload w koszyku, zapamietaj zeby nie dodawac produktu
        $reload=true;
    }
}

// odczytaj numer id produktu, ktory jest dodawany do koszyka
// jesli id nie jest puste, to produkt jest dodawany do ksozyka,
// w przeciwnym razie przedstawiany jest tylko status koszyka
$id="";
if (!empty($_REQUEST['id'])) {
    $id=$_REQUEST['id'];
}
$num = intval(@$_REQUEST['num']);
if(($num == '') || ($num == 0))
$num = 1;



if ((! empty($id)) && ($reload==false) && (@$_SESSION['basket_add_lock']!=1)) {
    
    // aktywuj blokade cofniêcia siê do koszyka poprzez BACK
    $basket_add_lock=1;
    $sess->register("basket_add_lock",$basket_add_lock);
    // end
    
    // zapytanie o wlaciwosci rekordu
    $query = "SELECT * FROM main WHERE id=?";
    $prepared_query=$db->PrepareQuery($query);
    $db->QuerySetText($prepared_query,1,"$id");
    $result=$db->ExecuteQuery($prepared_query);
    
    $my_price =& new MyPrice;
    
    if ($result==0) {
        $db->Error();
    }
    
    $id=$db->FetchResult($result,0,"id");
    $user_id=$db->Fetchresult($result,0,"user_id");
    $points_value=$db->Fetchresult($result,0,"points_value");
    // odczytaj nazwy w aktywnych jezykach
    $name=$db->FetchResult($result,0,"name_L0");
    for($i = 0; $i < count($config->langs_active); $i++) {
        if($config->langs_active[$i] == 1) {
            $lang_name[$config->langs_symbols[$i]]=$db->FetchResult($result,0,"name_L" . $i);
            $lang_name[$i]=$lang_name[$config->langs_symbols[$i]];
            if (empty($lang_name[$config->langs_symbols[$i]])) {
                $lang_name[$config->langs_symbols[$i]] = $name;
                $lang_name[$i] = $name;
            }
        }
    }
    
    // zapamiêtaj w sesji t³umaczenia zakupionych produktów
    if (! empty($_SESSION['products_lang_name'])) {
        $products_lang_name=$_SESSION['products_lang_name'];
    } else $products_lang_name=array();
    $products_lang_name[$name]=$lang_name;
    $sess->register("products_lang_name",$products_lang_name);   
    // end
    
    $producer=$db->FetchResult($result,0,"producer");
    $price_brutto=$my_price->price($result,0,'');
    $vat=$db->FetchResult($result,0,"vat");
    $xml_options=$db->FetchResult($result,0,"xml_options");
    $weight=$db->FetchResult($result,0,"weight");
    $sms=$db->FetchResult($result,0,"sms");

    // zapamietaj do jakiej kategorii nalezy dodawany produkt; informacja ta bedzie wykorzytana
    // do stworzenia linku do kategorii produtku w celu kontynuwoania zakupow w danej kategorii
    $__add_basket_category['id_category1']=$db->Fetchresult($result,0,"id_category1");
    $__add_basket_category['id_category2']=$db->Fetchresult($result,0,"id_category2");
    $__add_basket_category['id_category3']=$db->Fetchresult($result,0,"id_category3");
    $__add_basket_category['id_category4']=$db->Fetchresult($result,0,"id_category4");
    $__add_basket_category['id_category5']=$db->Fetchresult($result,0,"id_category5");
    $__add_basket_category['category1']=$db->Fetchresult($result,0,"category1");
    $__add_basket_category['category2']=$db->Fetchresult($result,0,"category2");
    $__add_basket_category['category3']=$db->Fetchresult($result,0,"category3");
    $__add_basket_category['category4']=$db->Fetchresult($result,0,"category4");
    $__add_basket_category['category5']=$db->Fetchresult($result,0,"category5");
    $__add_basket_category['id_producer'] =$db->Fetchresult($result,0,"id_producer");
    $__add_basket_category['producer'] =$db->Fetchresult($result,0,"producer");
    
    // sprawdz czy wybrano opcje zmeiniajaca cene produktu
    if (! empty($_REQUEST['options'])) {
        require_once ("./include/price_xml_options.inc.php");
        $price_xml_options = new Price_XML_Options;
        $price_xml_options->result=&$result;
        //$price_brutto=$price_xml_options->get_price($price_brutto,$xml_options);
        $price_brutto=$price_xml_options->get_price($price_brutto,$xml_options,$db->fetchResult($result,0,"id_currency"),$db->fetchResult($result,0,"price_currency"));
    }
    
    $data['category']=$__add_basket_category;
    
    // dodatkowe atrybuty rekordu zapamietywane w koszyku
    $data['currency']=$config->currency;
    $data['vat']=$vat;
    $data['user_id']=$user_id;
    $data['weight']=$weight;
    $data['lang_names'] = $lang_name;
    $data['sms']=$sms;
    
    
    // dodaj opcje do koszyka o ile zostaly przekazane w wywolaniu
    if (! empty($_REQUEST['options'])) {
        $data['options']=$_REQUEST['options'];
        // jesli nazwa nie jest wartoscia parametru, to odczytaj ja (z okreslonego formatu)
        $_object=$price_xml_options->my_xml_options;
        if (method_exists($_object,"getName")) {
            reset($data['options']);
            foreach ($data['options'] as $key=>$val) {
                $data['options'][$key]=$price_xml_options->my_xml_options->getName($val);
            }
        } // end if method_exists
    } else {
        $data['options']='';
    }
                
    // dodaj produkt do koszyka
    $pos=$basket->getId($id,$data);
    if ($pos>0) {
        // sprawdz czy produkt ma opcje, jesli ma to sprawdz czy uzytkwonik
        // dodaje produkt z ta sama opcja. jelsi tak to normalnie dodaj produkt, zwiekszajac ilosc o 1;
        // jesli nie, to potraktuj to jako dodanie nowego produktu
        
        if (! empty($data['options'])) {
            $data_current=$basket->getData($pos);
            $options_current=@$data_current['options'];
            // produkt w koszyku posiada opcje
            if ($options_current==@$data['options']) {
                // opcje tego samego produktu sa takie same - zwieksz ilosc o 1
                $quantity=$basket->getNum($pos);
                $data_current=$basket->getData($pos);
                $quantity=$quantity+$num;
                $basket->setNum($pos,$quantity);
                $basket->setData($pos,$data);
            } else {
                // opcje tego samego produktu sa rozne
                $basket->add($id,$name,$num,$price_brutto,$data,$points_value);
            }
        } else {
        	// jako ¿e produktukow jest wiecej - zwiekszamy ich ilosc
        	$data_current=$basket->getData($pos);
            $options_current=@$data_current['options'];
            $quantity=$basket->getNum($pos);
            $data_current=$basket->getData($pos);
            $quantity=$quantity+$num;
            $basket->setNum($pos,$quantity);
            $basket->setData($pos,$data);
            // produkt w koszyku posiada opcje
            
//            $basket->add($id,$name,$num,$price_brutto,$data,$points_value);
        } // end if ($pos>0)        
        // end (! $_REQUEST['music'])     
    } else {
        // zapamiêtaj informacjê, ¿e dla sprzeda¿y danych on-line mo¿na wy¶wietliæ tylko 
        // p³atno¶ci z potwierdzeniem on-line
        $__register_pay_method_requires=PAY_METHOD_ONLINE;
        $sess->register("__register_pay_method_requires",$__register_pay_method_requires);
        $basket->add($id,$name,$num,$price_brutto,$data,$points_value);
    }
    
    // w poni¿szych sytuacjach A i B nie zmieniamy ilo¶ci przy dodwaniau (takie za³o¿enie, które pó¼niej mo¿na zmieniæ)
    // A: jesli sa jakies produkty przekazane przez zmienna $_REQUEST['basket'], to dodaj je domyslnie do koszyka
    if (! empty($_REQUEST['basket'])) {
        $add_basket=$_REQUEST['basket'];
        foreach ($add_basket as $add_id=>$on) {
            $dat=$mdbd->select($config->select_main_price_list,"main","id=?",array($add_id=>"text"),"LIMIT 1");

            for($i = 0; $i < count($config->langs_active); $i++) {
                if($config->langs_active[$i] == 1) {
                    $lang_nameA[$config->langs_symbols[$i]]=$dat["name_L" . $i];
                    $lang_nameA[$i]=$lang_nameA[$config->langs_symbols[$i]];
                    if (empty($lang_nameA[$config->langs_symbols[$i]])) {
                        $lang_nameA[$config->langs_symbols[$i]] = $dat['name_L0'];
                        $lang_nameA[$i] = $dat['name_L0'];
                    }
                }
            }
            $dat['lang_names'] = $lang_nameA;
            $add_price=$my_price->price($mdbd->result);
            $basket->add($dat['id'],$dat['name_L0'],1,$add_price,$dat,$points_value);
        } // end foreach
    }
    // end
    
    // B: produkty z listy (kategorii) z atrybutow / konfigurator
    // jesli sa jakies produkty przekazane przez zmienna $_REQUEST['basket_cat'], to dodaj je domyslnie do koszyka
    $noempty = false;
    if ((! empty($_REQUEST['basket_cat']))) {
        reset($_REQUEST["basket_cat"]);
        while (list($bc_key, $bc_val) = each($_REQUEST['basket_cat'])) {
        	if(!empty($bc_val))
        	   $noempty = true;
        }
    }
    
    if ($noempty) {
        $add_basket=$_REQUEST['basket_cat'];
        foreach ($add_basket as $key=>$add_id) {
        	if (!empty($add_id)) {
	            $dat=$mdbd->select($config->select_main_price_list,"main","id=?",array($add_id=>"text"),"LIMIT 1");
	            
	            for($i = 0; $i < count($config->langs_active); $i++) {
	                if($config->langs_active[$i] == 1) {
	                    $lang_nameB[$config->langs_symbols[$i]]=$dat["name_L" . $i];
	                    $lang_nameB[$i]=$lang_nameB[$config->langs_symbols[$i]];
	                    if (empty($lang_nameB[$config->langs_symbols[$i]])) {
	                        $lang_nameB[$config->langs_symbols[$i]] = $dat['name_L0'];
	                        $lang_nameB[$i] = $dat['name_L0'];
	                    }
	                }
	            }
	            $dat['lang_names'] = $lang_nameB;
	
	            $add_price=$my_price->price($mdbd->result);
	            $basket->add($dat['id'],$dat['name_L0'],1,$add_price, $dat,$points_value);
        	}
        } // end foreach
    } // end
} // end if (! empty($id))
?>