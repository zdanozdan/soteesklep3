<?php
/**
 * Elementy zwiazane z wyszukiwaniem
 *
 * @author  m@sote.pl
 * @version $Id: search.inc,v 2.3 2004/12/20 18:02:57 maroslaw Exp $
* @package    include
 */

class Search {
    function select($column,$name='---') {
        print "<select>";
        print "<option> $name";
        print "</select>";
    } // end select()

    function query($size){
        print "<input type=text size=$size name=query>";
    } // end query()

    function submit($name) {
        print "<input type=submit value='$name'>\n";
        return(0);
    } // end submit()

} // end class Search
?>
