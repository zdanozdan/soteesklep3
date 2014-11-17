<?php
/**
 * PHP Template:
 * Prezentacja wiersza rekordu
 * 
 * @author m@sote.pl
 * \@template_version Id: row.html.php,v 1.3 2003/02/06 11:55:15 maroslaw Exp
 * @version $Id: row.html.php,v 2.6 2005/03/14 14:05:14 lechu Exp $
* @package    dictionary
* \@lang
 */

$id=$rec->data['id'];
global $lang;
?>
 
<tr>
    <td>
       <a href=edit.php?id=<?php print $id;?> onClick="open_window(350,350);" target=window><u> <?php print $rec->data['wordbase'];?></u></a>
   </td>

<?php
// pokaz tlumaczenia we wszystkich dostepnych jezykach
reset($config->languages_names);
reset($config->langs_names);
$col_count = 0;
while (list($clang,$clang_name) = each($config->langs_names)) {
    if($config->langs_active[$clang]) {
        $col_count++;
        $ls = $config->langs_symbols[$clang];
        if ($clang!=$config->lang_id) print "<td>".$rec->data[$ls]."</td>\n";
    }
}
// end
?>
   <td>
       <nobr><input type=checkbox name=del[<?php print $id;?>]><?php print $lang->delete;?></nobr>   
   </td>
</tr>

<?php 
$theme->lastRow($col_count);
?>
