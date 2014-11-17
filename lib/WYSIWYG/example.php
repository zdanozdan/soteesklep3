<?php
/**
* Przyk³ad wywo³ania
* @author  lech@sote.pl
* @version $Id: example.php,v 1.2 2004/05/24 10:48:12 lechu Exp $
* @package wysiwyg
*/

include("wysiwyg.inc.php");
$wysiwyg =& new Wysiwyg('pl');
$wysiwyg->Editor('<h3>raz dwa trzy</h3>', 'html_out','example_post.php');
?>