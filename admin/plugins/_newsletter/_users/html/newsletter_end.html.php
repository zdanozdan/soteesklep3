<?php
/**
* Podsumowanie/raport po wys³aniu newslettera.
*
* @author  rdiak@sote.pl
* @version $Id: newsletter_end.html.php,v 2.4 2004/03/28 15:06:38 maroslaw Exp $
* @package newsletter
* @subpackage users
*
* verified 2004-03-10 m@sote.pl
*/
?>

<?php global $lang;?>
<br><center>
<?php print $lang->newsletter_sent;?><font color=blue><?php print $send_ok; ?></font><?php print $lang->newsletter_letters;?><br>
<?php print $lang->newsletter_not_sent;?><font color=red><?php print $send_error;?></font><?php print $lang->newsletter_letters;?><br>
<?php print $lang->newsletter_ommited;?><font color=green><?php print $send_leave;?></font><?php print $lang->newsletter_letters;?><br>
</center>




