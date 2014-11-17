<?php
/**
 * Wyswietl akcesoria do produktow
 *
 * @author piotrek@sote.pl
 * @version $Id: accessories.inc.php,v 2.4 2004/12/20 18:01:39 maroslaw Exp $ 
* @package    info
 */

// nie zezwalaj na bezposrednie wywolanie tego pliku
if ((empty($secure_test)) || (! empty($_REQUEST['secure_test']))) {
    die ("Niedozwolone wywolanie");
}

if (in_array("accessories",$config->plugins)) {
    $accessories->show_accessories(&$rec);
}

?>
