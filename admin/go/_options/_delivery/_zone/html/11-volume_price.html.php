<?php
global $mdbd;
global $_REQUEST;
$data=$mdbd->select("id,name,range_max","delivery_volume");
// jesli otwieramy dopiero formularz to wez dane z bazy o ile juz wpis istnieje
if(empty($_REQUEST['item'])) {
	$str=$mdbd->select("price","delivery_price","id_zone=".$_REQUEST['id_zone']." AND id_delivery=".$_REQUEST['id_delivery']);
	if(!empty($str)) {
		$_REQUEST['item']=unserialize($str);
	}
}
?>
<form action="volume_price.php" method=POST>
<input type=hidden name=update value=true>
<input type=hidden name=id_delivery value=<?php print $_REQUEST['id_delivery']; ?> >
<input type=hidden name=id_zone value=<?php print $_REQUEST['id_zone']; ?> >
<input type=hidden name=id value=<?php print @$this->id;?>> 
<p>
<table align='center'>
<?php
foreach($data as $key=>$value) {
	print "<tr><td>";
	print $value['name'].":: ".$lang->delivery_zone_to." ".$value['range_max'];
	print "</td><td>";
	print "<input type=text name=item[".$value['id']."] value='".@$_REQUEST['item'][$value['id']]."' size=5>";
	print "</td></tr>\n";
}
?>
<tr>
 <td></td><td><input type=submit value="<?php print $lang->edit_submit;?>">
</tr>
</table>
</form>