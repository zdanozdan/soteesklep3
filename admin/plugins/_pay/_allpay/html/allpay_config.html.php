<?php 
print "<br>";
$theme->desktop_open("100%"); 

if (@$allpay_config->allpay_active=="1") $checked_active="checked"; else $checked_active="";
if (@$allpay_config->allpay_status=="1") $checked_status="checked"; else $checked_status="";
if (@$allpay_config->allpay_ch_lock=="1") $checked_ch_lock="checked"; else $checked_ch_lock="";
if (@$allpay_config->allpay_onlinetransfer=="1") $checked_onlinetransfer="checked"; else $checked_onlinetransfer="";

if (@$allpay_config->allpay_channel==0) $checked_channel_0="checked"; else $checked_channel_0="";
if (@$allpay_config->allpay_channel==1) $checked_channel_1="checked"; else $checked_channel_1="";
if (@$allpay_config->allpay_channel==2) $checked_channel_2="checked"; else $checked_channel_2="";
if (@$allpay_config->allpay_channel==3) $checked_channel_3="checked"; else $checked_channel_3="";
if (@$allpay_config->allpay_channel==4) $checked_channel_4="checked"; else $checked_channel_4="";
if (@$allpay_config->allpay_channel==6) $checked_channel_6="checked"; else $checked_channel_6="";
if (@$allpay_config->allpay_channel==7) $checked_channel_7="checked"; else $checked_channel_7="";
if (@$allpay_config->allpay_channel==8) $checked_channel_8="checked"; else $checked_channel_8="";
if (@$allpay_config->allpay_channel==9) $checked_channel_9="checked"; else $checked_channel_9="";
if (@$allpay_config->allpay_channel==10) $checked_channel_10="checked"; else $checked_channel_10="";
if (@$allpay_config->allpay_channel==11) $checked_channel_11="checked"; else $checked_channel_11="";
if (@$allpay_config->allpay_channel==12) $checked_channel_12="checked"; else $checked_channel_12="";
if (@$allpay_config->allpay_channel==13) $checked_channel_13="checked"; else $checked_channel_13="";
if (@$allpay_config->allpay_channel==14) $checked_channel_14="checked"; else $checked_channel_14="";
if (@$allpay_config->allpay_channel==15) $checked_channel_15="checked"; else $checked_channel_15="";
if (@$allpay_config->allpay_channel==16) $checked_channel_16="checked"; else $checked_channel_16="";
if (@$allpay_config->allpay_channel==17) $checked_channel_17="checked"; else $checked_channel_17="";
if (@$allpay_config->allpay_type==0) $selected_type_0="selected"; else $selected_type_0="";
if (@$allpay_config->allpay_type==1) $selected_type_1="selected"; else $selected_type_1="";
if (@$allpay_config->allpay_type==2) $selected_type_2="selected"; else $selected_type_2="";
if (@$allpay_config->allpay_type==3) $selected_type_3="selected"; else $selected_type_3="";


 
?>
<form action=index.php method=POST name=allpay_config>
<input type=hidden name=item[save] value=1>
<center>
<table border=0 cellpadding="3" cellspacing="0" width="98%" align="center">
<tr>
<td valign="top"><table border=0 cellpadding="2" cellspacing="0">
    <tr>
    <td colspan=2 align="center"><?php print "<img src=";$theme->img("_icons/allpay_logo.gif");print ">\n";?></td>
    </tr>
	<tr>
	<td><?php print $lang->allpay_config['id'];?></td>
	<td><input type=text size=20 name=item[id] value='<?php print @$allpay_config->allpay_id; ?>'></td>
	</tr>
	<tr>
	<td><?php print $lang->allpay_config['url'];?></td>
	<td><input type=text size=40 name=item[url] value='<?php print "http://".$config->www."/".@$allpay_config->allpay_url; ?>'></td>
	</tr>
	<tr>
	<td><?php print $lang->allpay_config['urlc'];?></td>
	<td><input type=text size=40 name=item[urlc] value='<?php print "http://".$config->www."/".@$allpay_config->allpay_urlc; ?>'></td>
	</tr>
	<tr>
	<td><?php print $lang->allpay_config['out_url'];?></td>
	<td><input type=text size=40 name=item[out_url] value='<?php print @$allpay_config->allpay_out_url; ?>'></td>
	</tr>
	<tr>
	<td><?php print $lang->allpay_config['pr_set'];?></td>
	<td><input type=text size=20 name=item[pr_set] value='<?php print @$allpay_config->allpay_pr_set; ?>'></td>
	</tr>
	<tr>
	<td><?php print $lang->allpay_config['active'];?></td>
	<td><input type="checkbox" name=item[active] <?php print $checked_active;?>></td>
	</tr>
	<tr>
	<td><?php print $lang->allpay_config['status'];?></td>
	<td><input type="checkbox" name=item[status] <?php print $checked_status;?>></td>
	</tr>
	<tr>
	<td><?php print $lang->allpay_config['ch_lock'];?></td>
	<td><input type="checkbox" name=item[ch_lock] <?php print $checked_ch_lock;?>></td>
	</tr>
	<tr>
	<td><?php print $lang->allpay_config['onlinetransfer'];?></td>
	<td><input type="checkbox" name=item[onlinetransfer] <?php print $checked_onlinetransfer;?>></td>
	</tr>
    <tr>
	<td><?php print $lang->allpay_config['type'];?></td>
	<td><select name="item[type]">
	<option value=0 <?php print $selected_type_0;?>>0</option>
	<option value=1 <?php print $selected_type_1;?>>1</option>
	<option value=2 <?php print $selected_type_2;?>>2</option>
	<option value=3 <?php print $selected_type_3;?>>3</option>
	</select></td>
	</tr>
	<tr>
	<td><?php print $lang->allpay_config['buttontext'];?></td>
	<td><textarea name=item[buttontext] rows="3" cols="20"><?php print @$allpay_config->allpay_buttontext; ?></textarea></td>
	</tr>
	<tr>
	<td><?php print $lang->allpay_config['txtguzik'];?></td>
	<td><textarea name=item[txtguzik] rows="3" cols="20"><?php print @$allpay_config->allpay_txtguzik; ?></textarea></td>
	</tr>
	
	</table>
