<?php
/**
* @version    $Id: reviews_row.html.php,v 1.4 2004/12/20 18:02:38 maroslaw Exp $
* @package    reviews
*/

if (empty($this->pcount)) $this->pcount=0;
$this->pcount++;

if ($this->pcount%2) { 
    $color="#f2f2f2";
} else {
    $color="E8E8E8";
} 

?> 
<tr> 
  <td> 
    <table border="0" width="100%" bgcolor="<?php print $color; ?>">
      <tr> 
        <td valign="top" align="left"> 
          <?php print "<B>$lang->info_review_author:</B> ";print $rec->data['author']; ?>
        </td>
        <td valign="top" align="left"> 
          <?php print "<B>$lang->info_review_score:</B> ";$this->user_score($rec->data['score'],"star.gif"); ?>
        </td>
        <td align="right" valign="top"> 
          <?php print "<B>$lang->info_review_date_add:</B> ";print $rec->data['date_add']; ?>
        </td>
      </tr>
      <tr> 
        <td colspan="3" align="justify"> 
          <?php print $rec->data['description'];  ?>
        </td>
      </tr>
    </table>
  </td>
</tr>
