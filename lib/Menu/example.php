<?php

session_start();


include_once('Menu.inc');

$submenu = new menu(11,'Sub Menu');
$submenu->add(1,'Sub Item 1', 'link.html', '_top');
$submenu->add(2,'Sub Item 2', 'link.html', '_new');

$main = new menu(22,'Main');
$main->add(3,'Main Item 1','link.html');
$main->add(4,'Main Item 2','link.html');
$main->add($submenu);
$main->add(5,'Main Item 3','link.html');

$second = new menu(33,'Secondary Menu');
$second->add(6,'Secondary item 1','link.html');
$second->add(7,'Secondary Item 2','link.html');

$main->show();
$second->show();


session_write_close();

?>
