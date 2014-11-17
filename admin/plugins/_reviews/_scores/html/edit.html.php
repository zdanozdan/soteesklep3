<?php
/**
 * PHP Template:
 * Formularz edycji rekordu
 *
 * @author piotrek@sote.pl 
 * @version $Id: edit.html.php,v 1.5 2005/04/18 12:05:35 lechu Exp $
* @package    reviews
* @subpackage scores
 */
require_once ("include/metabase.inc");
$database = new my_Database;

include_once ("include/forms.inc.php");
$forms = new Forms;

if(! empty($_REQUEST['id_product'])) {
    $id_product=$_REQUEST['id_product'];
} else {
    $id_product=@$rec->data['id_product'];
}

$score_average=$rec->data['score_amount']/$rec->data['scores_number'];
$score_average_cut=ereg_replace("^([0-9]+\.[0-9][0-9]).*$","\\1",$score_average);  

$product=$database->sql_select("name_L0","main","id=$id_product");

print "<center><TABLE border=0 width=270><TR><TD>";
$theme->desktop_open();
print "<TABLE>";
print "<TR><TD><B>$lang->scores_product_name</B>: $product</TD></TR>";
print "</TABLE>";
$forms->open($action,@$this->id);
$forms->hidden("id_product",@$rec->data["id_product"]);
$forms->text("score_amount",@$rec->data["score_amount"],$lang->scores_cols["score_amount"],5);
$forms->text("scores_number",@$rec->data["scores_number"],$lang->scores_cols["scores_number"],5);
$forms->text("score_average",@$score_average_cut,$lang->scores_cols["score_average"],5,1);
$forms->submit("submit",$lang->edit_submit);

$forms->close();
$theme->desktop_close();
print "</TD></TR></TABLE></center>";

?>
