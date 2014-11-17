<?php
/**
* Obsluga atrybutow do produktow, typ "multi"
* Zmiana atrybutu, ceny, zdjecia, prezenatcja atrybutow
*
* @author  m@sote.pl lech@sote.pl
* @version $Id: multi_group.inc,v 1.3 2007/12/01 11:09:43 tomasz Exp $
* @package    include
* \@lang
*/

require_once ("HTML/Form.php");
require_once ("include/price.inc");
require_once("include/lang_functions.inc");

define ('ATTR_MAX_NUM',10);            // maksymalna ilosc atrybutow
define ('ATTR_MAX_ELEMENTS_NUM',5000); // maksymalna ilosc opcji danego atrybutu
define ('ATTR_MAX_CAT_LIST',100);      // maksymalna ilosc produktow z kategorii na liscie
define ('ATTR_MAX_OPTIONS',3);         // maksymalna liczba opcji przy danej opcji np. nazwa, cena, zdjecie

class MultiGroup {
	/**
    * @var bool zmianna okreslajaca czy wyswietlana bedzie lista z obsluga zmiany zdjecia
    */
	var $_allow_change_image=true;

	/**
    * @var bool zmienna okreslajaca, czy w danej liscie zostala wywolana zmiana zdjecia
    */
	var $_change_image=false;

	/**
    * @var float $price_brutto  wartosc zakupu wg atrybutow
    */
	var $_price_brutto=0;

	/**
    * @var bool $_set_price informacja o tym, czy w formularzyu jest opcja zmiany ceny
    */
	var $_set_price=false;

	/**
    * Tablica powiazan nazwa opcji => nazwa elementu formularza np. Rozmiar=>"attr2"
    */
	var $_names=array();

	/**
    * @var string typ opcji (multi|music|...)
    * @access private
    */
	var $_type="multi";

	/**
    * Konstruktor
    */
	function MultiGroup () {
		global $rec,$config,$shop;
		global $__xml_options_type;

		if (! empty($__xml_options_type)) $this->_type=$__xml_options_type;

		if ($shop->admin) $action='#';
		//else $action=$config->url_prefix."/go/_basket/index.php";
                else $action=$config->url_prefix."/go/_basket/basket_redirect.php";
		if ($shop->admin) $action1='#';
		//else $action1=$config->url_prefix."/go/_basket/index3.php";
                $action1=$config->url_prefix."/go/_basket/basket_redirect.php?destination=wishlist";
		$this->forms = new HTML_Form($action,"POST","attrib");
		//        $this->forms1 = new HTML_Form($action1,"POST","attrib");

		if ($this->_type=="music") {
			// dla typu "music" nie dodawaj g³ównego produktu przy dodaniu do koszyka
			// opcja przenaczona do zakupu utworów on-line, generowanych przez atrybuty
			// lista utworów do wyboru z listy typu "checkbox"
			$this->forms->addHidden("music",1);
			//            $this->forms1->addHidden("music",1);
		}
		//        $this->forms1->addHidden("id",@$rec->data['id']);

		$this->my_price =& new MyPrice;

		return(0);
	} // end MultiGroup

	/**
    * @var array grupy atrybutow
    */
	var $_groups=array();

	var $_num=1; // numer porzadkowy atrybutu

