<?php
/**
* Za³±cz obs³ugê zdjêæ
*
* @author  m@sote.pl
* @version $Id: image.inc.php,v 2.5 2004/12/20 17:58:04 maroslaw Exp $
*
* \@verified 2004-03-16 m@sote.pl
* @package    edit
*/

require_once ("include/image.inc");

/**
* Obs³uga zdjêæ ptoduktów po stronie panelu
*/
class ImageAdmin extends Image {
    
    /**
    * @see Image::show() 
    */
    function show($photo,$align="right",$prefix='') {
        $image =& new Image;        
        return $image->show($photo,$align,$prefix);
    } // end show()
    
} // end class ImageAdmin

$image =& new ImageAdmin;
?>
