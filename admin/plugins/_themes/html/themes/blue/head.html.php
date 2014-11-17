<?php
/**
* @version    $Id: head.html.php,v 1.4 2005/03/14 14:09:11 lechu Exp $
* @package    themes
* \@lang
*/
//$design_mode = "";
?>
  
  <table width="760" id='tc[head][background-image]' border="0" cellspacing="0" cellpadding="0" align="center" <?php echo $design_mode; ?> background="<?php echo($prefix . $tc['head']['background-image']); ?>">
    <tr> 
      <td align="left">&nbsp;&nbsp;&nbsp;<img id='tc[head][logo]' src="<?php echo($prefix . $tc['head']['logo']);?>" <?php echo $design_mode; ?>></td>
      <td align="right" valign="bottom"> 
        <table border="0" cellspacing="0" cellpadding="0" align="right">
          <tr> 
            <td width="10"><img alt="" id='tc[head][small_menu][img][left]' id='tc[head][small_menu][img][left]' src="<?php echo($prefix . $tc['head']['small_menu']['img']['left']);?>"<?php echo $design_mode; ?>></td>
            <td  align="center"><img id='tc[head][small_menu][img][center]' src="<?php echo($prefix . $tc['head']['small_menu']['img']['center']); ?>"<?php echo $design_mode; ?>></td>
            <td align="right"><img id='tc[head][small_menu][img][right]' alt="" src="<?php echo($prefix . $tc['head']['small_menu']['img']['right']);?>"<?php echo $design_mode; ?>></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <table width="760" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr> 
      <td align="left" ><img  <?php echo $design_mode; ?> id='tc[head][main_menu][img][left]' alt="" src="<?php echo($prefix . $tc['head']['main_menu']['img']['left']);?>" ></td>
      <td width="100%"  <?php echo $design_mode; ?> id='tc[head][main_menu][img][center]' align="center" background="<?php echo($prefix . $tc['head']['main_menu']['img']['center']);?>"> 
        <?php //$this->autoButtons();
            while (list($key, $val) = each($tc['head']['main_menu']['buttons'])){
                echo "
        <img id='tc[head][main_menu][buttons][$key]' src='" . $prefix . $val['out'] . "' $design_mode>&nbsp;
                ";
            }
        ?>
      </td>
      <td align="right" ><img alt=""  <?php echo $design_mode; ?> id='tc[head][main_menu][img][right]'  src="<?php echo($prefix . $tc['head']['main_menu']['img']['right']);?>"></td>
    </tr>
  </table>
  <table width="760" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr> 
      <td align="left" bgcolor="<?php echo $tc['colors']['color_1']; ?>" width="200">&nbsp; 
      </td>
      <td align="center" bgcolor="<?php echo $tc['colors']['color_1']; ?>" style="padding: 4px;" width="360"> 
      </td>
      <td width="10" bgcolor="<?php echo $tc['colors']['color_1']; ?>">
      </td>
      <td bgcolor="<?php echo $tc['colors']['color_1']; ?>">
        <nobr>
        </nobr>
      </td>
      <td align="right" bgcolor="<?php echo $tc['colors']['color_1']; ?>" width="200"> 
        &nbsp; </td>
    </tr>
  </table>
  <table width="760" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr> 
      <td align="right" style="padding: 4px"> 
      </td>
    </tr>
  </table>
</center>
<br />
