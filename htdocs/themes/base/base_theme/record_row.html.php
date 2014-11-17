<!-- record_row.html.php -->

<?php
/**
* Szablon rozszerzonej prezentacji produktu na li¶cie produktów.
* Prezentacja z opisem i pomniejszonym zdjêciem.
*
* @author  rp@sote.pl m@sote.pl lech@sote.pl krzys@sote.pl
* @version $Id: record_row.html.php,v 1.7 2007/12/01 10:59:44 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/

$colspan=4;
global $available;
if(($rec->data['price_brutto_detal']>0) && ($rec->data['base_discount']==0) && !$rec->data['points']) {
$colspan++;
}

if ((! empty($rec->data['base_discount']))  && ($rec->data['base_discount']>0) && ($rec->data['base_discount']<99) && !$rec->data['points']) {
$colspan++;
}
global $shop, $prefix, $config;
?> 
<tr> 
  <td>
  
    <div id="block_1">  
<?php
      $bd = new BreadCrumbs();
      $title_tag = $rec->data['name'] . " ( " .$bd->getCategoriesSimple($rec) . " )";  
    ?>
    <div class="head_2">
<table width="100%"><tr><td>
    <h1>
    <?php 
        print $this->get_rewrite_anchor($rec->data['id'],$rec->data['name'],$title_tag);
        print $rec->data['name']."";
    ?>
    </h1>
    </a>
</td><td style="text-align:right;color:#808080;">
   <?php print "[kod mikran: " ?><a title="<?php print $title_tag ?>" href="<?php print '/go/_search/full_search.php?search_item_id='.$rec->data['id']?>" > <?php print $rec->data['id']; ?></a>]
</td>
</tr></table>
    </div>
 <?     
  //    if ( $rec->data['sms'] == '1') 
   //    {
     //     echo 'SMS';          
      // }
?>
       <?
       if ( $rec->data['photo'] == '' ) 
       {
          echo '';          
       }
       else 
       {
       ?>

       <div class="foto">

        <?
         print $this->get_rewrite_anchor($rec->data['id'],$rec->data['name']);
         $bd = new BreadCrumbs();
         $alt_tag = $rec->data['name'] . " ( " .$bd->getCategoriesSimple($rec) . " )";
         $image->show_with_alt_tag($rec->data['photo'],"",$alt_tag,"m_",115,IMAGE_ZOOM_UP_FALSE);
        ?>
		
		</a>
		</div>
		<?
		}
		?>
		<div class="opis">
			
			 <?php 
			 

				  if ($rec->data['id_available']!=0){
				  echo '<div class="tekst_1">';
				  print $lang->available." <b><nobr>".$available->get($rec->data['id_available'],$rec,"string")."</nobr></b>";
				  echo '</div>';
				  }

        $bd1 = new BreadCrumbs();

	//if sms field is set go into saleoff mode
	if($rec->data['sms']) {
        $title = $rec->data['name'] . " w kategorii: " . $bd1->getCategoriesSimple($rec);
	print "<span style=\"float:right\" title=\"$title\"><img src=\"/photo/_promotions/saleoff.jpg\" width=\"120px\"></span>";
	}
					
         //wyswietlenie producenta jesli istnieje
         if (!empty($rec->data['producer']))
         {
             $producer = $lang->cols['producer'].":&nbsp;".LangF::translate($rec->data['producer'])."";
	     echo "<div title=\"$producer\" class=\"tekst_1\">";
             print $producer;
	     echo '<br/></div>';
          }

//          $bd1 = new BreadCrumbs();
          $cat_string = $lang->cols['category'] . ":&nbsp&nbsp" . $bd1->getCategories($rec);
          $cat_title = $rec->data['name'] . " w kategorii: " . $bd1->getCategoriesSimple($rec);
          echo "<div title=\"$cat_title\" class=\"tekst_1\">";
          echo $cat_string;
 	  echo "</div>";
                   
                  if ($config->show_user_id==1){
				  echo '<div class="tekst_1" style="display: none;">';
                  print "<b>".$lang->basket_products_extra['user_id'].":</b> ".$rec->data['user_id'];
				  echo '<br/><br/></div>';
                  }
            ?> 
	     <?php 
                $title = $rec->data['name'] . " w kategorii: " . $bd1->getCategoriesSimple($rec);
                echo "<span title=\"$title\">";
                print $description->short($rec->data['xml_short_description'],$rec->data['xml_description']);
                echo "</span>";
             ?>
			
			
		</div>
    
		<div class="space"></div>
    			<div class="tools">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                  
                            <td class="tools_1">
                            <?php        
                            if ($this->checkView("points",$rec)) {
                            	print $this->info_points();
                            } else if ($this->checkView("price",$rec)) print $this->info_price();
                            ?>
                            </td>
                            <?php
                            //stara cena
                            //wyswietlaj tylko wted kiedy stara cena jest wprowadzona i nie ma rabatu
                               if ( (!$this->checkView("points",$rec)) && 
                                    ($rec->data['price_brutto_detal']>0) && 
                                    (!$rec->data['points']))
                               {
                                  //if (($rec->data['price_brutto_detal']>0) && ($rec->data['base_discount']==0) && !$rec->data['points']){
                            ?>	
                            <td class="tools_1"><?php //if ($this->checkView("price",$rec)) print @$lang->cols['price_brutto_detal']; ?></td>

                            <?php 
                             }    
                           ?>
                            
                              <td rowspan="2">
                                 <table>
                                 <td>
                                 <?php 
                                 // wy¶wietl ikonkê INFO
                                 $this->recInfo($rec->data['id'],$rec);
                                 ?>
                                 </td>
                                 <td>
                                 <?php 
                                    $this->recInfoDescription($rec->data['id'],$rec);
                                  ?>
                                 </td>
                                 </table>
                             </td>

                             <td rowspan="2">
                                 <table>
                                 <td>
                                 <?php 
                                 // wy¶wietl koszyk
                                    //$this->recBasket($rec->data['id'],$rec);                    
                                    //$this->recAjaxBasket($rec->data['id'],$rec);
                                    $this->recHeaderBasket($rec->data['id'],$rec);
                                 ?>
                                 </td>
                                 <td id="basket">
                                 <?php
                                    //$this->recAjaxBasketDescription($rec->data['id'],$rec);
                                    $this->recHeaderBasketDescription($rec->data['id'],$rec);
                                 ?>
                                 </td>
                                 </table>
                              </td>

                              <td rowspan="2">
                                 <table>
                                 <td>
                                 <?php
                                    //$this->recWishlist($rec->data['id'],$rec);   
                                    //$this->recAjaxWishlist($rec->data['id'],$rec);   
                                    $this->recHeaderWishlist($rec->data['id'],$rec);   
                                 ?>
                                 </td>
                                 <td id="basket">
                                 <?php
                                    //$this->recWishlistDescription($rec->data['id'],$rec);   
                                    $this->recHeaderWishlistDescription($rec->data['id'],$rec);   
                                 ?>
                                 </td>
                                 </table>
                             </td>
                
                          </tr>
                          <tr>
                       
                             <td class="tools_2"> 
                              <?php 
                              if ($this->checkView("points",$rec)) 
                              {
                              	print "<b>".$rec->data['points_value']."<b>";
                              } 
			      else if ($this->checkView("price",$rec)) 
			      {
                              print "<div style=\"color: #FF6000; font: bolder 15px Arial;\">".$this->print_price($rec).",- ";
			      print "<span style=\"font: bold 12px Tahoma;color:#808080;\">";
			      print $shop->currency->currency;
                              print "</span>";
			      }
                              ?>			    
			</div>			
                             </td>
                            
                             <?php
                             //stara cena
                             //wyswietlaj tylko wted kiedy stara cena jest wprowadzona i nie ma rabatu
                                if ( (!$this->checkView("points",$rec)) && 
                                   ($rec->data['price_brutto_detal']>0) &&
                                   (!$rec->data['points'])) 
                                 {
                                 //if ((!$this->checkView("points",$rec)) && ($rec->data['price_brutto_detal']>0)&& ($rec->data['base_discount']==0)){
                             ?>	
                             <td class="tools_2">
                            	<B><?php //print"<font color=red><strike>".$rec->data['price_brutto_detal']."</strike>&nbsp;</font>".$shop->currency->currency."\n";?></B>
                             </td>
                             <?php
                             }
                             ?>
                            
                           </tr>
		
                        </table>

			<?php if ($this->checkView("price",$rec)): ?>
			<?php if ($rec->data['base_discount']>0 && $rec->data['base_discount']<99) : ?>

   				<span style="font: bold 12px Tahoma;color:#808080;"><?php printf("Naliczono rabat internetowy <span 					style='color:red;font-size:14px'> %d%% </span> od ceny detalicznej.",$rec->data['base_discount']) ?></span>
				<br/>
         		<?php endif ?>
	 		<?php endif ?>

					</div>

      </div>

  
  </td>
</tr>
