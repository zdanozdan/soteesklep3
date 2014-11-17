<?php
/**
* Formularz wyszukiwania zaawansowanego.
*
* @author  m@sote.pl
* @version $Id: adv_search.html.php,v 1.1 2005/01/12 13:16:55 maroslaw Exp $
* @package search
*/

// Load the main class
require_once 'HTML/QuickForm.php';

// Read the category1 from main
$query="SELECT id_category1,category1 FROM main GROUP BY category1 ORDER BY category1";
$result=$db->Query($query);
$category1=array();
$category1[0]='---';
if ($result!=0) {
    $num_rows=$db->numberOfRows($result);
    if ($num_rows>0) {
        for ($i=0;$i<$num_rows;$i++) {
            $category1[$db->fetchResult($result,$i,"id_category1")]=$db->fetchResult($result,$i,"category1");
        }
    }
} else die ($db->error());

// Instantiate the HTML_QuickForm object
$form = new HTML_QuickForm('searchForm');

// Set defaults for the form elements
$form->setDefaults(array(
        'name' => ''
));

// Add elements to the form
// $form->addElement('header', null, $lang->search_adv_title);
$form->addElement('text', 'name', $lang->search_adv_word, array('size' => 50, 'maxlength' => 255));
$form->addElement('select','category1',$lang->search_adv_category,$category1);
$form->addElement('checkbox','promotion',$lang->search_adv_promotions['promotion']);
$form->addElement('checkbox','new',$lang->search_adv_promotions['new']);
$form->addElement('checkbox','bestseller',$lang->search_adv_promotions['bestseller']);
$form->addElement('checkbox','discount',$lang->search_adv_discount);
$form->addElement('submit', null, $lang->search);

$form->addElement('text', 'save_as', $lang->search_adv_save_as, array('size' => 30, 'maxlength' => 255));

// Define filters and validation rules
$form->applyFilter('name', 'trim');
// $form->addRule('name', 'Please enter your name', 'required', null, 'client');

// Try to validate a form
if ($form->validate()) {
    // Display search result
    // @todo display 
} else {
    // Output the form    
    print "<center>\n";
    $form->display();
    print "</center>\n";
}
?>
