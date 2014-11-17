<?php
/**
* @version    $Id: box1.html.php,v 1.4 2004/12/20 18:01:00 maroslaw Exp $
* @package    themes
*/
//$design_mode = "border=1 style='border-style: dashed; border-width: 1px; border-color: black;' onmouseover='event.cancelBubble=true; this.style.borderStyle=\"solid\"; window.status=this.id' onmouseout='this.style.borderStyle=\"dashed\"; window.status=\"\"' onclick='window.open();'";
//$design_mode = "";

        $left      = $prefix . $tc['box']['img']['bar']['left'];
    	$center    = $prefix . $tc['box']['img']['bar']['center'];
    	$right     = $prefix . $tc['box']['img']['bar']['right'];
    	
    	print "<table width=\"150\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n";
    	print "  <tr>\n";
    	print "    <td id='tc[box][img][bar][left]' align=\"left\" $design_mode background=\"$center";
//    	$this->img($center);    	
    	print "\"><img alt=\"\" src=\"$left";
//    	$this->img($left);
    	print "\" ></td>\n";
    	print "    <td id='tc[box][img][bar][center]' width=\"\" $design_mode background=\"$center";
//    	$this->img($center);
    	print "\" align=\"center\" style=\"color: ";
  		print $tc['colors']['header_font'];
    	print "; font-weight: bold;\">";
    	print $lang->themes_title."1";
    	print "</td>\n";
    	print "    <td id='tc[box][img][bar][right]' align=\"right\" $design_mode background=\"$center";
//    	$this->img($center);    	
    	print "\"><img alt=\"\" src=\"$right";
//    	$this->img($right);    
    	print "\" ></td>\n";
    	print "  </tr>\n";
    	print "</table>\n";    	

    	print "<table width=\"150\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n";
    	print "  <tr>\n";
    	print "    <td width=\"1\" id='tc[box][img][middle][left]' $design_mode background=\"" . $prefix . $tc['box']['img']['middle']['left'];
    	print "\"><img alt=\"\" src=\"" . $prefix . $tc['box']['img']['middle']['left'];
//    	$this->img("_img/_mask.gif");
    	print "\" ></td>\n";
    	print "    <td width=\"100%\" bgcolor=\"" . $tc['colors']['box_background'] . "\" align=\"left\">";

    	print "<br><br><center style='color: " . $tc['colors']['base_font'] . "'>$lang->themes_contents</center><br><br>";

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

    	print "<table width=\"150\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n";
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
