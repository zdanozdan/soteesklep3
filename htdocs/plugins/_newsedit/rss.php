<?php
/**
* Prezentacja listy newsów w formacie RSS.
* @version    $Id: rss.php,v 1.4 2005/01/24 10:33:35 lechu Exp $
* @author    lech@sote.pl
* @package    newsedit
*/

$global_database=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
header("Content-type: text/xml");
require_once ("../../../include/head.inc");


if (! empty($_REQUEST['lang'])) {
    // nazwa nowego jezyka
    $lang_name=$_REQUEST['lang'];
    
    if (in_array($lang_name,$config->languages)) {
        global $mdbd, $config;
        include_once("$DOCUMENT_ROOT/lang/_" . $lang_name . "/lang.inc.php");
        
        $config->www;
        $config->google['title'];
        $config->google['description'];
        $lang->encoding;
        
        $rss_list = '<?xml version="1.0" encoding="' .  strtolower($lang->encoding) . '"?>
        <rss version="2.0">
            <channel>
            <title>'. $config->google['title'] .'</title>
            <description>'. $config->google['description'] .'</description>
            <link>'. $config->www .'/plugins/_newsedit/rss.php</link>';
        
        $rss_news = $mdbd->select("id,date_add,subject,short_description,lang", "newsedit", "active=1 AND rss='1' AND lang=?", array($lang_name=> 'text'), 'ORDER BY date_add DESC', 'array');
        if($mdbd->num_rows > 0) {
            for ($i = 0; $i < count($rss_news); $i++) {
                $date_add_arr = explode('-', $rss_news[$i]['date_add']);
    //            Mon, 19 Oct 2004 00:00:01 GMT
                $date_gmt = date("D, d M Y H:i:s", mktime(0, 0, 0, $date_add_arr[1], $date_add_arr[2], $date_add_arr[0])) . ' GMT';
                $rss_list .= '
                    <item>
                        <title>' . $rss_news[$i]['subject'] . '</title>
                        <description>' . $rss_news[$i]['short_description'] . '</description>
                        <link>http://' . $config->www . '/plugins/_newsedit/news/' . $rss_news[$i]['id'] . '/index.php</link>
                        <pubDate>' . $date_gmt . '</pubDate>
                    </item>
                ';
            }
        }
        $rss_list .= '
            </channel>
        </rss>
        ';
        echo $rss_list;
    } else {
        $theme->go2main();
        exit;
    }
} else {
    $theme->go2main();
    exit;
}



include_once ("include/foot.inc");
?>