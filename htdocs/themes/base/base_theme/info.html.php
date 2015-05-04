<!-- info.html.php -->
<?php
/**
* Szablon PHP wygl�du rekordu w pe�nej prezentacji produktu - info.
*/

global $config, $prefix,$wp_config;
global $description;
global $available;
global $DOCUMENT_ROOT;
global $shop;
global $theme;



// odczytaj plugins
// @todo dolaczanie dodatkowych klas wylaczyc z pliku html i przeniesc do pliku php
if (in_array("in_category",$config->plugins)) {
    include_once ("plugins/_info/_in_category/include/in_category.inc.php");
}
if (in_array("accessories",$config->plugins)) {
    include_once ("plugins/_info/_accessories/include/accessories.inc.php");
}
if (in_array("pasaz.wp.pl",$config->plugins)) {
	include_once ("config/auto_config/wp_config.inc.php");
}

include_once ("plugins/_info/_ranking/include/ranking.inc.php");
include_once ("plugins/_breadcrumbs/include/breadcrumbs.inc.php");
include_once ("plugins/_breadcrumbs/lang/_$config->lang/lang.inc.php");

?> 
<center>

  <div class="head_category_old_mikran">
  <h2>
  <?php
   $bd = new BreadCrumbs();
   $cat_string = $lang->current_location . ":&nbsp&nbsp" . $bd->getCategories($rec);
//echo $cat_string;
  ?>
<?php //print ">" . $this->get_rewrite_anchor($rec->data['id'],$rec->data['name']) . $rec->data['name']. "</a>";?>
  </h2>
  </div>
 
  <div class="block_1">
  <?php
      $bd = new BreadCrumbs();
      $title_tag = $rec->data['name'] . " ( " .$bd->getCategoriesSimple($rec) . " )";  
  ?>
  <div class="head_2">
  <table width="100%"><tr><td>
  <h1 class="info_title">
  <?php
     print $this->get_rewrite_anchor($rec->data['id'],$rec->data['name'],$title_tag);
     print $rec->data['name'];
  ?>
  </a>
  </h1>
  </td><td style="text-align:right;color:#808080;">
   <?php print "[".$lang->mikran_code.": " ?><a title="<?php print $title_tag ?>" href="<?php print '/go/_search/full_search.php?search_item_id='.$rec->data['id']?>" > <?php print $rec->data['id']; ?></a>]
  </td></tr>
  </table>
  </div>
	<div id="foto_produkt">
	<div style="font: bold 25px Tahoma; text-align:center;color: #FF6000;">
