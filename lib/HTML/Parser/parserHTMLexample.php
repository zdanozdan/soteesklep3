<?php
require_once ("parserHTML.php");
$fd=fopen("../../../lib/HTML/Parser/test2.html","r");
$html=fread($fd,filesize("../../../lib/HTML/Parser/test2.html"));
fclose($fd);

$parser_html =& new ParserHTML;
$html=$parser_html->parse($html);

print "<textarea style='width: 100%; height: 100%'>$html</textarea>";
?>
