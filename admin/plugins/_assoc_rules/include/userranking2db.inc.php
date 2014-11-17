<?php
/**
* Zapisz listê rankingow± u¿ytkownika do pliku
*
* @author  lech@sote.pl
* @version $Id: userranking2db.inc.php,v 1.2 2005/11/03 10:28:47 lechu Exp $
*
* @package    _assoc_rules
*/
global $config, $current_user_id, $ftp, $assoc_rules, $db;
require_once ("include/ftp.inc.php");

if ($global_secure_test!=true) {
    die ("Forbidden");
}
/*
if(is_array($assoc_rules->Rules))
	reset($assoc_rules->Rules);
*/

/**/
//$ranking = serialize($assoc_rules->Rules);
$ranking = serialize($product_ranking);

$query = "UPDATE users SET ranking=? WHERE id=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$ranking);
    $db->QuerySetInteger($prepared_query,2,$current_user_id);
}
$result = $db->ExecuteQuery($prepared_query);

/*
$filecontents = '<?php

$user_ranking = unserialize(\'' . $ranking . '\');

?>';


$local=$DOCUMENT_ROOT . "/tmp/user_ranking.inc.php";

$fp = fopen($local, "w");
fwrite($fp, $filecontents);
fclose($fp);

$remote_dir = $config->ftp['ftp_dir']."/htdocs/go/_users/config/ranking";
$filename = $current_user_id . "_config.inc.php";
$ftp->connect();
$ftp->put($local,$remote_dir,$filename);
$ftp->close();
*/
?>