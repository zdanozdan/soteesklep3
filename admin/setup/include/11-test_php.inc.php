<?php
/**
 * Testowanie opcji PHP
 *
 * @author  m@sote.pl
 * @version $Id: test_php.inc.php,v 2.9 2005/12/22 10:30:00 lukasz Exp $
 * @soteesklep
* @package    setup
 */
 
class TestPHP {
    var $version="436"; // wymagana wersja m.in. PHP-4.1.2
    var $version_print=">=4.3.6";
    var $installed="Yes:)";
    var $not_onstalled="No:(";
    var $next="Next";
    var $num=1;
    var $testall=true;

    /**
     * Rozpocznij testy opcji PHP
     *
     * \@global bool $this->testall true wszystko OK
     *
     * return none 
     */
    function test_start() {
    	global $_ERROR;
    	$_ERROR=false;
        print "<table align=center>\n";
        $this->test("PHP: ($this->version_print): ",$this->version());
        $this->test("PHP: MySQL",$this->mysql());
        $this->test("PHP: ftp",$this->ftp());
        $this->test("PHP: trans_sid",$this->trans_sid());        
        $this->test("PHP: zlib",$this->zlib());
        $this->test("PHP: openssl",$this->openssl());
        print "</table>\n";
        @include ("./ignore");
        if (@$ignore_all) $_ERROR=false; 
        return;
    } // end test_start()

    /**
    * Wy�wietl informacje o tym, czy dana opcja jest zainstalowana
    *
    * @param string $text nazwa/opis opjcji
    * @param bool   true  opcja jest zainstalowana/skonfigurowana
    * 
    * @return none
    */
    function test($text,$bool) {
        global $lang;

        print "<tr><td>$this->num. $text</td><td>";
        if ($bool) print "<b>".$this->installed."</b>";
        else print "<b><font color=red>".$this->not_installed."</font></b>";
        print "</td></tr>";
        $this->num++;
		if (!$bool) {
			global $_ERROR;
			$_ERROR=true;
		}
        if (! $bool) $this->testall=false;

        return;
    } // end test()
	    
    /**
     * Sprawd� obecno�� zlib
     *
     * @return bool true - OK, false - brak
     */
    function zlib() {
    	if (function_exists('gzopen')) {
    		return true;
    	}
    	return false;
    } // end zlib
    
    /**
     * Sprawd� obecno�� openssl
     *
     * @return bool true - OK, false - brak
     */
    function openssl() {
    	if (function_exists('openssl_open')) {
    		return true;
    	}
    	return false;
    } // end openssl
    
    /**
    * Weryfikuj wersje PHP
    *
    * @return bool true - wersja OK, false w p.w.
    */
    function version() {
        $php_version=phpversion();
        $php_version=preg_split('@\.@',$php_version);
        if ($php_version[0]>=$this->version[0]) {
        	return true;
        }
        if ($php_version[1]>=$this->version[1]) {
        	return true;
        }
        if ($php_version[2]>=$this->version[2]) {
        	return true;
        }
        return false;
    } // end version

    /**
    * Sprawd�, czy PHP zawiera obs�uge MySQL
    *
    * @return bool true PHP zawiera obs�uge MySQL, false w p.w.
    */
    function mysql() {
        if (function_exists('mysql_connect')) return true;
        else return false;
    } // end mysql()

    /**
    * Sprawd�, czy PHP zawiera obs�uge FTP (--enable-ftp)
    *    
    * @return bool true PHP zawiera obs�uge FTP, false w p.
    */
    function ftp() {
        if (function_exists('ftp_login')) return true;
        else return false;
    } // end ftp()

    /**
    * Sprawd�, czy PHP ma w��czon� opcj� transparentnych sesji
    *
    * @return bool true PHP zawiera obs�uge transparentnych sesji, false w p.
    */
    function trans_sid() {
        $trans_sid=ini_get("session.use_trans_sid");
        if ($trans_sid==1) return true;
        else return false;
    } // end ftp()

} // end class TestPHP

$test_php =& new TestPHP;

$test_php->installed=$lang->installed;
$test_php->not_installed=$lang->not_installed;
$test_php->next=$lang->next;

?>