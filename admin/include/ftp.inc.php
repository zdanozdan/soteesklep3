<?php
/**
 * Obsluga polaczenia FTP
 *
 * @author m@sote.pl
 * @version $Id: ftp.inc.php,v 2.30 2006/05/24 13:38:14 lukasz Exp $
* @package    admin_include
 */

// obsluga kodowania + klucze
include_once ("include/keys.inc.php"); global $__key,$__secure_key;
require_once ("include/my_crypt.inc");
$my_crypt = new MyCrypt;

class FTP {
    //var $chmod="644";     // domyslne uprawnienia plikow
    var $ftp_user;          // login konta FTP, jest ustawiony, jesli jest inny niz aktualnie zapisany w bazie
    var $ftp_password;      // haslo dostepu do FTP, jw.

    /**
     * Sprawdz czy PHP ma wkompilowana obsluge FTP
     */
    function test_php(){
        global $debug;

        if (! function_exists('ftp_connect'))
        $debug->error("ftp_nomodule","FTP",-2);
        return;
    } // end test_php()

    /**
     * Odczytaj haslo z tablicy $config->ftp i odkoduj je
     */
    function get_decrypt_password() {
        global $db;
        global $config,$my_crypt;
        global $__secure_key;

        // odkoduj zakodowane haslo dostepu do FTP
        $decode=$my_crypt->endecrypt($__secure_key, $config->ftp['ftp_password'], "de");
        $this->ftp_password=$decode;

        return;
    } // end get_decrypt_password()

    /**
     * Otworz polaczenie FTP
     *
     * @param  string $auto "yes" - automatycznie pobierz haslo z tablicy $config->ftp
     * @returm bool   true udalo sie polaczyc z serwerem FTP, false w p. w.
     */
    function connect($auto="yes"){
        global $config;
        global $debug;

        // lacz sie tylko raz
        if (! empty($this->conn_id)) return true;

        if (@$config->demo=="yes") return true;

        // pobierz haslo z bazy danych i zdekoduj je
        if ($auto=="yes") {
            $this->get_decrypt_password();
        }

        if (! empty($this->conn_id)) return;  // jest juz 1 polaczenie
        $this->test_php();

        if (empty($this->ftp_host)) {
            if (! empty($config->ftp['ftp_host'])) {
                $this->ftp_host=$config->ftp['ftp_host'];
            }
        }

        if (empty($this->ftp_user)) {
            if (! empty($config->ftp['ftp_user'])) {
                $this->ftp_user=$config->ftp['ftp_user'];
            }
        }

        if (empty($this->ftp_password)) {
            if (! empty($config->ftp['ftp_password'])) {
                $this->ftp_password=$config->ftp['ftp_password'];
            }
        }

        $this->conn_id = ftp_connect($this->ftp_host);
        $login_result = ftp_login($this->conn_id,"$this->ftp_user","$this->ftp_password");
        if (! $this->conn_id) {
            // serwer FTP nie odpowiada
            $this->_go2ftp();
            die();
        }
        if (! $login_result)  {
            // nie udalo sie zalogowac przez FTP, wprowadz nowe dane do FTP
            $this->_go2ftp();
            die();
        }

        return true;
    } // end connect()

    /**
    * Przekieruj usera na strone, gdzie podawane sa dane dop FTP
    *
    * @access private()
    * @return none
    */
    function _go2ftp() {
        global $sess,$config,$lang;

        print $lang->ftp_go2newpass."<p>";
        print "<button onclick=\"if(window.opener) window.opener.location.href='/setup/ftp.php'; else window.location.href='/setup/ftp.php';\">$lang->ftp_new_password</button>";
        die();
    } // end _go2ftp()

    /**
     * Zamknij polaczenie FTP
     */
    function close() {
        global $config;

        if (@$config->demo=="yes") return true;

        if (empty($this->conn_id)) return false;
        $this->conn_id='';

        @ftp_quit($this->conn_id);
        return true;
    } // end close()

    /**
     * Wrzuc plik na serwer
     *
     * @param string $local      plik lokalny
     * @param string $remote_dir katalog zdalny
     * @param string @remote     plik zdalny
     * @param string $chmod      uprawnienia tworzonego pliku
     */
    function put($local,$remote_dir,$remote,$chmod="0644"){
        global $debug;
        global $config;
        global $lang;

        //print "local==".$local."<br>";
        //print "remote_dir==".$remote_dir."<br>";
        //print "remote==".$remote."<br>";


        if (empty($local)) {
            print ($lang->ftp_upload_error." ".ini_get("upload_max_filesize").")");
            return false;
        }

        if (@$config->demo=="yes") return true;

        if (! $this->chdir($remote_dir)) {
            $debug->error("ftp_put","FTP",-2);
        }

        ftp_chdir($this->conn_id,$remote_dir);

        if (! ftp_put($this->conn_id,$remote,$local,FTP_BINARY)) {
            $debug->error("ftp_put","FTP",-2);
        }

        if(ftp_size($this->conn_id,$remote)==0) {
            for($i=0;$i<5;$i++) {
                if (! ftp_put($this->conn_id,$remote,$local,FTP_BINARY)) {
                    $debug->error("ftp_put","FTP",-2);
                }
                if(ftp_size($this->conn_id,$remote)!=0) break;
            }
            // jesli sprobowano 5 razy i nie udalo sie przerzucic pliku
            // wypisz odpowiedni komunikat
            if($i == 5 && !filesize($local)==0) {
                print $lang->ftp_upload_count_error."<br>";
                print $lang->ftp_upload_info." ".$local." ".$remote_dir."/".$remote."<br>";
                return false;
                // przeprowadzono piec prob przeslania pliku i wszystkie sie nie powiodly
            }
        }

        // zmien prawa
        $this->chmod($remote_dir."/$remote",$chmod);

        // skasuj plik tymczasowy
        if (ereg("admin\/tmp",$local)) {
            @unlink($local);
        }

        return true;
    } // end put()

