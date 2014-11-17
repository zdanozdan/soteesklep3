<?php
/**
 * Skrypt wywolywany jesli wynik wyszukwiania rekordow zwrocil wartosc 0
 *
 * \@depend include/dbedit_list.inc
 *
 * @author  m@sote.pl
 * @version $Id: search_empty_query.html.php,v 1.3 2005/04/20 09:40:40 maroslaw Exp $
* @package    themes
* @subpackage base_notheme
 */


echo "<div id=\"block_1\">";

global $lang;
global $_REQUEST;
global $__new_search_action;


if (! empty($_REQUEST['search_query_words'])) {
    $search_query_words=$_REQUEST['search_query_words'];
} else $search_query_words='';

//if (empty($this->empty_list_message)) {
 //  print $lang->search_empty_list;
//} 

echo "<span id=\"empty_search\">";
echo "<img src=\"/themes/base/base_theme/_img/general_warning.gif\" width=\"100\" align=\"left\">";
echo "Wyszukiwanie nie zwróci³o ¿adnych wyników dla frazy (<span id=\"red\">".$search_query_words."</span>). Mo¿esz spróbowaæ wpisaæ inne zapytanie lub pos³u¿yæ siê drzewem kategorii po lewej stronie.</br>Wyszukiwarka przegl±da wszystkie nazwy i opisy towarów próbuj±c dopasowaæ wynik do zapytania, spróbuj zmodyfikowaæ trochê swoje zapytanie.";
echo "</br>";
echo "<a href=\"/go/_search/advanced_search.php\">Wyszukiwanie zaawansowane .....</a>";
echo "</span>";
echo "</div>";
?>
