<?php
/**
* @version    $Id: users_edit.html.php,v 1.12 2006/01/30 14:56:51 krzys Exp $
* @package    users
*/
require_once ("include/metabase.inc");

global $buttons;

if ($rec->data['hurt']==1) {
    $hurt_yes=" checked";
    $hurt_no="";
} else {
    $hurt_yes="";
    $hurt_no=" checked";
}

if (@$rec->data['active']==0) {
    $active_yes=" checked";
    $active_no="";
} else {
    $active_yes="";
    $active_no=" checked";
}

if (@$rec->data['newsletter']==0) {
    $newsletter_yes=" checked";
    $newsletter_no="";
} else {
    $newsletter_yes="";
    $newsletter_no=" checked";
}

if (@$rec->data['lock_user']==1) {
    $lock_user=1;
} else $lock_user=0;
?>

<form action=edit.php method=post name=usersForm>
<input type=hidden name=update value=true>
<?php
// jesli do danych klienta user wszedl z transakcji to przekaz dalej id transakcji, po to
// zeby mozna bylo do niej powróciæ
if (! empty($_REQUEST['order_id'])) {
    print "<input type=hidden name=order_id value=".$_REQUEST['order_id'].">\n";
}
?>
<input type=hidden name=id value='<?php print $rec->data['id'];?>'>
<input type=hidden name=form[hurt] value='<?php print @$rec->data['hurt'];?>'>
<input type=hidden name=form[id_discounts_groups] value='<?php print @$rec->data['id_discounts_groups'];?>'>
<input type=hidden name=form[lock_user] value='<?php print @$rec->data['lock_user'];?>'>

<!-- main table -->
<table align=center border=0 width=100% cellspacing=0 cellpadding=0>
<tr>
<td valign=top width=60%>
<!-- start main table-->


<table border=0 width=100%>
<tr>
<td valign=top>

<!-- start dane dodatkowe -->
<?php $theme->desktop_open("50%"); ?>
 <table border=0 align=center width=100%>
 <tr>
  <td align=right><B>ID</B></td><td><b><?php print @$rec->data['id'];?></B>, login:  <B><?php print $rec->data['login'];?></b></td>
  <td align=right rowspan=2 valign=bottom>
 <?php  $buttons->button($lang->update,"javascript:document.usersForm.submit();"); ?>
  </td>
 </tr>
 <tr>
  <td align=right>E-mail</td><td><a href=mailto:<?php print @$rec->data['email'];?>><u><?php print @$rec->data['email'];?></u></a></td>
 </tr>
<!-- <tr>
  <td align=right><?php print $lang->users['active'];?>:</td>
  <td>
    <input type=radio name=form[active] value=0<?php print $active_no;?>><?php print $lang->no;?>
    <input type=radio name=form[active] value=1<?php print $active_yes;?>><?php print $lang->yes;?>
  </td>
 </tr>
 <tr>
  <td align=right><?php print $lang->users['newsletter'];?>:</td>
  <td>
    <input type=radio name=form[newsletter] value=0<?php print $newsletter_no;?>><?php print $lang->no;?>
    <input type=radio name=form[newsletter] value=1<?php print $newsletter_yes;?>><?php print $lang->yes;?>
  </td>
 </tr>
-->
</table>


<!-- start dane billingowe -->
<?php $theme->frame_open($lang->users['billing']);?>
<table border=0 width=370>
 <tr>
  <td align=right><?php print $lang->users['firm'];?></td><td><input type=text size=34 name=form[firm] value='<?php print @$rec->data['firm'];?>'></td>
 </tr>
 <tr>
  <td align=right><b><?php print $lang->users['name'];?></b></td><td><input type=text size=34 name=form[name] value='<?php print @$rec->data['name'];?>'></td>
 </tr>
 <tr>
  <td align=right><b><?php print $lang->users['surname'];?></b></td><td><input type=text size=34 name=form[surname] value='<?php print @$rec->data['surname'];?>'></td>
 </tr>
 <tr>
  <td align=right><b><?php print $lang->users['email'];?></b></td><td><input type=text size=34 name=form[email] value='<?php print @$rec->data['email'];?>'></td>
 </tr>
 <tr>
  <td align=right>
    <b><?php print $lang->users['street'];?></b></td>
  <td>
    <input type=text size=20 name=form[street] value='<?php print @$rec->data['street'];?>'>
    <input type=text size=4 name=form[street_n1] value='<?php print @$rec->data['street_n1'];?>'>
    / <input type=text size=4 name=form[street_n2] value='<?php print @$rec->data['street_n2'];?>'>
    </td>
 </tr>
 <tr>
    <td align=right><b><?php print $lang->users['postcode'];?>,<?php print $lang->users['city'];?> </b></td><td><input type=text size=7 name=form[postcode] value='<?php print @$rec->data['postcode'];?>'>  
