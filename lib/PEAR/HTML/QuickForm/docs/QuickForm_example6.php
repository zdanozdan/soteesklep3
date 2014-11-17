<?php
require_once('HTML/QuickForm.php');
/*
* A file upload example for xml files.
*/
// $Id: QuickForm_example6.php,v 1.1 2003/12/16 10:09:30 maroslaw Exp $

$form = new HTML_QuickForm('myform');
$file =& $form->addElement('file', 'myfile', 'Your file:');
$form->addElement('submit', 'submit', 'Send');

// optional : see registered rules

$form->addRule('myfile', 'Cannot exceed 1776 bytes', 'maxfilesize', 1776);
$form->addRule('myfile', 'Must be plain text', 'mimetype', array('application/x-xml', 'text/plain', 'text/xml'));
$form->addRule('myfile', 'Must be *.xml', 'filename', '/^.*\.xml$/');
$form->addRule('myfile', 'File is required', 'uploadedfile');


if ($form->validate()) {
	// optional : you can move and rename the uploaded file
    $file->moveUploadedFile('/tmp', 'testfile.txt');
    echo '<pre>';
    var_dump($form->_submitFiles);
    echo '</pre>';
} else {
    $form->display();
}
?>