<?php if($rec->data['sms']) : ?>
<span style="float:right"><img src="/photo/_promotions/saleoff.jpg" width="150px"><br></span>
  <?php endif ?>
	<?php if ($this->checkView("price",$rec)) 
	{
       $price=$rec->data['price_netto'].",-";
       print $price;
       if($rec->data['price_brutto'] && $rec->data['price_netto'] > 0)
       {
          if($rec->data['price_netto'] > 1)
          {
             print "<span style=\"font: bold 12px Tahoma;color:#808080;\">";
             printf("&nbsp&nbsp&nbsp +%.0f%% VAT",$rec->data['price_brutto']/$rec->data['price_netto']*100 - 100 );
             print("</span>");
          }
       }
    } ?>
    </div>
	<div title="<?php print $rec->data['name'];?>" style="text-align:center;color: #FF6000;">
        <?php print wordwrap($rec->data['name'],60,"<br>");?>
    </div>
	<div style="text-align:center;color:#808080;">
        <?php //print "[kod mikran: " . $rec->data['id']."]"; ?>
        </div>
	<!-- start zdjecie produktu: -->
        <?php 
      //if ($image->check_max_Photo($rec->data['photo']) == true)
      //   {
      //       print "<div style=\"text-align: center;\">";
      //       $image->_show_max_Photo($rec->data['photo'],$lang->desc_max_photo);
      //       print "<br><br>";
      //       print "</div>";
      //   }           
      ?>
      <?php if ($image->check_max_Photo($rec->data['photo']) == true): ?>
      <div style="text-align: center">
      <a data-toggle="modal" href="#imageModal">
      <?php $image->show_with_alt_tag($rec->data['photo'],"no",$rec->data['name'] . " ( " .$bd->getCategoriesSimple($rec) . " )");?>
      </a>
      </div>
      <div style="text-align: center">
      <a data-toggle="modal" href="#imageModal"><i class="icon-zoom-in"></i><?php print $lang->desc_max_photo ?></a>
      </div>
      <?php endif ?>

        <!-- end zdjecie produktu:-->
           
	<!-- start Flash: -->              
              <?php print "\n\n".$rec->data['flash_html']."\n\n";?>
	<!-- end Flash: -->              
	
	<!-- producent  -->   
         <?php
              //wyswietlenie producenta jesli istnieje
              if (!empty($rec->data['producer'])){
                  $producer_title = LangF::translate($rec->data['producer']);
                  print "<span title=\"$producer_title\">";
                  print $lang->cols['producer'].":&nbsp;<b>".LangF::translate($rec->data['producer'])."</b><br/></br>";
                  print "</span>";
              }
              if ($config->show_user_id==1)
              {
                  print "<b>".$lang->basket_products_extra['user_id'].":</b> ".$rec->data['user_id']."<br><br>";
              }
         ?>

	<!-- /producent  -->  
	
	
	<!-- info o cenach -->
	<table  border="0" cellspacing="0" cellpadding="0">          
          <tr> 
            <?php global $wp_config; 
            // rejestracja w statystykach wp
            if(!empty($wp_config->wp_shop_id) && $_SESSION['global_partner_id'] == 47474747) { ?>
            
            <img src="http://zakupy.wp.pl/stat_view.html?sid=<?php print $wp_config->wp_shop_id; ?>" width="1" height="1" border="0">
            <?php } ?>
            
            <?php 
            // wy�wietlaj cenne brutto tylko wtedy gdy hidden price=0
            if (($rec->data['hidden_price']==0) && ($rec->data['ask4price']==0)) {
            ?>	
            <td  style="padding: 2px 20px 2px 0px;">
            <?php 
            //if ($this->checkView("price",$rec)) print $lang->cols['price_brutto'];
            if ($this->checkView("points",$rec)) print $this->info_points(); else 
            if ($this->checkView("price",$rec)) print $this->info_price();
            
            ?>
            </td>
            <?php 
            }
            ?>
            <?php
              //stara cena
              //wyswietlaj tylko wted kiedy stara cena jest wprowadzona
               if ( (!$this->checkView("points",$rec)) && 
                    //(! empty($rec->data['base_discount']))  && 
                    //($rec->data['base_discount']>0) && 
                    //($rec->data['base_discount']<99) &&
                    ($rec->data['price_brutto_detal']>0) && 
                    (!$rec->data['points']))
                 {
                  //if (($rec->data['price_brutto_detal']>0) && ($rec->data['base_discount']==0) && !$rec->data['points']){
               ?>	
               <td class="tools_1" style="padding: 2px 20px 2px 0px;">
                <?php //if ($this->checkView("price",$rec)) print @$lang->cols['price_brutto_detal']; ?>
               </td>                     
            <?php 
                  }
             ?>
                       
          </tr>
          <tr> 

            
            <?php             
            //wy�wietlaj cene brutto tylko wtedy gdy hidden price=0
            if (($rec->data['hidden_price']==0) && ($rec->data['ask4price']==0)) {
            ?>
            <td  style="padding: 2px 20px 2px 0px;"> <div style="color: #FF6000; font: bolder 20px Arial;">
              <?php
              // start cena:
              // sprawdz, czy w opcjach sa atrybuty zmiany cen
              if ($this->checkView("points",$rec)) {
				print $rec->data['points_value'];
              } else if ($this->checkView("price",$rec)) {
                  //$price=$rec->data['price_brutto']." ".$shop->currency->currency;
                  print $price=$this->print_price($rec).",- ";
              }
              // end cena:
             ?>
   <span style="font: bold 12px Tahoma;color:#808080;">
				<?php print $shop->currency->currency ?>
			    </span>
              </div> </td>
            <?php 
            }
            ?>
             <?php
             //stara cena
             //wyswietlaj tylko wted kiedy stara cena jest wprowadzona
             //if ((!$this->checkView("points",$rec)) && ($rec->data['price_brutto_detal']>0)&& ($rec->data['base_discount']==0)){
             if ( (!$this->checkView("points",$rec)) && 
                  //(! empty($rec->data['base_discount']))  && 
                  //($rec->data['base_discount']>0) && 
                  //($rec->data['base_discount']<99) && 
                  ($rec->data['price_brutto_detal']>0) &&
                  (!$rec->data['points'])) 
              {
             ?>	
            <td  style="padding: 2px 20px 2px 0px;">
            <?php 
            //if ($this->checkView("price",$rec)) print"<div style=\"font: bold 16px Tahoma; color: red;\"><strike>".$rec->data['price_brutto_detal']."&nbsp;".$shop->currency->currency."</strike></div>";
            ?>
            </td>
              <?php
             }
             ?>
                                    
            </tr>
        </table>
	<!--  / info o cenach -->
	<?php if ($this->checkView("price",$rec)): ?>
	<?php if ($rec->data['base_discount']>0 && $rec->data['base_discount']<99) : ?>

	    <span style="font: bold 12px Tahoma;color:#808080;"><?php print $lang->discount_1;printf("<span style='color:red;font-size:14px'> %d%% </span>",$rec->data['base_discount']);print " ".$lang->discount_2; ?></span>
