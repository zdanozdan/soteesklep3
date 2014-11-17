PROMOTIONS4<?php
/**
* @version    $Id: promotions_info.html.php,v 1.4 2004/12/20 18:02:29 maroslaw Exp $
* @package    promotions
*/
?>
<p>
<b><a href="info.php?id=<?php print $this->data['id'];?>"><?php print $this->data['name'];?></a></b>
<p>
<?php 
if (! empty($this->data['photo'])) {
    global $config;
    print "<img src=\"".$config->url_prefix."/photo/_promotions/".$this->data['photo']."\" alt=\"\"><br>\n";
}
?>
<table width=60%>
<tr>
    <td>
        <?php print $this->data['description'];?>
    </td>
</tr>
</table>
