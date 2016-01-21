<ul class="nav nav-pills block_1">
  <li><a href="/"><?php print $lang->foot_main_page; ?></a></li>
  <li><a href="/go/_promotion/saleoff.php"><?php print $lang->head_saleoff; ?></a></li>
  <li><a href="/go/_promotion/promo.php"><?php print $lang->foot_promotions; ?></a></li>
<!--
  <li><a href="/go/_promotion/?column=promotion"><?php print $lang->foot_promotions;?></a></li>
  <li><a href="/go/_promotion/?column=newcol"><?php print $lang->foot_news;?></a></li>
-->
  <li><a href="/go/_files/?file=terms.html"><?php print $lang->foot_terms;?></a></li>
  <li><a href="/go/_files/?file=howtobuy.html"><?php print $lang->foot_howtobuy;?></a></li>
  <li><a href="/go/_files/?file=privacy.html"><?php print $lang->foot_privacy;?></a></li>
  <li><a href="/go/_files/?file=payments.html"><?php print $lang->foot_payments;?></a></li>
  <li><a href="/go/_files/?file=delivery.html"><?php print $lang->foot_delivery;?></a></li>
  <li><a href="/go/_files/?file=help.html"><?php print $lang->foot_help;?></a></li>
  <li><a href="http://docs.google.com/leaf?id=0B12554jLABN2ZDExNTg1YjMtYzdlMy00YWJkLWJlZDgtNWFhNzJhMTUwM2Q0&hl=pl"><?php print $lang->download_files; ?></a></li>
  <li><a href="/go/_files/?file=mikran_o_nas.html"><?php print $lang->foot_gallery;?></a></li>
  <li><a href="/sitemap"><?php print $lang->sitemap; ?></a></li>

</ul>
   
<?php if (!$_COOKIE['privacy_ok']): ?>
   <div id="cookie-law-info-bar" class="center-text" style="display: block; background-color: rgb(238, 241, 244); border-top-width: 4px; border-top-style: solid; border-top-color: rgb(68, 68, 68)">
   <span><?php print $lang->cookie1 ?>
   <br><?php print $lang->cookie2 ?>
   <a href="/go/_info/cookie.php" style="color: rgb(255, 255, 255); background-color: rgb(0, 0, 0);"><?php print $lang->cookie3; ?></a><br/><a href="/go/_files/?file=privacy.html"><?php print $lang->foot_privacy;?></a>
   </span>
   </div>
<?php endif ?>

<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-1222712-1";
urchinTracker();
</script>
</body>
</html>
