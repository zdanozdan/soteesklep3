<?php
/**
 * Dodatkowe funkcje
 *
 * @author  m@sote.pl
 * @version $Id: functions.inc.php,v 2.4 2004/12/20 17:58:04 maroslaw Exp $
 *
 * \@verified 2004-03-16 m@sote.pl
* @package    edit
 */

/**
 * Wyswietl informacje o tym, czy jest plik html zlaczony dla danego produktu
 * Jesli tak, to pokaz link do strony
 * 
 * @param string $user_id
 * @param int $id id tabeli main
 * \@global string $DOCUMENT_ROOT
 *
 * @return none
 */
function show_desc_file_info($user_id,$id) {
    global $DOCUMENT_ROOT;
    global $lang;

    $id=$user_id;
    $id=ereg_replace(" ","_",$id);
    $file="$DOCUMENT_ROOT/products/$id.html.php";
    
    if (file_exists($file)) {
        print "<a href=/products/$id.html.php target=products>$id.html.php</a>";
        print "&nbsp; &nbsp; &nbsp; <input type=radio name=item_del[$id] value=1 onclick=\"this.form.submit();\">";
        print "$lang->delete";
    }
    
    return;
} // end show_desc_info()

?>
