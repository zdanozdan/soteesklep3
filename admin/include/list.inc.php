<?php
/**
 * Lista rekordow
 *
 * \@global string $bar             tytul
 * \@global string $list_th         naglowek tabeli listy rekordow
 * \@global string $sql             zapytanie SQL
 * \@global string $__action        action formularza listy rekordow
 * \@global bool   $__submit        true - wstaw przycisk submit pod tabelka, false - nie wstawiaj
 * \@global string $__onclick       akcja onclick przy wywolaniu "$__submit"
 * 
 * @auhtor m@sote.pl
 * @version $Id: list.inc.php,v 2.8 2006/03/01 08:32:30 lechu Exp $
* @package    admin_include
 */

if (empty($__action)) $__action="delete.php";

include_once ("./include/menu.inc.php");

if (! empty($bar)) $theme->bar($bar);

if (! empty($__submit)) {
    print "<form action=$__action method=POST name=FormList target=window>";
} else {
    print "<form action=$__action method=POST name=FormList>";        
}

// funkcja prezentujaca wynik zapytania w glownym oknie strony 
include_once ("include/dbedit_list.inc");
include_once ("./include/row.inc.php");      // zaladuj klase ModTableRow
$dbedit = new DBEditList;
$dbedit->record_class="ModTableRow";

print "<p>";
$dbedit->start_list_element=$list_th;
global $__dump_all;
if($__dump_all == true) {
    $dbedit->set_page_records = 5000;
}
$dbedit->show();
print "<p>";

if (@$__submit==true) {
    print "<div align=right>";
?>

<script language=JavaScript>
function submitwindow() {
    var my_window = window.open('', 'window', 'resizable=yes,scrollbars=1,height=200,width=500', false);
    document.FormList.submit();     
    my_window.focus();
} 
</script>

<?php
    $buttons->button($lang->update,"javascript:submitwindow();");
    print "</div>";
}

print "</form>";
?>
