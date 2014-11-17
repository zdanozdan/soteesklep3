<?php
/**
* Formularz edycji produktu
*
* @author  m@sote.pl
* @version $Id: edit_page.html.php,v 2.52 2006/04/28 15:05:19 lechu Exp $
*
* @package    edit
*/

global $config,$lang;

if (empty($rec)) {
    class RecTmp{}
    $rec = new RecTmp();
}

if (@$rec->data['main_page']=="1") $checked_main_page="checked"; else $checked_main_page="";
if (@$rec->data['newcol']=="1") $checked_newcol="checked"; else $checked_newcol="";
if (@$rec->data['promotion']=="1") $checked_promotion="checked"; else $checked_promotion="";
if (@$rec->data['bestseller']=="1") $checked_bestseller="checked"; else $checked_bestseller="";
if (@$rec->data['hidden_price']=="1") $checked_hidden_price="checked"; else $checked_hidden_price="";
if (@$rec->data['points']=="1") $checked_points="checked"; else $checked_points="";
if (@$rec->data['sms']=="1") $checked_sms="checked"; else $checked_sms="";
if (@$rec->data['active']=="1") $checked_active="checked"; else $checked_active="";

global $__edit;
if ($__edit!=true) $checked_active="checked";

if (@$rec->data['ask4price']=="1") $checked_ask4price="checked"; else $checked_ask4price="";
if (@$rec->data['status_vat']=="1") $checked_status_vat="checked"; else $checked_status_vat="";
// sprzadaz kodow/pinow online
if (in_array("main_keys",$config->plugins)) {
    if (@$rec->data['main_keys_online']=="1") $checked_main_keys_online="checked"; else $checked_main_keys_online="";
}

// sprawdz jakie oznaczenia cen domyslnie prezentowac na listach rozwijanych (netto/brutto)
if (@$edit_config->netto=="1") {
    $netto_default="selected";
    $brutto_default="";
} else {
    $netto_default="";
    $brutto_default="selected";
}
// end

// skroc opisy jesli sa zbyt dlugie
require_once ("include/description.inc");
if (! empty($rec->data['xml_short_description'])) {
    $rec->data['xml_description']=$description->short("",$rec->data['xml_description']);
}

if (! empty($rec->data['xml_description'])) {
    $rec->data['xml_short_description']=$description->short("",$rec->data['xml_short_description']);
}
// end

// sprawdz czy jest jakas wartosc w price_curency, jesli nie ma to pod to pole przypisz wartosc price_brutto
// ma to miejsce wtedy, kiedy w polu price_brutto sa wprowad4zone ceny i mamy aktywny modul "currency" i nie
// wprowadzilismy jeszcze zadnych wartosci do price_currency
if (in_array("currency",$config->plugins)) {
    if ((empty($rec->data['price_currency'])) &&  (! empty($rec->data['price_brutto']))) {
        if (@$edit_config->netto!="1") {
            $rec->data['price_currency']=$rec->data['price_brutto'];
        } else  {
            $rec->data['price_currency']=$my_price->brutto2netto($rec->data['price_brutto'],$rec->data['vat']);
        }
    }
}

// odczytaj ID
global $__id;
if ((empty($rec->data['id'])) && (! empty($__id))) {
    $rec->data['id']=$__id;
}

// odczytaj dostawców magazynowych do pola wyboru
if (empty($rec->data['deliverer_id']))
    $rec->data['deliverer_id'] = 0;
$res = $mdbd->select("id,name", "deliverers", "1=1", array(), '', 'array');
$deliverers = array();
if(!empty($res) && (is_array($res))) {
    $deliverers[0] = "---";
    for ($i = 0; $i < count($res); $i++) {
        $deliverers[$res[$i]['id']] = $res[$i]['name'];
    }
}
$deliverers_selected[$rec->data['deliverer_id']] = 'selected';
?>
<?php
/*
include_once("config/category_tree.php"); // tablice do konstrukcji list kategorii
$tree = unserialize($tree);
$category_names = unserialize($category_names);
?>
<script>
<?php
include_once("html/category_selection.js");
*/
?>

