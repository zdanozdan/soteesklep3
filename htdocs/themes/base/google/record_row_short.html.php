<?php
/**
* Szablon PHP wygl±du rekordu na li¶cie skróconej.
* Jest on tak¿e wykorzystywany do pokazywania innych produktów z tej samej kategorii i akcesoriów do produktu.
*
* @author  m@sote.pl
* @version $Id: record_row_short.html.php,v 1.1 2005/08/08 14:16:05 maroslaw Exp $
*
* @todo brak opisu zmiennej $odd
* @package    themes
* @subpackage google
*/

global $shop;
?>
<tr bgcolor="<?php if($odd==0){ print $this->record_odd_color; } else { print $config->colors['light'];}?>"> 
  <td style="color: #000000; padding: 1px;" align="left" width="230"><nobr>&nbsp;&nbsp;<a href="/go/_info?id=<?php print $rec->data['id'];?>"> 
    <?php print "".$rec->data['name']."";?></nobr>
    </a></td>
                
  <td style="color: #000000; padding: 1px;" align="left" width="90"> 
   <nobr>
   <?php 
   // wy¶wietlaj cene brutto tylko wtedy gdy hidden price=0
   if ($this->checkView("price",$rec)) {
       print "".$this->print_price($rec)." ".$shop->currency->currency."";
   }
   ?>
   </nobr>
  </td>
               
  <td style="color: #000000; padding: 1px;" align="left" width="90">
	<nobr>
	<?php 
	//stara cena
	//wyswietlaj tylko wted kiedy stara cena jest wprowadzona i nie ma rabatu
	if ((($rec->data['price_brutto_detal']>0)&&($rec->data['base_discount']==0))){
	    if ($this->checkView("price",$rec)) 
	    print"<font color=red><strike>".$rec->data['price_brutto_detal']."</strike>&nbsp;</font>".$shop->currency->currency."\n";
	}
	
	// rabat;
	// wyswietalj tylko wtedy kiedy rabat jest wprowadzony
	if ((! empty($rec->data['base_discount']))  && ($rec->data['base_discount']>0) && ($rec->data['base_discount']<99)) {
	    if ($this->checkView("discount",$rec)) print $lang->cols['discount'].":&nbsp;".$rec->data['base_discount']."%\n";
	}
    ?>
    </nobr>
  </td> 
                            
  <td style="color: #000000; padding: 1px;" align="right" width="60"><?php $this->recInfo($rec->data['id'],$rec);?></td>
  <td style="color: #000000; padding: 1px;" align="right" width="60"><?php $this->recBasket($rec->data['id'],$rec);?></td>             
</tr>