	/**
    * Wyswietl prezentacje atrybutow do produktu
    *
    * @param &$result wynik zapytania z bazy danych
    *
    * @access public
    * @return none
    */
	function show(&$result)
	{
		global $db,$config,$lang, $shop, $theme, $rec;

		if ($shop->admin)
		{
			$action1='#';
			$this->result=&$result;

			include_once ("lib/JavaScripts/imgChange.js");
			include_once ("lib/JavaScripts/selectChange.js");
			$temp_db=$db->FetchResult($result,0,'xml_options');
			$this->_SelectGroups($temp_db);
			$this->forms->addHidden("id",@$rec->data['id']);
			$this->forms->addHidden('attr_memory','null');
			//        $this->forms1->addHidden('attr_memory','null');
			$this->_showForm();
		}
		else
		{
                   //   $action1=$config->url_prefix."/go/_basket/index3.php";
                        $action1=$config->url_prefix."/go/_basket/basket_redirect.php?destination=wishlist";

			$this->result=&$result;

			include_once ("lib/JavaScripts/imgChange.js");
			include_once ("lib/JavaScripts/selectChange.js");
			$temp_db=$db->FetchResult($result,0,'xml_options');
			$this->_SelectGroups($temp_db);


			////////////////////////////////////////////////////////////////////////////////////////////
			//TZ
			$this->forms->addHidden("id",@$rec->data['id']);
			$this->forms->addHidden("basket_action","add");

			// $this->forms->addImage('add2basket', "<a onclick=\"document.forms['attrib'].submit(); \" style='cursor: pointer;'>" .
			// $lang->basket_add .
			// "</a>", $theme->filepath("_img/_bmp/" . $config->theme_config['icons']['basket']), "style='border-width: 0px;'" , "first");

			// $this->forms->addImage('add2basket', "<br/><a onclick=\"document.forms['attrib'].action='$action1'; document.forms['attrib'].submit(); \" style='cursor: pointer;'>" . $lang->wishlist_add . "</a>",
			// $theme->filepath("_img/_bmp/" . $config->theme_config['icons']['wishlist']), "onclick=\"this.form.action='$action1'\" style='border-width: 0px;'" , "last");


			// element, pod ktorym beda (przez skrypt JS) zapisane dostepne wartosci
			// pola dla modyfikowanego pola select
			$this->forms->addHidden('attr_memory','null');
			//        $this->forms1->addHidden('attr_memory','null');


			$this->_showForm();

			$id = @$rec->data['id'];

			print "<form action=\"/go/_basket/basket_redirect.php\" method=\"post\" name=\"add2basket\">";

			print "<br><br><table><tr><td>";
			print "<a onclick=\"document.forms['attrib'].submit(); \" style='cursor: pointer;'>";
			print "<img style=\"border-width: 0px;\" src=\"" . $theme->filepath("_img/_bmp/" . $config->theme_config['icons']['basket']) . "\">";
			print "</a>";
			print "</td><td>";
			print "<a onclick=\"document.forms['attrib'].submit(); \" style='cursor: pointer;'>";
			print $lang->icons_description['basket'];
			print "</a>";
			print "</td><td>";
			print "&nbsp&nbsp&nbsp&nbsp";
			print "</td><td>";
			print "<a onclick=\"document.forms['attrib'].action='$action1'; document.forms['attrib'].submit(); \" style='cursor: pointer;'>";
			print "<img style=\"border-width: 0px;\" src=\"" . $theme->filepath("_img/_bmp/" . $config->theme_config['icons']['wishlist']) . "\">";
			print "</a>";
			print "</td><td>";
			print "<a onclick=\"document.forms['attrib'].action='$action1'; document.forms['attrib'].submit(); \" style='cursor: pointer;'>";
			print $lang->icons_description['wishlist'];
			print "</a>";
			print "</table>";

			print "</form>\n";

			//TZ
			///////////////////////////////////////////////////////////////////////////////////////

			return (0);
		}
	} // end show()

	/**
    * Podziel dane na grupy oddzielone pusta linia
    *
    * @param string &$xml_options wartosc pola xml_options
    * \@global array $this->_groups
    *
    * @access private
    * @return none
    */
	function _SelectGroups(&$xml_options) {
		$this->_groups=preg_split("/\n\s/",$xml_options,ATTR_MAX_NUM,PREG_SPLIT_NO_EMPTY);
		reset($this->_groups);
		foreach ($this->_groups as $group)
		{
			if ((trim($group)!='multi') && (trim($group)!='music'))
			{
				$group_tab=preg_split("/\n/",$group,ATTR_MAX_ELEMENTS_NUM,PREG_SPLIT_NO_EMPTY);
				if (eregi("^ID:",@$group_tab[1]))
				{
					$this->_checkbox($group_tab);
				}
				elseif (eregi("^IDC:",@$group_tab[1]))
				{
					$this->_select_cat($group_tab);
					//print_r($group_tab);

				}
				else
				{
					//print_r($group_tab);
					$this->_select($group_tab);
				}
			}
		} // end foreach
		return(0);
	} // end _SelectGroups()