<script>
<?php
echo "\n";
include("./html/adv_search.js");
?>


function initTree() { // inicjuj drzewo
    c_root = new CCategory(0, "Wybierz kategorie", null, false); // definicja korzenia

    <?php
    global $js_code;
    echo "
    $js_code
    ";
    ?>
}


</script>

<!-- glowna tabela-->
<table border=0 width=100%>
<tr>
  <td width=30% valign=top>


  <!-- kategorie cena -->
  <form action=<?php print $action;?> method=post name=editForm  enctype=multipart/form-data>
  <input type=hidden name=id value='<?php print $rec->data['id'];?>'>
  <input type=hidden name=update value=true>

  <?php $theme->desktop_open();?>

  <table border=0 width=100%>
  <tr> 
    <td>

    <b><?php print $lang->cols['user_id'];?></b></td>
    <?php
    if ($action=="index.php") {
        // update rekordu
        print "<td><b>".@$rec->data['user_id']."</b></td>\n";
        print "<td><input type=hidden name=item[user_id] value=\"".@$rec->data['user_id']."\">\n";
    } else {
        // dodanie rekordu
        if (! empty($default_user_id)) {
            print "<td><input type=texdt size=16 name=item[user_id] value=\"$default_user_id\"><br>\n";
        } else {
            print "<td><input type=text size=16 name=item[user_id] value=\"".@$rec->data['user_id']."\"><br>\n";
        }
        $theme->form_error('user_id');
        print "</td>\n";
    }
    ?>
  </tr>
  <tr>
    <td>
      <b><?php print $lang->cols['name'];?></b></td>
    <td>
      <input type=text size=28 name=item[name] value='<?php print @$rec->data['name'];?>'>       
      <br><?php $theme->form_error('name');?>
   </td>
  </tr>

  <!-- cena itp.-->
  <!-- waluty -->
  <?php
  // if (in_array("currency",$config->plugins)) {
  if (1) {
  ?>
  <tr bgcolor=<?php print $theme->bg_select3;?>>
    <td><?php print $lang->cols['price_brutto'];?></td>
    <td>
      <?php print $theme->price(@$rec->data['price_brutto']);?> <?php print $config->currency;?>
      <input type=hidden name=item[price_brutto] value=<?php print @$rec->data['price_brutto'];?>>
    </td>
  </tr>
  <tr bgcolor=<?php print $theme->bg_select3;?>>
    <td>
      <nobr>
      <?php print $lang->cols['price_currency'];?></td>
      <td>
            
      <input type=text size=10 name=item[price_currency] value="<?php print $theme->price(@$rec->data['price_currency']);?>">
      <!--
      <input type=hidden name=item[price_currency_long]  value="<?php print @$rec->data['price_currency'];?>">
      <input type=hidden name=item[price_currency_short] value="<?php print $theme->price(@$rec->data['price_currency']);?>">
      -->
      <?php $currency->select_list(@$rec->data['id_currency']);?>
      

      <!-- start netto/brutto: -->
      <select name=item[price_nb]>
      <option value='netto' <?php print $netto_default;?>><?php print $lang->netto;?>
      <option value='brutto' <?php print $brutto_default;?>><?php print $lang->brutto;?>
      </select>
      </nobr>
      <!-- end netto/brutto -->

      <br><?php $theme->form_error('price_currency');?>     
      
    </td>
  </tr>
  <?php
  } else {
  ?>
  <input type=hidden name=item[price_currency] value=''>
  <tr bgcolor=<?php print $theme->bg_select3;?>>
    <td>
      <nobr>      
      <b><?php print $lang->cols['price_brutto'];?></b></td><td><input type=text size=10 name=item[price_brutto] value="<?php print @$rec->data['price_brutto'];?>"> <?php print $config->currency;?><br>

      <!-- start netto/brutto: -->
      <select name=item[price_nb]>
      <option value='netto' <?php print $netto_default;?>><?php print $lang->netto;?>
      <option value='brutto' <?php print $brutto_default;?>><?php print $lang->brutto;?>
      </select>
      </nobr>
      <!-- end netto/brutto -->
    
      <br>
      <?php $theme->form_error('price_brutto');?>
    </td>
  </tr>
  <?php
  }
  ?>
  <!-- end waluty-->

  <!-- vat -->
  <tr bgcolor=<?php print $theme->bg_select3;?>>
    <td><?php print $lang->cols['vat'];?></td>
    <td>
      <?php 
      include_once ("./include/vat.inc.php");
      ?>
      %<br>
      <?php $theme->form_error('vat');?>
    </td>
  </tr>
  <!-- end vat -->

  <tr  bgcolor=<?php print $theme->bg_select3;?>>
    <td>
      <nobr>
      <?php print $lang->cols['price_2'];?></td><td><input type=text size=10 name=item[price_2] value="<?php print @$rec->data['price_2'];?>">
      <?php $theme->form_error('price_2');?>
      <select name=item[price_2_nb]>
      <option value='netto' <?php print $netto_default;?>><?php print $lang->netto;?>
      <option value='brutto' <?php print $brutto_default;?>><?php print $lang->brutto;?>
      </select>
      </nobr>
    </td>
  </tr>
  <tr  bgcolor=<?php print $theme->bg_select3;?>>
    <td>
      <?php print $lang->cols['price_brutto_detal'];?></td>
      <td>
      <input type=text size=10 name=item[price_brutto_detal] value="<?php print $theme->price(@$rec->data['price_brutto_detal']);?>">
      <!--
      <input type=hidden name=item[price_brutto_detal_long] value="<?php print @$rec->data['price_brutto_detal'];?>">
      <input type=hidden size=10 name=item[price_brutto_detal_short] value="<?php $theme->price(print @$rec->data['price_brutto_detal']);?>">
      -->
      
      <?php print $lang->cols['discount'];?>  <input type=text size=4 name=item[discount] value="<?php print @$rec->data['discount'];?>">%
    </td>
  </tr>