<br/>
         <?php endif ?>
	 <?php endif ?>
<br/>
	<!-- dostepnosc -->   

	      <?php 
                  if ($rec->data['id_available']!=0){
                  print $lang->available."<b> ".$available->get($rec->data['id_available'],$rec,"string")."</b><br/>";
                  }
                  ?>   
	<!-- / dostepnosc --> 


	<!-- Koszyk -->
    			         
         <table border="0" cellspacing="0" cellpadding="10">
          <tr valign="baseline">
           <td align="left">
             <?php
               // wy�wietl koszyk + opcje, je�li s� dost�pne
                if (empty($rec->data['xml_options']))
                {
                   print "<table><tr><td>";
                   $this->recHeaderBasket($rec->data['id'],$rec);
                   //$this->recBasketSimple($rec->data['id'], $rec);
                   print "</td><td>";
                   //$this->recBasketDescriptionSimple($rec->data['id'], $rec);
                   $this->recHeaderBasketDescription($rec->data['id'],$rec);
                   print "</table>";
                }
                else
                {
                   $this->recBasket($rec->data['id'],$rec);
                   //$this->recHeaderBasket($rec->data['id'],$rec);
                }
              ?>
             </td>
           <td align="center">
             <?php
                // wy�wietl przechowalnie + opcje, je�li s� dost�pne
                if (empty($rec->data['xml_options']))
                {
                   print "<table><tr><td>";
                   //$this->recWishlistSimple($rec->data['id'], $rec);
                   $this->recHeaderWishlist($rec->data['id'], $rec);
                   print "</td><td>";
                   //$this->recWishlistDescriptionSimple($rec->data['id'], $rec);
                   $this->recHeaderWishlistDescription($rec->data['id'], $rec);
                   print "</table>";
                }
                else
                {
                   $this->recWishlist($rec->data['id'],$rec);
                   //$this->recHeaderWishlist($rec->data['id'],$rec);
                }
             ?>
             </td>
           </tr>
         </table>

	 <!-- / Koszyk -->
	      <br/>
	<!-- start PDF: -->
              <?php
              // @todo przeniesc wywolanie pdf do funkcji w temacie
              if ((! empty($rec->data['pdf'])) && file_exists("$DOCUMENT_ROOT/photo/_pdf/".$rec->data['pdf'])) {
                  print "<br>";
                  print "$lang->info_pdf <a href=".$config->url_prefix."/photo/_pdf/".$rec->data['pdf'].">"."<img src=";
                  $this->img("_img/_icons/pdf.gif");
                  print " border=0 align=center></a>";
                  print "</br>";
              }
              ?>
	<!-- end PDF: -->
	<!-- start DOC: -->
                 <?php
              // @todo przeniesc wywolanie pdf do funkcji w temacie
              if ((! empty($rec->data['doc'])) && file_exists("$DOCUMENT_ROOT/photo/_doc/".$rec->data['doc'])) {
                  print "<br>";
                  print "$lang->info_doc <a href=".$config->url_prefix."/photo/_doc/".$rec->data['doc'].">"."<img src=";
                  $this->img("_img/_icons/doc.gif");
                  print " border=0 align=center></a>";
                  print "</br>";
              }
              ?>
	<!-- end DOC: -->
                </div>     

              <!-- Opis produktu -->
	      <!-- <div style="padding: 10px 0 0 10px;"> -->
              <div class="product_desc">
              <?php  
                 $title = $rec->data['name'] . " w kategorii: " . $bd->getCategoriesSimple($rec);
                 print "<span title=\"$title\">";
                   // sprawdz czy istnieje plik HTML np. A001.html.php
                   // @todo przeniesc do funkcji w temacie
                    $file=$rec->data['user_id'];
                    $file = ereg_replace(" ","_",$file);
                    $file.=".html.php";
                    $file_path="$DOCUMENT_ROOT/products/$file";
                    if (file_exists($file_path)) {
                       $check_info=1;
                    } else $check_info=0;
                    // przekaz zmienna globalna do pliku menu.inc.php
                    $__check_info=$check_info;
                    print $rec->data['xml_description']; //description pelen opis
                    // end
              ?>			
              <?php 
              // start dodatkowy link
               if ((! empty($rec->data['link_url'])) && ($rec->data['link_name'])) {
               print "<BR><BR>";
               print $lang->see_link.":<BR>";
               print "<a target=\"_blank\" href=\"http://".$rec->data['link_url']."\">".$rec->data['link_name']."</a>";
               } 
              // end dodatkowy link
              ?>											
              </span>
              </div>

			
		 <div class="space"></div> 

	<SCRIPT TYPE="text/javascript">
	<!--
	function popup(mylink, windowname)
	{
		if (! window.focus)return true;

		var href;
		if (typeof(mylink) == 'string')
		   href=mylink;
		else
		   href=mylink.href;
		window.open(href, windowname, 'width=300');
	return false;
	}
	//-->
	</SCRIPT>  


        <?php if($rec->data['id'] == 493): ?>
	<div  style="color:#808080;font-size:15px">Tabela ksztaltow, kliknij aby pokazac w duzym rozmiarze</div>
		<?php for ($a=0 ; $a<4; $a++) : ?>

		<div style="display:inline-block">
		<div style="border-top:1px solid"><a href="http://www.sklep.mikran.pl/photo/max_493(<?php echo $a ?>).jpg" onClick="return popup(this)">
		<?php echo sprintf("Ksztalt: %s",$a+1) ?>
		</a></div>
		<a href="http://www.sklep.mikran.pl/photo/max_493(<?php echo $a ?>).jpg" onClick="return popup(this)">
			<img style="width:280px;border:0px" src="http://www.sklep.mikran.pl/photo/max_493(<?php echo $a ?>).jpg">
		</a>
		</div>

		<?php endfor ?>
	<?php endif ?>

        <?php if($rec->data['id'] == 720 or $rec->data['id'] == 8761): ?>

	<div>
	<div  style="color:#808080;font-size:15px">Tabela frezow, kliknij aby pokazac w duzym rozmiarze</div>
	<hr/>
	<?php
	$im = array(
	    1 => 30,
	    2 => 31,
	    3 => 32,
	    4 => 33,
	    5 => 34,
	    6 => 35,
	    7 => 0,
	    8 => 1,
	    9 => 2,
	    10 => 3,
	    11 => 4,
	    12 => 5,
	    13 => 6,
	    14 => 7,
	    15 => 8,
	    16 => 9,
	    17 => 10,
	    18 => 11,
	    19 => 12,
	    20 => 13,
	    21 => 14,
	    22 => 15,
	    23 => 16,
	    24 => 17,
	    25 => 18,
	    26 => 19,
	    27 => 20,
	    28 => 21,
	    29 => 22,
	    30 => 23,
	    31 => 24,
	    32 => 25,
	    33 => 26,
	    34 => 27,
	    35 => 28,
	    36 => 29,
	    37 => 36,
	    38 => 37,
	    39 => 38,	
	    40 => 39
	);
	?>
		<?php for ($a=0 ; $a<40; $a++) : ?>

		<div style="display:inline-block">
		<div style="border-top:1px solid"><a href="http://www.sklep.mikran.pl/photo/max_720(<?php echo $im[$a+1] ?>).jpg" onClick="return popup(this)">
		<?php echo sprintf("Ksztalt: %s",$a+1) ?>
		</a></div>
		<a href="http://www.sklep.mikran.pl/photo/max_720(<?php echo $im[$a+1] ?>).jpg" onClick="return popup(this)">
			<img style="width:135px;border:0px" src="http://www.sklep.mikran.pl/photo/m_720(<?php echo $im[$a+1] ?>).jpg">
		</a>
		</div>

		<?php endfor ?>
        </div>
   
	<?php endif ?>

        <div style="text-align:center;color:#808080;">
        <p>
        <?php print $lang->last_update.":&nbsp&nbsp " . $rec->data['date_update']; ?>
        </div>
        </p>

              <hr />    
