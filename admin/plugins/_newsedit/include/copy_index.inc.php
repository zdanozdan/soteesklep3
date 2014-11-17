<?php
/**
 * Skopiuj plik template/index.php do katalogu newsa np. do http://www.example.com/plugins/_newsedit/news/1
 * 
 * \@global int $global_id id dodanego newsa
 *
 * @author m@sote.pl
 * @version $Id: copy_index.inc.php,v 2.5 2004/12/20 18:00:09 maroslaw Exp $
 *
 * \@verified 2004-03-19 m@sote.pl
* @package    newsedit
 */

if ($global_secure_test!=true) die ("Forbidden");

if (empty($global_id)) {
    die ("Forbidden: Unknown ID");
}

require_once ("include/ftp.inc.php");

$local=$DOCUMENT_ROOT."/plugins/_newsedit/template/index.php";
$remote_dir="$config->ftp_dir/htdocs/plugins/_newsedit/news/".$global_id."/";
$remote="index.php";
$ftp->put($local,$remote_dir,$remote);

?>
