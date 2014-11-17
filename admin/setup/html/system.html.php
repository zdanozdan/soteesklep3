<?php
/**
* Formularz wyboru opcji instalacji.
*
* @author  m@sote.pl
* @version $Id: system.html.php,v 2.17 2006/05/29 13:11:23 lukasz Exp $
*
* @verfied 2004-03-16 m@sote.pl
* @package    setup
*/

// ustaw odpowieni typ instalacji
$checked_simple="";$checked_rebuild="";

if (! empty($_REQUEST['type'])) {
    $__type=$_REQUEST['type'];
} elseif (! empty($_SESSION['__type'])) {
    $__type=$_SESSION['__type'];
} else $__type="";

switch ($__type) {
    case "simple": $checked_simple="checked";
    break;
    case "rebuild": $checked_rebuild="checked";
    break;
    default: $checked_simple="checked";
    break;
}
?>

<form action=type.php method=POST name=MyForm>
<?php $theme->desktop_open();?>

1. <b><u><?php print $lang->setup_steps[0];?></u></b>
2. <?php print $lang->setup_steps[1];?>
3. <?php print $lang->setup_steps[2];?> 
4. <?php print $lang->setup_steps[3];?> 
<?php $theme->desktop_close();?>

<table align=center>
<tr>
  <td valign=top>
    <?php $theme->desktop_open();?>
    <?php
    print "<b>".$lang->setup_system_php."</b><P>";
    $test_php->test_start();
    ?>
    <?php $theme->desktop_close();?>
  </td>
  <?php 
  if (!$_ERROR) {
  ?>
  <td valign=top>
    <?php $theme->desktop_open();?>
    <?php
    print "<b>".$lang->setup_system_type_title."</b><P>";
    ?>

    <input type=radio name=config[type] value=simple <?print $checked_simple;?>><?php print $lang->setup_system_type['simple'];?><br>
<!--  <input type=radio name=config[type] value=full><?php print $lang->setup_system_type['full'];?><br>-->

<!--  <input type=radio name=config[type] value=demo><?php print $lang->setup_system_type['demo'];?><br>-->      
    <input type=radio name=config[type] value=rebuild <?print $checked_rebuild;?>><?php print $lang->setup_system_type['rebuild'];?><br>
   
    <!-- 
    <nobr><input type=radio name=config[type] value=upgrade <?print $checked_rebuild;?>><?php print $lang->setup_system_type['upgrade'];?></nobr><br>    
    -->
<!--    <input type=radio name=config[type] value=multi><?php print $lang->setup_system_type['join'];?><br>-->
    <?php $theme->desktop_close();?>
  </td>
  <td valign=top>
    <?php $theme->desktop_open();?>
    <?php print "<b>".$lang->setup_system_os_title."</b><P>";?>

    
    <?php
    if ($shop->home==1) {
        $checked_linux='';
        $checked_freebsd="checked";   
    } else {
        $checked_linux="checked";
        $checked_freebsd='';   
    }
    ?>
    <table>
    <tr> 
      <td valign=top><input type=radio name=config[os] value=linux <?php print $checked_linux;?>><?php print $lang->setup_system_os['linux'];?></td>
      <td><img src=./html/_img/linux.gif></td>
    </tr>
    <tr>
      <td valign=top><input type=radio name=config[os] value=freebsd <?php print $checked_freebsd;?>><?php print $lang->setup_system_os['freebsd'];?></td>
      <td><img src=./html/_img/freebsd.gif></td>
    </tr>
  <!--
  <tr>
    <td><input type=radio name=config[os] value=windows><?php print $lang->setup_system_os['windows'];?></td>
    <td><img src=./html/_img/windows.gif></td>
  </tr>
  <tr>
    <td><input type=radio name=config[os] value=macosx><?php print $lang->setup_system_os['macosx'];?></td>
    <td><img src=./html/_img/macosx.gif></td>
  </tr>
  -->
    </table>
    <?php $theme->desktop_close();?>
  </td>
  <td valign=top>
    <?php $theme->desktop_open();?>
    <?php print "<b>".$lang->setup_system_host_title."</b><P>";?>

    <nobr><input type=radio name=config[host] value=local checked><?php print $lang->setup_system_host['local'];?><br>
    <input type=radio name=config[host] value=internet><?php print $lang->setup_system_host['internet'];?></nobr><br>  
    <?
    if ($shop->home==1) {
    ?>
    <input type=radio name=config[host] value='home.pl' checked><?php print $lang->setup_system_host['home.pl'];?><br>
    <?php 
    }
    ?>
    <?php $theme->desktop_close();?>
  </td>
  <?php } ?>
</tr>
</table>


<div align=right>
<?php
if (!$_ERROR) {
	// jesli wszsytkie testy opcji PHP powiodly sie, to wyswietl link dalej
	global $buttons;
	$buttons->perm=false;
	$buttons->button($lang->next,"javascript:document.MyForm.submit();");
	$buttons->perm=true;
}
?>
</div>

<br>

<!--
<table>
<tr>
  <td>
   <?php print "<b>".$lang->setup_system_plugins_title."</b><P>";?>
    <ul>
    <?php
    while (list($name,$desc) = each ($config->setup_plugins)) {
        if (! empty($lang->setup_system_plugins[$desc])) {
            print "<input type=checkbox name=plugins[$name] value=1>".$lang->setup_system_plugins[$desc]."<BR>\n";
        }
    } // end while
    ?>  
    </ul>
    <?php print "<b>".$lang->setup_plugins_code."</b><P>";?>
    <input type=password name=config[plugins_code]><br>
  </td>
</tr>
</table>
-->
</form>
