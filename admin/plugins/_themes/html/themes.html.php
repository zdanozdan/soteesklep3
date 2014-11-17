<?php
/**
 * Zarz±dzanie tematami wygl±du sklepu
 *
 * @author     amiklosz@sote.pl
 * @version    $Id: themes.html.php,v 1.16 2005/01/28 15:35:32 lechu Exp $
* @package    themes
*/
?>

<?php require_once("HTML/Form.php"); ?>

<?php
/**
 * @param string $action akcja formularza
 * @param string $method metoda przesy³ania danych formularzowych
 * @param string $forName nazwa formularza
 * @param string $title tekst, który pojawi siê w rozwijalnej liscie
 * @param array $options tablica warto¶ci w rozwijanej li¶cie
 * @param string $selected domy¶lnie wybrana warto¶æ
 */
function printSelectForm($action, $method, $formName, $title, $options, $selected) {
  global $lang, $config;
  
  $htmlForm = new HTML_Form($action, $method, $formName);
  $htmlForm->addSelect("thm", $title, $options, $selected);
  $htmlForm->addHidden("update","1");
  $htmlForm->display();
}
?>



<?php
  include ("include/menu.inc.php");
  $theme->bar($lang->themes_title);
  print $lang->themes_info;
  print "<p>\n";
?>


<table align="center" width="90%">

<!-- start Edycja istniej±cego tematu: -->
<tr>
  <td align="right"><?php print $lang->themes_edit_info; ?></td>
  <td><?php printSelectForm("action_edit.php", "get", "formEdit", "", $config->editable_themes, $config->theme ); ?></td>
  <td><?php print $buttons->button(@$lang->themes_menu['themes'],"javascript:document.formEdit.submit()");?></td>
</tr>
<!-- end Edycja istniej±cego tematu: -->


<!-- start Ustawienie domy¶lnego tematu: -->
<tr>
  <td  align="right"><?php print $lang->themes_set; ?></td>
  <td><?php printSelectForm("action_setdefault.php", "get", "formSetDefault", "", $config->themes, $config->theme); ?></td>
  <td><?php print $buttons->button(@$lang->themes_menu['set_theme'],"javascript:document.formSetDefault.submit()");?></td>
</tr>
<!-- end Ustawienie domy¶lnego tematu: -->

<!-- start W³±czenie obs³ugi wielu tematów: -->
<tr>
  <td  align="right"><?php print $lang->themes_show_info; ?></td>
  <td>
    <?php
      $htmlChoose = new HTML_Form("action_choose.php", "get", "formChoose");
      //$htmlChoose->addPlaintext("", $lang->themes_show_info);
      
      reset($config->themes);
      $checked = "";
      foreach ($config->themes as $key=>$thm)
      {
        // zaznacz te tematy, które s± ustawione jako aktywne
        foreach ($config->themes_active as $key_act=>$thm_act)
        {
          if ( !empty($config->themes_active[$key]) )
            $checked="1";
          else $checked="";
        }
        
        // zaznacz równie¿ ten tamat, który który jest wybrany jako domy¶lny
        if ($config->theme == $key)
          $checked="1";
//          print $buttons->button($lang->delete,'"/plugins/_themes/action_add_delete.php?action=delete&new_theme_name=' . $thm . '" onclick="open_window(500,400);" target="window"');
          $htmlChoose->addCheckbox("active[$key]", $thm . " <a href='/plugins/_themes/action_add_delete.php?action=delete&new_theme_name=$thm' onclick='open_window(500,400);' target=window>[" . $lang->delete . "]</a>", $checked);
      }
    
      $htmlChoose->addHidden("update","1");
      $htmlChoose->display();
    ?>
  </td>
  <td><?php print $buttons->button($lang->update,"javascript:document.formChoose.submit()");?></td>
</tr>
<tr>
    <td align="right"><?php echo $lang->themes_addition; ?></td>
    <td><?php print $buttons->button($lang->add,'"/plugins/_themes/action_add_delete.php?action=add" onclick="open_window(500,400);" target="window"');?></td>
</tr>
<!-- end W³±czenie obs³ugi wielu tematów: -->

</table>

</p>
