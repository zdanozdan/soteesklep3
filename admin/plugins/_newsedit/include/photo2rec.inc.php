<?php
/**
 * Przekaz parametry (nazwy plikow) $_FILES do tablicy $rec->data
 *
 * @author m@sote.pl
 * @version $Id: photo2rec.inc.php,v 2.3 2004/12/20 18:00:11 maroslaw Exp $
 *
 * \@verified 2004-03-19 m@sote.pl
* @package    newsedit
 */

if ($global_secure_test!=true) die ("Forbidden");

// odczytaj dane zdjec juz zalaczonych
if (! empty($_POST['photo'])) {
    $photo=$_POST['photo'];
}

for ($i=1;$i<=8;$i++) {
    $filename="photo$i";
    if (! empty($_FILES['newsedit']['name'][@$filename])) {
        $datafile=$_FILES['newsedit']['name'][@$filename];
        $rec->data[$filename]=my($datafile);
    } else {
        if (! empty($photo[$filename])) {
            // zdjecie zostalo zalaczone wczesniej, odczytaj dane przekazane w polu photo[photo$i] (dla i=>1-8)
            $rec->data[$filename]=$photo[$filename];
        }
    } // end if    
} // end for

$filename="photo_small";
if (! empty($_FILES['newsedit']['name'][@$filename])) {
    $datafile=$_FILES['newsedit']['name'][@$filename];
    $rec->data[$filename]=my($datafile);
} else {
    if (! empty($photo[$filename])) {
        // zdjecie zostalo zalaczone wczesniej, odczytaj dane przekazane w polu photo[photo$i] (dla i=>1-8)
        $rec->data[$filename]=$photo[$filename];
    }
} // end if  

?>
