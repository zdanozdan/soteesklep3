<?php

setcookie('privacy_ok','ok',time() + (86400 * 365),'/'); // 86400 = 1 day

//Header( "HTTP/1.1 301 Moved Permanently" );
//Header( "Location: /" );

require_once ("../../../include/head.inc");

$theme->head();

print '<script type="text/javascript">';
print 'window.location = "http://www.sklep.mikran.pl"';
print '</script>';

//print_r($_COOKIE);
//print "oasda";
//$theme->page_open("left","cookie_info","right","","","","page_open_2");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