<!-- warto¶æ produktu w punktach -->
  <tr  bgcolor=<?php print $theme->bg_select3;?>>
    <td>
      <?php print $lang->cols['points_value'];?></td>
      <td>
      <input type=text size=10 name=item[points_value] value="<?php print @$rec->data['points_value'];?>">
    </td>
  </tr>
  <?php
  // jesli sa definiowane rabaty wg kategorii/producentow i grup kategorii to dodaj definiowanie rabatu progowego produktu
  if (in_array("product_discounts",$config->plugins)) {
      print "<tr bgcolor=$theme->bg_select3>\n";
      print "<td></td><td>".$lang->cols['max_discount']." ";
      print "<input type=text size=4 name=item[max_discount] value=".@$rec->data['max_discount'].">%</td>\n";
      print "</tr>\n";
  }
  ?>
  <!-- end rabat-->

  <!-- producent -->
  <tr bgcolor=<?php print $theme->bg_select2;?>>
    <td><?php print $lang->cols['producer'];?></td>
    <td>
      <?php $form_elements->select("producer",@$rec->data['producer']);?><br>
      <input type=text size=32 name=item[producer] value="<?php print @$rec->data['producer'];?>">
    </td>
  </tr>
  <!-- end producent-->

  <!-- kategorie -->
  <tr>
    <td></td>
    <td><?php print $lang->edit_category_info;?></td>
  </tr>
  <tr>
    <td><b><?php print $lang->cols['category1'];?></b></td>
    <td>
      <select id="item2[category1]" name="item2[category1]"></select>
      <?php
//      $form_elements->select("category1",@$rec->data['category1']);
      ?>
      <?php $theme->add2Dictionary(@$rec->data['category1']);?>
      <br>
      <input type=text size=32 name=item[category1] value="<?php print @$rec->data['category1'];?>"><BR>
      <?php $theme->form_error('category1');?>
    </td>
  </tr>
  <tr bgcolor=<?php print $theme->bg_select;?>>
    <td><?php print $lang->cols['category2'];?></td>
    <td>
      <select id="item2[category2]" name="item2[category2]"></select>
      <?php
