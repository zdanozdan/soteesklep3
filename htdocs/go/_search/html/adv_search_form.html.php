<?php
include_once ("include/metabase.inc");
global $database;
global $theme;
global $shop;
global $config_search;
?>

<?php 
echo '<div class="head_1">';
echo $lang->adv_search_elements['header'];
echo '</div>';
echo '<div id="block_1">';
?>
<table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
  
  <tbody>
  <tr> 
    <td align="center"> 
      <form name="form1" method="get" action="advanced_search.php">
      <input type="hidden" name="send_form" value="1">
        <table border="0" cellspacing="3" cellpadding="3">
         
          <?php 
          if ($config_search->by_name==1){
          ?>  
          <tr> 
            <td align="right"><?php print $lang->adv_search_fields['name'];?></td>
            <td align="left">
               <input type="text" name="form[name]" value="<?php $theme->form_val('name');?>"><br />
              <?php $theme->form_error('name');?>
            </td>
          </tr>
          
          <?php
          }
          if ($config_search->by_phrase==1){
          ?>
          <tr> 
            <td align="right"><?php print $lang->adv_search_fields['phrase'];?></td>
            <td align="left"> 
              <input type="text" name="form[phrase]" value="<?php $theme->form_val('phrase');?>"><br />
              <?php $theme->form_error('phrase');?>
            </td>
          </tr>
         
           <?php
          }
          if ($config_search->by_price==1){
          ?>
             
          <tr> 
            <td align="right"><?php print $lang->adv_search_fields['price']."&nbsp;&nbsp;".$lang->adv_search_elements['from'];?></td>
            <td>
              <table border="0" cellspacing="0" cellpadding="0" align="left">
                <tr>
                  <td><input size="6" type="text" class="input" name="form[price_min]" value="<?php $theme->form_val('price_min');?>"><br><?php $theme->form_error('price_min')?></td>                 
                  <td>&nbsp;&nbsp;</td>
                  <td><?php print $lang->adv_search_elements['to']."&nbsp;&nbsp;";?><input size=6 type="text"  class="input" name="form[price_max]" value="<?php $theme->form_val('price_max');?>"><br /><?php $theme->form_error('price_max');?></td>
                  <td>&nbsp;&nbsp;<?php print $shop->currency->currency;?><td>
                </tr> 
              </table>
            </td>
           </tr>
           <?php
          if ($config_search->by_price_netto_brutto==1){
          ?>
             <tr>
            <td></td>
            <td>
              <table border="0" cellspacing="0" cellpadding="0" align="left">
                <tr>
                   <td><input type="radio" style="border-width:0px;" name="form[brutto_netto]" value="1" checked>&nbsp;&nbsp;<?php print $lang->basket_th_brutto;?></td><td>&nbsp;&nbsp;</td><td><input type="radio" style="border-width:0px;" name="form[brutto_netto]" value="0">&nbsp;&nbsp;<?php print $lang->basket_th_netto;?></td>
                </tr>
              </table>
            </td>
          </tr>
         
          <?php
          
          }
          }
          if ($config_search->by_attrib==1){
          ?>
         
          <tr> 
            <td align="right"><?php print $lang->adv_search_fields['attributes'];?></td>
            <td class="input"> 
              <input class="input1" type="text" name="form[size]"  class="input" value="<?php $theme->form_val('size');?>"> <br />
              <?php $theme->form_error('bowl');?>
            </td>
          </tr> 
              
          <?php
          }
          if ($config_search->by_producer==1){
          ?>
          
          
           <tr> 
            <td align="right"><?php print $lang->adv_search_fields['producer'];?></td>
            <td align="left"> 
            <?php
            @$str=$database->sql_select_select2("main","form[producer]","id_producer","producer",$_REQUEST['form']['producer'],"","opt=".@$lang->producer_select.$lang->list_select," GROUP BY 'producer' ORDER BY producer");
			print $str;
            $theme->form_error('producer');?>
            </td>
          </tr> 
          
           <?php }
          if ($config_search->by_category==1){
          ?>
          <tr>
            <td align="center" colspan="2">
                <br>
                <?php print $lang->adv_search_choose_category . "\n"; ?>
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
            </td>
          </tr>

          <tr> 
            <td align="right"><?php print $lang->adv_search_fields['category1'];?></td>
            <td align="left"> 
                <select style="width: 141px;"  class="input" name="form[c1]" id=form[c1] onchange="selectCategory(this)">
            </td>
          </tr>
          <tr> 
            <td align="right"><?php print $lang->adv_search_fields['category2'];?></td>
            <td align="left"> 
                <select    name="form[c2]" id=form[c2] class="input" onchange="selectCategory(this)">
            </td>
          </tr>
          <tr> 
            <td align="right"><?php print $lang->adv_search_fields['category3'];?></td>
            <td align="left"> 
                <select   class="input" name="form[c3]" id=form[c3] onchange="selectCategory(this)">
            </td>
          </tr>
          <tr> 
            <td align="right"><?php print $lang->adv_search_fields['category4'];?></td>
            <td align="left"> 
                <select   class="input" name="form[c4]" id=form[c4] onchange="selectCategory(this)">
            </td>
          </tr>
          <tr> 
            <td align="right"><?php print $lang->adv_search_fields['category5'];?></td>
            <td align="left"> 
                <select   class="input" name="form[c5]" id=form[c5] onchange="selectCategory(this)">
            </td>
          </tr>
          
          <script>
           initCategories('form[c1];form[c2];form[c3];form[c4];form[c5]');
          </script>
          
          <?php }?>
          
        <tr>
        <td></td>
            <td align="left">
              <input type="submit" name="Submit" value="<?php print $lang->adv_search_elements['send_button'];?>">
            </td>
          </tr>
         
        </table>
      </form>
    </td>
  </tr>
  </tbody>
</table>
</div>
