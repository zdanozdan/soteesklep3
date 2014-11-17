<?php
/**
* Generuj Google SiteMap
*
* @see https://www.google.com/webmasters/sitemaps/stats
*
* @author  m@sote.pl
* @version $Id: google_sitemap.inc.php,v 1.8 2006/08/16 10:21:02 lukasz Exp $
* @package google
*
*
* example of sitemap protocol:

<urlset xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84 http://www.google.com/schemas/sitemap/0.84/sitemap.xsd">  
  <url>
    <loc>www.1440.demo.sote.pl:9686/</loc>
    <changefreq>daily</changefreq>
    <priority>0.5</priority>
  </url>
</urlset>

*/

define ("SITEMAP_LIST",1);
define ("SITEMAP_ONE",2);


include_once("Date/Calc.php");

/**
* Generowanie Google SiteMap XML
*/
class GoogleSitemap {

    /**
    * @var string $_www adres URL sklepu 
    * @access private
    */
    var $_www;

    /**
    * @var string $_xml_head_list
    * @access private
    */
    var $_xml_head_list="<?xml version='1.0' encoding='UTF-8'?>\n<sitemapindex xmlns=\"http://www.google.com/schemas/sitemap/0.84\">\n";
    
    /**
    * @var string $_xml_head
    * @access private
    */
    var $_xml_head="<?xml version='1.0' encoding='UTF-8'?>\n<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.84\">\n";

    /**
    * @var string $_xml_foot
    * @access private
    */
    var $_xml_foot="</urlset>\n";

    /**
    * @var string $_priority domy¶lna warto¶æ wa¿no¶ci strony 0.1 -> 1
    * @access private
    */
    var $_priority="0.5";

    /**
    * @var string $_freq czêstotliwo¶æ modyfikacji strony
    * @access private
    */
    var $_freq="weekly";

    /**
    * @var string $_xml generowany xml sitemap
    * @access private
    */
    var $_xml;

    /**
    * Konstruktor
    * 
    * @param int $type typ mapy SITEMAP_LIST,SITEMAP_ONE
    * @return void
    */
    function GoogleSitemap($type=SITEMAP_ONE) {
        global $config;
        $this->_www=$config->www;
        if ($type==SITEMAP_LIST) {
            $this->_xml=$this->_xml_head_list;
        } else {
            $this->_xml=$this->_xml_head;
        }
        $this->Date_mod =& New Date_Calc();
        return;
    } // end GoogleSiteMap()

    /**
     * Obni¿anie daty przekazanej jako parametr o 1 dzieñ
     *
     * @param date $date YYYY-MM-DD
     */
    function lowerdate(&$date) {
    	ereg("([0-9]{4})-([0-9]{2})-([0-9]{2})",$date,$matches);
    	$yyyy=$matches[1];
    	$mm=$matches[2];
    	$dd=$matches[3];
    	$date=$this->Date_mod->prevDay($dd,$mm,$yyyy,"%Y-%m-%d");
    }    
    
    /**
    * Dodaj adres
    * Dodaj wpis do XML
    *
        <url>
         <loc>www.1440.demo.sote.pl:9686/</loc>
         <changefreq>daily</changefreq>
         <priority>0.5</priority>
        </url>
    *
    * @see https://www.google.com/webmasters/sitemaps/docs/en/protocol.html
    *
    * @param string $url
    * @param string $priority 0.1-1
    * @param string $freq always, hourly, daily, weekly, monthly, yearly, never
    * @param string $lastmod ostatnia modyfikacja YYYY-MM-DD
    *    
    * @return void
    */
    function add($url,$lastmod='',$priority='',$freq='') {
        if (empty($priority)) $priority=$this->_priority;
        if (empty($freq)) $freq=$this->_freq;

        $url=trim($url);
        $lastmod=$this->lowerdate($lastmod);
        $o='';
        $o.="  <url>\n";
        $o.="    <loc>".$url."</loc>\n";
        $o.="    <changefreq>$freq</changefreq>\n";
        $o.="    <priority>$priority</priority>\n";
        if (! empty($lastmod)) {
            $o.="    <lastmod>$lastmod</lastmod>\n";
        }
        $o.="  </url>\n";
        $this->_xml.=$o;
        return;
    } // end add()

    /**
    * Generuj pelny XML Sitemap
    */
    function readSitemap() {
        $this->_xml.=$this->_xml_foot;
        return $this->_xml;
    } // end readSitemap()

    /**
    * Generuj zbiorcz± mapê - lista map
    */
    function readSitemapAll($ile) {
        global $config;
        
        // 2004-10-01T18:23:17+00:00
        $last_mod=date("Y-m-d");
        $this->lowerdate($last_mod);
        $o="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
   <sitemapindex xmlns=\"http://www.google.com/schemas/sitemap/0.84\">";
   
   for($i=1;$i<=$ile;$i++){     
   $o.="
   <sitemap>
      <loc>http://$config->www/google/sitemap".$i.".xml.gz</loc>
      <lastmod>$last_mod</lastmod>
   </sitemap>
   <sitemap>
      <loc>http://$config->www/google/sitemap".$i."d.xml.gz</loc>
      <lastmod>$last_mod</lastmod>
   </sitemap>";
   }
   $o.="</sitemapindex>";
        return $o;
    } // end readSiteMapAll

} // end class GoogleSitemap
?>
