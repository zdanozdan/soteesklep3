<?php
/**
* @version    $Id: promotions_row.html.php,v 1.2 2004/12/20 18:02:30 maroslaw Exp $
* @package    promotions
*/
?>
PROMOTIONS ROW
<b><a href=info.php?id=<?php print $this->data['id'];?>><?php print $this->data['name'];?></a></b>
<p>

<?php 
if (! empty($this->data['photo'])) {
    global $config;
    print "<a href=info.php?id=".$this->data['id'].">";
    print "<img src=".$config->url_prefix."/photo/_promotions/".$this->data['photo']." alt='' border=0>\n";
    print "</a><br>\n";
}
?>
<?php print $this->data['short_description'];?>