<input type=text size=24 name=form[city] value='<?php print @$rec->data['city'];?>'>
    </td>
 </tr>
 <tr>
    <td align=right><?php print $lang->users['country'];?></td>
    <td>
    <?php $theme->inputCountries('form[country]', @$rec->data['country']); ?>
    </td>
 </tr>     
 <tr>
  <td align=right><b><?php print $lang->users['phone'];?></b></td><td><input type=text size=34 name=form[phone] value='<?php print @$rec->data['phone'];?>'></td>
 </tr>
 <tr>
  <td align=right><?php print $lang->users['nip'];?></td><td><input type=text size=34 name=form[nip] value='<?php print @$rec->data['nip'];?>'></td>
 </tr>
</td>
</tr>
<?php 
if (! empty($rec->data['user_description'])) {
?>
<tr>
  <td align="right" valign="top"><?php print $lang->users['user_description'];?></td>
  <td>
    <?php 
    print $rec->data['user_description'];
    ?>
  </td>
</tr>
<?php
}
?>
</table>
<?php $theme->frame_close();?>
<!-- end dane bilingowe -->


<!-- start dane korespondencyjne -->
<?php $theme->frame_open($lang->users['cor']);?>
<table border=0 width=370>
 <tr>
  <td align=right><?php print $lang->users['firm'];?></td><td><input type=text size=34 name=form[cor_firm] value='<?php print @$rec->data['cor_firm'];?>'></td>
 </tr>
 <tr>
  <td align=right><b><?php print $lang->users['name'];?></b></td><td><input type=text size=34 name=form[cor_name] value='<?php print @$rec->data['cor_name'];?>'></td>
 </tr>
 <tr>
  <td align=right><b><?php print $lang->users['surname'];?></b></td><td><input type=text size=34 name=form[cor_surname] value='<?php print @$rec->data['cor_surname'];?>'></td>
 </tr>
 <tr>
  <td align=right><?php print $lang->users['email'];?></td><td><input type=text size=34 name=form[cor_email] value='<?php print @$rec->data['cor_email'];?>'></td>
 </tr>
 <tr>
  <td align=right>
    <b><?php print $lang->users['street'];?></b></td><td><input type=text size=20 name=form[cor_street] value='<?php print @$rec->data['cor_street'];?>'> 
    <input type=text size=4 name=form[cor_street_n1] value='<?php print @$rec->data['cor_street_n1'];?>'> /
    <input type=text size=4 name=form[cor_street_n2] value='<?php print @$rec->data['cor_street_n2'];?>'> 
  </td>
 </tr>
 <tr>
    <td align=right><b><?php print $lang->users['postcode'];?>,<?php print $lang->users['city'];?> </b></td><td><input type=text size=7 name=form[cor_postcode] value='<?php print @$rec->data['cor_postcode'];?>'> 
<input type=text size=24 name=form[cor_city] value='<?php print @$rec->data['cor_city'];?>'>
    </td>
 </tr> 
  <tr>
    <td align=right><?php print $lang->users['country'];?></td>
    <td>
    <?php $theme->inputCountries('form[cor_country]', @$rec->data['cor_country']); ?>
    </td>
         
 <tr>
  <td align=right><b><?php print $lang->users['phone'];?></b></td><td><input type=text size=34 name=form[cor_phone] value='<?php print @$rec->data['cor_phone'];?>'></td>
 </tr>
 </tr>   
 </table>
<?php $theme->frame_close();?>
<table width=100% border=0>
 <tr>
  <td></td>
 </tr>
 <tr>
  <td align=right>
   <?php  $buttons->button($lang->update,"javascript:document.usersForm.submit();"); ?>
  </td>
 </tr>
</table>
<!-- end dane korespondencyjne -->


</form>
<!-- end form edit user-->
<?php $theme->desktop_close();?>