	/**
    * Wyswietl formularz z atrybutami
    *
    * @access private
    * @return none
    */
	function _showForm() {
		$this->forms->display();
		//        $this->forms1->display();
		return (0);
	} // end _showForm()

	/**
    * Przet³umaczenie atrybutów na bie¿±c± wersjê jêzykow±
    *
    * @param array $data tablica z danymi [0]->nazwa pola [1]..[n]->atrybuty
    * @access private
    * @return array Przet³umaczona tablica atrybutów
    * @author lech@sote.pl
    */
	function _translateData($data) {
		while(list($key, $val) = each($data)) {
			$val_arr = explode(',', $val);
			$temp_trim=trim($val_arr[0]);
			$val_arr[0] = LangF::translate($temp_trim);
			$data[$key] = implode(', ', $val_arr);
		}
		return $data;
	}


	// {{{ changeCurrency()

	/**
    * Odszukaj warto¶ci cenowych w opcjach i zmieñ je wed³ug aktualnej waluty.
    *
    * @param array $data
    *
    * @access private
    * @return array dane te same co na wej¶ciu, tylko ¿e ze zmienionymi cenami wg waluty
    */
	function _changeCurrency($data) {
		global $shop,$rec,$theme;

		$shop->currency();
		$this->my_price->get_discount($this->result);
		$discount=$this->my_price->discount;
		$new_data=array();
		foreach ($data as $dat) {
			$tab=split(",",$dat,3);
			$d=trim(@$tab[1]);
			$new_d=0;$sub='';
			if (! empty($d)) {
				if (ereg("^\+",$d)) $sub="+";
				//                if (ereg("^\-",$d)) $sub="-";
				if (abs($d)>0) {
					// przelicz kurs
					$id_currency1=$rec->data['id_currency'];
					$id_currency2=$shop->currency->id_currency;
					$new_d=$theme->price($shop->currency->change($d,$id_currency1,$id_currency2));
					// dodajemy rabat
					$new_d=$new_d*(1-($discount/100));

				}
			}

			// generuj tablicê danych z nowymi cenami
			reset($tab);$val='';$i=0;
			//            print "<pre>";
			//            print_r ($tab);
			//            print "</pre>";
			if ( $d=='+0' || $d=='-0' ) {
				$new_d='';
				$sub='';
			}
			foreach ($tab as $t) {
				if ($i==1) {
					$val.=$sub.$new_d.", ";
				} else {
					$val.=$t.", ";
				}
				$i++;
			}
			$val=substr($val,0,strlen($val)-2);
			$new_data[]=$val;

		} // end foreach

		if (! empty($new_data)) return $new_data;

		return $data;
	} // end _changeCurrency()

	// }}}

	/**
    * Wyswietl element select z atrybutami
    *
    * @param array $data tablica z danymi [0]->nazwa pola [1]..[n]->atrybuty
    *
    * @access private
    * @return none
    */
	function _select($data) {
		if (empty($data)) return;

		$data = $this->_translateData($data);
		$data = $this->_changeCurrency($data);

		$name=$this->_name();$title=$data[0];$data[0]='---';

		// sprawdz czy tytul jest zakonczony znakiem '->', jesli tak to jest to definicja atrybutow zaleznych
		if (ereg("->",$title)) {
			$this->_subSelect($data,LangF::translate(trim($title)));
			return(0);
		}

		$data=$this->_activeData($data);
		if ($this->_allow_change_image==true) {
			// sprawdz czy w atrybutach jest jakies wywolanie zdjecia
			if ($this->_isImage($data)) {
				$attrib="onChange=imgChange(this)";
				
				foreach($data as $k => $v)
				{
					$k=explode("/",$k);

					$img=$k[count($k)-1];

					if (is_file($_SERVER['DOCUMENT_ROOT']."/photo/max_".$img))
					$max .= $img.";";
				}

				$this->forms->addHidden("max_images",$max);
				
			} else $attrib='';
			if ($this->_change_image==true) $this->_allow_change_image=false;
		} else $attrib='';
		$temp_trim=trim($title);
		$temp_lang=LangF::translate($temp_trim);
		$this->forms->addSelect($name,$temp_trim,$data,'',1,'',false,$attrib);

		if ($name=='options[attr_1]')
		{

		}
		//        $this->forms1->addSelect($name,LangF::translate(trim($title)),$data,'',1,'',false,$attrib);
		// zapamietaj powiazanie nazwy opcji z nazwa elementu formularza
		$this->_names[trim($title)]=$name;

		return(0);
	} // end _select()

