<?php
/**
 * Obsluga kategorii  i podkategorii na podstawie klasy lib/Menu
 *
 * @author m@sote.pl
 * @version $Id: category.inc,v 1.8 2008/08/11 16:48:18 tomasz Exp $
 * @package soteesklep
 */


global $sess;
global $DOCUMENT_ROOT;
global $_REQUEST;
global $__producer_filter;
global $shop;

//require_once ("lib/Menu/Menu.inc");

// klasa do encodingu urla
include_once ("include/encodeurl.inc");

// inkluduj klase obslugi funkcji jezykowych
global $langfunctions;
require_once("include/lang_functions.inc");

class NavbarCategory {

  var $category = Array();

  function read_idc()
  {
    //1. read from session
    if (!empty($_SESSION["current_idc"]))
      $idc = $_SESSION["current_idc"];

    //2. read from product category is product cart is shown
    $idc = $this->get_product_category();

    //3. read from category tree when tree is clicked
    if (!empty($_REQUEST['idc'])) 
      {
	$idc=$_REQUEST['idc'];
      }
    if ((empty($_REQUEST['idc'])) && (! empty($_REQUEST['cidc']))) 
      {
	$idc=$_REQUEST['cidc'];
      }

    global $sess;
    $sess->register("current_idc",$idc);

    return $idc;
  }

  function init() 
  {
    global $sess;
    global $DOCUMENT_ROOT;

    // odczytaj kategorie dla danego producenta
    if (ereg("^[0-9]+$",@$_REQUEST['producer_filter'])) {
      $__producer_filter=$_REQUEST['producer_filter'];
      $sess->unregister("__producer_filter");
    } elseif (ereg("^[0-9]+$",@$_SESSION['__producer_filter'])) {
      $__producer_filter=$_SESSION['__producer_filter'];
    } else {
      $__producer_filter=0;
    }

    if (! empty($__producer_filter)) {
      $file="$DOCUMENT_ROOT/../config/tmp/producers/$__producer_filter"."_category.php";
      $file_include="config/tmp/producers/$__producer_filter"."_category.php";
      // jesli nie ma kategorii dla producenta to odzytaj glowne kategorie
      if ((! file_exists($file)) && (! $shop->home)) {
        $file="$DOCUMENT_ROOT/../config/tmp/category.php";
        $file_include="config/tmp/category.php";
      } else {
        $sess->register("__producer_filter",$__producer_filter);
      }
    } else {
      $sess->register("__producer_filter",$__producer_filter);
      $file="$DOCUMENT_ROOT/../config/tmp/category.php";
      $file_include="config/tmp/category.php";
    }
    
    if ((file_exists($file)) || ($shop->home)) {
      include_once($file_include);
    }

    if (empty($category)) {
      // odczytaj gloalna wartosc - ponad klasa $theme
      // jesli wczesniej plik caregory.php zostal zalaczony, to nie jest on tu domylsnie widoczny
      if (! empty($GLOBALS['category'])) {
        $category=$GLOBALS['category'];
      } else $category=array();
    }

    $this->category = $category;
  }

  function get_product_breadcrumb()
  {
    global $rec;
    global $config;
    $enc = new EncodeUrl;

    if ($rec->data['id'] > 0)
      {
	$rewrite = $enc->encode_url_category($rec->data['name']);
	$name = $rec->data['name'];
	return array('name'=>$name,'href'=>'/'.$config->lang.'/id'.$rec->data['id'].'/'.$rewrite);
      }
  }

  function breadcrumbs()
  {
    $this->get_breadcrumbs($this->category);
    $product_bc = $this->get_product_breadcrumb();
    if($product_bc)
      $this->breadcrumbs['product'] = $product_bc;

    return $this->breadcrumbs;
  }

