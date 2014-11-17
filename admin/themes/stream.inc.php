<?php
/**
 * Elementy zwiazane ze strumieniowym wyswietlaniem statustu reazliazacji zadania
 *
 * @author  m@sote.pl
 * @version $Id: stream.inc.php,v 2.6 2004/12/20 18:01:18 maroslaw Exp $
* @package    themes
 */

class StreamTheme {
    var $img_dir="/themes/base/base_theme";
    
    function title_500() {
        global $theme;
        print "<img src=$this->img_dir/_img/line_title.png><br>\n";
        return;
    } // end title_500()

    function line_red() {
        global $theme;
        print "<img src=$this->img_dir/_img/line_red.png width=1 height=15>";
        return;
    } // end line_red()
    
    
    function line_green() {
        global $theme;
        print "<img src=$this->img_dir/_img/line_green.png width=1 height=15>";
        return;
    } // end line_green()

    function line_blue() {
        global $theme;
        print "<img src=$this->img_dir/_img/line_blue.png width=1 height=15>";
        return;
    } // end line_blue()

    function line_sel() {
        global $theme;
        print "<img src=$this->img_dir/_img/line_sel.png width=1 height=15>";
        return;
    } // end line_blue()
                
    function line_fiol() {
        global $theme;
        print "<img src=$this->img_dir/_img/line_fiol.png width=1 height=15>";
        return;
    } // end line_blue()
        
     function legend() {
        global $theme;
        global $lang;

        print "<br><b>".$lang->offline_legend['info'].":</b><br>";
        print "<img src=$this->img_dir/_img/legend_green.png width=30 height=15>  ".$lang->offline_legend['green']."<br>";
        print "<img src=$this->img_dir/_img/legend_blue.png width=30 height=15>  ".$lang->offline_legend['blue']."<br>";
        print "<img src=$this->img_dir/_img/legend_red.png width=30 height=15>  ".$lang->offline_legend['red']."<br>";
        print "<img src=$this->img_dir/_img/legend_fiol.png width=30 height=15>  ".$lang->offline_legend['fiol']."<br>";
        print "<img src=$this->img_dir/_img/legend_sel.png width=30 height=15>  ".$lang->offline_legend['sel']."<br>";
        return;
    } // end line_blue()
   

} // end class StreamTheme

?>
