<!-- info.html.php -->
<?php
/**
* Szablon PHP wygl±du rekordu w pe³nej prezentacji produktu - info.
*
* @author  m@sote.pl
* @version $Id: require_options.html.php,v 1.6 2007/12/01 11:02:14 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/

// XHTML Id: info.html.php,v 2.12 2003/10/15 12:20:10 maroslaw Exp

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

  <div class="head_category">
  <h2>
  <?php
   $bd = new BreadCrumbs();
   $cat_string = $lang->current_location . ":&nbsp&nbsp" . $bd->getCategories($rec);
   echo $cat_string;
  ?>
      <?php //print "> <a href=\"/go/_info/?id=" . $rec->data['id']. "\">" . $rec->data['name']. "</a>";?>
      <?php print ">" . $this->get_rewrite_anchor($rec->data['id'],$rec->data['name']) . $rec->data['name']. "</a>";?>
  </h2>
  </div>
  
  <div class="block_1">

  <div class="head_2" title="<?php print $rec->data['name'];?>">
  <h1>
  <?php print $rec->data['name'];?>
  </h1>
  </div>
  
	<div id="foto_produkt">
	<div style="text-align:center;color: #FF6000;;">
        <?php print $rec->data['name'];?>
        </div>
	<div style="text-align:center;color:#808080;">
        <?php print "[kod mikran: mik_" . $rec->data['id']."]"; ?>
        </div>
	<!-- start zdjecie produktu: -->
	<div style="text-align:center;">
        <?php $image->show_with_alt_tag($rec->data['photo'],"no",$rec->data['name'] . " ( " .$bd->getCategoriesSimple($rec) . " )");?>
        </div>
        <?php 
           if ($image->check_max_Photo($rec->data['photo']) == true)
           {
               print "<div style=\"text-align: center;\">";
               $image->_show_max_Photo($rec->data['photo'],$lang->desc_max_photo);
               print "<br><br>";
               print "</div>";
           }
           
        ?>
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
            // wy¶wietlaj cenne brutto tylko wtedy gdy hidden price=0
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
                <?php if ($this->checkView("price",$rec)) print @$lang->cols['price_brutto_detal']; ?>
               </td>                     
            <?php 
                  }
             ?>
                       
          </tr>
          <tr> 

            
            <?php             
            //wy¶wietlaj cene brutto tylko wtedy gdy hidden price=0
            if (($rec->data['hidden_price']==0) && ($rec->data['ask4price']==0)) {
            ?>
            <td  style="padding: 2px 20px 2px 0px;"> <div style="color: #FF6000; font: bolder 13px Arial;">
              <?php
              // start cena:
              // sprawdz, czy w opcjach sa atrybuty zmiany cen
              if ($this->checkView("points",$rec)) {
				print $rec->data['points_value'];
              } else if ($this->checkView("price",$rec)) {
                  //$price=$rec->data['price_brutto']." ".$shop->currency->currency;
                  print $price=$this->print_price($rec)." ".$shop->currency->currency;
              }
              // end cena:
             ?>
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
            if ($this->checkView("price",$rec)) print"<div style=\"font: bold 11px Tahoma; color: red;\"><strike>".$rec->data['price_brutto_detal']."</strike>&nbsp;".$shop->currency->currency."</div>";
            ?>
            </td>
              <?php
             }
             ?>
                                    
            </tr>
        </table>
	<!--  / info o cenach -->
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
               // wy¶wietl koszyk + opcje, je¶li s± dostêpne
                if (empty($rec->data['xml_options']))
                {
                   print "<table><tr><td>";
                   $this->recBasketSimple($rec->data['id'], $rec);
                   print "</td><td>";
                   $this->recBasketDescriptionSimple($rec->data['id'], $rec);
                   print "</table>";
                }
                else
                {
                   $this->recBasket($rec->data['id'],$rec);
                }
              ?>
             </td>
           <td align="center">
             <?php
                // wy¶wietl przechowalnie + opcje, je¶li s± dostêpne
                if (empty($rec->data['xml_options']))
                {
                   print "<table><tr><td>";
                   $this->recWishlistSimple($rec->data['id'], $rec);
                   print "</td><td>";
                   $this->recWishlistDescriptionSimple($rec->data['id'], $rec);
                   print "</table>";
                }
                else
                {
                   $this->recWishlist($rec->data['id'],$rec);
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
	      <div style="font-size:12px; color: #FF3300; padding: 10px 0 0 10px;">

              <?php               
                print "Uwaga ! <br><br> Wybrany produkt (" . $rec->data['name'] . ") posiada cechy które musz± zostaæ wybrane przed wrzuceniem go do koszyka lub przechowalni. Nie bêdziemy mogli zrealizowaæ zamówienia dopóki nie okre¶licie Pañstwo wymaganych cech towaru (np. kolor albo rozmiar). Proszê wybraæ ceche z listy, która znajduje siê po prawej stronie pod zdjêciem. Nastêpnie proszê zatwiedziæ wybór klikaj±c 'Dodaj do koszyka' lub 'Dodaj do przechowalni' poni¿ej listy dostêpnych cech. Sklep nie pozwoli umie¶ciæ towaru w koszyku lub przechowalni dopóki wszystkie wymagane cechy nie zostan± wybrane";
print "<br><br><br>";
//print "<a  style=\"color: #FF6000;\"href=/go/_info/?id=" . $rec->data['id'] . "><b>Kliknij tutaj aby zobaczyæ pe³en opis produktu</b></a>";
//'/go/_info/?id=' . $rec->data['id']);
print "<table><tr><td>";
$this->recInfo($rec->data['id'], $rec);
print "</td><td>";
$this->recInfoDescription($rec->data['id'], $rec);
print "</table>";
              ?>											

              </div>

		 <div class="space"></div>   
        <div style="text-align:center;color:#808080;">
        <p>
        <?php print "Data ostatniej aktualizacji:&nbsp&nbsp " . $rec->data['date_update']; ?>
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
                 /* $user_id=$rec->data['user_id'];
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
                  }
                  print "&nbsp;&nbsp;&nbsp;";*/

		 $encode = new EncodeUrl();
		 $encoded = $encode->encode_url_category($rec->data['name']);

		  print "<fb:like href=\"http://www.sklep.mikran.pl/id".$rec->data['id']."/".$encoded."\" width=\"350\" action=\"recommend\"></fb:like>";

                  print "<br/><br/>";

	          print "<a href=\"http://www.sklep.mikran.pl/id".$rec->data['id']."/".$encoded."\"  class=\"twitter-share-button\" data-count=\"yes\" data-via=\"mikranpl\">Tweet</a>";
                  print "<br/><br/>";

                  print "<a style=\"color: #FF6000;\" href=\"http://www.blog.mikran.pl\">Czytaj na blog.mikran.pl</a>";
                  print "<sup style=\"color: red;\">Nowosc !</sup>";
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
          $bar_title=$lang->in_category;
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
          $bar_title=$lang->in_category;
      }
	echo '<div class="block_1">';
	echo '<div class="head_1">';
	echo $bar_title;
	echo '</div>';
     // $this->win_top($bar_title,570,1,1);
     
      include ("./include/choose_item.inc.php");
       echo '</div>';
      //$this->win_bottom(570);
      // koniec obsluga zakladek
      ?>

<?php
}
// end plugin cd:
?>
<!-- end dodatkowe menu na dole: -->

	