  function get_breadcrumbs($category)
  {
    global $config;
    $enc = new EncodeUrl;

    foreach($category as $key=>$val)
      {
	$id=$key;
	$name=$val['name'];
	if (strlen($name) > 0)
	  {	    
	    $elements = $val['elements'];
	    foreach ($elements as $key=>$item) 
	      {
		if ($this->is_visible($id))
		 {
		   $rewrite_name = $enc->encode_url_category($name);
		   $url_cat="/$config->lang/idc/$id/$rewrite_name#$id";
		   $name=LangFunctions::f_translate($name);
		   $this->breadcrumbs[$id]=array('name'=>$name,'id'=>$id,'href'=>$url_cat);
		   $this->get_breadcrumbs($item);
		 }
	      }
	  }
      }
  }

  function get_product_category()
  {
    global $rec;   
    //sprawdzamy czy istnieje id
    if ($rec->data['id'] > 0)
      {
	if ($rec->data['id_category1'] > 0 && strlen($rec->data['category1']) > 0)
	  {
	    $idc = "id_" . $rec->data['id_category1'];	    
	    if ($rec->data['id_category2'] > 0 && strlen($rec->data['category2']) > 0)
	      {
		$idc = $idc .'_'. $rec->data['id_category2'];
		if ($rec->data['id_category3'] > 0 && strlen($rec->data['category3']) > 0)
		  {
		    $idc = $idc .'_'. $rec->data['id_category3'];
		    if ($rec->data['id_category4'] > 0 && strlen($rec->data['category4']) > 0)
		      {
			$idc = $idc .'_'. $rec->data['id_category4'];
			if ($rec->data['id_category5'] > 0 && strlen($rec->data['category5']) > 0)
			  {
			    $idc = $idc .'_'. $rec->data['id_category5'];
			  }                 
		      }                 
		  }                 
	      }                 
	  }
      }

    return $idc;
  }

  function is_visible($id)
  {
    //pojawi sie w request jest klik byl na menu. Jesli nie to trzeba odczytac z sesji lub z biezacego produktu
    $idc = $this->read_idc();
    //teraz reszta id jesli istnieje z pominieciem tego ktory juz byl dodany
    //$idc_array=explode("_",$idc);

    //check id format: id_xx - need to remove 'id_'
    if (substr($id,0,3) == 'id_')
      $id = substr($id,3,strlen($id));

    if (substr($idc,0,3) == 'id_')
      $idc = substr($idc,3,strlen($idc));

    //print $id.':'.$idc;
    return strncmp($idc,$id,strlen($id)) == 0 ? True : False;
  }

  function menu()
  {
    $idc = $this->read_idc();
    $this->build_menu($this->category,$idc);
  }

  function build_menu($category,$idc)
  {
    global $config;
    $enc = new EncodeUrl;

    foreach($category as $key=>$val)
      {
	$id=$key;
	$name=$val['name'];
	//	print "<li>".var_dump($name)."</li>";
	if (strlen($name) > 0)
	  {
            $rewrite_name = $enc->encode_url_category($name);
            $url_cat="/$config->lang/idc/$id/$rewrite_name#$id";
	    $name=LangFunctions::f_translate($name);
	    $a="";$icon="icon-chevron-right";$s="float:right;opacity:.25";
	    //check if product page is shown - if so also mark category
	    $pc = $this->get_product_category();
	    if (substr($pc,0,3) == 'id_')
	      $pc = substr($pc,3,strlen($pc));

	    if ($id == $idc || strcmp($id,$pc) == 0) 
	      {
		$a="active";
		$icon = "icon-ok";
		$s="float:right;";
	      }

	    print '<li class="'.$a.'"><a id="'.$id.'"href='.$url_cat.'>'.$name.'<i class="'.$icon.'" style="'.$s.'"></i></a></li>';

	    //$retval = array('id'=>$id,'url'=>'url_cat',$name=>'name','open'=>'none');

	    $visible = $this->is_visible($id);

	    $elements = $val['elements'];
	    foreach ($elements as $key=>$item) 
	    {
	      if ($visible == True)
	      	{
		  print '<ul class="navsub">';
		  $this->build_menu($item,$idc);
		  print "</ul>";
		}
	    }
	  }
      }
  }
}

