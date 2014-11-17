<?php
/**
* Formularze z zawarto¶ci± plików: z dysku i z systemu upgrade'u, oraz plik z ró¿nic± + ró¿nica.
* Skrypt wywo³uje program zainstalowany na http://sote.pl/plugis/_bugs/_diff/index.php, gdzie podpiêty
* jest odpowiedni system ³±czenia zmian w plikach.
*
* @author  m@sote.pl
* @version $Id: repair.html.php,v 1.8 2005/09/08 13:23:22 lukasz Exp $
*
* \@global array $file tablica z zawartoscia plików 
* @package    upgrade
*/
?>

<br />
<?php print $lang->upgrade_file_info;?>
<p />

<table width="100%">
  <tr>
    <td>


   
    <form action=repair.php METHOD=POST>
    <input type=hidden name=new value=1>
    <?php
    print "<input type=hidden name=file[name] value='".$file['name']."'>\n";
    print "<input type=hidden name=file[patch_version] value='".$file['patch_version']."'>\n";
    print "<input type=hidden name=file[upgrade_file] value='".$file['upgrade_file']."'>\n";
    // print "<input type=hidden name=file[new] value='".$file['diff']."'>\n";
    print "<input type=hidden name=file[tmp_file] value='".$file['tmp_file']."'>\n";
    ?>
    <br />
    <center><input type=submit value='<?php print $lang->upgrade_accept;?>'></center>
    </form>

    <p />
    
    <!-- pobierz pliki -->
    <?php
    global $lang;
    global $shop;
    print "<li><a href=".$shop->home_relink("/tmp/diff_source_").$file['tmp_file'].".txt target=download><u>$lang->bugs_download_source</u></a></li>\n";
    print "<li><a href=".$shop->home_relink("/tmp/diff_result_").$file['tmp_file'].".txt target=download2><u>$lang->bugs_download_diff_result</u></a></li>\n";
    ?>
    <!-- end -->
    
    <?php
    /*
    <form action=repair.php METHOD=POST>
    <input type=hidden name=new value=1>
    <?php
    print "<input type=hidden name=file[name] value='".$file['name']."'>\n";
    print "<input type=hidden name=file[patch_version] value='".$file['patch_version']."'>\n";
    print "<input type=hidden name=file[upgrade_file] value='".$file['upgrade_file']."'>\n";
    ?>
    2. <?php print $lang->upgrade_file['path'];?><br>
    <div align=right><input type=submit value='<?php print $lang->update;?>'></div>
    <textarea name=file[new] cols=120 rows=10><?php print $file['path'];?></textarea>
    </form>
    
    <p />
    
    <form action=repair.php METHOD=POST>
    <input type=hidden name=new value=1>
    <?php
    print "<input type=hidden name=file[name] value='".$file['name']."'>\n";
    print "<input type=hidden name=file[patch_version] value='".$file['patch_version']."'>\n";
    print "<input type=hidden name=file[upgrade_file] value='".$file['upgrade_file']."'>\n";
    ?>
    3. <?php print $lang->upgrade_file['upgrade'];?><br>
    <div align=right><input type=submit value='<?php print $lang->update;?>'></div>
    <textarea name=file[new] cols=120 rows=10><?php print $file['upgrade'];?></textarea>
    </form>
    
    <p />
    */
    ?>
    
    </td>
  </tr>
</table>
</form>
