<?php
/**
 * PHP Template:
 * Formularz edycji rekordu
 *
 * @author piotrek@sote.pl 
 * @version $Id: edit.html.php,v 1.10 2005/10/20 06:44:59 krzys Exp $
* @package    reviews
 */

require_once ("include/metabase.inc");
$database = new my_Database;

include_once ("include/forms.inc.php");
$forms = new Forms;

if (empty($rec->data['user_id'])) {
	@$rec->data['user_id']=$_REQUEST['item']['user_id'];
	if(empty($rec->data['user_id'])) {
		@$rec->data['user_id']=$_REQUEST['user_id'];
	}
}
if (empty($rec->data['author'])) {
	@$rec->data['author']=$_REQUEST['item']['author'];
	if(empty($rec->data['author'])) {
		@$rec->data['author']=$_REQUEST['author'];
	}
}

$user_id=@$rec->data['user_id'];
$product=$database->sql_select("name_L0","main","user_id=$user_id");
print "<B>$lang->reviews_product_name</B>: $product";


if (empty($rec->data['date_add'])) {
	@$rec->data['date_add']=date("Y-n-j");
}

for ($i=1;$i<=5;$i++) {
	$data[$i]=$i;
}

global $config;

for ($i = 0; $i < count($config->langs_symbols);$i++) {
	$r_langs[$config->langs_symbols[$i]]=$config->langs_names[$i];
}


$script=$_SERVER['SCRIPT_NAME'];
preg_match("/([0-9a-z_]+.php)$/",$script,$matches);
if (! empty($matches[1])) {
	$script_new=$matches[1];
}

print "<center><TABLE border=0><TR><TD align=center>";
$theme->desktop_open();
$forms->open($action,@$this->id);

if (! empty($_REQUEST['id']))  {
	$forms->text("user_id",@$rec->data["user_id"],$lang->reviews_cols["user_id"],20,1);
	$forms->text("date_add",@$rec->data["date_add"],$lang->reviews_cols["date_add"],20,1);
	$forms->hidden("user_id",@$rec->data["user_id"]);
	$forms->hidden("date_add",@$rec->data["date_add"]);

} else {
	if (empty($_REQUEST['user_id'])) {
		$forms->text("user_id",@$rec->data["user_id"],$lang->reviews_cols["user_id"]);
	} else {
		$forms->text("user_id",@$rec->data["user_id"],$lang->reviews_cols["user_id"],20,1);
		$forms->hidden("user_id",@$rec->data["user_id"]);
	}

	$forms->text("date_add",@$rec->data["date_add"],$lang->reviews_cols["date_add"]);
}


$forms->select("score",@$rec->data["score"],$lang->reviews_cols["score"],$data);
$forms->select("lang",@$rec->data["lang"],$lang->reviews_cols["lang"],$r_langs);
$forms->text_area("description",@$rec->data["description"],$lang->reviews_cols["description"],10,30,"hard");

if (!empty($rec->data['author_id'])){
	$forms->text("author",@$rec->data["author"],$lang->reviews_cols["author"],20,1);
	$forms->hidden("author",@$rec->data["author"]);
	$forms->hidden("author_id",@$rec->data["author_id"]);
}else{
	$forms->text("author",@$rec->data["author"],$lang->reviews_cols["author"],20);
}
$forms->checkbox("state",@$rec->data['state'],$lang->reviews_cols['state']);
$forms->submit("submit",$lang->edit_submit);
$forms->close();
$theme->desktop_close();
print "</TD></TR></TABLE></center>";
?>