<div style="float: right; padding: 0 10px;">
<?php $this->print_page('/go/_info/print.php?id=' . $rec->data['id']);?>
</div>


              <?php
              // @todo przeniesc do funckji w temacie, polec produkt itp.
              if ($config->cd!=1) {
                  
                  // polec produkt
              /*    $user_id=$rec->data['user_id'];
                  $product=urlencode($rec->data['name']);
                  $onclick=$this->onclick("360","230");
                  $recommend_url="\"/plugins/_recommend/?id=$user_id&product=$product\" $onclick target=\"window\"";
                  print "<a  style=\"color: #FF6000;\"href=$recommend_url>$lang->info_recommend_product</a>";
                  print "&nbsp;&#183;&nbsp;";
                  // ocen produkt
                  $onclick=$this->onclick("440","320");
                  $id=$rec->data['id'];
                  $score_link="\"/plugins/_reviews/add.php?id=$id&user_id=$user_id&product=$product\" $onclick target=\"window\"";
                  print "<a style=\"color: #FF6000;\" href=$score_link>$lang->info_score</a>";
                  print "&nbsp;"; // spacja pomiedzy info a wynikiem
                  if(isset($rec->data['user_score'])){
                      $this->user_score($rec->data['user_score'],"star.gif");
                  }*/

                 $encode = new EncodeUrl();
		 $encoded = $encode->encode_url_category($rec->data['name']);

		 // print "<fb:like href=\"http://www.sklep.mikran.pl/id".$rec->data['id']."/".$encoded."\" width=\"350\" action=\"recommend\"></fb:like>";

                 // print "<br/><br/>";

	          //print "<a href=\"http://www.sklep.mikran.pl/id".$rec->data['id']."/".$encoded."\"  class=\"twitter-share-button\" data-count=\"yes\" data-via=\"mikranpl\">Tweet</a>";
                  //print "<br/><br/>";

		 //print "<a style=\"color: #FF6000;\" href=\"http://www.blog.mikran.pl\">Czytaj na blog.mikran.pl</a>";
                 // print "<sup style=\"color: red;\">Nowosc !</sup>";
              } // end plugin cd:
              ?>
              
	      

              <br /><br />
              
     