class Category {
    var $prefix_url="/go/_category/";
    var $table_start="<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";

    function read(&$category,&$menu_obj,$level=1) {
        global $_REQUEST;
        global $lang;
        global $langfunctions;
        global $__current_root_id;
        global $sess,$_SESSION;
        global $config;

        // odczytaj wybrana kategorie uzytkownika
        if (! empty($_REQUEST['idc'])) {
            $get_idc=$_REQUEST['idc'];
        }
        if ((empty($_REQUEST['idc'])) && (! empty($_REQUEST['cidc']))) {
            $get_idc=$_REQUEST['cidc'];
        }

//         echo "IDC:$get_idc";
//         include_once("./include/query_rec.inc.php");
//         echo "encoded";


        // odczytaj id glownej kategorii
        // uwaga! na 1 poziomie id jest wyolywane jako parametr np. idc=id_1 cidc=id_1
        // na kolejnych poziomach idc=1_2 cidc=1_4
        preg_match("/^[id_]+([0-9]+)/",@$get_idc,$matches);
        $current_root_id=my(@$matches[1]);
        if (empty($current_root_id)) {
            // wybrano podkategorie (nie glowna kategorie)
            preg_match("/^([0-9]+)/",@$get_idc,$matches);
            $current_root_id=my(@$matches[1]);
        }

        // zapamietanie i odczytanie ostatniego IDC(CIDC)
        if (! empty($current_root_id)) {
            // zapisz w seji osttnie wywolanie kategorii
            $__current_root_id=$current_root_id;
            $sess->register("__current_root_id",$__current_root_id);
        } elseif (! empty($_SESSION['__current_root_id'])) {
            $current_root_id=$_SESSION['__current_root_id'];
        }

        //Change 10/09/2007 TZ
        global $rec;
        $pv = "registered";

        //
        //jesli mamy karte produktu i menu nie jest rozwiniete to rozwijamy
        //if (empty($current_root_id))
        //{
           //sprawdzamy czy istnieje id
           if ($rec->data['id'] > 0)
           {
              if ($rec->data['id_category1'] > 0)
              {
                 $current_root_id = $rec->data['id_category1'];
                 $pn = "idc_id_" . $current_root_id;
                 $GLOBALS[$pn]=$pv;

                 if ($rec->data['id_category2'] > 0 && $rec->data['id_category3'] > 0)
                 {
                    $pn = "idc_" . $rec->data['id_category1'] . "_" . $rec->data['id_category2'];
                    $GLOBALS[$pn]=$pv;

                    if ($rec->data['id_category3'] > 0 && $rec->data['id_category4'] > 0)
                    {
                       $pn = "idc_" . $rec->data['id_category1'] . "_" . $rec->data['id_category2'] . $rec->data['id_category3'];
                       $GLOBALS[$pn]=$pv;
                    }                 
                 }                 
              }
           }
           //        }


        //zapamietujemy glowne menu z uzyciem current_root_id        
        $pn = "idc_id_" . $current_root_id;
        $GLOBALS[$pn]=$pv;

        //teraz reszta id jesli istnieje z pominieciem tego ktory juz byl dodany
        $node=explode("_",$get_idc);
        if (count($node) > 0)
        {
           //nie interesuje nas element z id_xxx bo juz go mamy
           if (strcmp($node[0],"id") != 0)
           {
              $node_c = count($node);
              if ($node_c > 2)
              {
                 $val2r = "idc";
                 for ($c=0; $c<$node_c-1;$c++)
                 {
                    $val2r = $val2r . "_" . $node[$c];
                    $GLOBALS[$val2r]=$pv;
                 }
              }
           }
        }
        //Change 10/09/2007 TZ

        //teraz reszta id jesli istnieje z pominieciem tego ktory juz byl dodany
        $node=explode("_",$get_idc);
        if (count($node) > 0)
        {
           //nie interesuje nas element z id_xxx bo juz go mamy
           if (strcmp($node[0],"id") != 0)
           {
              $node_c = count($node);
              if ($node_c > 2)
              {
                 $val2r = "idc";
                 for ($c=0; $c<$node_c-1;$c++)
                 {
                    $val2r = $val2r . "_" . $node[$c];
                    $GLOBALS[$val2r]=$pv;
                 }
              }
           }
        }
        //Change 10/09/2007 TZ

        $i=0;$lcategory=sizeof($category);$lcat=1;
        //
        // PHP5 patch
        // while (list($key,$val) = each($category)) {
        foreach($category as $key=>$val) {
            $id=$key;
            $name=$val['name'];
            $name=LangFunctions::f_translate($name);  //przetlumacz slowo bazowe
            $elements=@$val['elements'];

            // zaznacz wybrana kategorie
            if (! empty($get_idc)) {
                if ($get_idc==$id) {
                   //$name=" <b><u>$name</u></b>";
                   //$name=" <div id=\"active_category\">$name</div>";
                }
            }

            // ustal ikonki menu
            $icons=0;
            if (! empty($config->category['icons'])) {
                $icons=1;
            }

            // utworz menu/submenu
            $menu_name="menu_$id";

            $enc = new EncodeUrl;
            $rewrite_name = $enc->encode_url_category($name);
            $url_cat="/$id/$rewrite_name";

            //$$menu_name = new Menu($id,$name,$this->prefix_url,$icons);
            $$menu_name = new Menu($id,$name,$url_cat,$icons);
            if (! empty($current_root_id)) {
                $$menu_name->current_root_id=$current_root_id;
            }

            // przejrzyj elementy poszczgolnych kategorii 1 poziomu, zdefiniowanych jako odzeilne rekordy tablicy $category
            if (! empty($elements)) {
               //
               // PHP5 patch
               //while (list($key,$item) = each($elements)) {
               //
               foreach ($elements as $key=>$item) {
                    if (is_array($item)) {
                        // dany element jest drzewem
                        $level++;
                        $$menu_name->add($this->read($item,$$menu_name,$level),$level);
                    } else {
                        // dany element jest lisciem

                        // utworz parametry przekazywane do dodawanego elementu menu
                        $id=$item;
                        $name=$key;
                        $name=LangFunctions::f_translate($name);  //przetlumacz slowo bazowe

                        // zaznacz wybrana kategorie
                        if (! empty($get_idc)) {
                            if ($get_idc==$id) {
                                $level++;
                                //$name=" $name";
                                //$name=" <div id=\"active_category\">$name</div>";
                            }
                        }
                        //$url="$this->prefix_url?idc=$id" . "TEST";

                        $rewrite_name = $enc->encode_url_category($name);

                        $url="/idc/$id/$rewrite_name";

                        if (@$config->category['use_frames']=="yes") {
                            $url.=" target=left";
                        }

                        // dodaj element do menu
                        $$menu_name->add($id,$name,$url,$level);
                    }
                }
            } // end if (! empty($elements))

            // inicjuj glowne menu  (glowny element meenu 1 poziomu)
            if (empty($menu_obj)) {
                if ($name!=$lang->points_category) {
                    if ($lcat==$lcategory) {
                        // ostatni element
                        $$menu_name->last_element=true;
                        $$menu_name->set_html();
                    }
                    // end obrazki

                    // pokaz menu (glowna galaz drzewa), zeruj tablice z danymi czy poszczegolne kategorie byly ostatnie na swoim poziomie
                    $$menu_name->show(0,$$menu_name->last_element,$last_mem=array());
                }
            } // end if

            $lcat++;
        } // end  while (list($key,$val) = each($category))

        if (! empty($menu_obj))
        return $$menu_name;
        else return;

    } // end read()

} // end class Category

//$categ = new Category;
//$categ->read($category,$null_obj="");

//$navbar_cat = new NavbarCategory;
//$navbar_cat->init($category);

?>
