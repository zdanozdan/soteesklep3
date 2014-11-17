<?php
/**
 * Strona konfiguracyjna modu³u ceneo pasa¿.
 *
 * @author  rdiak@sote.pl
 * @version $Id: ceneo_config.html.php,v 1.5 2006/08/16 10:41:41 lukasz Exp $
 *
* @package    pasaz.ceneo.pl
 */
 ?>

<form action=config.php method=POST name=ceneo_config>
<input type=hidden name=item[save] value=1>
<p>
<table cellpadding="0" cellspacing="0" align="center">
<tr>
<td>
<img src="<?php $theme->img('_img/ceneo.png');?>">

<table cellpadding="0" cellspacing="0" align="center">
<tr><td style="padding-top:20px;">
<?php print $lang->ceneo_config['id']; ?>
</td>
<td style="padding-top:20px;padding-left:5px;">
<input type=text size=5 name=item[id] value='<?php print $ceneo_config->ceneo_shop_id; ?>'>
</td>
</tr>
</table>

</td>
</tr>
</table>

<center>
   <?php
      $buttons->button($lang->ceneo_config['save'],"javascript:document.ceneo_config.submit();");
?>
</center>
</from>
