<?php
/**
 * Generowanie stron statycznych dla produktów, stron HTML, kategorii itp.
 *
 * @author  m@sote.pl
 * @version $Id: stat_pages_products.php,v 1.4 2006/08/16 10:21:02 lukasz Exp $
 * @version $Id: stat_pages_products.php,v 1.4 2006/08/16 10:21:02 lukasz Exp $
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

$per_one = 250;//to nam daje 100.000 podstron do zindeksowania
global $db;
$query="SELECT COUNT(*) FROM main";
$result=$db->query($query);
$ile=$db->fetchResult($result,0,"COUNT(*)");
//$ile-=40000;//do testow
$number=@$_REQUEST['number'];
$number=mysql_escape_string($number);
if (empty($number)) $number=1;

$tmp2 = $ile/$per_one;
print '<p /><center>Postêp '.$number.'/'.ceil($tmp2).'</center>';
flush();

$google =& new Google($number,$per_one);
$google->genStatProductPages();
$google->genHTMLPages();
$google->genCat();
$google->close();

// zainstaluj sitemap
$ftp->connect();
$sitemap1=$google->sitemap->readSitemap();
$sitemap2=$google->sitemap2->readSitemap();

$sitemap_all =& new GoogleSitemap(SITEMAP_LIST);
//$sitemap_all_xml = $sitemap_all->readSitemapAll(array("sitemap".$number.".xml","sitemap".$number."d.xml"));
$sitemap_all_xml = $sitemap_all->readSitemapAll($number);
	require_once ("Packer/packer.php");
	
	//to odpowiada za glowny plik
	$sitemaps=array("sitemap.xml"=>$sitemap_all_xml);
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
	//to odpowiada za male sitemapy -> wrzucane do katalogu google
	$sitemaps=array("sitemap".$number.".xml"=>$sitemap1,"sitemap".$number."d.xml"=>$sitemap2);
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
	
	    $ftp->put($file.".gz",$config->ftp['ftp_dir']."/htdocs/google",$file_sitemap.".gz");
	    
	    @unlink($file);
	}
	$ftp->close();
	


// stopka
$theme->foot_window();
if($number<$ile/$per_one){
	$number++;
?>
<script>
window.location="stat_pages_products.php?number=<?php print $number;?>"
</script>
<?php
	
	
}else{
	
	print "<p />\n<center>";
	$theme->close();
	print "</center>";
}
include_once ("include/foot.inc");

?>
