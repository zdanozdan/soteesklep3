<?php
/**
 * Generowanie stron statycznych dla produktów, stron HTML, kategorii itp.
 *
 * @author  m@sote.pl
 * @version $Id: stat_pages_products.php,v 1.3 2005/08/12 09:29:47 maroslaw Exp $
 * @package google
 */

$DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];
require_once ("../../include/head_stream.inc.php");

/**
* Obs³uga Google.
*/
require_once ("./include/google.inc.php");

/**
* Obs³uga FTP.
*/
require_once ("include/ftp.inc.php");

// naglowek
$theme->head_window();
$theme->bar($lang->google_products_title);

// obsluga streamingu -> status bar
require_once ("themes/stream.inc.php");
$stream = new StreamTheme;
$stream->title_500(); // wyswietl pasek z numerami 100,200,300,400,500

$google =& new Google();
$google->genStatProductPages();
$google->genHTMLPages();
$google->genCat();
$google->close();

// zainstaluj sitemap
$ftp->connect();
$sitemap1=$google->sitemap->readSitemap();
$sitemap2=$google->sitemap2->readSitemap();

$sitemap_all =& new GoogleSitemap(SITEMAP_LIST);
$sitemap_all_xml=$sitemap_all->readSitemapAll(array("sitemap1.xml","sitemap2.xml"));

/**
* Obs³uga pakowania do gzip
*/ 
require_once ("Packer/packer.php");

$sitemaps=array("sitemap1.xml"=>$sitemap1,"sitemap2.xml"=>$sitemap2,"sitemap.xml"=>$sitemap_all_xml);
foreach ($sitemaps as $file_sitemap=>$sitemap) {
    
    $file=$DOCUMENT_ROOT."/tmp/$file_sitemap";
    $fd=fopen($file,"w+");
    fwrite($fd,$sitemap,strlen($sitemap));
    fclose($fd);

    // gzipuj mapê
    $archive =& new packer($file);
    $archive->toVar($out);
    
    $fd=fopen($file.".gz","w+");
    fwrite($fd,$out,strlen($out));
    fclose($fd);

    $ftp->put($file.".gz",$config->ftp['ftp_dir']."/htdocs",$file_sitemap.".gz");
    
    @unlink($file);
}
$ftp->close();

print "<p />\n<center>";
$theme->close();
print "</center>";

// stopka
$theme->foot_window();
include_once ("include/foot.inc");
?>
