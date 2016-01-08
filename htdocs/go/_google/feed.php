<?php
/**
* Generowanie pelnej mapy product feed dla wszystkich produktow i kategorii
*
* @author  tomasz@mikran.pl
* @version $Id: index.php,v 1.3 2007/04/27 18:35:09 tomasz Exp $
* @package google product feed
*/
$global_database=true;
$DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

// zapytamie o produkty w promocji, nowowsci itp
$sql = "SELECT * FROM main where active = '1'";
$result=$db->Query($sql);
if ($result==0) {
    $db->Error();
}

// funkcja prezentujaca wynik zapytania w glownym oknie strony
include_once ("include/feed_list.inc");
$feed = new DBFeedList;
$feeds = $feed->feed();
?>
<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">
<channel>
<title>mikran</title>
<link>http://www.sklep.mikran.pl</link>
<description>mikran feed</description>
  <?php foreach ($feeds as $item): ?>
  <item>
  <title><?php echo $item['title']; ?></title>
  <link><?php echo $item['link'] ?></link>
  <description><?php echo $item['description'] ?></description>
  <g:image_link><?php echo $item['image'] ?></g:image_link>
  <g:price><?php echo $item['price'] ?> PLN</g:price>
  <g:condition>new</g:condition>
  <g:id><?php echo $item['id'] ?></g:id>
  <g:product_type><?php echo $item['category'] ?></g:product_type>
  <g:availability>in stock</g:availability>
  <g:sale_price><?php echo $item['sale_price']?> PLN</g:sale_price>
  </item>
  <?php endforeach; ?>
</channel>
</rss>
