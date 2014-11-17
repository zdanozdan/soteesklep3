<?php
/**
* G³ówna strona instlacji sklepu (HTML).
*
* @author  m@sote.pl
* @version $Id: start.html.php,v 2.6 2005/04/01 12:18:54 maroslaw Exp $
*
* \@verified 2004-03-16 m@sote.pl
* @package    setup
*/
?>
<br>
<center>
<?php $theme->desktop_open("540");?>
<table align=center>
<tr>
  <td width=50% valign=top>
    <br><br>
    <?php
    print $lang->setup_start_info;
    ?>
    <br>
    <br>
    <?php print $lang->setup_choose_lang;?>
  
  
    <?php
    global $config;
    global $lang;

       
    print "<table>";
    print "<tr>";
    print "<td>";
    print "<form action=license.php name=MyForm>\n";
    print "<select name=lang><br>\n";
    while (list($lang2,$name) = each($config->setup_langs)) {
        if ($config->lang==$lang2) {
           $selected="selected"; 
        } else $selected='';
        print "<option value='$lang2' $selected>$name\n";
        
    }
    print "</select>\n";
    print "<br>\n";
    print "</td>";
    print "<td>";
    
    global $buttons;
    $buttons->perm=false;
    $buttons->button($lang->setup_next,"javascript:document.MyForm.submit();");
    $buttons->perm=true;
    
    print "</form>\n";
    print "</td>";
    print "</tr>";
    print "</table>";
    
  ?>
  </td>
  <td valign=top>
    <img src=html/_img/case_<?php print $config->lang;?>.jpg>
  </td>
</tr>
</table>
<?php $theme->desktop_close();?>
</center>
<br>
