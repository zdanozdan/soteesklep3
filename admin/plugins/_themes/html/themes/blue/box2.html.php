<?php
/**
* @version    $Id: box2.html.php,v 1.6 2005/12/08 14:09:31 lukasz Exp $
* @package    themes
*/
//$design_mode = "border=1 style='border-style: dashed; border-width: 1px; border-color: black;' onmouseover='event.cancelBubble=true; this.style.borderStyle=\"solid\"; window.status=this.id' onmouseout='this.style.borderStyle=\"dashed\"; window.status=\"\"' onclick='window.open();'";
//$design_mode = "";

        $left      = $prefix . $tc['box']['img']['top']['left'];
    	$center    = $prefix . $tc['box']['img']['top']['center'];
    	$right     = $prefix . $tc['box']['img']['top']['right'];
    	
    	print "<table width=\"180\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" bgcolor=\"" . $config->theme_config['colors']['box_background'] . "\">\n";
    	print "  <tr>\n";
    	print "    <td id='tc[box][img][top][left]' align=\"left\" $design_mode background=\"$center";
//    	$this->img($center);    	
    	print "\"><img alt=\"\" src=\"$left";
//    	$this->img($left);
    	print "\" ></td>\n";
    	print "    <td id='tc[box][img][top][center]' width=\"100%\" $design_mode background=\"$center";
//    	$this->img($center);
    	print "\" align=\"center\" ";
    	print "><img alt=\"\" src=\"$center\"></td>\n";
    	print "    <td id='tc[box][img][top][right]' align=\"right\" $design_mode background=\"$center";
//    	$this->img($center);    	
    	print "\"><img alt=\"\" src=\"$right";
//    	$this->img($right);    
    	print "\" ></td>\n";
    	print "  </tr>\n";
    	print "</table>\n";    	

    	print "<table width=\"180\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" bgcolor=\"" . $config->theme_config['colors']['box_background'] . "\">\n";
    	print "  <tr>\n";
    	print "    <td width=\"1\" id='tc[box][img][middle][left]' $design_mode background=\"" . $prefix . $tc['box']['img']['middle']['left'];
    	print "\"><img alt=\"\" src=\"" . $prefix . $tc['box']['img']['middle']['left'];
//    	$this->img("_img/_mask.gif");
    	print "\" ></td>\n";
    	print "    <td width=\"100%\" align=\"left\" style='color: " . $config->theme_config['colors']['base_font'] . "; '>";

    	print "
    	<br><br><center>
    	$lang->themes_contents<br><br>
    	<img alt=\"\" id=tc[icons][basket] src=\"" . $prefix . $tc['icons']['basket'] . "\" $design_mode>
    	&nbsp;&nbsp;&nbsp;
    	<img alt=\"\" id=tc[icons][wishlist] src=\"" . $prefix . $tc['icons']['wishlist'] . "\" $design_mode>
    	&nbsp;&nbsp;&nbsp;
    	<img alt=\"\" id=tc[icons][info] src=\"" . $prefix . $tc['icons']['info'] . "\" $design_mode>
    	</center><br><br>";

    	print "</td>\n";    	
    	print "    <td width=\"1\" id='tc[box][img][middle][right]' $design_mode background=\"" . $prefix . $tc['box']['img']['middle']['right'];
//    	$this->path($config->theme_config['box']['img']['middle']['right']);
    	print "\"><img alt=\"\" src=\"" . $prefix . $tc['box']['img']['middle']['right'];
//    	$this->img("_img/_mask.gif");
//    	$this->path($config->theme_config['box']['img']['middle']['right']);
    	print "\" ></td>\n";
    	print "  </tr>";
    	print "  </table>";

    	$left      = $prefix . $tc['box']['img']['bottom']['left'];
    	$center    = $prefix . $tc['box']['img']['bottom']['center'];
    	$right     = $prefix . $tc['box']['img']['bottom']['right'];

    	print "<table width=\"180\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" bgcolor=\"" . $config->theme_config['colors']['box_background'] . "\">\n";
    	print "  <tr>\n";
    	print "    <td id='tc[box][img][bottom][left]' $design_mode><img alt=\"\"  src=\"$left";
//    	$this->img($left);
    	print "\" ></td>\n";
    	print "    <td id='tc[box][img][bottom][center]' width=\"100%\" $design_mode background=\"$center";
//    	$this->img($center);
    	print "\" ><img alt=\"\"  src=\"$center\" ></td>\n";
    	print "    <td id='tc[box][img][bottom][right]' $design_mode><img alt=\"\" src=\"$right";
//    	$this->img($right);
    	print "\" ></td>\n";
    	print "  </tr>\n";
    	print "</table>\n";
    	/**
    	* jesli nie jest to bar to zalacz cialo tabelki
    	*/
?>
