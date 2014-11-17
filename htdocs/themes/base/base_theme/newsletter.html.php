<?php
/**
* @version    $Id: newsletter.html.php,v 1.1 2006/09/27 21:53:21 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/
global $config;
echo '<div class="head_1">';
echo $lang->bar_title["newsletter"];
echo '</div>';
echo '<div id="block_1" style="text-align: center;"><center>';

$this->file("newsletter_window.html","");
print "<form id=newsletter_frm name=newsletter_frm action=\"/go/_newsletter/index.php\">";
//print "      <td><input type=\"submit\" name=\"newsletter\" value=\" $lang->symbol_del \"></td>\n";
print "      <input type=\"text\" size=\"20\" name=\"email\" style=\"margin: 2px 1px;\"><br/>";
//print "      <td><input type=\"submit\" name=\"newsletter\" value=\" $lang->symbol_add \"></td>\n";
print "  		<input class=\"input\" type=hidden name=newsletter id=newsletter value=\" Dodaj \">";	
print "      <button class=\"button\" onclick='document.getElementById(\"newsletter_frm\").submit();'>$lang->add</button>";
print "      <button class=\"button\" onclick='document.getElementById(\"newsletter\").value=\" Usuñ \"; document.getElementById(\"newsletter_frm\").submit();'>$lang->newsletter_remove</button>";
print "</form>";
echo '</center></div>';
?>
