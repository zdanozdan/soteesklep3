<?php
/**
* Edycja wersji jêzykowych - Wy¶wietlenie formularza zmiennej tablicowej
*
* @author  lech@sote.pl
* @version $Id: lang_editor_form_array_var.html.php,v 1.10 2005/11/07 09:47:23 lechu Exp $
* @package    lang_editor
* \@encoding
*/
$loc = '';
$disable = 0;
$varnames = array();
for($i02 = 0; $i02 < count($editor->languages); $i02++){
    if($loc == '')
    $loc = @$val['location'][$editor->languages[$i02]]; // ustalenie ¶cie¿ek do wersji jêzykowych zmiennej
    if(is_array(@$val['value'][$editor->languages[$i02]])){
        reset($val['value'][$editor->languages[$i02]]);
        while(list($key001, $val001) = each($val['value'][$editor->languages[$i02]])){
            $varnames[$key001] = ''; // pobranie WSZYSTKICH pól zmiennej (dla ka¿dej wersji jêzykowej mo¿e byæ inny zbiór pól, a potrzebujemy sumê ich zbiorów)
        }
    }
}

$element_count = count($varnames);
    ?>
    <form action="index.php?lang_editor_action=search&lang_editor_post=update&group_name=<?php echo @$_REQUEST['group_name'];?>&var_value=<?php echo @$_REQUEST['var_value'];?>&var_name=<?php echo @$_REQUEST['var_name'];?>" method=post target="window">
    <tr>
        <td bgcolor="White" rowspan="<?php $rowspan = $element_count + 2; echo $rowspan; ?>" valign="top">
            <?php echo stripslashes($key); ?>
            <input type="hidden" name=var_name value='<?php echo stripslashes($key); ?>'>
            <input type="hidden" name=var_type value='array'>
            <input type="hidden" name=var_location value='<?php echo $loc ; ?>'>
            <table cellpadding="7" cellspacing="1">
            <?php
            reset($varnames);
            while(list($key02, $val02) = each($varnames)){ // wy¶wietlenie poszczególnych pól zmiennej
                ?>
                <tr>
                    <td>&nbsp;&nbsp;<?php echo $key02 ?></td>
                </tr>
                <?php
                // todo: zmieniæ tak, by nie dublowaæ pêtli
                for($ll = 0; $ll < count($editor->languages); $ll++){ // wy¶wietlamy inputy z ka¿d± wersj± jêzykow± zmiennej
                if (is_array(@$val['value'][$editor->languages[$ll]][$key02]))
                $disable = 1;
                }
            }
            ?>
            </table>
        </td>
        <td bgcolor="White" rowspan="<?php $rowspan = $element_count + 2; echo $rowspan; ?>">
            <?php echo $val['group']; ?>
        </td>
        <td bgcolor="White" colspan="<?php echo count($editor->languages); ?>">
            &nbsp;
        </td>
        <td bgcolor="White" rowspan="<?php $rowspan = $element_count + 2; echo $rowspan; ?>">
        <?php
        if($disable == 0) {
        ?>
            <input type="submit" value="<?php echo $NewEncoding->Convert($lang->change, $config->langs_encoding[$config->lang_id], "utf-8", 0); ?>" onclick="window.parent.open('', 'window', 'width=200, height=150, status=0, scrolling=1, resizable=1, toolbar=1');" >
        <?php
        }
        ?>
        </td>
    </tr>
    <?php
    reset($varnames);
    while(list($key02, $val02) = each($varnames)){ // dla ka¿dej zmiennej
        ?>
        <tr>
        <?php
        
        for($ll = 0; $ll < count($editor->languages); $ll++){ // wy¶wietlamy inputy z ka¿d± wersj± jêzykow± zmiennej
            $confirmed = 1;
            $style = '';
            if(@$val['confirmed'][$editor->languages[$ll]] == 0) {
                if(!empty($editor->lang_to_report)) {
                    if($editor->lang_to_report == $editor->languages[$ll]) {
                        $basic_loc = trim(strstr($loc, '/./'));
                        $editor->report[$basic_loc][stripslashes($key)] = @$val['value']['pl'];
                    }
                }
                $confirmed = 0;
                $style = " background-color: #ffaaaa; ";
            }
            ?>
            <td bgcolor="White"><input style='width: 100%; <?php echo $style; ?>' type=text name='var_value[<?php echo $editor->languages[$ll] . '][' . $key02;  ?>]' value="<?php 
            $val1=@stripslashes(@$val['value'][$editor->languages[$ll]][$key02]);
            $val1=ereg_replace('"','&quot;',$val1);
//            print $val1;
            echo $NewEncoding->Convert($val1, $editor->encoding[$ll], "utf-8", 0); ?>">
            </td> <?php
            
        }
        ?>
        </tr>
        <?php
    }
    ?>
        <tr>
        <?php
        for($ll = 0; $ll < count($editor->languages); $ll++){
            ?>
            <td bgcolor="White" nowrap>
                <input type="checkbox" name="confirm[<?php echo $editor->languages[$ll]; ?>]" value=1 checked><span style="font-size: 9px;"><?php echo $lang->lang_editor_authorize; ?></span>
            </td>
            <?php
        }
        ?>
        </tr>
    </form>
    <?php
    
    
?>
