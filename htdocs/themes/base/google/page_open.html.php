<?php
/**
* Uk³ad strony.
* 
* @author  m@sote.pl
* @version    $Id: page_open.html.php,v 1.1 2005/08/08 14:16:05 maroslaw Exp $
* @package    themes
* @subpackage google
*/
?>


<table width="760" cellspacing="0" cellpadding="0" border="0">
  <tr> 
  
<!--
    <td width="180" valign="top" align="left" height="100%"> 
      <?php $this->left();?>
    </td>
-->    
    <td width="10" valign="top">&nbsp;</td>
    <td width="380" valign="top" align="left">
    
      <?php $o_main->$main();?>

    </td>
    <td width="10" valign="top">&nbsp;</td>
    <td width="180" valign="top" align="left"  height="100%"> 
      <?php $this->right();
      ?>
    </td>
  </tr>
</table>
