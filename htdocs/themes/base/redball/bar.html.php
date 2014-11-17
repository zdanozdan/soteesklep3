<?php
/**
* @version    $Id: bar.html.php,v 2.4 2004/12/20 18:02:47 maroslaw Exp $
* @package    themes
* @subpackage redball
*/
    global $config, $prefix;
?>
<TABLE width="<?php print $width;?>" border="0" cellspacing="0" cellpadding="0">
<TR>
  <TD width="1"><IMG src="<?php $this->img($prefix . $config->theme_config['box']['img']['bar']['left']);?>"></TD>
  <TD  width="100%" background="<?php $this->img($prefix . $config->theme_config['box']['img']['bar']['center']);?>" style='color: <?php echo $config->theme_config['colors']['header_font'];?>;'>&nbsp;&nbsp;<B><?php print $text;?></B></TD>
  <TD width="50"><IMG src="<?php $this->img($prefix . $config->theme_config['box']['img']['bar']['right']);?>"></TD>
</TR>
</TABLE>
