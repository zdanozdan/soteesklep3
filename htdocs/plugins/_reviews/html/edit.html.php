<?php
/**
* @version    $Id: edit.html.php,v 1.4 2005/10/20 06:43:00 krzys Exp $
* @package    reviews
*/
?>
<form action=add.php method=POST name=My_Form>
<input type=hidden name=update value=true>
<input type=hidden name=id value="<?php print $_REQUEST['id'];?>">
<input type=hidden name=product value="<?php print $_REQUEST['product'];?>">
<input type=hidden name=user_id value="<?php print $_REQUEST['user_id'];?>">

<TABLE border=0>
 <TR>
  <TD colspan=2 align=center>
   <?php $theme->file("review_info.html",""); ?>
  </TD>
 </TR>
 <TR>
  <TD colspan=2 align=center>
   <?php 
         print $lang->reviews_info;
         print "<b>".$_REQUEST['product']."</b>"; 
   ?>
  </TD>
 </TR>
 <TR>
  <TD align=right><?php print $lang->reviews_cols['score'];?></TD>
  <TD>
   <select name=item[score]>
  <?php 
           $value=@$form_check->form['score'];
           $data=array("1"=>"1",
                       "2"=>"2",
                       "3"=>"3",
                       "4"=>"4",
                       "5"=>"5");

           if(empty($_REQUEST['update'])) {
              for($i=1;$i<=5;$i++) {
                  if ($i==4) {
                      print "<option selected>$i\n";
                  } else {
                      print "<option>$i\n";
                  }
              }
              
          } else {
              while (list($key,$val) = each($data)) {
                  if ($value==$key) {
                      print "\t<option value='$key' selected>$val</option>\n";
                  } else {
                      print "\t<option value='$key'>$val</option>\n";
                  }
              }
          }
    ?>
  </select>
  </TD>
 </TR>
 <TR>
  <TD align=right valign=top><?php print $lang->reviews_cols['description'];?></TD>
  <TD>
   <textarea name=item[description] rows=8 cols=50 wrap=hard><?php print @$form_check->form['description']; ?></textarea><BR>
  </TD>
 </TR>
 <TR>
  <TD align=right><?php print $lang->reviews_cols['author'];?></TD>
  <TD>
    <?php if ((! empty($_SESSION['global_id_user'])) && (! empty($_SESSION['global_login']))){ 
    print $_SESSION['global_login'];?>
    <input type=hidden name=item[author] value="<?php print $_SESSION['global_login'];?>">
    <input type=hidden name=item[author_id] value="<?php print $_SESSION['global_id_user'];?>"><BR>
    <?php }else{ ?>
   <input type=text name=item[author] value="<?php print @$form_check->form['author'];?>" size=20><BR>
   <?php } ?>
  </TD>
 </TR>
 <TR>
  <TD colspan=2 align=right>
   <input type=submit value="<?php print $lang->reviews_send;?>">
  </TD>
 </TR>
</TABLE>
</form>
