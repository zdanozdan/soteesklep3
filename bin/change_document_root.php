<?php
/**
* Zmieñ odwo³anie do head.inc we wskazanym pliku.
*
* @author  m@sote.pl
* @version $Id: change_document_root.php,v 1.1 2005/02/21 12:07:25 maroslaw Exp $
* @package bin
*/

error_reporting(1);

if (! empty($_SERVER["argv"][1])) {
    $file=$_SERVER["argv"][1];
} else {
    die ("Unknown file. Try ./change_document_root.php ./path/file.php");
}

// policz na jakim poziomie jest dany skrypt
$level=1;
if ((ereg("\/go\/",$file)) || (ereg("\/plugins\/",$file)) || (ereg("\/setup\/",$file)) ) $level++;
$level+=sizeof(preg_split("/\/_[a-zA-Z0-9_]+/",$file,100))-1;

$fd=fopen($file,"r");
$data=fread($fd,filesize($file));
fclose($fd);

$go_up=str_repeat("/..",$level);
$go_up=substr($go_up,1,strlen($go_up)-1); // obetnij znak "/" na poczatku
// $go_up ma postaæ np: ../../../ dla level=3

// wyszukujemy ciagu ("../include/head.inc");
$data=ereg_replace('\$'."DOCUMENT_ROOT\/..\/include/head.inc",$go_up."/include/head.inc",$data);
print $data;
?>
