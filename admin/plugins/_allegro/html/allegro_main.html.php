<?php
/**
 * Strona g³ówna modu³u allegro.
 *
 * @author  krzys@sote.pl
 * @version $Id: allegro_main.html.php,v 1.1 2006/03/16 10:16:41 krzys Exp $
 *
* @package    allegro
 */
?>
<table align=center width=95%><tr><td>

&nbsp;<?php print $lang->allegro['title']; ?> 
<p>
<ul>
 <li> <?php print $lang->allegro['config']; ?> <a href=/plugins/_allegro/config.php><u><?php print $lang->allegro_options["config"]; ?></u></a>
 <li> <?php print $lang->allegro['export']; ?> <a href=/plugins/_allegro/export.php><u><?php print $lang->allegro_options["export"]; ?></u></a>

<p>
</td></tr></table>