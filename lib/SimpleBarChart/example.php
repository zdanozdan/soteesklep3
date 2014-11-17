<?php
/**
* Przyk³ad wywo³ania
*
* @author  lech@sote.pl
* @version $Id: example.php,v 1.1 2004/05/25 11:03:44 lechu Exp $
* @package simplebarchart
*/
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

/**
* Nag³ówek skryptu
*/
require_once ("$DOCUMENT_ROOT/../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/chart.inc.php");

$data['title'] = 'Wykresik 01';
$data['series'] = array(
                        'Styczeñ'=> 150,
                        'Luty'=> 130,
                        'Marzec'=> 160,
                        'Kwiecieñ'=> 110,
                        );

$chart =& new SimpleBarChart($data, 300, 400);
$chart->draw();
echo '<br>';
$chart =& new SimpleBarChart($data, 100, 400);
$chart->bar_unit_image = 'unit_red_3d.jpg';
$chart->draw();
echo '<br>';
$chart =& new SimpleBarChart($data, 600, 400);
$chart->bar_unit_image = 'unit_darkgreen_3d.jpg';
$chart->draw();
echo '<br>';

$data['title'] = 'Wykresik 02';
$data['series'] = array(
                        'Kategoria I'=> 12,
                        'Kategoria II'=> 15,
                        'Kategoria III'=> 3,
                        'Kategoria IV'=> 7,
                        );

$chart =& new SimpleBarChart($data, 300, 400);
$chart->bar_unit_image = 'unit_darkblue_3d.jpg';
$chart->draw();
echo '<br>';
$chart =& new SimpleBarChart($data, 100, 400);
$chart->bar_unit_image = 'unit_blue_3d.jpg';
$chart->draw();
echo '<br>';
$chart =& new SimpleBarChart($data, 600, 400);
$chart->bar_unit_image = 'unit_black_3d.jpg';
$chart->draw();


$theme->page_open_foot();
// stopka
$theme->foot();
include_once ("include/foot.inc");
?>