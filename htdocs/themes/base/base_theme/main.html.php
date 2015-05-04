<?php
global $config;

if (((@$config->catalog_mode==0) && ($config->newsedit==1))||((@$config->catalog_mode==1)&&(@$config->catalog_mode_options['newsedit']==1))){

  @include_once ("plugins/_newsedit/include/newsedit.inc.php");
  if ((is_object(@$newsedit)) && ($newsedit->get_news_count() > 0)) 
    {
      echo '<div class="head_1">';
      echo $lang->main_news;
      echo '</div>';
      $newsedit->show_list();
      if($config->rss_link == 1) 
	{
	  echo "<table width=100% cellspacing=0 cellpadding=0 border=0><tr><td width=100% align=right style='padding-right: 10px;'>";  $this->theme_file("rss.html.php"); echo "</td></tr></table>";
        }
        print "<br />\n";
    }
}
?>

<div class="head_1">
<?php echo $lang->main_recommend; ?>
</div>
