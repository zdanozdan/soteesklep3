<?php
/**
* Formularz - wprowadzenie tre¶ci newslettera + okre¶lenie grup, do których bêdzie on wys³any.
*
* @author  rdiak@sote.pl
* @version $Id: newsletter_form.html.php,v 2.13 2006/03/03 07:52:58 krzys Exp $
* 
* verified 2004-03-10 m@sote.pl
* @package    newsletter
* @subpackage users
*/

?>
<br>
<center>
<?php $theme->desktop_open("650"); ?>

<?php
/**
* Dodaj funkcje dodatkowej obs³ugi Metabase.
*/
include_once("include/metabase.inc");
$table=$database->sql_select_data_array("user_id","name","newsletter_groups","");
?>

<?php global $table ?>
<form action=send1.php method=POST target=window name=newsletterForm>
<input type=hidden name=send value=true>
<p>

<table align=center>
<tr><td>

  <?php $theme->frame_open($lang->newsletter_sending);?>
  <table>
  <tr>
   <td><?php print $lang->newsletter_cols['subject']?></td>
   <td><input type=text size=52 name=item[subject]><br>
   </td>
  </tr>
  <tr>
   <td><?php print $lang->newsletter_cols['content']?></td>
   <td>     
     HTML <input type=checkbox name=item[type] value='html'><br />
     <textarea rows=10 cols=50 name=item[message] warp='virtual'></textarea><br />     
   </td>
  </tr>
  </table>
  <?php $theme->frame_close();?>

</td>

<td valign=top>

  <?php 
   $theme->frame_open($lang->newsletter_cols['groups']);
   $i=0; 
   foreach ($table as $key => $value) { 
       print "<input type=checkbox name=groups[$i] value='$key' $value>$value<br>";    
       $i++;
   }
   $theme->frame_close();
   ?>
   
   <?php
   // wybór jêzyka
   global $config;
   print "<p>".$lang->newsletter_lang_select_info."<BR>";
   print "<select name=lang>\n";
   foreach ($config->langs_symbols as $lang_key=>$lang_name) {
       if ($lang_name==$config->lang) $selected="selected"; else $selected='';
       print "<option value='$lang_name' $selected>$lang_name</option>\n";
   }
   print "</select>\n";
   ?>
</td>
</tr>
</table>


<table align=center>
<tr>
 <td></td><td align=center>
   <?php
      $buttons->button($lang->newsletter_send,"javascript:document.newsletterForm.submit(); onclick=\"open_window(515,350);\"");
   ?>
</tr>
</table>
<?php $theme->desktop_close(); ?>
</form>
