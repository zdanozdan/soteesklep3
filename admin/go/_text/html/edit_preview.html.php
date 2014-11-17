<?php 
/**
 * Wyswietl plik html_files - podglad
* @version    $Id: edit_preview.html.php,v 2.4 2004/12/20 17:59:06 maroslaw Exp $
* @package    text
 */
$theme->desktop_open();

// wyswietl plik, z odpowiedniego katalogu uwzgledniajac zdefiniowany przez uzytkownika jezyk dla ktorego zmieniane sa
// strony HTML
// ...

if (($config->devel!=1) && (empty($filedev))) {
    $theme->file(@$file,@$lang_name);
}

$theme->desktop_close();
?>