	/**
    * Generuj select dla listy zale¿nej
    *
    * @param array $data tablica z danymi  [0]->nazwa pola [1]..[n]->atrybuty
    *
    * @access private
    * @return none
    */
	function _subSelect($data,$title) {
		/*
		Dane postaci:
		Array
		(
		[0] => ---
		[1] => L-> czerwony, zielony
		[2] => XL->zolty, czerwony
		)
		Przerabiamy na:
		'"options[attr_2]","L->czerwony,zielony;XL->zolty,czerwony"'
		*/

		$data = $this->_translateData($data);
		$tab=split("->",$title);
		// nazwa elementu formularza w ktorym wywolujemy funkcje JS
		$name_from=$this->_names[trim($tab[0])];
		// nazwa elementu formularza, w ktorym zmieniamy opcje
		$name_to=$this->_names[trim($tab[1])];

		reset($data);$o="onChange='selectChange(this.form,this,";
		foreach ($data as $key=>$val) {
			if ($key==0) {
				$o.='"'.$name_to.'","';
			} else {
				$tab2=preg_split("/\n/",$val,ATTR_MAX_ELEMENTS_NUM);
				foreach ($tab2 as $attr2) {
					$tab3=split("->",$attr2,2);
					$o.=trim($tab3[0])."->";
					$tab4=split(",",$tab3[1],ATTR_MAX_ELEMENTS_NUM);
					foreach ($tab4 as $el) {
						$el=trim($el);
						$o.=$el.",";
					}
					$o=substr($o,0,strlen($o)-1);
					$o.=";";
				}
			}
		}
		$o=substr($o,0,strlen($o)-1);
		$o.="\");'";

		// zmien atrybuty w opcji SELECT
		$this->_setFormsAttrib($name_from,$o);

		return(0);
	} // end _subSelect()

	/**
    * Zmien atrybuty w elemencie select
    *
    * @param string $name   nazwa pola
    * @param string $attrib atrybuty
    *
    * @access private
    * @return none
    */
	function _setFormsAttrib($name,$attrib) {
		reset($this->forms->fields);
		$i=0;
		foreach ($this->forms->fields as $field) {
			if (($field[0]=='select') && ($field[1]==$name)) {
				$this->forms->fields[$i][8]=$attrib;            // dla elementu select 8 parametr to atryb.
			}
			$i++;
		} // end foreach
		//        reset($this->forms1->fields);
		//        $i=0;
		//        foreach ($this->forms1->fields as $field) {
		//            if (($field[0]=='select') && ($field[1]==$name)) {
		//                $this->forms1->fields[$i][8]=$attrib;            // dla elementu select 8 parametr to atryb.
		//            }
		//            $i++;
		//        } // end foreach
		return(0);
	} // end _setFormsAttrib()

	/**
    * Wyswietl element select z atrybutami - produktami odczytanymi ze wskazanych kategorii
    *
    * @param array $data tablica z danymi [0]->nazwa pola [1]..[n]->atrybuty (idc kategorii)
    *
    * @access private
    * @return none
    */
	function _select_cat($data) {
		global $mdbd;

		$this->default='';                           // domyslnie nie zaznaczony jest zaden produkt

		$title=$data[0];$entries=array();$entr=array();
		for ($i=1;$i<sizeof($data);$i++) {
			$entr[$i]=$this->_productsFromCat($data[$i]);
		} // end for

		reset($entr);
		foreach ($entr as $e) {
			while (list($id,$name) = each($e)) {
				$entries[$id]=$name;
			}
		} // end foreach

		$name=$this->_name($id,"basket_cat");
		if (! empty($entries)) {
			$this->forms->addSelect($name,$title,$entries,$this->default);
			//            $this->forms1->addSelect($name,$title,$entries,$this->default);
		}


		return(0);
	} // end _select_cat()

