<?php
/**
* Edycja wersji jêzykowych - Wy¶wietlenie formularza zmiennej prostej
*
* @author  lech@sote.pl
* @version $Id: lang_editor_form_simple_var.html.php,v 1.11 2005/11/07 09:47:23 lechu Exp $
* @package    lang_editor
* \@encoding
*/
$loc = '';
for($i02 = 0; $i02 < count($editor->languages); $i02++){
    if($loc == '')
    $loc = @$val['location'][$editor->languages[$i02]]; // ustalenie ¶cie¿ki do wersji jêzykowych zmiennej
}
?>
                        <tr>
                        <form action="index.php?lang_editor_action=search&lang_editor_post=update&group_name=<?php echo @$_REQUEST['group_name'];?>&var_value=<?php echo @$_REQUEST['var_value'];?>&var_name=<?php echo @$_REQUEST['var_name'];?>" method=post target="window">
                            <td bgcolor="White">
                                <?php echo stripslashes($key); ?>
                                <input type="hidden" name=var_name value='<?php echo stripslashes($key); ?>'>
                                <input type="hidden" name=var_location value='<?php echo $loc ; ?>'>
                            </td>
                            <td bgcolor="White">
                                <?php echo $val['group']; ?>
                            </td>
                            <?php
                            $switch_to_textarea = 0;
                            for($ll = 0; $ll < count($editor->languages); $ll++)
                            {
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
                                if(($switch_to_textarea == 1) || (@strlen(@$val['value'][$editor->languages[$ll]]) > 27) // je¿eli warto¶æ zmiennej jest za d³uga lub ma znak koñca linii, wy¶wietl j± w textarea
                                || (@strpos(@stripslashes(@$val['value'][$editor->languages[$ll]]), "\n") !== false)){
                                    $switch_to_textarea = 1;
                                    
                            ?>
                            <td bgcolor="White" nowrap><textarea style="<?php echo $style; ?>" rows=4 cols=25 name='var_value[<?php echo $editor->languages[$ll] . ']'; ?>'><?php 
                            $val1=@stripslashes(@$val['value'][$editor->languages[$ll]]);
                            $val1=ereg_replace('"',"&quot;",$val1);
                            $val1 = $NewEncoding->Convert($val1, $editor->encoding[$ll], "utf-8", 0);
                            print $val1;
                            ?></TEXTAREA><br>
                            <input type="checkbox" name="confirm[<?php echo $editor->languages[$ll]; ?>]" value=1 checked><span style="font-size: 10px;"><?php echo $lang->lang_editor_authorize; ?></span>
                            </td><?php }
                            
                            else { // zmienna zmie¶ci siê w polu input
                            
                            ?>
                            <td bgcolor="White" nowrap><input style='width: 100%; <?php echo $style; ?>' type=text name='var_value[<?php 
                            echo $editor->languages[$ll] . ']'; ?>' value="<?php
                            $val1=@stripslashes(@$val['value'][$editor->languages[$ll]]);
                            $val1=ereg_replace('"',"&quot;",$val1);
                            $val1 = $NewEncoding->Convert($val1, $editor->encoding[$ll], "utf-8", 0);
                            print $val1;
                            ?>"><br>
                            <input type="checkbox" name="confirm[<?php echo $editor->languages[$ll]; ?>]" value=1 checked><span style="font-size: 9px;"><?php echo $lang->lang_editor_authorize; ?></span>
                            </td><?php }
                            }
                            
                            ?>
                            <td bgcolor="White">
                                <input type="submit" value="<?php echo $NewEncoding->Convert($lang->change, $config->langs_encoding[$config->lang_id], "utf-8", 0); ?>" onclick="window.parent.open('', 'window', 'width=200, height=150, status=0, scrolling=1, resizable=1, toolbar=1');">
                            </td>
                         </FORM>
                         </tr>
