<?PHP
/**
 * Funckje zwiazane z obsluga platnosciPl
 *
 * @author Robert Diak
 */

class platnoscipl {

    /**
     * Enter description here...
     *
     * @var unknown
     */
    var $_posId='';                 // numer posId merchanta
    /**
     * Enter description here...
     *
     * @var unknown
     */
    var $_amount='';                // kwota do zaplaty
    /**
     * Enter description here...
     *
     * @var unknown
     */
    var $_description='';           // opis platnosci
    /**
     * Enter description here...
     *
     * @var unknown
     */
    var $_sms=array("122","244","366","610","732","1098");

    /**
     * Pierwsze dwie litery pierwszego klucza md5
     *
     * @var string
     */
    var $_key1='';
    
    var $_js_function='PlnDrawRadioImg(4);';
    
    /**
     * Konstruktor obiektu 
     */
    function platnoscipl($amount) {
        global $platnoscipl_config;
        $this->_posId=$platnoscipl_config->pl_pos_id;
        $this->_key1=substr($platnoscipl_config->pl_md5_one,0,2);
        $this->_amount=$amount;
        if (!empty($platnoscipl_config->draw_type)) {
        	if ($platnoscipl_config->draw_type=="radioimg") {
        		$this->_js_param=@$platnoscipl_config->js_param;
        		if (empty($this->_js_param)) {
        			$this->_js_param=4;
        		}
        		$this->_js_function="PlnDrawRadioImg($this->_js_param);";
        	} else if ($platnoscipl_config->draw_type=="radio") {
        		$this->_js_function="PlnDrawRadio();";
        	} else if ($platnoscipl_config->draw_type=="select") {
        		$this->_js_function="PlnDrawSelect();";
	        }
        }
        $this->_description=@$platnoscipl_config->pl_description;
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
    function check_product()
    {
        global $_SESSION;
        global $lang;
        if(!in_array($this->price($this->_amount),$this->_sms)) {
            print "<table cellpadding=\"2\" cellspacing=\"2\" width=\"60%\"><tr><td align=left><font color=red>".$lang->info_bad_value."</td></tr></table>";
            return false;
        }
        $status=1;
        $data=array();
        foreach($_SESSION['global_basket_data']['items'] as $key => $value ) {
            if(empty($value['data']['sms'])) {
                $status=0;
                array_push($data,$value);
            }
        }
        if(!$status) {
            print "<table cellpadding=\"2\" cellspacing=\"2\" width=\"60%\"><tr><td align=left><font color=red>".$lang->info_no_sms."</td></tr></table>";
            print "<table border=0 cellpadding=\"2\" cellspacing=\"2\" width=\"60%\">";
            foreach($data as $key=>$value) {
                print "<tr bgcolor=\"#e0e0e0\"><td>".$value['user_id']."</td><td>".$value['name']."</td><td>".$value['price']."</td></tr>";
            }
            print "</table><br><br>";
        }
        //print "<pre>";
        //print_r($data);
        //print "</pre>";

        if($status) return true;
        return false;
    } // end func

    /**
     * Enter description here...
     *
     * @return unknown
     */
    function form() {
        global $_SERVER;
        global $sess;
        global $platnoscipl_config;
        global $lang;
        global $_SESSION;
        global $config;
        global $_REQUEST;
        global $shop;
        $shop->currency();
        if(@$_REQUEST['sms'] && $this->check_product()) {
            $o="";
            $o.="<form action=\"https://www.platnosci.pl/paygw/ISO/NewSMS\" method=\"POST\" name=\"smsform\">\n";
            $o.="<input type=\"hidden\" name=\"pos_id\" value=\"".$this->_posId."\">\n";
            $o.="<input type=\"hidden\" name=\"session_id\" value=\"".$_SESSION['order_session']."\">\n";
            $o.="<input type=\"hidden\" name=\"amount\" value=\"".$this->price($this->_amount)."\">\n";
            $o.="<input type=\"hidden\" name=\"desc\" value=\"Sklep - zamówienie nr ".$_SESSION['global_order_id']."\">\n";
            $o.="<input type=\"hidden\" name=\"client_ip\" value=\"".$_SERVER['SERVER_ADDR']."\">\n";
            $o.="<input type=\"hidden\" name=\"js\" value=\"0\">\n";
            $o.="<input type=\"submit\" value=\"".$lang->register_platnoscipl_sms."\">\n";
            $o.="</form>";
        } else {
            $o="";
            $o.="<form action=\"https://www.platnosci.pl/paygw/ISO/NewPayment\" method=\"POST\" name=\"payform\">\n";
            $o.="<input type=\"hidden\" name=\"pos_id\" value=\"".$this->_posId."\">\n";
            $o.="<input type=\"hidden\" name=\"client_ip\" value=\"".$_SERVER['SERVER_ADDR'] ."\">\n";

            $o.="<input type=\"hidden\" name=\"session_id\" value=\"".$_SESSION['order_session']."\">\n";
            $o.="<input type=\"hidden\" name=\"js\" value=\"0\">\n";
            $o.="<input type=\"hidden\" name=\"amount\" value=\"".$this->price($this->_amount)."\">\n";
            $o.="<input type=\"hidden\" name=\"desc\" value=\"Sklep - zamówienie nr ".$_SESSION['global_order_id']."\">\n";
            $o.="<script language=\"JavaScript\" type=\"text/javascript\" src=\"https://www.platnosci.pl/paygw/ISO/js/".$this->_posId."/".$this->_key1."/paytype.js\">";
			$o.="</script>";
			$o.="<script language=\"JavaScript\" type=\"text/javascript\">";
			$o.=$this->_js_function;
			$o.="</script>";
            $o.="<br><br><input type=\"hidden\" name=\"first_name\" value=\"".$_SESSION['form']['name']."\">\n";
            $o.="<input type=\"hidden\" name=\"last_name\" value=\"".$_SESSION['form']['surname']."\">\n";
            $o.="<input type=\"hidden\" name=\"email\" value=\"".$_SESSION['form']['email']."\">\n";
            $o.="<input type=\"hidden\" name=\"street\" value=\"".$_SESSION['form']['street']."\">\n";
            $o.="<input type=\"hidden\" name=\"street_hn\" value=\"".$_SESSION['form']['street_n1']."\">\n";
            $o.="<input type=\"hidden\" name=\"street_an\" value=\"".$_SESSION['form']['street_n2']."\">\n";
            $o.="<input type=\"hidden\" name=\"post_code\" value=\"".$_SESSION['form']['postcode']."\">\n";
            $o.="<input type=\"hidden\" name=\"city\" value=\"".$_SESSION['form']['city']."\">\n";
            $o.="<input type=\"submit\" value=\"".$lang->register_platnoscipl_order."\">\n";
            $o.="</form>\n";
        }
        return $o;
    } // end func form
} // end class
?>