	/**
    * Odczytaj liste produktow wedlug katergorii IDC: kategoria np. id_23, 23_1, 23_27_1
    *
    * @param  array  $idc_data      dane w postaci IDC: kategoria\n IDC: kategori2 itd.
    * \@global string $this->default zapamietaj domyslny element na liscie
    *
    * @access private
    * @return array tablica z nazwami produktow, ktore beda wyswietlone na liscie
    */
	function _productsFromCat($data=array()) {
		global $mdbd;
		global $config;
		global $shop;
		global $theme;

		$tab=split("IDC:",$data,2);
		if (! empty($tab[1])) {
			$idc=trim($tab[1]);
			if (ereg(",",$idc)) {
				$tab2=split(",",$idc,2);
				if (! empty($tab2[0])) {
					$idc=trim($tab2[0]);
				}
				if (! empty($tab2[1])) {
					$this->default=trim($tab2[1]);  // user_id produktu domyslnie zaznaczonego
				}
			}
		}

		$category=array();
		if (ereg("^id_",$idc)) {
			$idc=ereg_replace("id_","",$idc);
		}
		$category=split("_",$idc,5);

		// generuj WHERE do zapytania SQL na podstawie danych kategorii
		$where="1";
		for ($i=1;$i<=sizeof($category);$i++) {
			$c=$i-1;
			if (ereg("^[0-9]+$",$category[$c])) {
				$where.=" AND id_category$i=".$category[$c];
			}
		} // end for

		// odczytaj liste produktow z bazy
		$products=$mdbd->select($config->select_main_price_list,"main",$where." AND hidden_price!=1",array(),"LIMIT ".ATTR_MAX_CAT_LIST,"ARRAY");
		if (($mdbd->num_rows>0) && (is_array($products))) {
			reset($products);$entries=array(''=>'---');
			$row=0;
			foreach ($products as $product) {
				$price=$this->my_price->price($mdbd->result,$row);
				$price=$theme->price($shop->currency->change($price,$product['id_currency'],$shop->currency->id_currency));
				$entries[$product['id']]=$product['name_L' . $config->lang_id].", +".$price;
				$row++;
			}
		} else return array();

		return $entries;
	} // end _productsFromCat()


	/**
    * Wyswietl element checkbox z atrybutami.
    * Generowanie elementów dla danych postaci:
    * ID: 12,1
    *
    * @param array tablica z danymi [0]->nazwa pola [1]..[n]->atrybuty
    *
    * @access private
    * @return none
    */
	function _checkbox($data) {
		global $config;
		global $shop,$theme;

		$shop->currency();

		$default=0;
		reset($data);$i=0;
		foreach ($data as $idp) {
			if ($i++>0) {
				$tab=split(":",$idp,2);
				if (! empty($tab[1])) {
					// sprawdz, ktore atrybuty maja byc domyslnie wybrane
					$tab2=split(",",trim($tab[1]),2);
					if (! empty($tab2[0])) {
						$user_id=trim($tab2[0]);
						if (trim(@$tab2[1])!="1") {
							$default=0;
						} else $default=1;
					}
					$main=$this->_getMainInfo($user_id);
					$name=$this->_name($main['id']);
					$prod_price = $main['price'];
					if($config->price_type == 'netto') {
						$prod_price = MyPrice::brutto2netto($prod_price, $main['vat']);
					}

					// zmieñ cenê z waluty w jakiej zdefiniowany jest cena g³ówna produktu
					// na walutê aktualnie wy¶iwetlan± w sklepie
					$prod_price=$shop->currency->change($prod_price,1,$shop->currency->id_currency);
					$prod_price=$theme->price($prod_price);  // formatuj cenê

					$title=" ".$main['name_L0']."</td><td align=right>+<b>".$prod_price." ".$shop->currency->currency."</b>";
					if (! empty($main['name_L0'])) {
						$this->forms->addCheckbox($name,$title,$default);
						//                        $this->forms1->addCheckbox($name,$title,$default);
					}
				}
			} // end if ($i++>0)
		} // end foreach

		return(0);
	} // end _checkbox()

