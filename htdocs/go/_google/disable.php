<?php
/**
 * Strona generujaca przekierowanie na odpowiedni adres do sklepu, ze strony zaindeksowanej.
 * Je¶li jest wykryty system indeksuj±cy, to nie ma przekierowania, tylko wywo³ywana jest odpowiednia tre¶c strony
 * dostosowana do indeksowania.
 * 
 * @author  m@sote.pl
 * @version $Id: index.php,v 1.1 2005/08/08 14:21:42 maroslaw Exp $
 * @package  google
 */
$global_database=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu
*/
require_once ("../../../include/head.inc");

/**
* Obs³uga Google - wylaczanie strony z raportow analytics
*/

$passwd = $_REQUEST['password'];
if ($passwd == "mikran123")
{
   $action = $_REQUEST['action'];
   if ($action!="execute")
   {
      // naglowek
      $theme->head();
      
      print "<center>";
      print "<table width=\"770\" class=\"block_1\"><tr><td>";
      
      if ($passwd == "mikran123")
      {
         print "Blokowanie zbierania statystyk Google dla tego komputera. Adres ukryty, chroniony has³em";
         print "</td></tr><tr><td>";
         print "<input type=\"button\" onclick=\"alert('Próba zablokowania statystyk');__utmSetVar('no_report');alert('Gotowe !')\" value=\"Zablokuj statystyki dla tego komputera\">";
      }
      else
      {
         print "Dostêp zabroniony !";
      }
      print "</table>";
   }
   else
   {
      print "<head><script src=\"http://www.google-analytics.com/urchin.js\" type=\"text/javascript\"></script></head>";
      print "<body onLoad=\"javascript:__utmSetVar('no_report');alert('Statystyki zablokowane')\">";
      print "Zablokowanie statystyk gotowe";
      print "</body>";
   }
}
else
{
   print "Dostêp zabroniony";
}
$theme->foot();
// stopka
include_once ("include/foot.inc");
?>
