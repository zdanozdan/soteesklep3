<?php
/**
* prezentacja produktow w wierszu
* @version    $Id: 12-newsedit_row.html.php,v 1.1 2006/09/27 21:53:18 tomasz Exp $
* @package    newsedit
*/
global $__news_row, $theme;

/* szeroko¶æ maksymlana wiersza z newsami */
$max_rows_width=370;

/**
* liczba rekordow w wierszu
* @var int
*/

$rec_per_row=$config->newsedit_columns_default;
$width=intval($max_rows_width/$rec_per_row);


if (empty($__news_row)) $__news_row=1;
else $__news_row++;

if ($__news_row==1) {
    print "  <tr>\n";
    print "    <td valign=\"top\">";
} else {   
    /**
    * separator rekordow w wierszu
    * uzyty opcjonalnie
    */
    $this->recordSeparator();
    print "    <td valign=\"top\" align=\"center\">";    
}
?>
<table width="<?php print $width;?>" border="0" cellspacing="0" cellpadding="0" class="bg_yellow">
  <tr> 
    <td bgcolor="#ffffff" style="padding: 8px;" valign="top"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr> 
          <td valign="top" style="padding: 0px 0px 4px 0px;"><?php $this->newsPhoto(); ?></td>
        </tr>
        <tr> 
          <td valign="top" style="padding: 0px 0px 4px 0px;"><?php $this->newsSubject(); ?><br><?php $this->newsAddDate();?></td>
        </tr>
        <tr>
          <td height="60" valign="top" align="left"><?php $this->newsShortDescription(); ?></td>
        </tr>
        <tr> 
          <td valign="bottom"> 
            <div align="right" style="padding: 8px 24px;"><?php $this->newsInfoButton(); ?></div>
          </td>
        </tr>
      </table>
				</td>
		</tr>
</table>    

<?php
if ($__news_row==$rec_per_row) {
    $__news_row=0;
    
    /**
    * zakonczenie rekordu
    */
    print "    </td>\n";
    print "  </tr>";    
    /**
    * ozdobne zakonczenie tabeli
    * uzyty opcjonalnie
    */
    $this->recordEndDots($rec_per_row);
    
} else print "    </td>";
?>
