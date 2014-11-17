<?php 
/**
* Szablon PHP prezentacji produktu w okienkach promocyjnych (nowo¶ci/promocje/itp)
*
* @author  m@sote.pl
* @version $Id: random_record.html.php,v 1.2 2007/03/20 11:38:09 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/
global $lang;
global $shop;
global $config;
include_once ("plugins/_breadcrumbs/include/breadcrumbs.inc.php");
include_once ("plugins/_breadcrumbs/lang/_$config->lang/lang.inc.php");

?>

<table align=center border=0>
  <tr>
    <td align=center>
      <?php 
         print $this->get_rewrite_anchor($rec->data['id'],$rec->data['name']);
         $bd = new BreadCrumbs();
         $alt_tag = $rec->data['name'] . " ( " .$bd->getCategoriesSimple($rec) . " )";
         $image->show_with_alt_tag($rec->data['photo'],"",$alt_tag,"m_",115,IMAGE_ZOOM_UP_FALSE);
         print "<br/>" . $rec->data['name'];
// zmiana IMAGE_ZOOM_UP_FALSE na IMAGE_ZOOM_UP_TRUE spowoduje mozliwo¶c powiêkszenia zdjecia po klikniêciu na fotkê
//           $image->show($rec->data['photo'],"","m_",0,IMAGE_ZOOM_UP_FALSE);
      ?>
      </a>
    </td>
  </tr>
  <tr>
    <td align=center class="row_short_td">
      <?php
       print $this->get_rewrite_anchor($rec->data['id'],$rec->data['name']);
       print "<br/>";
       print LangF::translate(@$rec->data['producer']);
      ?><br/>
      </a>
      <br>
      <?php
      
      if ($this->checkView("price",$rec) && !$this->checkView("points",$rec))
      print $this->info_price().": <B>".$this->print_price($rec)."&nbsp;".$shop->currency->currency."</B>";
      
      // rabat %
//      if (!$this->checkView("points",$rec) && (! empty($rec->data['base_discount']))  && ($rec->data['base_discount']>0) && ($rec->data['base_discount']<99)) {
//        if ($this->checkView("discount",$rec))
//        print "<br />$lang->discount: ".$rec->data['base_discount']."%\n";
//    }
      
      // start cena detaliczna: jesli nie ma rabatu to pokaz przekreslona cene detaliczna produktu
        if ( (!$this->checkView("points",$rec)) && 
           ($rec->data['price_brutto_detal']>0) && 
           (!$rec->data['points']))
        {
           //if ((!$this->checkView("points",$rec)) && (@$rec->data['base_discount']==0) && (@$rec->data['price_brutto_detal']>0)) {
          if ($this->checkView("price",$rec))
          print "<br>".$lang->cols['price_brutto_detal'].": <font color=red><strike>".$rec->data['price_brutto_detal']."</strike></font>\n";
      }
      if ($this->checkView("points",$rec)) {
      	print "<b>".$rec->data['points_value']."</b> ".$lang->cols['m_points'];
      }
      // end cena detaliczna:
      ?>
      <p />

    </td>
  </tr>
</table>
<hr/>