    /**
     * Zmien nazwe pliku/katalogu
     *
     * @param string $remote_dir katalog zdalny
     * @param string $from       nazwa zmienianego pliku/katalogu
     * @param string $to         nowa nazwa pliku/katalogu
     */
    function rename($remote_dir,$from,$to) {
        global $config;

        if (@$config->demo=="yes") return true;

        if (! ftp_chdir($this->conn_id, $this->realPath($remote_dir))) {
            $debug->error("ftp_put","FTP",-2);
        }
        if (! ftp_rename($this->conn_id,$from,$to)) {
            $debug->error("ftp_rename","FTP",-2);
        }
    } // end rename()

    /**
     * Zaloz katalog
     * 
     * @param string $remote_dir katalog
     * @param string $chmod      uprawniania tworzonego katalogu
     */
    function mkdir($remote_dir,$chmod="711",$i=1) {
        global $debug;
        global $config;

        if (@$config->demo=="yes") return true;

        if (! @ftp_chdir($this->conn_id,$this->realPath($remote_dir))) {
            // nie ma katalogu, zakladamy katog
            $up_remote_dir=dirname($remote_dir);
            if (ftp_chdir($this->conn_id,$this->realPath($up_remote_dir))) {
                ftp_mkdir($this->conn_id,$remote_dir);
                return true;
            } else {
                $this->mkdir($up_remote_dir);
                $this->mkdir($remote_dir);
                return true;
            }

            /*
            if (! ftp_mkdir($this->conn_id,$remote_dir)) {
            if ($i<8) {
            $remote_dir=dirname($remote_dir);
            print "i=$i remote_dir=$remote_dir <br/>\n";
            $this->mkdir($remote_dir,$i++);
            ftp_mkdir($this->conn_id,$remote_dir);
            return true;
            } else {
            $debug->error("ftp_mkdir","FTP",1);
            }
            }
            */
        } else {
            // wskazany katalog ju¿ istniejue, OK
        }

        // zmien prawa
        $this->chmod($remote_dir,$chmod);

        return true;
    } // end mkdir()

    /**
     * Zmien uprawnienia pliku/katalogu
     *
     * @param string $file  plik/katalog
     * @param string $chmos prawa np. 0711
     */
    function chmod($file,$chmod="0644") {
        return;
        // zmien prawa
        if (! ftp_exec($this->conn_id, "chmod $chmod $file")) {
            $debug->error("ftp_chmod","FTP",-2);
        }
        return;
    } // end chmod

    /**
     * Skasuj plik
     * 
     * @param string $remote_dir katalog zdalny
     * @param string $remote plik zdalny
     */
    function delete($remote_dir,$remote) {
        global $debug;
        global $config;

        //        print "DELETE";

        if (@$config->demo=="yes") return true;

        //        print "remote_dir=$remote_dir $remote=$remote <BR>";

        if (! ftp_delete($this->conn_id,$remote_dir."/".$remote)) {
            $debug->error("ftp_delete","FTP",1);
        }
        return;
    }

    /**
     * Wylistuj pliki w danym katalogu
     * 
     * @param string $remote_dir katalog zdalny
     *
     * retrun array list plików
     */
    function nlist($remote_dir) {
        global $debug;
        global $config;

        if (@$config->demo=="yes") return true;

        if (!($data=@ftp_nlist($this->conn_id,$remote_dir))) {
            $debug->error("ftp_delete","FTP",1);
        }
        return $data;
    } // end nlist

    /**
     * Zmien katalog
     * 
     * @param string $remote_dir katalog zdalny
     */
    function chdir($remote_dir) {
        global $debug;
        global $config;

        if (@$config->demo=="yes") return true;
        if (! ftp_chdir($this->conn_id, $this->realPath($remote_dir))) {
            if (! $this->mkdir($remote_dir)) {
                return false;
            }
        }
        return true;
    } // end chdir

    /**
    * Skróæ ¶cie¿kê, tj wyeliminuj powtarzaj±ce siê wywo³ania np. soteesklep3/../soteesklep itp.
    *
    * @param string $path ¶cie¿ka w dowolnym formacie
    * @param string ¶cie¿ka w formacie, bez ".."
    */
    function realPath($path) {
        $tab=split("/",$path);
        $real_path=array();
        $i=0;
        foreach ($tab as $dir) {
            if ($dir!="..") {
                $real_path[$i]=$dir;
                $i++;
            } else {
                $i--;
            }
        }
        reset($real_path);$new_dir='';
        foreach ($real_path as $dir) {
            $new_dir.="/".$dir;
        }

        return $new_dir;
    } // path()

} // end class FTP

$ftp = new FTP;
// przypisanie dla zachowania zgodnosci ze starym systemem przechowywania informacji o katalogu FTP programu
$config->ftp_dir=$config->ftp['ftp_dir'];
?>
