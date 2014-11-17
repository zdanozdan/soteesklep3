<?php
/**
* Szablon PHP wygl±du rekordu w pe³nej prezentacji produktu - info.
*
* @author  m@sote.pl
* @version $Id: info.html.php,v 2.61 2006/02/10 12:05:24 krzys Exp $
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

?> 

<center>
  <?php
  $this->bar($rec->data['name']);
  ?>
  <div class="block_3">
  
  <?php print $lang->cols['name'];?>: <div class="head_2"><?php print $rec->data['name'];?></div>
  
  
  
  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr> 
          <td width="100%" valign="top">
  		<table width="100%" border="0" cellspacing="0" cellpadding="0">          
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
            <td>
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
            //wyswietlaj tylko wted kiedy stara cena jest wprowadzona i nie ma rabatu
            if (($rec->data['price_brutto_detal']>0) && ($rec->data['base_discount']==0)){
             ?>	
            <td >
            	<?php 
            	if ($this->checkView("price",$rec) && (!$this->checkView("points",$rec))) print $this->info_price();
            	?>
            </td>
            <?php 
            }
             ?>
            
            <?php 
            // rabat;
            // wyswietalj tylko wtedy kiedy rabat jest wprowadzony
            if ((!$this->checkView("points",$rec)) && (! empty($rec->data['base_discount']))  && ($rec->data['base_discount']>0) && ($rec->data['base_discount']<99)) {
            ?>
            <td  style="padding: 2px;">
            	<?php 
            	if ($this->checkView("discount",$rec)) print @$lang->cols['discount'];
            	?>
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
            <td > <B>
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
              </B> </td>
            <?php 
            }
            ?>
             <?php
             //stara cena
             //wyswietlaj tylko wted kiedy stara cena jest wprowadzona i nie ma rabatu
             if ((!$this->checkView("points",$rec)) && ($rec->data['price_brutto_detal']>0)&& ($rec->data['base_discount']==0)){
             ?>	
            <td >
            <?php 
            if ($this->checkView("price",$rec)) print"<font color=red><strike>".$rec->data['price_brutto_detal']."</strike>&nbsp;</font>".$shop->currency->currency."\n";
            ?>
            </td>
              <?php
             }
             ?>
            
            
            <?php
            // rabat;
            // wyswietalj tylko wtedy kiedy rabat jest wprowadzony
            if ((!$this->checkView("points",$rec)) && (! empty($rec->data['base_discount']))  && ($rec->data['base_discount']>0) && ($rec->data['base_discount']<99)) {
            ?>
            <td >
            	<?php 
            	if ($this->checkView("discount",$rec)) print $rec->data['base_discount']."%\n";
            	?>
            </td> 
            <?php
            }
            ?>
            
            </tr>
        </table>
	
	
	
	
	
        <br>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="318"  valign="top" align="left"> 
              <!-- Opis produktu -->
              <?php
              //wyswietlenie producenta jesli istnieje
              if (!empty($rec->data['producer'])){
                  print $lang->cols['producer'].":&nbsp;".LangF::translate($rec->data['producer'])."<BR><BR>";
              }
              if ($config->show_user_id==1){
                  print "<b>".$lang->basket_products_extra['user_id'].":</b> ".$rec->data['user_id']."<br><br>";
                  }
              ?>
              <?php               
              // sprawdz czy istnieje plik HTML np. A001.html.php
              // @todo przeniesc do funkcji w temacie
              $file=$rec->data['user_id'];
              $file=ereg_replace(" ","_",$file);
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
            </td>
            <td width="250" align="center" valign="top"> 
              
              <!-- start zdjecie produktu: -->
              <?php $image->show($rec->data['photo'],"no");?>
              <br>
              <?php $image->_show_max_Photo($rec->data['photo'],$lang->desc_max_photo);?>
              <!-- end zdjecie produktu:-->
              
              <!-- start Flash: -->              
              <?php print "\n\n".$rec->data['flash_html']."\n\n";?>
              <!-- end Flash: -->
              
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
              <table width="250" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="250" align="center" colspan="4">
                   <?php 
                  if ($rec->data['id_available']!=0){
		  print $lang->available;
                  print "<nobr>".$available->get($rec->data['id_available'],$rec,"string")."</nobr>";
                  }
                  ?>                
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
	
	<hr/>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td align="center">
												<!-- Koszyk -->
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td align="center">
			         
                    <table border="0" cellspacing="5" cellpadding="5" align="center">
					<tr >
					  <td >
					  <?php
					  // wy¶wietl koszyk + opcje, je¶li s± dostêpne
					  $this->recBasket($rec->data['id'],$rec);
				      ?>
                      </td>
					  <td >
					  <?php
					  // wy¶wietl koszyk + opcje, je¶li s± dostêpne
					  $this->recWishlist($rec->data['id'],$rec);
				      ?>
                      </td>

                      <td >
                      <?php $this->print_page('/go/_info/print.php?id=' . $rec->data['id']);?>
                      </td>
                    </tr>
                    </table>
                  </td>
                </tr>
              </table>  
     <?php
              // @todo przeniesc do funckji w temacie, polec produkt itp.
              if ($config->cd!=1) {
                  
                  // polec produkt
                  
                  $user_id=$rec->data['user_id'];
                  $product=urlencode($rec->data['name']);
                  $onclick=$this->onclick("360","230");
                  $recommend_url="\"/plugins/_recommend/?id=$user_id&product=$product\" $onclick target=\"window\"";
                  print "<a href=$recommend_url><b>$lang->info_recommend_product</b></a>";
                  print "&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;";
                  // ocen produkt
                  $onclick=$this->onclick("440","320");
                  $id=$rec->data['id'];
                  $score_link="\"/plugins/_reviews/add.php?id=$id&user_id=$user_id&product=$product\" $onclick target=\"window\"";
                  print "<a href=$score_link><b>$lang->info_score</b></a>";
                  print "&nbsp;"; // spacja pomiedzy info a wynikiem
                  if(isset($rec->data['user_score'])){
                      $this->user_score($rec->data['user_score'],"star.gif");
                  }
                  print "&nbsp;&nbsp;&nbsp;";
              } // end plugin cd:
              ?> 
              
            </td>
          </tr>
        </table>        
      </td>
      
    </tr>
  </table>
</center>

</div>
<br />
<?php 
// start plugin cd:
if (in_array("reviews",$config->plugins)) 
{
?>
<center>
<table width="570" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr> 
    <td width="570" align="center">
      <?php      
	  if (($config->ranking1_enabled == 1) && ($ranking->check_product_in_ranking($rec))) {
//	  if (1) {
		echo '<div class="head_1">';
	      echo $lang->ranking_title;
	      echo '</div>';
	      include ("./include/ranking.inc.php");
	      echo "<br>";
	  }
      // @todo cale ponizsze wywolanie przeniesc do funkcji (menu z linkami pod info)
      /**
      * pokaz buttony dla plugin'u jesli nie to pokaz link tekstowy
      * Inne produkty, Recenzje, itp;
      */
      include ("./include/menu.inc.php");


      
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
	echo '<div class="head_1">';
	echo $bar_title;
	echo '</div>';
      include ("./include/choose_item.inc.php");

      // koniec obsluga zakladek
      ?>
    </td>
  </tr>
</table>

</center>
<?php
}
// end plugin cd:
?>
<!-- end dodatkowe menu na dole: -->
