<?php
/**
* Szablon PHP wygl±du rekordu w pe³nej prezentacji produktu do druku
*
* @author  krzys@sote.pl
* @version $Id: info.html.php,v 1.3 2006/01/25 09:41:12 lechu Exp $
* @package    themes
* @subpackage print
*/

// XHTML Id: info.html.php,v 2.12 2003/10/15 12:20:10 maroslaw Exp

global $config, $prefix,$wp_config;
global $description;
global $available;
global $DOCUMENT_ROOT;
global $shop;
global $theme;
?>
<div align="left">
<?php
print "http://".$_SERVER['HTTP_HOST']."/?id=";
print $rec->data['user_id'];
?> 
<diV>
<BR><BR>
<center>
 
  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr> 
      
      <td width="100%" valign="top" align="center">
  		<table width="100%" border="0" cellspacing="0" cellpadding="0">          
          <tr> 
            
            <td align="center"><?php print $lang->cols['name'];?></td>
                      
            <?php 
            // wy¶wietlaj cenne brutto tylko wtedy gdy hidden price=0
            if (($rec->data['hidden_price']==0) && ($rec->data['ask4price']==0)) {
            ?>	
            <td align="center">
            <?php 
            //if ($this->checkView("price",$rec)) print $lang->cols['price_brutto'];
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
            <td align="center">
            	<?php 
            	if ($this->checkView("price",$rec)) print $this->info_price();
            	?>
            </td>
            <?php 
            }
             ?>
            
            <?php 
            // rabat;
            // wyswietalj tylko wtedy kiedy rabat jest wprowadzony
            if ((! empty($rec->data['base_discount']))  && ($rec->data['base_discount']>0) && ($rec->data['base_discount']<99)) {
            ?>
            <td align="center">
            	<?php 
            	if ($this->checkView("discount",$rec)) print @$lang->cols['discount'];
            	?>
            </td>
            <?php
            }
            ?>
            
          </tr>
          <tr> 
            <td width="100%" align="center" colspan="100%"><hr width="100%"></td>
          </tr>
          <tr> 
           
            <td align="center"> 
              <?php print $rec->data['name'];?>
            </td>
            
            <?php             
            //wy¶wietlaj cene brutto tylko wtedy gdy hidden price=0
            if (($rec->data['hidden_price']==0) && ($rec->data['ask4price']==0)) {
            ?>
            <td align="center"> <B><CENTER>
              <?php
              // start cena:
              // sprawdz, czy w opcjach sa atrybuty zmiany cen
              if ($this->checkView("price",$rec)) {
                  print $price=$this->print_price($rec)." ".$shop->currency->currency;
              }
              // end cena:
             ?>
              </B> </CENTER></td>
            <?php 
            }
            ?>
             <?php
             //stara cena
             //wyswietlaj tylko wted kiedy stara cena jest wprowadzona i nie ma rabatu
             if (($rec->data['price_brutto_detal']>0)&& ($rec->data['base_discount']==0)){
             ?>	
            <td align="center">
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
            if ((! empty($rec->data['base_discount']))  && ($rec->data['base_discount']>0) && ($rec->data['base_discount']<99)) {
            ?>
            <td align="center">
            	<?php 
            	if ($this->checkView("discount",$rec)) print $rec->data['base_discount']."%\n";
            	?>
            </td> 
            <?php
            }
            ?>
            
            </tr>
          <tr> 
            <td width="100%" align="center" colspan="100%"><img src="<?php $this->img("_img/mask.gif");?>" width="1" height="1"></td>
          </tr>
        </table>
        <br>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="318" style="padding: 8px;" valign="top" align="left"> 
              <!-- Opis produktu -->
              <?php
              //wyswietlenie producenta jesli istnieje
              if (!empty($rec->data['producer'])){
                  print $lang->cols['producer'].":&nbsp;".LangF::translate($rec->data['producer'])."<BR><BR>";
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
            </td>
            <td width="250" align="center" valign="top" style="padding: 8px 0px;"> 
              
              <!-- start zdjecie produktu: -->
              <?php $image->show($rec->data['photo'],"no");?>
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
             
              <table width="250" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="250" align="center" colspan="4">
                  <BR>
                    <?php print $lang->available . ' ' . $available->get($rec->data['id_available'],$rec,"string");?>                
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        
        
            </td>
          </tr>
        </table>        
      </td>
    </tr>
  </table> 
</center>
