<?php
/**
 * Logowanie do systemu, odczytanie danych uzytkownika
 *
 * @author m@sote.pl
 * @version $Id: login.inc.php,v 2.21 2005/12/19 10:00:05 lukasz Exp $
* @package    users
 */

if (@$global_secure_test!=true) {
    die ("Bledne wywolanie");
}

// dane rabat w kategoriach i dla producentow
global $DOCUMENT_ROOT,$_SESSION;
$filed="$DOCUMENT_ROOT/../config/auto_config/discounts/".@$_SESSION['__discount_group']."_discounts_config.inc.php";
if ((! empty($_SESSION['__discount_group'])) && (file_exists($filed))) {
    @include_once ($filed);
}

class LoginUsers {

    var $form=array();
    var $form_cor=array();
    
    /**
     * Sprawdz czy login i haslo sa OK. Zaloguj uzytkwonika
     *
     * \@globals array $this->form
     * \@globals array $this->form_cor
     * \@globals array $this->prv_key
     * \@globals int   $this->user['id_discounts_groups'] id grupy rabatowej
     * \@session int   $__id_discounts_groups             id grupy rabatowej
     * \@session int   $__id_sales                        id handlowca przypisanego do klienta
     * @return  bool  true - uzytkwonik zalogowany, false - nie
     */
    function login($login,$password) {
        global $config;
        global $db;
        global $sess;
        global $global_id_user;
        global $global_firm_login;
        global $mdbd;
        if (empty($password)) return false;
        
        require_once ("include/my_crypt.inc");
        $my_crypt = new MyCrypt;
        
        // klucz prywatny - od wersji 3.0 prv_key = pub_key
        $prv_key=md5($config->salt);
        $this->prv_key=$prv_key;        
        
        // zakodowany login zapisany w bazie
        $crypt_login=$my_crypt->endecrypt("",$login,"");
        $md5_password=md5($password);
        
        $query="SELECT * FROM users WHERE crypt_login=? AND crypt_password=?";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,$crypt_login);
            $db->QuerySetText($prepared_query,2,$md5_password);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {                    
                    // odczytaj dane z bazy i odkoduj je jesli sa zakodowane
                    $global_id_user=$db->FetchResult($result,0,"id");
                    $sess->register("global_id_user",$global_id_user); // zapisz id uzytkownika w bazie
                    
   	 	            // sprawdz czy uzytkwonik jest odbiorca hurtowym
		      	    $hurt=$db->FetchResult($result,0,"hurt");                
		            if ($hurt==1) {
                        // uzytkownik jest odbiorca hurtowym, zapamietaj ta informacje w sesji
                        $global_firm_login=$login;
                        $sess->register("global_firm_login",$global_firm_login);
                    }
                    
                    // dane billingowe                    
                    $this->form['firm']=$my_crypt->endecrypt($prv_key,$db->FetchResult($result,0,"crypt_firm"),"de");
                    $this->form['name']=$my_crypt->endecrypt("",$db->FetchResult($result,0,"crypt_name"),"de");
                    $this->form['surname']=$my_crypt->endecrypt("",$db->FetchResult($result,0,"crypt_surname"),"de");
                    $this->form['street']=$my_crypt->endecrypt($prv_key,$db->FetchResult($result,0,"crypt_street"),"de");
                    $this->form['street_n1']=$my_crypt->endecrypt($prv_key,$db->FetchResult($result,0,"crypt_street_n1"),"de");
                    $this->form['street_n2']=$my_crypt->endecrypt($prv_key,$db->FetchResult($result,0,"crypt_street_n2"),"de");
                    $this->form['postcode']=$my_crypt->endecrypt($prv_key,$db->FetchResult($result,0,"crypt_postcode"),"de");
                    $this->form['nip']=$my_crypt->endecrypt($prv_key,$db->FetchResult($result,0,"crypt_nip"),"de");
                    $this->form['city']=$my_crypt->endecrypt($prv_key,$db->FetchResult($result,0,"crypt_city"),"de");
                    $this->form['phone']=$my_crypt->endecrypt($prv_key,$db->FetchResult($result,0,"crypt_phone"),"de");
                    $this->form['email']=$my_crypt->endecrypt("",$db->FetchResult($result,0,"crypt_email"),"de");
                    $this->form['country']=$my_crypt->endecrypt("",$db->FetchResult($result,0,"crypt_country"),"de");
                    $this->form['description']=$my_crypt->endecrypt("",$db->FetchResult($result,0,"crypt_user_description"),"de");
                    // szuflujemy obecnymi katalogiami zeby lokalne includy koszyka byly dostepne dla skryptow
					$old_dir=getcwd();
					global $DOCUMENT_ROOT;
					$path_to_basket=$DOCUMENT_ROOT."/go/_basket/";
					chdir($path_to_basket);
					require_once("./include/my_ext_basket.inc.php");
					chdir($old_dir);
//					$basket=&new My_Ext_Basket();
					$wishlist=&new My_Ext_Basket('wishlist');
//                    $basket->_id_basket=$db->FetchResult($result,0,"id_basket");
                    $wishlist->_id_basket=$db->FetchResult($result,0,"id_wishlist");
//                    $basket->_load_from_db();
                    $wishlist->_load_from_db();
//                    $basket->register();
                    $wishlist->register();
                    // zapamietaj handlowca
                    $this->form['id_sales']=$db->FetchResult($result,0,"id_sales");
                    if (@$this->form['id_sales']>0) {
                        global $__id_sales;
                        $__id_sales=$this->form['id_sales'];
                        $sess->register("__id_sales",$__id_sales);
                    }
                    // end

                    // dane korespondencyjne                    
                    $this->form_cor['firm']=$my_crypt->endecrypt($prv_key,$db->FetchResult($result,0,"crypt_cor_firm"),"de");
                    $this->form_cor['name']=$my_crypt->endecrypt($prv_key,$db->FetchResult($result,0,"crypt_cor_name"),"de");
                    $this->form_cor['surname']=$my_crypt->endecrypt($prv_key,$db->FetchResult($result,0,"crypt_cor_surname"),"de");
                    $this->form_cor['street']=$my_crypt->endecrypt($prv_key,$db->FetchResult($result,0,"crypt_cor_street"),"de");
                    $this->form_cor['street_n1']=$my_crypt->endecrypt($prv_key,$db->FetchResult($result,0,"crypt_cor_street_n1"),"de");
                    $this->form_cor['street_n2']=$my_crypt->endecrypt($prv_key,$db->FetchResult($result,0,"crypt_cor_street_n2"),"de");
                    $this->form_cor['postcode']=$my_crypt->endecrypt($prv_key,$db->FetchResult($result,0,"crypt_cor_postcode"),"de");
                    $this->form_cor['city']=$my_crypt->endecrypt($prv_key,$db->FetchResult($result,0,"crypt_cor_city"),"de");
                    $this->form_cor['phone']=$my_crypt->endecrypt($prv_key,$db->FetchResult($result,0,"crypt_cor_phone"),"de");
                    $this->form_cor['email']=$my_crypt->endecrypt($prv_key,$db->FetchResult($result,0,"crypt_cor_email"),"de");

                    // punkty klienta
                    //$this->form['points']=$db->FetchResult($result,0,"points");
                    // odczytanie punktów klienta z tablicy users_points
                    $this->form['points']=$mdbd->select("points","users_points","id_user=?",array($global_id_user=>"int"));

                    // odczytaj id grupy rabatowej uzytkownika i zapamietaj w sesji
                    $this->user['id_discounts_groups']=$db->Fetchresult($result,0,"id_discounts_groups");
                    global $__id_discounts_groups;
                    $__id_discounts_groups=$this->user['id_discounts_groups'];
                    if (! empty($__id_discounts_groups)) {
                        $sess->register("__id_discounts_groups",$__id_discounts_groups);     
                        
                        // start promotions:
                        // usun globalne promocje, zeby sie nie pokrywaly z grupami rabatowymi
                        $sess->unregister("__promotions");                        
                        // end promotions:
                        
                        global $__user_discount,$discounts_config;
                        global $DOCUMENT_ROOT;                        
                        
                        global $shop;
                                          
                        if (! $shop->home) {
                            $filed="$DOCUMENT_ROOT/../config/auto_config/discounts/".@$_SESSION['__id_discounts_groups']."_discounts_config.inc.php";
                        } else {
                            $filed="/base/config/auto_config/discounts/".@$_SESSION['__id_discounts_groups']."_discounts_config.inc.php";
                        }
                        
                        if ((! empty($_SESSION['__id_discounts_groups'])) && (file_exists($filed))) {
                            @include_once ($filed);
                        }

                        if (! empty($discounts_config->default_discounts[$__id_discounts_groups])) {
                            $__user_discount=$discounts_config->default_discounts[$__id_discounts_groups];
                            $sess->register("__user_discount",$__user_discount);
                        }
                        $shop->basket();
                        $shop->basket->reload();
                    }
                    // end

                    return true;
                } else return false;
            } else die ($db->Error());
        } else die ($db->Error());
    } // end login()

} // end class LoginUsers

?>
