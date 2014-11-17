<?php
/**
* @version    $Id: info.html.php,v 2.3 2004/12/20 18:02:36 maroslaw Exp $
* @package    market
*/
global $rec;
?>

<table width=70% align=center bgcolor="<?php print $config->market_info_color;?>">
<tr>
<td align=left>
<?php $this->bar($rec->data['title']);?>
<?php $this->back();?>

 <table width=100%>
 <tr>
   <td width=50% valign=top>
    <B>Tytul:</B> <?php print $rec->data['title'];?><br />
    <B>Data zamieszczenia:</B> <?php print $rec->data['date_start'];?>
   </td>
   <td width=50% valign=top>
    
    <B>Zglosil:</B><br />
    <?php print @$rec->data['name'];?><br />
    <a href="mailto:<?php print $rec->data['email'];?>"><u><?php print $rec->data['email'];?></u></a>
    <?php
    if (! empty($rec->data['phone'])) {
        print "<br />";
        print "<B>Tel.:</B> ".$rec->data['phone'];
    }
    ?>
   </td>
 </tr>
 </table>
  <p>
    <B>Tresc ogloszenia:</B> <br />
    <?php print $rec->data['description'];?>
    <br />
    <?php
    global $DOCUMENT_ROOT;
    if (! empty($rec->data['photo'])) {
        if (file_exists("$DOCUMENT_ROOT/plugins/_market/photo/".$rec->data['photo'])) {
            print "<center>";
            print "<img src=/plugins/_market/photo/".$rec->data['photo'].">";
            print "</center>";
        }
    }
    ?>
</td>
</tr>
</table>