</div>

<br />
<?php 
// start plugin cd:
if (in_array("reviews",$config->plugins)) 
{
?>






      <?php      
	  if (($config->ranking1_enabled == 1) && ($ranking->check_product_in_ranking($rec))) {
//	  if (1) {
	      $this->win_top($lang->ranking_title,570,1,1);
	      include ("./include/ranking.inc.php");
	      //$this->win_bottom(570);
	      echo "<br>";
	  }
      // @todo cale ponizsze wywolanie przeniesc do funkcji (menu z linkami pod info)
      /**
      * pokaz buttony dla plugin'u jesli nie to pokaz link tekstowy
      * Inne produkty, Recenzje, itp;
      */
      //include ("./include/menu.inc.php");


      
      /* obsluga zakladek w zaleznosci od klikniecia
      *  gdy $__item=1 - inne produkty z tej samej kategorii
      *  $__item=2 - akcesoria do produktow
      *  $__item=3 - pelny opis produktu (zalaczony plik html)
      *  $__item=4 - recenzje do produktu
      */
      $secure_test=true;
      @$__id=$_REQUEST['id'];
      @$__item=$_REQUEST['item'];
      switch ($__item){
          case 1:
          //$bar_title=$lang->in_category;          
	  $bar_title=$lang->ranking_title;
          break;
          case 2:
          $bar_title=$lang->accessories;
          break;
          case 3:
          $bar_title=$lang->full_description;
          break;
          case 4:
          $bar_title=$lang->write_up;
          break;
          default:
          //$bar_title=$lang->in_category;
	  $bar_title=$lang->ranking_title;
      }
//	echo '<div class="block_1">';
	echo '<div class="head_1">';
	echo $bar_title;
	echo '</div>';
     // $this->win_top($bar_title,570,1,1);

	$cache_file = $_SERVER['DOCUMENT_ROOT'].'/tmp/'.$rec->data['id'].'.txt';
	//7 dni = 60*60*24*7 = 604800 sekund
	if (file_exists($cache_file) and time() - filemtime($cache_file) < 604800)
	{	
		//print time() - filemtime($cache_file);
		print file_get_contents($cache_file);
	}
	else
	{
		//print "cached now";
		ob_start();
        	include ("./include/choose_item.inc.php");
        	$c = ob_get_clean();

    		file_put_contents($cache_file, $c);
		print $c;
	}     
      
	//include ("./include/choose_item.inc.php");
      // echo '</div>';
      //$this->win_bottom(570);
      // koniec obsluga zakladek
      ?>

<?php
}
// end plugin cd:
?>

<div id="imageModal" style="max-width:<?php print $image->_get_max_width($rec->data['photo']); ?>px" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h5 id="imageModalLabel"><?php print $rec->data['name'];?></h5>
   </div>
   <div class="modal-body">
   <img style="max-height:480px" id="modalphoto" src="<?php print $image->_get_max_href($rec->data['photo']); ?>">
   </div>
   <div class="modal-footer">
     <p class="text-left"><?php print $bd->getCategories($rec); ?> </p>
     <button class="btn" data-dismiss="modal" aria-hidden="true">Zamknij</button>
   </div>
</div>

<!-- end dodatkowe menu na dole: -->

	
