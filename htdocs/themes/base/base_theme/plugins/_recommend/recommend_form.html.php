<?php
/**
* @version    $Id: recommend_form.html.php,v 1.4 2005/10/20 06:42:18 krzys Exp $
* @package    recommend
*/
?>
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2">
<LINK rel="stylesheet" href="<?php $this->img("_style/style.css");?>" type="text/css">
</HEAD>
<BODY>

<?php
if (! empty($_GET['shop'])) {
    $item="shop";
    $bar_name=$lang->recommend_s;
} else {
    $item="product";
    $bar_name=$lang->recommend_p;
}
?>

<CENTER>
<TABLE width="300" border="0" cellspacing="0" cellpadding="0">
 <TR>
  <TD><?php $this->bar($bar_name); ?><br /></TD> 
 </TR>
 <TR> 
  <TD align=center>
       <?php if($item!="shop") {
           print $lang->recommend_shop_friend;
           print ".<br />";
           print $lang->recommend_email;
           print ".<br /><br />";
       } else { 
           print $lang->recommend_product_friend;
           print ".<br />";
           print $lang->recommend_email;
           print ".<br /><br />";
       } ?>
  </TD>
 </TR>
 <TR>
  <TD align=center>
    <form action=/plugins/_recommend/send.php method=post>
     <input type=hidden name=form[check] value="true">
     <input type=hidden name=id value=<?php print @$_GET['id'] ;?>>
     <input type=hidden name=product value=<?php print urlencode(@$_GET['product']) ;?>>
     <input type=hidden name=shop value=<?php print @$_GET['shop'] ;?>>
     <?php print $lang->recommend_friend_email;?>
  </TD>
  </TR>
  <TR>
   <TD align=center>
    <input type=text size=20 name=friend_email><br /><br />
    <?php $this->form_error('friend_email'); ?>
   </TD>
  </TR>
  <TR>
   <TD align=center>
    <?php 
    //print "<pre>";
    //print_r ($_SESSION);
    if ((! empty($_SESSION['global_id_user'])) && (! empty($_SESSION['global_login']))){
    print $_SESSION['global_login']." e-mail";
    }else{  	
    print $lang->recommend_your_email;
    }
    ?>
   </TD>
  </TR>
  <TR>
   <TD align=center>
   <?php  if ((! empty($_SESSION['global_id_user'])) && (! empty($_SESSION['global_login']))){?>
     <input type=text size=20 name=your_email value="<?php print @$_SESSION['form']['email'];?>">
    <?php }else{?>
    <input type=text size=20 name=your_email>
   	 <?php } ?>
   </TD>
  </TR>
 <TR>
  <TD align=right>
   <input type=submit value='<?php print $lang->recommend_send;?>'><br /><br />
  </TD>
 </TR> 
 <TR> 
  <TD width="150" bgcolor="#000000"><IMG src="<?php $this->img("_img/mask.gif");?>" width="1" height="1"></TD>
 </TR>
</TABLE>
</CENTER>
</BODY>
</HTML>
