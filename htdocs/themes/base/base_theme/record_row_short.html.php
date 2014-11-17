<!-- record_row_short.html.php -->

<?php
/**
* Szablon PHP wygl±du rekordu na li¶cie skróconej.
* Jest on tak¿e wykorzystywany do pokazywania innych produktów z tej samej kategorii i akcesoriów do produktu.
*
* @author  m@sote.pl
* @version $Id: record_row_short.html.php,v 1.4 2007/12/01 12:25:30 tomasz Exp $
*
* @todo brak opisu zmiennej $odd
* @package    themes
* @subpackage base_theme
*/

global $shop;
global $image;
?>



<?php //if($odd==0){ print $this->record_odd_color; } else { print $config->colors['light'];}?>

<?php include_once ("plugins/_breadcrumbs/include/breadcrumbs.inc.php"); ?>



<?php if ($this->count == 0) : ?>
  <tr> 
<?php endif ?>
  <td style="border-bottom:1px solid grey;" align="center">
  <table cellspacing="0" cellpadding="0" align="center" border=0>
   <tr> 
     <td align="center">
       <?php
         print $this->get_rewrite_anchor($rec->data['id'],$rec->data['name']);
         print "".$rec->data['name']."";
       ?>
      
   
     </td>
     <tr> 
     <td align="center">
     <?php
       $bd = new BreadCrumbs();
       $alt_tag = $rec->data['name'] . " ( " .$bd->getCategoriesSimple($rec) . " )";
       print $this->get_rewrite_anchor($rec->data['id'],$rec->data['name']);
         $image->show_with_alt_tag($rec->data['photo'],"",$alt_tag,"m_",515,IMAGE_ZOOM_UP_FALSE);
       print "</a>";

      //print $this->get_rewrite_anchor($rec->data['id'],$rec->data['name']);
      // print "".$rec->data['name']."";
    ?>
     </td>
     </tr>

     <tr> 
       <td align="center">
	<div style="font: bold 15px Tahoma; text-align:center;color: #FF6000;">
	<?php if ($this->checkView("price",$rec)) 
	{
          $price=$rec->data['price_netto'].",-";
          print $price;          
        } 
        ?>
<?php if($rec->data['sms']) : ?>

<img src="/photo/_promotions/saleoff.jpg" width="60px">

<?php endif ?>
        </div>
       </td>
     </tr>
   <tr> 
       <td align="center">
       <?php if ($this->checkView("price",$rec)) 
	{
          //$price=$rec->data['price_netto'].",-";
          //print $price;
          if($rec->data['price_brutto'] && $rec->data['price_netto'] > 0)
          {
            if($rec->data['price_netto'] > 1)
            {
               print "<span style=\"font: 10px Tahoma;color:#808080;\">";
               printf("&nbsp&nbsp&nbsp +%.0f%% VAT",$rec->data['price_brutto']/$rec->data['price_netto']*100 - 100 );
               print("</span>");
            }
          }
        } 
        ?>
       </td>
   </tr>
  </table>
</td>
<?php if ($this->count == 3) : ?>
  <?php $this->count = 0 ?>
  </tr>
<?php else: ?>
  <?php $this->count++ ?>
<?php endif ?>
