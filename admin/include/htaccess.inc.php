<?php
/**
 * Generowanie hasle do plikow z kasalmi do .htaccess
* @version    $Id: htaccess.inc.php,v 2.3 2006/04/25 08:59:15 lukasz Exp $
* @package    admin_include
 */
class htaccess {
    
    /**
     * Genruj haslo dostepu i zapisz je w pliku hasel, do ktorego odwolanie jest w .htaccess
     *
     * @param string $login    login dostepu
     * @param string $password haslo dostepu
     * @param string $file tworzony plik z haslami
     */ 
    function gen_passwd($login,$password,$file) {
        global $DOCUMENT_ROOT;

        if (empty($password)) $password=md5(time());
        $pass_crypt=crypt($password,'$1$');
        $fh="$login:$pass_crypt\n";
        $fd=fopen("$DOCUMENT_ROOT/setup/tmp/$file","w+");
        fwrite($fd,$fh,strlen($fh));
        fclose($fd);
		
        return;
    } // end gen_password()

    /**
     * Generuj plik z lista loginow i hasel jw.
     *
     * @param array  $data tablica login=>haslo
     * @param string $file tworzony plik z haslami
     */
    function gen_passwd_file($data,$file) {
        global $DOCUMENT_ROOT;

        $fh="";
        reset($data);
        while (list($login,$password) = each($data)) {
            $pass_crypt=crypt($password,'$1');
            $fh.="$login:$pass_crypt\n";
        } 
        $fd=fopen("$DOCUMENT_ROOT/setup/tmp/$file","w+");
        fwrite($fd,$fh,strlen($fh));
        fclose($fd);

        return;
    } // end gen_passwd_file()


} // end class htaccess
?>