	/**
    * Odczytaj nazwe produktu wskazanego jako atrybut
    *
    * @param string $user_id identyfikator produktu
    *
    * @access private
    * @return array dane produktu "name"=>"nazwa","price"=>"cena produktu brutto"
    */
	function _getMainInfo($user_id='') {
		global $mdbd;
		global $config;

		$m=$mdbd->select($config->select_main_price_list,"main","user_id=?",array($user_id=>"text"),"LIMIT 1");
		if ($config->lang!=$config->base_lang) {
			// zmieñ nazwê produktu, we¼ inne pole okre¶laj±ce nazwê w danym jêzyku
			if(!empty($m["name_L" . $config->lang_id]))
			$m['name'] = $m["name_L" . $config->lang_id];
			else {
				$m['name'] = $m["name_L0"];
			}
		}
		@$m['price']=$this->my_price->price($mdbd->result);
		return $m;
	} // end _getMainName()

	/**
    * Sprawdz czy w danej opcji jest zdjecie
    *
    * @param array &$data tablica z danymi opcji
    *
    * @access private
    * @return bool true - w opcji jest wywolanie zdjecia
    */
	function _isImage(&$data) {
		reset($data);
		foreach ($data as $key=>$val) {
			if ((ereg(".jpg",$val)) || (ereg(".gif",$val)) ||(ereg(".jpeg",$val))) {
				return true;
			}
			if ((ereg(".jpg",$key)) || (ereg(".jpg",$key)) ||(ereg(".jpg",$key))) {
				return true;
			}
		} // end foreach

		return false;
	} // end _isImage()

	/**
    * 'Aktywuj' dane, odczytaj cene, dodlacz obsluge zmiany zdjecia
    *
    * @param array $dane dane do listy formularza
    *
    * @access private
    * @return array przetworzone dane do listy fomularza
    */
	function _activeData($data) {
		global $DOCUMENT_ROOT;
		global $rec;

		$_isImage=$this->_isImage($data);

		reset($data);$data2=array();
		foreach ($data as $key=>$val)  {

			$val=trim($val);
			// sprawdz, czy zdjecie jest zalaczone do opcji
			$tab=split(",",$val,ATTR_MAX_OPTIONS);

			$image='';$price='';
			if (! empty($tab[1])) {
				if ( (eregi(".gif$",$tab[1])) || (eregi(".png$",$tab[1])) || (eregi(".jpg$",$tab[1])) ) {
					$image=trim($tab[1]);
				} else $price=trim($tab[1]);
			}

			if ( (empty($image)) && (! empty($tab[2])) && ((eregi(".png$",$tab[2])) || (eregi(".jpg$",$tab[2])) || (eregi(".gif$",$tab[2])))) $image=trim($tab[2]);

			$name=$tab[0];

			// zazwalaj zmiane zdjecia tylko na 1 liscie atrybutow
			if ($this->_allow_change_image==true) {
				if ((! empty($image)) && (file_exists("$DOCUMENT_ROOT/photo/$image"))) {
					$this->_change_image=true;
					$key="IMG:$name:/photo/$image";
				} elseif ($_isImage) {
					$key="IMG:$name:/photo/".$rec->data['photo'];
				} else $key=$name;
				if (! empty($price)) {
					$data2[$key]=$name.", ".$price;
				} else $data2[$key]=$name;
			} else {
				if (! empty($price)) {
					$data2[$name]=$name.", ".$price;
				} else $data2[$name]=$name;
			}

		} // end foreach

		// zapamietaj ze w fromularzu jest zmiana ceny
		if (! empty($price)) $this->_set_price=true;

		return $data2;
	} // end _activeData()

	/**
    * Generuj kolejna nazwe pola formularza dla atrybutu
    *
    * @param string $id   id produktu
    * @param string $name nazwa pola formularza (tablicy parametrow)
    *
    * @access private
    * @return string nazwa pola formularza
    */
	function _name($id='',$name='') {
		if (! empty($id)) {
			return "basket[$id]";
		} elseif (! empty($name)) {
			return $name."[attr_".$this->_num++."]";
		} else
		return "options[attr_".$this->_num++."]";
	} // end _name()

