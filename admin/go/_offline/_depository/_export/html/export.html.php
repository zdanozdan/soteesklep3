<?php
/**
* Strona do konfiguracji exportu
*
* @author  rdiak@sote.pl
* @version $Id: export.html.php,v 1.1 2005/12/22 11:39:04 scalak Exp $
* @package    offline
* @subpackage export
*/
?>

<script type="text/javascript" language="javascript">
function setSelectOptions(the_form, the_select, do_check)
{
    var selectObject = document.forms[the_form].elements[the_select];
    var selectCount  = selectObject.length;

    for (var i = 0; i < selectCount; i++) {
        selectObject.options[i].selected = do_check;
    } // end for

    return true;
} // end of the 'setSelectOptions()' function
</script>

<?php
$onclick="onclick=\"window.open('','window','width=525,height=380,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
global $lang;
?>

<form name="db_dump" action=export.php method=POST target="window">
<p>

<table width=95% align=center>
<tr>
        <td width=50%  nowrap="nowrap" valign="top">
            <fieldset >
            <legend><?php print $lang->export_column; ?></legend>

            <br>
            <div align="center">
                <select name="column_select[]" size="9" multiple="multiple">
                <?php 
                    foreach($config->offline_names_column as $key=>$value) {
                    print "<option value='".$key."'>".$lang->export_names_column[$key]."</option>";
                } ?>
</select>
</div>
<br>
<center><a href="" onclick="setSelectOptions('db_dump', 'column_select[]', true); return false;"><?php print $lang->export_selected;?></a>
            &nbsp;/&nbsp;
<a href="" onclick="setSelectOptions('db_dump', 'column_select[]', false); return false;"><?php print $lang->export_unselected; ?></a></center>
            <br><br><br>          
</fieldset>


<br>


</td>
<td width=50% nowrap="nowrap" valign="top">
            <fieldset id="Parametry pliku">
                <legend><?php print $lang->export_option; ?></legend>

             <fieldset>
             <legend><?php print $lang->export_type; ?></legend>

<!--            <input type="radio" name=item[type_export] value="sql" id="radio_dump_sql" disabled />
            <label for="radio_dump_sql">SQL</label>
            &nbsp;&nbsp;
-->
            <input type="radio" name=item[type_export] value="csv" id="radio_dump_csv" checked />
            <label for="radio_dump_sql">CSV</label>
            &nbsp;&nbsp;
<!--
            <input type="radio" name=item[type_export] value="xml" id="radio_dump_sql" disabled />
            <label for="radio_dump_sql">XML</label>
-->
             </fieldset>
	    <br>
             <fieldset>
             <legend><?php print $lang->export_encoding; ?></legend>

<!--            <input type="radio" name=item[encoding] value="win1250" id="radio_dump_sql" checked/>
            <label for="radio_dump_sql">WIN-1250</label>
            &nbsp;&nbsp;
-->
            <input type="radio" name=item[encoding] value="iso8859-2" id="radio_dump_sql" checked/>
            <label for="radio_dump_sql">ISO-8859-2</label>
<!--            &nbsp;&nbsp;
            <input type="radio" name=item[encoding] value="mac" id="radio_dump_sql" />
            <label for="radio_dump_sql">MAC</label>
-->
             </fieldset>
            
            <br>
             <fieldset>
             <legend><?php print $lang->export_mode['mode']; ?></legend>

            <input type="radio" name=item[command] value="U" id="radio_dump_sql" checked/>
            <label for="radio_dump_sql"><?php print $lang->export_mode['update'];?></label>
			<br>
            
             </fieldset>
            
            
 
<td>
</tr>
</table>
<center><input type=submit name=save value="<?php print $lang->export_execution; ?>" <?php print $onclick; ?>></center>
</from>
<script type="text/javascript" language="javascript">setSelectOptions('db_dump', 'column_select[]', true);</SCRIPT>
