<?php
/**
* Formularz konfiguracji opcji zwi±zanych z google
*
* @author  m@sote.pl
* @version    $Id: config.html.php,v 1.1 2005/08/02 10:37:22 maroslaw Exp $
* @package    google
*/
require_once ("include/forms.inc.php");

$forms =& new Forms;

$forms->open("config.php",1,"GoogleForm","multipart/form-data");

$forms->text("http_user_agents",@$item['http_user_agents'],$lang->google_config_form['http_user_agents'],80);
$forms->text("title",@$item['title'],$lang->google_config_form['title'],80);

$forms->text_maxsize=128;
$forms->text("keywords",@$item['keywords'],$lang->google_config_form['keywords'],80);
reset($google_config->keywords);
foreach ($google_config->keywords as $id=>$keyword) {    
    $keyword=trim($keyword);
    if (! empty($keyword)) {  
        $forms->text("keywords_$id",@$item["keywords_$id"],$lang->google_config_form['sentence'].":<b>$keyword</b>",80);
    }
}
$forms->text_maxsize=0;
$forms->wysiwyg=false;

$forms->text_area("description",@$item['description'],$lang->google_config_form['description'],2,80);
$forms->text("keyword_plain",@$item['keyword_plain'],$lang->google_config_form['keyword_plain'],80);
$forms->file("logo",$lang->google_config_form['logo']);
$forms->button_submit("",$lang->update);
$forms->close();

print "<div align=\"right\"><a href=\"./html/_img/$google_config->logo\" target=\"logo\" onclick=\"window.open('', 'logo', 'width=300, height=300, toolbar=0, scrollbars=0, status=0, resizable=1')\"><u>$lang->google_logo</u></a></div><br />\n";

print "<p />";
print $lang->google_help;
?>