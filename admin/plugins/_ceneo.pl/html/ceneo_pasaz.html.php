<?php
/**
 * Strona g³ówna modu³u ceneo pasa¿.
 *
 * @author  rdiak@sote.pl
 * @version $Id: ceneo_pasaz.html.php,v 1.4 2006/08/16 10:41:41 lukasz Exp $
 *
* @package    pasaz.ceneo.pl
 */
?>
<table align=center width=95%><tr><td>

&nbsp;<?php print $lang->ceneo_pasaz['title']; ?>
</td>
</tr>
<tr>
<td align="center">
<img src="<?php $theme->img('_img/ceneo.png');?>">
<ul>

 <li> <?php print $lang->ceneo_pasaz['export']; ?> <a href=/plugins/_ceneo.pl/export.php><u><?php print $lang->ceneo_options["export"]; ?></u></a>

<p>
</td></tr></table>