</td>
<td valign="top"><table border=0 cellpadding="2" cellspacing="0">
	<tr>
		<td colspan="2"><?php print $lang->allpay_config['channel'];?>:</td>
	</tr>
	<tr>
	<td><input type="radio" name="item[channel]" value=0 <?php print $checked_channel_0;?>></td>
	<td><?php print $lang->allpay_channel[0];?></td>
	</tr>
	<tr>
	<td><input type="radio" name="item[channel]" value=1 <?php print $checked_channel_1;?>></td>
	<td><?php print $lang->allpay_channel[1];?></td>
	</tr>
	<tr>
	<td><input type="radio" name="item[channel]" value=2 <?php print $checked_channel_2;?>></td>
	<td><?php print $lang->allpay_channel[2];?></td>
	</tr>
	<tr>
	<td><input type="radio" name="item[channel]" value=3 <?php print $checked_channel_3;?>></td>
	<td><?php print $lang->allpay_channel[3];?></td>
	</tr>
	<tr>
	<td><input type="radio" name="item[channel]" value=4 <?php print $checked_channel_4;?>></td>
	<td><?php print $lang->allpay_channel[4];?></td>
	</tr>
	<tr>
	<td><input type="radio" name="item[channel]" value=6 <?php print $checked_channel_6;?>></td>
	<td><?php print $lang->allpay_channel[6];?></td>
	</tr>
	<tr>
	<td><input type="radio" name="item[channel]" value=7 <?php print $checked_channel_7;?>></td>
	<td><?php print $lang->allpay_channel[7];?></td>
	</tr>
	<tr>
	<td><input type="radio" name="item[channel]" value=8 <?php print $checked_channel_8;?>></td>
	<td><?php print $lang->allpay_channel[8];?></td>
	</tr>
	<tr>
	<td><input type="radio" name="item[channel]" value=9 <?php print $checked_channel_9;?>></td>
	<td><?php print $lang->allpay_channel[9];?></td>
	</tr>
	<tr>
	<td><input type="radio" name="item[channel]" value=10 <?php print $checked_channel_10;?>></td>
	<td><?php print $lang->allpay_channel[10];?></td>
	</tr>
	<tr>
	<td><input type="radio" name="item[channel]" value=11 <?php print $checked_channel_11;?>></td>
	<td><?php print $lang->allpay_channel[11];?></td>
	</tr>
	<tr>
	<td><input type="radio" name="item[channel]" value=12 <?php print $checked_channel_12;?>></td>
	<td><?php print $lang->allpay_channel[12];?></td>
	</tr>
	<tr>
	<td><input type="radio" name="item[channel]" value=13 <?php print $checked_channel_13;?>></td>
	<td><?php print $lang->allpay_channel[13];?></td>
	</tr>
	<tr>
	<td><input type="radio" name="item[channel]" value=14 <?php print $checked_channel_14;?>></td>
	<td><?php print $lang->allpay_channel[14];?></td>
	</tr>
	<tr>
	<td><input type="radio" name="item[channel]" value=15 <?php print $checked_channel_15;?>></td>
	<td><?php print $lang->allpay_channel[15];?></td>
	</tr>
    <tr>
	<td><input type="radio" name="item[channel]" value=16 <?php print $checked_channel_16;?>></td>
	<td><?php print $lang->allpay_channel[16];?></td>
	</tr>
	<tr>
	<td><input type="radio" name="item[channel]" value=17 <?php print $checked_channel_17;?>></td>
	<td><?php print $lang->allpay_channel[17];?></td>
	</tr>
	
	</table>
</td>
</tr>
</table>
<center>
<?php
      $buttons->button($lang->allpay_config['save'],"javascript:document.allpay_config.submit();");
?>
</center>
<?php 

$theme->desktop_close(); 
?>
