<?PHP
/**
 * Funckje zwiazane z obsluga platnosciPl
 *
 * @author Robert Diak
 */

class allpay {
     /**
     * Konstruktor obiektu 
     */
    function allpay($amount) {
        global $allpay_config;
        $this->_amount=$amount;
        return true;
    } // end func platnoscipl
    
     /**
     * Zamien kwote na format dla Platnosci tj. na kwote wyrazona w groszach
     * 
     * @param real $price
     * @return int kwota do zaplaty w groszach
     */
    function price($price) {
        $price=number_format($price,2,".","");
        return intval($price*100);
    } // end
    
    /**
     * Enter description here...
     *
     * @return unknown
     */
    function form() {
        global $_SERVER;
        global $sess;
        global $allpay_config;
        global $lang;
        global $_SESSION;
        global $config;
        global $_REQUEST;
        global $shop;
        $shop->currency();
            $o="";
            $o.="<form action=\"".$allpay_config->allpay_out_url."\" method=\"POST\" name=\"payform\">\n";
            $o.="<input type=\"hidden\" name=\"id\" value=\"".$allpay_config->allpay_id."\">\n";
            $o.="<input type=\"hidden\" name=\"amount\" value=\"".$this->_amount."\">\n";
            $o.="<input type=\"hidden\" name=\"description\" value=\"".$_SESSION['global_order_id']."\">\n";
            $o.="<input type=\"hidden\" name=\"currency\" value=\"".$config->currency_name[$_SESSION['__currency']]."\">\n";
            $o.="<input type=\"hidden\" name=\"lang\" value=\"".$config->lang."\">\n";
            $o.="<input type=\"hidden\" name=\"channel\" value=\"".$allpay_config->allpay_channel."\">\n";
            $o.="<input type=\"hidden\" name=\"ch_lock\" value=\"".$allpay_config->allpay_ch_lock."\">\n";
            $o.="<input type=\"hidden\" name=\"onlinetransfer\" value=\"".$allpay_config->allpay_onlinetransfer."\">\n";
            $o.="<input type=\"hidden\" name=\"URL\" value=\"http://".$config->www."/".$allpay_config->allpay_url."\">\n"; 
            $o.="<input type=\"hidden\" name=\"type\" value=\"".$allpay_config->allpay_type."\">\n"; 
            $o.="<input type=\"hidden\" name=\"txtguzik\" value=\"".$allpay_config->allpay_txtguzik."\">\n"; 
            $o.="<input type=\"hidden\" name=\"buttontext\" value=\"".$allpay_config->allpay_buttontext."\">\n"; 
            $o.="<input type=\"hidden\" name=\"URLC\" value=\"http://".$config->www."/".$allpay_config->allpay_urlc."\">\n"; 
            $o.="<input type=\"hidden\" name=\"control\" value=\"".$_SESSION['order_session']."\">\n";
            $o.="<input type=\"hidden\" name=\"firstname\" value=\"".$_SESSION['form']['name']."\">\n";
            $o.="<input type=\"hidden\" name=\"surname\" value=\"".$_SESSION['form']['surname']."\">\n";
            $o.="<input type=\"hidden\" name=\"email\" value=\"".$_SESSION['form']['email']."\">\n";
            $o.="<input type=\"hidden\" name=\"street\" value=\"".$_SESSION['form']['street']."\">\n";
            $o.="<input type=\"hidden\" name=\"street_n1\" value=\"".$_SESSION['form']['street_n1']."\">\n";
            $o.="<input type=\"hidden\" name=\"street_n2\" value=\"".$_SESSION['form']['street_n2']."\">\n";
            $o.="<input type=\"hidden\" name=\"city\" value=\"".$_SESSION['form']['city']."\">\n";
            $o.="<input type=\"hidden\" name=\"postcode\" value=\"".$_SESSION['form']['postcode']."\">\n";
            $o.="<input type=\"hidden\" name=\"phone\" value=\"".$_SESSION['form']['phone']."\">\n";
            $o.="<input type=\"hidden\" name=\"country\" value=\"".$config->country_select[$_SESSION['form']['country']]."\">\n";
            //$o.="<input type=\"hidden\" name=\"code\" value=\"Jaki kod\">\n";
            $o.="<input type=\"hidden\" name=\"p_info\" value=\"".$config->merchant['name']."\">\n";
            $o.="<input type=\"hidden\" name=\"p_email\" value=\"".$config->order_email."\">\n";
            $o.="<input type=\"submit\" value=\"$lang->register_allpay_order\">\n";
            $o.="</form>\n";
        print $o;
    } // end func form
} // end class
?>