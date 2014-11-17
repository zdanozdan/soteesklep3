<?php
/**
* @version    $Id: market_row.html.php,v 2.3 2004/12/20 18:02:36 maroslaw Exp $
* @package    market
*/
global $lang;
global $description;

$id=$rec->data['id'];

// zmien kolory
if (@$this->market_color!=$config->market_color_1) $color=$config->market_color_1;
else  $color=$config->market_color_2;
$this->market_color=$color;

?>

<?php
if (! function_exists("market_list_th")) {
    function market_list_th() {
        $o="<tr>";
        $o.="<th>ID</th>";
        $o.="<th>Kategoria</th>";
        $o.="<th>Data</th>";
        $o.="<th>Tresc ogloszenia</th>";
        $o.="<th>Foto</th>";
        $o.="<th>Zamiescil</th>";
        $o.="</tr>";
        
        return $o;
    } // end market_list_th

    print market_list_th();
}
?>

<tr width=100% bgcolor=<?php print $color;?>>
   <td valign=top>
   <?php print $id;?>
   </td>
   <td valign=top> 
   <?php print $config->market_category[$rec->data['id_market_category']];?>
   </td>
   <td valign=top>
     <B><?php print $rec->data['date_add'];?></B>
   </td>
   <td valign=top>
     <a href=info.php?id=<?php print $id;?>><u><?php print $rec->data['title'];?></u></a><br />
     <br />     
     <?php print $description->short("",$rec->data['description']);?>
   </td>
   <td valign=top> 
     <?php 
   if (! empty($rec->data['photo'])) {
       print $config->market_photo;
   }
     ?>
   </td>
   <td valign=top>
      Kontakt: <?php print $rec->data['name'];?><br />
     <a href="mailto:<?php print $rec->data['email'];?>"><?php print $rec->data['email'];?></a>     
   </td>
</tr>
