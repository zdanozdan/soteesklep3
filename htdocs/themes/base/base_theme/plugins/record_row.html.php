<?php
/**
* Szablon rozszerzonej prezentacji produktu na li¶cie produktów.
* Prezentacja z opisem i pomniejszonym zdjêciem.
*
* @author  rp@sote.pl m@sote.pl lech@sote.pl krzys@sote.pl
* @version $Id: record_row.html.php,v 2.36 2006/01/16 12:29:48 krzys Exp $
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
      <table  border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td background="<?php $this->img($prefix . $config->theme_config['box']['img']['middle']['left']);?>"><img alt="" src="<?php $this->img($prefix . $config->theme_config['box']['img']['middle']['left']);?>"></td>
          <td width="100%" align="center"><br>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td align="center" width="150">&nbsp;</td>
                <td align="left" valign="top" style="padding: 4px;" width="228"><b><a  href="/go/_info/?id=<?php print $rec->data['id'];?>"> 
                  <?php print $rec->data['name']."<BR><BR>";?>
                  </a> </b>
                  <?php 
                  //wyswietlenie producenta jesli istnieje
                  if (!empty($rec->data['producer'])){
                      print $lang->cols['producer'].":&nbsp;".LangF::translate($rec->data['producer'])."<BR><BR>";
                  }
                   
                  if ($config->show_user_id==1){
                  print "<b>".$lang->basket_products_extra['user_id'].":</b> ".$rec->data['user_id'];
                  }
                  ?> 
                   	
                  </td>
              </tr>
              <tr> 
                <td align="center" valign="top" style="padding: 4px;"> <a href="/go/_info/?id=<?php print $rec->data['id'];?>"> 
                  <?php $image->show($rec->data['photo'],"","m_",115,IMAGE_ZOOM_UP_FALSE);?>
                  </a><br>
                   <?php 
                  if ($rec->data['id_available']!=0){
                  print $lang->available." <b><nobr>".$available->get($rec->data['id_available'],$rec,"string")."</nobr></b>";
                  }
                  ?>
                  </td>
                <td align="left" valign="top" style="padding: 4px 50px 4px 4px;"> 
                  <?php print $description->short($rec->data['xml_short_description'],$rec->data['xml_description']);?>
                </td>
              </tr>
            </table>
            <br>
            <br>
          </td>
          <td><img alt="" src="<?php $this->img($prefix . $config->theme_config['box']['img']['middle']['right']);?>"></td>
        </tr>
      </table>
      
      <table  border="0" cellspacing="0" cellpadding="0">
        <tr> 

          <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                        <td width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr bgcolor="<?php echo $config->theme_config['colors']['color_2'];?>">
                            <td height="1" background="<?php $this->img($prefix . $config->theme_config['box']['img']['middle']['left']);?>" width="1"><img alt="" src="<?php $this->img($prefix . $config->theme_config['box']['img']['middle']['left']);?>"></td>
                            <td style="color: <?php echo $config->theme_config['colors']['header_font']; ?>; padding: 0px;" align="center">
                            <b>
                            <?php        
                            if ($this->checkView("points",$rec)) {
                            	print $this->info_points();
                            } else if ($this->checkView("price",$rec)) print $this->info_price();
                            ?>
                            </b>
                            </td>
                            <?php
                            //stara cena
                            //wyswietlaj tylko wted kiedy stara cena jest wprowadzona i nie ma rabatu
                            if (($rec->data['price_brutto_detal']>0) && ($rec->data['base_discount']==0) && !$rec->data['points']){
                            ?>	
                            <td style="color: <?php echo $config->theme_config['colors']['header_font']; ?>; padding: 2px;" align="center">
                            <B>
                            <?php 
                            if ($this->checkView("price",$rec)) print @$lang->cols['price_brutto_detal'];
                            ?>
                            </B>
                            </td>
                            <?php 
                             }
                             ?>
                            
                             <?php 
                             // rabat;
                             // wyswietalj tylko wtedy kiedy rabat jest wprowadzony
                             if ((! empty($rec->data['base_discount']))  && ($rec->data['base_discount']>0) && ($rec->data['base_discount']<99) && (!$this->checkView("points",$rec))) {
                             ?>
                            <td style="color: <?php echo $config->theme_config['colors']['header_font']; ?>; padding: 2px;" align="center">
                             <B>
                             <?php 
                             if ($this->checkView("price",$rec)) print $lang->cols['discount'];
                             ?>
                             </B>
                             </td>
                             <?php
                             }
                              ?>
                            
                            <td style="color: <?php echo $config->theme_config['colors']['header_font']; ?>; padding: 2px;" align="center"><b>&nbsp;</b></td>
                            <td style="color: <?php echo $config->theme_config['colors']['header_font']; ?>; padding: 2px;" align="center"><b>&nbsp;</b></td>
                            <td style="color: <?php echo $config->theme_config['colors']['header_font']; ?>; padding: 2px;" align="center"><b>&nbsp;</b></td>
                            <td height="1" background="<?php $this->img($prefix . $config->theme_config['box']['img']['middle']['right']);?>" width="1"><img alt="" src="<?php $this->img($prefix . $config->theme_config['box']['img']['middle']['right']);?>"></td>
                          </tr>
                          <tr>
                             <td ><img src="<?php $this->img($prefix . $config->theme_config['box']['img']['middle']['left']);?>"></td>
                             <td style="padding: 2px;" align="center"> sssssssssssssssssssssssssssssssssss
                              <?php 
                              if ($this->checkView("points",$rec)) {
                              	print "<b>".$rec->data['points_value']."<b>";
                              } else if ($this->checkView("price",$rec)) 
                              print "<B>".$this->print_price($rec)." ".$shop->currency->currency."</b>";
                              ?>
                             </td>
                            
                             <?php
                             //stara cena
                             //wyswietlaj tylko wted kiedy stara cena jest wprowadzona i nie ma rabatu
                             if ((!$this->checkView("points",$rec)) && ($rec->data['price_brutto_detal']>0)&& ($rec->data['base_discount']==0)){
                             ?>	
                             <td style="padding: 2px;" align="center" valign="middle">
                            	<B><?php print"<font color=red><strike>".$rec->data['price_brutto_detal']."</strike>&nbsp;</font>".$shop->currency->currency."\n";?></B>
                             </td>
                             <?php
                             }
                             ?>
                            
                             <?php
                             // rabat;
                             // wyswietalj tylko wtedy kiedy rabat jest wprowadzony
                             if ((!$this->checkView("points",$rec)) && (! empty($rec->data['base_discount']))  && ($rec->data['base_discount']>0) && ($rec->data['base_discount']<99)) {
                              ?>
                             <td style="padding: 2px;"  align="center" valign="middle">
                        	 <B>
                        	 <?php 
                        	 if ($this->checkView("discount",$rec)) print $rec->data['base_discount']."%\n";
                        	 ?>
                        	 </B>
                             </td> 
                             <?php
                             }
                             ?> 
                                                        
                             <td style="padding: 2px;" align="center" valign="middle">
                              <?php 
                              // wy¶wietl ikonkê INFO
                              $this->recInfo($rec->data['id'],$rec);
                              ?>                  
                             </td>
                             <td style="padding: 2px;" align="center" valign="middle">
                              <?php 
                              // wy¶wietl koszyk
                              $this->recBasket($rec->data['id'],$rec);                    
                              ?>
                              </td>
                              <td style="padding: 2px;" align="center" valign="middle">
                              <?php
                              $this->recWishlist($rec->data['id'],$rec);   
                              ?>
                             </td>
                             <td width="1" style="background-image: url(<?php $this->img($prefix . $config->theme_config['box']['img']['middle']['right']);?>); background-repeat: repeat-y;"><img src="<?php $this->img($prefix . $config->theme_config['box']['img']['middle']['right']);?>"></td>
                          </tr>
                        </table></td>
                </tr>
              </table></td>

        </tr>
      </table>
      </div>


    <br>
    
  </td>
</tr>