<!-- end main table -->
</td>
<?php
if ($rec->data['order_data']==0) {
?>
<td valign=top width="100%">
<!-- start right -->


<form action=edit.php method=post>
<input type=hidden name=id value='<?php print $rec->data['id'];?>'>
<input type=hidden name=update_points value=true>

 <?php $theme->desktop_open();?>
 <table border=0 align=center>
 <tr>
  <td></td><td><?php print $lang->users['sum_amount'];?></td>
 </tr>
 <tr>
  <td></td><td><B><?php print $rec->data['sum_amount'];?> <?php print $config->currency;?></B></td>
 </tr>
 </table>
 <?php $theme->desktop_close();?>
 <p>
</form>

<!-- start rabaty, uzytkownik hurtowy, blokada -->

<form action=edit.php method=post name=usersForm1>
<input type=hidden name=update value=true>
<input type=hidden name=id value='<?php print $rec->data['id'];?>'>
<input type=hidden name=form[firm] value='<?php print @$rec->data['firm'];?>'>
<input type=hidden name=form[name] value='<?php print @$rec->data['name'];?>'>
<input type=hidden name=form[surname] value='<?php print @$rec->data['surname'];?>'>
<input type=hidden name=form[email] value='<?php print @$rec->data['email'];?>'>
<input type=hidden name=form[street] value='<?php print @$rec->data['street'];?>'>
<input type=hidden name=form[street_n1] value='<?php print @$rec->data['street_n1'];?>'>
<input type=hidden name=form[street_n2] value='<?php print @$rec->data['street_n2'];?>'>
<input type=hidden name=form[postcode] value='<?php print @$rec->data['postcode'];?>'>
<input type=hidden name=form[city] value='<?php print @$rec->data['city'];?>'>
<input type=hidden name=form[country] value='<?php print @$rec->data['country'];?>'>
<input type=hidden name=form[phone] value='<?php print @$rec->data['phone'];?>'>
<input type=hidden name=form[nip] value='<?php print @$rec->data['nip'];?>'>
<input type=hidden name=form[cor_firm] value='<?php print @$rec->data['cor_firm'];?>'>
<input type=hidden name=form[cor_name] value='<?php print @$rec->data['cor_name'];?>'>
<input type=hidden name=form[cor_surname] value='<?php print @$rec->data['cor_surname'];?>'>
<input type=hidden name=form[cor_email] value='<?php print @$rec->data['cor_email'];?>'>
<input type=hidden name=form[cor_street] value='<?php print @$rec->data['cor_street'];?>'>
<input type=hidden name=form[cor_street_n1] value='<?php print @$rec->data['cor_street_n1'];?>'>
<input type=hidden name=form[cor_street_n2] value='<?php print @$rec->data['cor_street_n2'];?>'>
<input type=hidden name=form[cor_postcode] value='<?php print @$rec->data['cor_postcode'];?>'>
<input type=hidden name=form[cor_city] value='<?php print @$rec->data['cor_city'];?>'>
<input type=hidden name=form[cor_country] value='<?php print @$rec->data['cor_country'];?>'>
<input type=hidden name=form[cor_phone] value='<?php print @$rec->data['cor_phone'];?>'>

<?php $theme->desktop_open();?>
 <table border=0 align=center>

 <!-- uzytkownik hurtowy --> 
 <tr>
  <td align=right width=60%><?php print $lang->users['hurt'];?>:</td>
  <td>
    <input type=radio name=form[hurt] value=0<?php print $hurt_no;?>><?php print $lang->no;?>
    <input type=radio name=form[hurt] value=1<?php print $hurt_yes;?>><?php print $lang->yes;?>
  </td>
 </tr>
 <!-- koniec uzytkownik hurtowy -->
 
 <!-- grupy rabatowe -->
 <?php if (in_array("discounts",$config->plugins)): ?>
 <tr>
   <td align=right><?php print $lang->users['group'];?></td>
   <td> 
     <?php
     // wy¶wietl listê grup rabatowych, zaznacz odpowiedni± grupê, jesli kleint jest do niej przypisany
     $query="SELECT *FROM discounts_groups ORDER BY group_name";
     $result=$db->Query($query);
     if ($result!=0) {
         $num_rows=$db->NumberOfRows($result);
         if ($num_rows>0) {
             print "<select name=\"form[id_discounts_groups]\">\n";
             print "<option value=0>---</option>\n";
             for ($r=0;$r<$num_rows;$r++) {
                 $user_id=$db->FetchResult($result,$r,"user_id");
                 $group_name=$db->FetchResult($result,$r,"group_name");
                 if ($rec->data['id_discounts_groups']==$user_id) $selected="selected"; else $selected='';
                 print "<option value=\"$user_id\" $selected>$group_name</option>\n";
             }
             print "</select>\n";
         } else print "<input type=hidden name=\"form[id_discounts_groups]\" value=\"0\">\n";
     } else die ($db->Error());
     ?>
   </td>
 </tr>
 <?php endif; ?> 
 <!-- koniec grupy rabatowe -->

 <!-- blokada przechodzenia uzytkownikow do innych grup rabatowych -->
 <?php if(in_array("users_sales",$config->plugins)): ?>
 <tr>
  <td align=right><?php print $lang->users['lock_user'];?>:</td>
  <td>
  <?php if ($lock_user==1) { ;?> 
    <input type=checkbox name=form[lock_user] checked>
  <?php } else {;?>
    <input type=checkbox name=form[lock_user]>
  <?php };?>
  </td>
 </tr>
 <tr>
 <?php endif;?> 
 <!-- koniec blokada -->
 
<tr>
  <td align=right colspan=2>
    <?php  $buttons->button($lang->update,"javascript:document.usersForm1.submit();"); ?>
  </td>
 </tr>
 </table>
<?php $theme->desktop_close();?>
<br>
<?php $theme->desktop_open();?>
<table border="0" cellpadding="0" cellspacing="0">
<tr>
<td><?php print $lang->users['admin_remarks'];?>:</td>
</tr>
<tr>
<td style="padding-top:5px;"><textarea rows="5" cols="40" name="form[remark_admin]"><?php print @$rec->data['remark_admin'];?></textarea></td>
</tr>
<tr>
  <td align=right colspan=2>
    <?php  $buttons->button($lang->update,"javascript:document.usersForm1.submit();"); ?>
  </td>
 </tr>
</table>
<?php $theme->desktop_close();?>
</form>

</td>

<?php
} // end if ($rec->data['id_users_data']==0)
?>

</tr>
</table>