//      $form_elements->select("category2",@$rec->data['category2']);
      ?>
      <?php $theme->add2Dictionary(@$rec->data['category2']);?>
      <br>
      <input type=text size=32 name=item[category2] value="<?php print @$rec->data['category2'];?>"><BR>
      <?php $theme->form_error('category2');?>
    </td>
  </tr>
  <tr>
    <td><?php print $lang->cols['category3'];?></td>
    <td>
      <select id="item2[category3]" name="item2[category3]"></select>
      <?php
//      $form_elements->select("category3",@$rec->data['category3']);
      ?>
      <?php $theme->add2Dictionary(@$rec->data['category3']);?>
      <br>
      <input type=text size=32 name=item[category3] value="<?php print @$rec->data['category3'];?>"><BR>
      <?php $theme->form_error('category3');?>
    </td>
  </tr>
  <tr bgcolor=<?php print $theme->bg_select;?>>
    <td><?php print $lang->cols['category4'];?></td>
    <td>
      <select id="item2[category4]" name="item2[category4]"></select>
      <?php
//      $form_elements->select("category4",@$rec->data['category4']);
      ?>
      <?php $theme->add2Dictionary(@$rec->data['category4']);?>
      <br>
      <input type=text size=32 name=item[category4] value="<?php print @$rec->data['category4'];?>"><BR>
      <?php $theme->form_error('category4');?>
    </td>
  </tr>
  <tr>
    <td><?php print $lang->cols['category5'];?></td>
    <td>
      <select id="item2[category5]" name="item2[category5]"></select>
      <?php
//      $form_elements->select("category5",@$rec->data['category5']);
      ?>
      <?php $theme->add2Dictionary(@$rec->data['category5']);?>
      <br>
      <input type=text size=32  name=item[category5] value="<?php print @$rec->data['category5'];?>"><BR>
      <?php $theme->form_error('category5');?>
    </td>
  </tr>
  </table>
    <script>
        initCategories('item2[category1];item2[category2];item2[category3];item2[category4];item2[category5]');
    </script>

  <!-- end kategorie -->

  <!-- strony promocyjne [0|1]-->
  <table width=100%>
  <tr>
    <td colspan="100%">
        <br>
        <?php print $lang->depository_num; ?>: <input type=text size="5" name=item[depository_num] value="<?php print @$rec->data['depository_num'];?>"><BR>
        <?php
        if (!empty($deliverers)) {
            reset($deliverers);
            ?>
            <br>
            <?php print $lang->deliverer; ?>:
            <select name="item[deliverer_id]" style="width: 160px;">
            <?php
            while (list($deliverer_id, $deliverer_name) = each($deliverers)) {
                echo "
                <option value='$deliverer_id' " . @$deliverers_selected[$deliverer_id] . ">$deliverer_name</option>
                ";
            }
            ?>
            </select>
            <?php
        }
        else {
            echo "<input type=hidden name='item[deliverer_id]' value=0>";
        }
        ?>
    </td>
  </tr>
  <tr>
    <td></td>
    <td>
      <input type=checkbox name=item[main_page] <?php print $checked_main_page;?> value=1>
      <?php print $lang->cols['main_page'];?><br>
      <input type=checkbox name=item[newcol] <?php print $checked_newcol;?> value=1>
      <?php print $lang->cols['newcol'];?><br>
      <input type=checkbox name=item[promotion] <?php print $checked_promotion;?> value=1> 
      <?php print $lang->cols['promotion'];?><br>
      <input type=checkbox name=item[bestseller] <?php print $checked_bestseller;?> value=1>
      <?php print $lang->cols['bestseller'];?><br>
      <input type=checkbox name=item[points] <?php print $checked_points;?> value=1>
      <?php print $lang->cols['points'];?><br>
      <?php print $lang->points_warning;?><br>
  
      <!-- nie pokazuj ceny -->
      <?php
      if (in_array("hidden_price",$config->plugins)) {
          print "<input type=checkbox name=item[hidden_price] $checked_hidden_price value=1 \>\n";
          print $lang->cols['hidden_price']."<BR>";
      } else {
          print "<input type=hidden name=item[hidden_price] value=0 \>";
      }
      ?>
      <!-- end -->
 
      <!-- main_keys kody/piny, sprzedaz on-line -->
      <?php
      if (in_array("main_keys",$config->plugins)) {
          print "<input type=checkbox name=item[main_keys_online] $checked_main_keys_online value=1 \>\n";
          print $lang->cols['main_keys_online']."<BR>";
      } else {
          print "<input type=hidden name=item[main_keys_online] value=0 \>";
      }
      ?>
      <!-- end -->   
      
      <input type=checkbox name=item[ask4price] <?php print $checked_ask4price;?> value=1>
      <?php print $lang->cols['ask4price'];?><br>
      
      <input type=checkbox name=item[status_vat] <?php print $checked_status_vat;?> value=1>
      <?php print $lang->cols['status_vat'];?><br>

      <input type=checkbox name=item[active] <?php print $checked_active;?> value=1>
      <?php print $lang->cols['active'];?><br>

      <input type=checkbox name=item[sms] <?php print $checked_sms;?> value=1>
      <?php print $lang->cols['sms'];?><br>
      
   
      
    </td>
    <td valign=top align=right>
      <?php
      if ($action!="add.php") {
          $buttons->button($lang->edit_edit_submit,"javascript:document.editForm.submit();");
      } else {
          $buttons->button($lang->edit_add_submit,"javascript:document.editForm.submit();");
      }       ?>     
    <td>
 
    </tr>
  
    <!-- end strony promocyjne-->

  </table>
  

  <!-- end kategorie cena-->
  <?php $theme->desktop_close();?>
  </td>


