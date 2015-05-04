<!DOCTYPE html>
<html lang="<?php echo $config->lang ?>">
  <head>
    <?php require_once('header.html.php') ?>
  </head>
<body>
<div class="container">
  <div>
    <a href="\"><img alt="<?php print $lang->head_mainbanner ?>" title="<?php echo $lang->head_bannertitle ?>" src='<?php $this->img("header.png"); ?>'></a>
  </div>
  <div class="head_block"><?php $this->head() ?></div>
</div>
<div class="container">
  <div class="row">
    <div class="span12">
      <?php 
	 include_once ("include/category.inc"); 
	 $cat = new NavbarCategory;
	 $cat->init();
	 ?>      

      <ul class="breadcrumb">
	<li><a href="/">Home</a> <span class="divider">/</span></li>
	<li><a href="/contact/form"><?php echo $lang->contact_form ?></a> <span class="divider">/</span></li>
      </ul>

    </div>
  </div>
  <div class="row">
    <div class="span4">
      <p><?php $this->left();?></p>
    </div>
    <div class="span8">
      <div class="block_1" style="margin-top:10px">

	<?php 
         $mail_error = false;

         if (isset($_POST['send_email']))
         {
         $imie = trim($_POST['inputName']);
         $company=trim($_POST['inputCompany']);
         $mail=trim($_POST['inputEmail']);
         $tresc=trim($_POST['inputBody']);

         if (!ereg("^[a-zA-Z0-9_]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$", $mail))
         {
         $mail_error = true;
         }
         else
         {
         $ccaddress = "sklep@mikran.pl"; 
         $toaddress = "sklep@mikran.pl"; 
                  
         $headers = "From:" . $mail . "\r\n" . "Reply-To:". $dest . "\r\n" ."Cc:".$ccaddress."\r\n" . "X-Mailer: PHP/" . phpversion();
                  
         $subject = $lang->contact_subject;
         $mailcontent = $lang->contact_customer .": ".$imie."\n"."\n"."e-mail: ".$mail."\n".$lang->contact_body.": \n".$tresc."\n";
	 }

         if (mail($toaddress, $subject, $mailcontent, $headers ) == true)
         {
           print "<h2><div class='alert alert-success'>".$lang->contact_success."</div></h2>";
	   $sent=true;
         }
         else
         {
	    if (!$mail_error) 
	    {
                print "<h2><div class='alert alert-error'>".$lang->contact_send_error."</div></h2>";	 
             }
         }
	 }

         ?>

	<?php if(!$sent): ?>
	<form method="POST" action="/contact/form" class="form-horizontal">
	  <fieldset>
	    <legend><?php echo $lang->contact_header ?>
	    </legend>
	    <div class="control-group">
	      <label class="control-label" for="inputName"><?php echo $lang->contact_name; ?></label>
	      <div class="controls">
		<input type="text" name="inputName" placeholder="<?php echo $lang->contact_name ?>"  value="<?php echo $_POST['inputName'] ?>">
	      </div>
	    </div>
	    <div class="control-group">
	      <label class="control-label" for="inputCompany"><?php echo $lang->contact_company; ?></label>
	      <div class="controls">
		<input type="text" name="inputCompany" placeholder="<?php echo $lang->contact_company ?>" value="<?php echo $_POST['inputCompany'] ?>">
	      </div>
	    </div>
	    
	    <div class="control-group <?php if ($mail_error):?>error<?endif?>">
	      <label class="control-label" for="inputEmail">Email</label>
	      <div class="controls">
		<?php if($mail_error): ?>
		<div class="text-error"><?php echo $lang->contact_error ?></div>
		<?php endif ?>
		<input type="text" name="inputEmail" placeholder="Email" value="<?php echo $_POST['inputEmail'] ?>">
	      </div>
	    </div>

	    <div class="control-group">
	      <label class="control-label" for="inputBody"><?php echo $lang->contact_body; ?></label>
	      <div class="controls">
		<textarea rows="6" name="inputBody" placeholder="<?php echo $lang->contact_body ?>"><?php echo $_POST['inputBody'] ?></textarea>
	      </div>
	    </div>
	    <div class="control-group">
	      <div class="controls">
		<input type=hidden name="send_email" value="yes">
		<button type="submit" class="btn btn-primary"><?php echo $lang->send; ?></button>
	      </div>
	    </div>
	  </fieldset>
	</form>
	<?php endif; ?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="span12">
      <?php $this->foot() ?>
    </div>
  </div>
</div>
</body>