	/**
    * Sprawdz, czy w opcjach sa zmieniane zdjecia
    *
    * @access public
    * @return bool true - zdjecia sa zmieniane, false w p.w.
    */
	function checkChangeImage() {
		if ($this->_change_image==false) return false;
		return $this->_change_image;
	} // end checkChangeImage

	/**
    * Odczytaj wartosc parametru przekaywana do koszyka
    *
    * @param string $name np. IMG:wartosc:test.jpg
    *
    * @access public
    * return string wartosc atrybutu
    */
	function getName($name) {
		if (ereg("---",$name)) return '';

		if (ereg("^IMG:",$name)) {
			$tab=split(":",$name,3);
			if (! empty($tab[1])) return $tab[1];
			else return $name;
		}
		return $name;
	} // end getName()

	/**
    * Wyswietl cen eproduktu wg atrybutow (cena zmieniana online)
    *
    * @param float $price domyslna cena
    *
    * @access public
    * @return none
    */
	function showPrice($price) {
		print "<form name=price><input type=text readonly name=price_preview value='$price' class=text_preview size=12></form>\n";
		return(0);
	} // end showPrice()


	/**
    * Odczytaj cene produktow wg podanych atrybutow
    *
    * @param float   $price_brutto cena produktu brutto
    * @param string &$xml_options  wartosc pola xml_options produktu
    *
    * \@global object &$this->result wynik zapytania z bazy danych (o dane produktu)
    *
    * @access public
    * @return float cena sprzedazy produktu
    */
	function price($price_brutto,&$xml_options) {
		global $db;
		global $_REQUEST;

		$this->my_price->get_discount($this->result);
		$discount=$this->my_price->discount;
		if (empty($xml_options)) {
			return $price_brutto;
		}

		if (! empty($_REQUEST['options'])) {
			if (is_array($_REQUEST['options'])) {
				$options=$_REQUEST['options'];
			} else return $price_brutto;
		}

		reset($options);
		if (empty($this->_price_brutto)) {
			$this->_price_brutto=$price_brutto;
		}
		foreach ($options as $key=>$val) {
			if (ereg("^attr_",$key)) {

				// odczytaj numer grupy parametrow
				preg_match("/^attr_([0-9]+)$/",$key,$matches);
				if (! empty($matches[1])) {
					$num=$matches[1];
				} else continue;

				$attrib=$this->getName($_REQUEST['options'][$key]);
				if (empty($attrib)) continue;

				$data=preg_split("/\n/",$xml_options);$num_param=0;
				// $data zawiera w tablicy linie calej wartosci xml_options
				foreach ($data as $line) {
					$line=trim($line);
					if ($num_param==$num) {
						$tab=split(",",$line,3);
						if (LangF::translate(@$tab[0])==trim($attrib)) {
							if (ereg("^[-0-9+. ]+$",trim(@$tab[1]))) {
								$nprice=trim($tab[1]);  $nprice=ereg_replace(" ","",$nprice);
								$subprice=number_format(substr($nprice,1,strlen($nprice)-1),2,'.','');
								$subprice=$subprice*(1-($discount/100));
								if (substr($nprice,0,1)=="+") {

									$this->_price_brutto+=$subprice;
								} elseif (substr($nprice,0,1)=="-") {
									$this->_price_brutto-=$subprice;
								} else {
									$this->_price_brutto=$nprice;
								}
							}
						} // if (@$tab[0]==attrib)
					}
					if (empty($line)) {
						$num_param++;
					}
				} // end foreach lines
			} // if (ereg("^attr",$key))
		} // end foreach

		if ($this->_price_brutto<0) $this->_price_brutto=0;

		return $this->_price_brutto;
	} // end price()

	/**
    * Sprawdz czy dany typ danych mozna edytowac w formie uproszczonej (wprowadzajac dane do pola <input ...>
    *
    * @access public
    * @return boll   true - uproszczona edycja jest dostepna, false w p.w.
    */
	function checkSimpleEdit() {
		return false;
	} // end checkSimpleEdit()

} // end class MultiGroup

class MyXMLOptions extends MultiGroup {};
global $my_xml_options;
$my_xml_options = new MyXMLOptions;

?>