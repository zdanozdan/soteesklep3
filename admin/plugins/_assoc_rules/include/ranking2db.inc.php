<?php
/**
* Zapisz listê rankingow± do bazy
*
* @author  lech@sote.pl
* @version $Id: ranking2db.inc.php,v 1.3 2005/11/03 12:21:06 lechu Exp $
*
* @package    _assoc_rules
*/

if ($global_secure_test!=true) {
    die ("Forbidden");
}
global $stream, $theme, $_REQUEST;
reset($assoc_rules->Rules);

/**/
while (list($key, $val) = each($assoc_rules->Rules)) {
	$ranking = serialize($val);
	$query = "UPDATE main SET ranking=? WHERE user_id=?";
	$prepared_query=$db->PrepareQuery($query);
	if ($prepared_query) {
	    $db->QuerySetText($prepared_query,1,$ranking);
	    $db->QuerySetInteger($prepared_query,2,$key);
	}
	$result = $db->ExecuteQuery($prepared_query);
	if(empty($_REQUEST['cron_mode']))
	   $stream->line_blue();
}

?>