<!--opisy-->
  <td width=60% valign=top>
    <?php
    if ($action!="add.php") {
    ?>

    <?php $theme->desktop_open();?>
    <table bgcolor='#f0f0f0' width=100%>
    <tr>
      <td>
        <?php print $lang->upload." ".$lang->cols['xml_description'];?> <input type=file name=desc_file>   
        <br>
        <?php show_desc_file_info(@$rec->data['user_id'],@$rec->data['id']);?>
      </td>
      <td align=right>
        <?php $buttons->button($lang->edit_submit,"javascript:document.editForm.submit();");?>
      </td>
    </tr>
    </table>
    <div align=right>
    <?php $buttons->button($lang->edit_link,"description_lang.php?id=".@$rec->data['id']);?>
    </div>
    <div align=right>
    <?php 
    $onclick=$theme->onclick(360,425);
    $buttons->button($lang->edit_add_review,"/plugins/_reviews/add.php?user_id=".@$rec->data['user_id']." $onclick");
    ?>
    </div>

    <b><?php print $lang->cols['xml_description'];?>:</b><br>
    <?php print @$rec->data['xml_description'];?><br>

    <br>
    <b><?php print $lang->cols['xml_short_description'];?>:</b><br>
    <?php print @$rec->data['xml_short_description'];?><br>
    <p>
    <?php $theme->desktop_close();?>
    <?php
    } else {
        $theme->desktop_open();
        print $lang->edit_add_description_info;
        $theme->desktop_close();
    }
    ?>

    <!-- end opisy-->

    <!-- zdjecia--> 
    <p>
    <?php $theme->desktop_open();?>
    
    <?php print $lang->cols['photo'];?>: <input type=text size=15 name=item[photo] value="<?php print @$rec->data['photo'];?>">

    <input type=hidden name=id value='<?php print @$rec->data['id'];?>'>
    <table border=0 width=100%>
    <tr>
      <td width="0">   
        <?php    
        $image->max_size="150";
        $image->show(@$rec->data['photo'],"");
        ?>
      </td>
      <td>  
        <?php $image->show(@$rec->data['photo'],"","m_");?>
      </td>  
    </tr>
    <tr>
       <td valign=top>
         <?php print $lang->edit_photo_upload;?><br>
         <input type=file size=5 name=item_photo_upload align=center><br>  
         <input type=radio name=del[photo] value="<?php print @$rec->data['photo'];?>" onClick="document.editForm.submit();"><?php print $lang->edit_photo_delete;?>
       </td>
       <td valign=top>
         <?php print $lang->edit_m_photo_upload;?><br>
         <input type=file size=5 name=item_m_photo_upload align=center><br>     
         <input type=radio name=del[m_photo] value="<?php print "m_".@$rec->data['photo'];?>" onClick="document.editForm.submit();"><?php print $lang->edit_photo_delete;?>
      </td>
    </tr>
    
    </table>
    <?php $theme->desktop_close();?>
    <!-- end zdjecia -->
    <p>
     <?php $theme->desktop_open();?>
     <table cellpadding="0" cellspacing="0"  border="0" width="100%">
     <tr>
     	<td valign=top align="left">    
        <table cellspacing="0" cellpadding="0" border=0 align="left">
        <tr>
          <td align="left" width="0"><nobr>PDF (.pdf)</nobr></td>
          <td align="left">&nbsp;&nbsp;<input type=image src=html/_img/pdf.gif style='border-width: 0px;'></td>
        </tr>
         <tr>
         <td colspan="2" align="left"> 
        <input type=file size=5 name=item_pdf_upload align=center><br>
        <input type=hidden name=item[pdf] value='<?php print @$rec->data['pdf'];?>'>
        <?php
        if (! empty($rec->data['pdf'])) {
            print "<a href=/photo/_pdf/".$rec->data['pdf'].">".$rec->data['pdf']."</a> <input type=radio name=del[pdf] value=".@$rec->data['pdf']." onClick=\"document.editForm.submit();\">$lang->delete</a>";
        }
        ?>
        <td>
        </tr>
        <tr>
        <td><img src="<?php $theme->img('_img/mask.gif');?>" height="40"></td>
        </tr>
        <tr>
        <td align="left" width="0"><nobr>DOC (.doc)</nobr></td>
        <td align="left">&nbsp;&nbsp;<input type=image src=html/_img/doc.gif style='border-width: 0px;'></td>
        </tr>
        <tr>
         <td colspan="2" align="left"> 
        <input type=file size=5 name=item_doc_upload align=center><br>
        <input type=hidden name=item[doc] value='<?php print @$rec->data['doc'];?>'>
        <?php
        if (! empty($rec->data['doc'])) {
            print "<a href=/photo/_doc/".$rec->data['doc'].">".$rec->data['doc']."</a> <input type=radio name=del[doc] value=".@$rec->data['doc']." onClick=\"document.editForm.submit();\">$lang->delete</a>";
        }
        ?>
        <td>
        </tr>
        </table>
      </td>
      <td valign=top align="left">
        <table cellspacing=0 cellpadding=0 border=0 align="left"> 
        <tr>
          <td width="0"><nobr>Flash (.swf)</nobr></td>
          <td align=left width="100%">&nbsp;&nbsp;<input type=image src=html/_img/flash.gif style='border-width: 0px;'></td>
        </tr>
        <tr>
        <td colspan="2" align="left" style="padding-top:2px;">
	       	<input type=file size=5 name=item_flash_upload align=center><br>
	        <?php
	        if (! empty($rec->data['flash'])) {
	            print "<a href=/photo/_flash/".$rec->data['flash']." target=preview>".$rec->data['flash']."</a> <input type=radio name=del[flash] value=".@$rec->data['flash']." onClick=\"document.editForm.submit();\">$lang->delete</a>";    }
	        ?>
        </td>
        </tr>
        <tr>
        	<td style="padding-top:6px;"><nobr><?php print $lang->flash_description;?></nobr></td>
        </tr>
        <tr>
         <td colspan="2" align="left" style="padding-top:6px;">
	        <textarea name=item[flash_html] rows=6 cols=26 wrap=off><?php print @$rec->data['flash_html'];?></textarea><br>
	        <input type=hidden name=item[flash] value='<?php print @$rec->data['flash'];?>'> 
        </td>
        </tr>
        </table>
      </td>
     </tr>
     <tr>
     <td colspan="2">
	     <table cellspacing=0 cellpadding=2 border=0 align="left"> 
	     <tr>
		     <td style="padding-top:10px; padding-bottom:10px;" colspan="2">
		     	<?php print $lang->add_link;?>
		     </td>
	     </tr>
	     <tr>
	     <td bgcolor="#fdffc9"><?php print $lang->link['url'];?></td>
	     <td bgcolor="#fdffc9">
	      	<input type=text size=28 name=item[link_url] value='<?php print @$rec->data['link_url'];?>'>       
	     </td>
	     </tr>
	     <tr>
	     <td bgcolor="#fdffc9"><?php print $lang->link['name'];?></td>
	     <td bgcolor="#fdffc9">
	      	<input type=text size=28 name=item[link_name] value='<?php print @$rec->data['link_name'];?>'>       
	     </td>
	     </tr>
	     </table>
     </td>
     </tr>
     </table>
     <?php $theme->desktop_close();?>
    <p>

    <?php $theme->desktop_open();?>
    <table>
    <tr>
    <td valign=top>


      <!-- start dostepnosc -->
      <table>
      <tr bgcolor=<?php print $theme->bg_select;?>>
        <td>
          <?php print @$lang->cols['id_available'];?></td>
        <td>
          <?php $form_elements->select_available(@$rec->data['id_available']);?>
        </td>
      </tr>
      </table>
      <!-- end dostepnosc -->

    </td>
    </tr>
    <tr>
      <td>
        <?php 
        print $lang->cols['weight'];?> [ <?php print $config->unit; ?> ]</b>: <input type=text size=4 name=item[weight] value="<?php print @$rec->data['weight'];?>"><br>
      </td>
    </tr> 
    <tr>
      <td width=50% valign=top>
      
      <table border=0>
      <!-- xml options -->
      <tr>
         <td><?php print $lang->cols['xml_options'];?></td>
         <td>
       
           <?php
           
           if (! empty($rec->data['xml_options'])) {
               // dodaj obsluge pola xml_options
               global $result,$my_xml_options;
               include_once ("include/xml_options.inc");
           }
           // nie wyswietlaj pola <input ...> jesli dany typ opcji nie ma edycji uproszczonej
           // $my_xml_options->checkSimpleEdit() -> false (@see ../include/query_rec.inc.php)
           
           if ((method_exists($my_xml_options,"checkSimpleEdit")) && ($my_xml_options->checkSimpleEdit())) {
               print "<input type=text size=24 name=item[xml_options] value='".@$rec->data['xml_options']."'>\n";
               print "</td>\n";
               print "<td bgcolor=#ffffff>\n";
               $my_xml_options->show($result);
               print "</td>\n";
               print "<td>";
           } else {
               print "<input type=hidden name=item[xml_options2] value='".@$rec->data['xml_options2']."'>\n";
           }
           ?>
           <?php
           if (! empty($rec->data['id'])) {
               $buttons->button("<nobr>".$lang->edit_edit['options_adv']."</nobr>","edit_xml_options_frame.php?id=".$rec->data['id']);
           }
           ?>
          </td>
      </tr>
      <!-- end xml options -->

      <!-- start accessories -->
      <?php
      if (in_array("accessories",$config->plugins)) {
      ?>
      <tr>
        <td>
          <?php print $lang->cols['accessories'];?></b></td><td><input type=text size=24 name=item[accessories] value="<?php print @$rec->data['accessories'];?>"><br>
          <?php $theme->form_error('accessories');?>
        </td>
      </tr> 
      <?php
      } else {
          print "<input type=hidden name=item[accessories] value=''>";
      }
      ?>
      </table>
      <p>
      <?php
      // wstaw liste akcesorii
      if (! empty($rec->data['accessories'])) {
          $__accessories=$rec->data['accessories'];
          include_once ("./include/accessories.inc.php");
      }
      ?>
     <!-- end accessories -->
 
    </td>
  </tr>
  </table>

  <?php $theme->desktop_close();?>

  <p>

 <!-- end zdjecia-->
</td>
</tr>
</table>
<!-- end glowna tabela-->
