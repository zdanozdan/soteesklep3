<?php
/**
* @version    $Id: newsedit_info.html.php,v 2.2 2004/12/20 18:02:47 maroslaw Exp $
* @package    themes
* @subpackage redball
*/
global $theme;
?>

<?php $theme->bar(my(@$rec->data['subject']));?>
<br>
<?php $theme->back();?>

<center>
<table cellpadding=0 cellspacing=0 border=0 width=100%>
<tr> 
<td bgcolor="#646464"><IMG src="/themes/base/redball/_layout/mask.gif" width="1" height="1"></td>
<td bgcolor="#646464"><IMG src="/themes/base/redball/_layout/mask.gif" width="1" height="1"></td>
<td bgcolor="#646464"><IMG src="/themes/base/redball/_layout/mask.gif" width="1" height="1"></td>
</tr>
<tr>
<td bgcolor="#646464"><IMG src="/themes/base/redball/_layout/mask.gif" width="1" height="1"></td>
<td width=100% style="padding: 4">


  <center>
  <table align=center width=90%>
  <tr>
    <td width=60% valign=top>
    <b><?php print @$rec->data['subject'];?></b> (<?php print @$rec->data['category'];?>; <?php print @$rec->data['date_add'];?>) <p>
    <?php 
       @include_once ("news.html");
       print @$rec->data['description'];
    ?>
    <p>
    </td>
    <td width=40% valign=top>
     <?php
      global $DOCUMENT_ROOT;

      for ($i=1;$i<=8;$i++) {
          $id=$rec->data['id'];       
          if (! empty($rec->data["photo$i"])) {
              $photo=$rec->data["photo$i"];
              if (file_exists("$DOCUMENT_ROOT/plugins/_newsedit/news/$id/$photo")) {
                  print "<img src=/plugins/_newsedit/news/$id/$photo border=0><p>";
              } 
          }
      } // end for
     ?>
   </td>
  </tr> 
  </table>
  </center>




</td>
<td bgcolor="#646464"><IMG src="/themes/base/redball/_layout/mask.gif" width="1" height="1"></td>
</tr>

<tr> 
<td bgcolor="#646464"><IMG src="/themes/base/redball/_layout/mask.gif" width="1" height="1"></td>
<td bgcolor="#646464"><IMG src="/themes/base/redball/_layout/mask.gif" width="1" height="1"></td>
<td bgcolor="#646464"><IMG src="/themes/base/redball/_layout/mask.gif" width="1" height="1"></td>
</tr>

</table>
