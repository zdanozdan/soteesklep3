<?php
/**
* Obs�uga plik�w aktualizacji.
* Odczytanie plik�w do aktualizacji, weryfikacja, aktualizacja.
*
* @author  m@sote.pl
* @version $Id: upgrade.inc.php,v 1.38 2006/03/09 11:41:07 lukasz Exp $
* @package    upgrade
*/

/**
* Dodaj obs�ug� FTP
*/
require_once ("include/ftp.inc.php");

/**
* Dodaj obs�ug� plik�w CVS
*/
require_once ("include/cvs.inc.php");

/**
* Dodaj obs�ug� generowania sum kontrolnych plik�w
*/
require_once ("include/file_checksum.inc.php");

/**
* Odczytaj konfiguracje patch'y
*/
require_once ("config/auto_config/patch_config.inc.php");

/**
* Oczytaj zarz�dzanie licencj�
*/
require_once ("include/license.inc.php");

/**
* Maksymalna ilo�� zagnie�dze� katalog�w przy zak�adaniu nowych �cie�ek.
* Ilo�� katalog�w przegl�danych "w g�r�" w celu znalezienia odpowiedniej �cie�ki, w kt�rej
* mo�na zak�ada� wsakzane katalogi.
*/
define ("MKDIR_MAX_COUNT",8);

/**
* Okre�lenie do jakiej bazy sum kontrolnych jest zapisywana suma kontrolna. UPGRADE_FILE_SUM -> sum.md5
*/
define ("UPGRADE_FILE_SUM",1);

/**
* Okre�lenie do jakiej bazy sum kontrolnych jest zapisywana suma kontrolna. UPGRADE_FILE_MOD -> mod.md5
*/
define ("UPGRADE_FILE_MOD",2);

/**
* Okre�lenie czy dokonujemy symulacji instalacji pakietu.
*/
define ("UPGRADE_SIMULATION",true);

/**
* Okre�lenie poprawnej aktualizacji pliku.
*/
define ("UPGRADE_RESULT_OK",0);

/**
* Okre�lenie pliku z modyfikacj� klienta.
*/
define ("UPGRADE_RESULT_MOD",-1);

/**
* B��d podczas instalacji pliku.
*/
define ("UPGRADE_RESULT_ERROR",-2);

/**
* Tryb autonmatycznej instalacji plik�w.
*/
define ("UPGRADE_INSTALL_AUTO_MODE",1);

/**
* Zapami�taj aktualizowany plik w bazie, nie instaluj go.
*/
define ("UPGRADE_SAVE_MOD",1);

/**
* Obs�uga plik�w "Diff"
* @package upgrade
*/
class Diff {

    /**
    * @var array wiersze z aktualizacji
    * @access private
    */
    var $_file_lines=array();

    /**
    * @var array lista plik�w do aktualizacji
    */
    var $_files=array();

    /**
    * @var int licznik za�o�onych katalog�w, przy tworznieu odpowiedniej �cie�ki do pliku (zobacz MKDIR_MAX_COUNT)
    */
    var $_mkdirCount=0;

    /**
    * @var bool true - symulacja instalacji    
    * @access private
    */
    var $_simulation=false;

    /**
    * @var int status aktualizacji 0 - ok, 1 - modyfikacja
    */
    var $upgrade_status=0;

    /**
    * @var string zawarto�c ostatnio aktualizowanego pliku
    */
    var $_source='';

    /**
    * @var string opcjonalny kod aktywacyjny do pakietu zdefiniowany w pliku 000-upgrade_config.php w sta�ej PATCH_CODE
    * @access private
    */
    var $_patch_code='';

    /**
    * Konstruktor
    *
    * @param string $file plik z aktualizacj�
    * @return bool true plik poprawnie za��czony, false w p.w.
    */
    function Diff($file) {
        if (file_exists($file)) {
            $fd=fopen($file,"r");
            $data=fread($fd,filesize($file));
            fclose($fd);
            $this->_file_lines=split("\n",$data);
            return true;
        }
        return false;
    } // end Diff()

    /**
    * Odczytaj list� plik�w do aktualizacji
    * @return array
    */
    function _getFiles() {
        $files=array();
        reset($this->_file_lines);
        foreach ($this->_file_lines as $_line) {
            if (ereg("^diff -ruN",$_line)) {
                $tab=split(" ",$_line,4);
                if (! empty($tab[3])) $files[]=$tab[3];
            }
        } // end foreach
        $this->_files=$files;
        return $files;
    } // end _getFiles()

    /**
    * Odczytaj zawarto�c wskazanego pliku z pakietu aktualizcyjnego.
    *
    * @param string nazwa pliku + �cie�ka w wzgl�dem $DOCUMENT_ROOT/../
    * @return string zawarto�c pliku
    */
    function getFile($file) {
        if (empty($this->_file_lines)) return;
        reset($this->_file_lines);$file_source='';$_read=false;$_start=false;
        foreach ($this->_file_lines as $_line) {
            if (ereg(" ".$file."$",$_line)) $_read=true;
            if ((! (ereg(" ".$file."$",$_line))) && ((ereg("^diff "."-ruN ",$_line)))) { $_read=false; $_start=false; }
            if (ereg("\ No newline "."at end of file",$_line)) { $_read=false; $_start=false; }
            if (($_read) && ($_start)) {
                $line=preg_replace("/^\+/","",$_line); // usu� znak +, k�try dodaje diff na pocz�tku ka�dej linii
                $file_source.=$line."\n";
            }
            if (($_read) && (! $_start)) {
                if (ereg("^@@ ",$_line)) $_start=true;
            }
        } // end foreach()
        return $file_source;
    } // getFile()

} // end class Diff

/**
* Klasa aktualizacja sklepu na bazie plik�w "diff".
* @package upgrade
*/
class DiffUpgrade extends Diff {

    /**
    * @var int numer wersji upgrade'u, dla ka�dego upgradu numer powinien by� nowy numer CVS
    */
    var $_version=-1;

    /**
    * @var string zmienna zawieraj�ca plik zawieraj�cy pakiet upgrade'u (nazwa pliku z uaktualneiniem)
    * @access public
    */
    var $upgradeFile='';

    /**
    * Lista podkatalog�w z g��wnego katalogu sklepu, dla kt�rych zmieniana jest lokalizacja docelowa
    * Dot. instalacji na home.pl
    */
    var $_base_dirs=array("config","include","lib","bin");

    /**
    * Kondtruktor
    * @see Diff::Diff()
    */
    function DiffUpgrade($file) {
        $this->upgradeFile=$file;
        preg_match("/([0-9][0-9][0-9])\./",basename($file),$matches);
        if (! empty($matches[1])) $this->_version=intval($matches[1]);
        else $this->version=date("YmdHi");
        return $this->Diff($file);
    } // end DiffUpgrade()

    /**
    * Wy�wietl liste plik�w do aktualizacji
    * @return none
    */
    function showListFiles() {
        if  (empty($this->_files)) $this->_getFiles();
        reset($this->_files);
        print "<ul>\n";
        foreach ($this->_files as $_file) {
            $file_url=urlencode($_file);
            print "<li>$_file</li>\n";
        } // end foreach
        print "</ul>\n";
        return;
    } // end showListFiles()

    /**
    * Wykonaj upgrade
    *
    * @param bool $simulation true - emulacja trybu instalacji pakietu, bez jego instalacji, false - instalacja pakietu
    *
    * @return int  1 upgrade wykonany poprawnie,  (-1) - bledny pakiet  
    */
    function doUpgrade($simulation=false) {
        global $ftp,$DOCUMENT_ROOT;
        global $lang,$shop,$config;

        $this->_simulation=$simulation;

        $this->_getFiles();
        if  (empty($this->_files)) $this->_getFiles();
        $ftp->connect();
        //print "<table cellspacing=1 cellpadding=0 border=0>\n";
        $result=array();
        foreach ($this->_files as $_file) {
            // print "<tr>\n";
            // spawdz, czy plik mozna zaktualizowac
            $result_upgrade_test=$this->_upgradeTestFile($_file);

            if (! ereg("000-upgrade_config.php",$_file)) {
                // pomi� plik konfiguracji aktualnie instalowanego pakietu
                $result[$_file]['result']=$result_upgrade_test;
            }

            if (($result_upgrade_test>0) && ($result_upgrade_test!=2)) {
                $this->upgrade_status=1;
            }
            if ($result_upgrade_test==0) {
                // instaluj plik je�li nie zosta� wywo�any tryb symulacji lub je�li jest odczytywany plik konfiguracyjny
                if ((! $this->_simulation) || (ereg("000-upgrade_config.php",$_file))) {
                    if (! $this->upgradeFile($_file)) {
                        $result['files'][$_file]=UPGRADE_RESULT_ERROR;
                    } else {
                        // start home.pl 2005-08-17 m@sote.pl
                        // instaluj plik konfiguracyjny do g��wnego katalogu i do admin (dla home.pl)
                        // gdy� na home.pl plik z g��wnego katalogu nie jest dost�pny i jego
                        // kopia musi znajdowa� si� w podkatalogu "admin"
                        if ((ereg("000-upgrade_config.php",$_file)) && ($shop->home)) {
                            if ($fd=fopen("/tmp/000-upgrade_config.php","w+")) {
                                fwrite($fd,$this->_source,strlen($this->_source));
                                fclose($fd);
                                $ftp->put("/tmp/000-upgrade_config.php",$config->ftp['ftp_dir']."/admin","000-upgrade_config.php");
                            } else {
                                die ("Error: Unable to install file /tmp/000-upgrade_config.php");
                            }
                        }
                        // end home.pl

                    }

                    if (ereg("000-upgrade_config.php",$_file)) {
                        // odczytaj numer wersji aktualnie instalowanego pakietu
                        include_once ("000-upgrade_config.php");
                        if (! defined("PATCH_VERSION")) {
                            $this->upgrade_status=1;
                        } else {
                            $this->_version=PATCH_VERSION;
                        }

                        // kod aktywacyjny zwi�zany z pakietem aktualizacyjnym
                        if (defined("PATCH_CODE")) {
                            $this->_patch_code=PATCH_CODE;
                        }

                    }
                }

                // sprawd� wersj� instalowanego pakietu,
                if (! $this->checkVersion()) {
                    return (-1);
                }

                // } elseif ($result_upgrade_test==-1) {
                //  if (! $this->upgradeFile($_file,'',UPGRADE_FILE_MOD)) {
                //      $result['files'][$_file]=UPGRADE_RESULT_ERROR;
                //  }
            } else {
                //print "</td>\n";
                //print "<td>\n";
                //print " <font color=\"$color\">".$lang->upgrade_file_status_simulation[$result_upgrade_test]."</font>";
                //print "</td>\n";
                global $shop;
                if (($result_upgrade_test!=2) && ($this->_simulation) && !@$shop->home) {
                    //print "<td>\n";
                    // poka� formularze do wykrycia modyfikacji pliku i "wyleczenia/pogodzenia" zmian
                    //print "      <form action=repair.php method=POST target=window>\n";
                    //print "      <input type=hidden name=file[name] value='".$_file."'>\n";
                    $result[$_file]['form']['name']=$_file;
                    $result[$_file]['form']['upgrade_file']=$this->upgradeFile;
                    //print "      <input type=hidden name=file[upgrade_file] value='".$this->upgradeFile."'>\n";
                    //print "      <input type=hidden name=file[path] value='".$this->_files['path']."'>\n";
                    $result[$_file]['form']['path']=$this->_files['path'];
                    //print "      <input type=hidden name=file[upgrade] value='".$this->_files['upgrade']."'>\n";
                    $result[$_file]['form']['upgrade']=$this->_files['upgrade'];
                    //print "      <input type=submit value='$lang->upgrade_file_repair' onclick='window.open(\"\", \"window\", \"width=800, height=600, status=no, toolbar=no, scrollbars=yes, resize=1\")'>\n";
                    //print "      </form>\n";
                    //print "</td>\n";
                } else {
                    // instalacja plik�w z bufora, lub nadpisanie plik�w z dysku plikami z pakietu
                    // sprawd�, czy aktualizowany plik jest w buforze, je�li tak to odczytaj jego zawarto�� i zainstaluj
                    // je�li nie, instaluj pliki z pakietu
                    $upgrade_file_source=$this->getFileFromDB($_file);
                    if ($upgrade_file_source) {
                        // plik jest w buforze
                        $this->upgradeFile($_file,$upgrade_file_source,UPGRADE_FILE_MOD);
                        $result[$_file]['result']=4;
                    } else {
                        // nie ma plku w buforze, we� plik z pakietu akualizacyjnego
                        $this->upgradeFile($_file);
                        $result[$_file]['result']=0;
                    }
                }
                //print "</tr>\n";
            }
        } // end foreach()
        //print "</table>\n";

        // zapami�taj wynik testu/aktualizacji
        $this->_result=$result;
        //print "<pre>";print_r($result);print "</pre>";


        if (empty($result)) {
            print "<font color=\"red\">$lang->upgrade_error_ext</font>\n";
            $this->upgrade_status=2;
        }

        global $__database_md5;

        // zapisz now� baz� sum kontrolnych
        if (! $this->_simulation) {
            if (FileChecksum::saveDat()) {
                print "<p>$lang->upgrade_checksums_upgraded <p>";
            } else {
                print "<p><font color=\"red\">$lang->upgrade_checksums_upgrade_error</font><p>\n";
            }
        }
        $ftp->close();

        return (1);
    } // end doUpgrade()

    // {{{ showUpgradeInfo()

    /**
    * Wyswietl raport dot. aktualizacji.
    *
    * @param int $upgrade_mode 0 - defualt, UPGRADE_INSTALL_AUTO_MODE - nie pokazuj linku do naprawy plik�w
    *
    * @return  bool
    */
    function showUpgradeInfo($upgrade_mode=0) {
        global $theme;
        if (empty($this->_result)) return false;
        if ((empty($this->_version)) && ($this->_version!=0)) return false;

        $ret=true;
        print "<table cellspacing=\"0\" cellpadding=\"1\">\n";
        foreach ($this->_result as $file=>$val) {
            print "<tr>";
            print "<td>";
            $status=$val['result'];
            switch ($status) {
                case 0: $theme->point("g");break; // 0 - mo�na aktualizowa� plik
                case 1: $theme->point("r");break; // 1 - plik zmieniony, wykryto modyfikacj�
                case 2: $theme->point("b");break; // 2 - nowsza wersja pliku
                case 3: $theme->point("o");break; // 3 - indywidualna modyfikacja
                case 4: $theme->point("rg");break; // 4 - indywidualna modyfikacja, zatwierdzona w poprzedniej aktualizacji
                default: $theme->point("black");break;
            }
            print "</td>";
            print "<td>$file</td>";
            if (($status==1) || ($status==3) | ($status==4)) {
                if (empty($upgrade_mode)) {
                    $ret=false;
                    print "<td>";$this->_repairForm($file);print "</td>\n";
                }
            }
            print "</tr>\n";
        } // end foreach;
        print "</table>\n";

        return $ret;
    } // end showUpgradeInfo()

    // {{{ repairForm()

    /**
    * Wy�wietl formularz przekierowuj�cy u�ytkownika na stron� ��czenia modyfikacji plik�w z pakietu i z dysku
    *
    * @param string $file nazwa pliku np. soteesklep3/admin/index.php
    * @return void
    */
    function _repairForm($_file) {
        $result=$this->_result;

        print "<form action=repair.php method=POST target=window>\n";
        print "      <input type=hidden name=file[name] value='".$_file."'>\n";
        print "      <input type=hidden name=file[patch_version] value='".$this->_version."'>\n";
        print "      <input type=hidden name=file[upgrade_file] value='".$result[$_file]['form']['upgrade_file']."'>\n";
        print "      <input type=hidden name=file[path] value='".$result[$_file]['form']['path']."'>\n";
        print "      <input type=hidden name=file[upgrade] value='".$result[$_file]['form']['upgrade']."'>\n";
        print "<input type=image  src=/themes/base/base_theme/_img/repair.png border=0 width=10 height=10 onclick='window.open(\"\", \"window\", \"width=800, height=600, status=no, toolbar=no, scrollbars=yes, resize=1\")'>";
        print "      </form>\n";


        return;
    } // end _repairForm()

    // }}}

    // }}}

    // {{{ legend()

    /**
    * Wy�wietl legend� status�w aktualizacji.
    */
    function legend() {
        global $theme,$lang;

        print "<br />$lang->upgrade_legend_title:<br \>";
        print "<table cellspacing=\"1\" cellpadding=\"1\">\n";
        print "<tr><td>";$theme->point("g");print "</td><td>".$lang->upgrade_legend[0]."</td></tr>\n";
        print "<tr><td>";$theme->point("b");print "</td><td>".$lang->upgrade_legend[2]."</td></tr>\n";
        print "<tr><td>";$theme->point("r");print "</td><td>".$lang->upgrade_legend[1]."</td></tr>\n";
        print "<tr><td>";$theme->point("o");print "</td><td>".$lang->upgrade_legend[3]."</td></tr>\n";
        print "<tr><td>";$theme->point("rg");print "</td><td>".$lang->upgrade_legend[4]."</td></tr>\n";
        print "<tr><td><img src=/themes/base/base_theme/_img/repair.png width=10 height=10></td><td>".$lang->upgrade_legend['repair']."</td></tr>\n";
        print "</table>\n";
        return;
    } // end legend()

    // }}} legend()

    // {{{ checkVersion()

    /**
    * Sprawd� wersj� instalowanego pakietu.
    * Sprawd� czy wersja istnieje oraz czy mo�na dany pakiet zainstalowa�. Pakiety, kt�re mo�na zainstalowa�
    * musz� by� kolejnymi numerami PATCH_LAST lub powinny mie� warto�� 0 - dla indywidualnych pakiet�w.
    * 
    * @return bool true - mo�na instalowa� dan� wersj�, false w p.w.
    */
    function checkVersion() {
        global $mdbd,$lang,$__devel;
        global $config,$_REQUEST;

        // dla wersji o numerze 0 zwracja true, po weryfikacji kodu
        if ($this->_version==0) {
            // sprawd� czy kod aktualizacji jest poprawny
            if ($this->_simulation) {
                $lic =& new License();
                $code=$lic->checkCode($this->_patch_code);
                if ($_REQUEST['upgrade_code']==$code) {
                    return true;
                } else {
                    print "<font color=\"red\">".$lang->upgrade_code_error."</font>";
                    return false;
                }
            }
            return true;
        }

        // sprawd� czy dany pakiet jest ju� zainstalowany
        $exists=$mdbd->select("id","`upgrade`","version=?",array($this->_version=>"text"),"LIMIT 1");
        // nie zezwalaj na powt�rne �adowanie pakietu, chyba �e sklep dzia�a w trybie devel
        if (($exists>0) && (! $__devel)) {
            $this->upgrade_status=1;
            print  "<font color=\"red\">$lang->upgrade_already_installed</font>\n";
            return false;
        } elseif (($__devel) && ($exists>0)) {
            // je�li pakiet ju� by� zainstalowany i panel dzia�a w trybie "devel" to zezwalaj na jego ponown� instalacj�
            return true;
        }

        // odczytaj ostatnio zainstalowany pakiet
		$max_current_version=$mdbd->select("version","`upgrade`","1",array(),"ORDER BY id DESC LIMIT 1");
        if (empty($max_current_version)) $max_current_version=$config->pkg_first_number-1;
        if ($this->_version!=$max_current_version+1) {
            // sprawd� sytuacj�: czy czasem nie ma �adnych wpis�w w bazie, je�li tak jest
            // to sprawd� w config'u jaki pakiet powinien by� instalowany jako pierwszy
            // @todo
            $any=$mdbd->select("id","`upgrade`",1,array(),"LIMIT 1");
            if (! $any) {
                // nie ma �adnych rekord�w w upgrade
                if ($this->_version==$config->pkg_first_number) {
                    return true;
                } else {
                    $this->upgrade_status=1;
                    print  "<font color=\"red\">$lang->upgrade_wrong_pkg_number</font>\n";
                    return false;
                }
            }

            $this->upgrade_status=1;
            print  "<font color=\"red\">$lang->upgrade_wrong_pkg_number</font>\n";
            return false;
        }
        // sprawd� czy instalowany pakiet mo�e by� instalowany tj. jest o 1 wi�kszy od max_current_version

        if ($this->_version==-1) {
            print ("<font color=\"red\">$lang->upgrade_wrong_format</font>\n");
            return false;
        }
        return true;
    } // end checkVersion()

    // }}}

    /**
    * Sprawd� czy mo�na zaktualizowa� plik
    * Weryfikacja czy plik nie zosta� zmieniony przez klienta i czy wersja pliku w sklepie nie jest
    * nowsza od wersji instalowanej. Dodatkowo system sprawdza, czy plik na dysku nie jest zgodny z plikiem
    * w upgrade. Je�li tak to mimo r�znych sum kontrolnych zwraca wynik pozytywny.
    *
    * @param string $file plik
    *
    * @access private
    * @return int     0 - mo�na aktualizowa� plik,
    *                 1 - plik zmieniony przez usera,
    *                 2 - nowsza wersja pliku
    *                 3 - wykryta indywidualna modyfikacja,
    *                 4 - plik zaktualizowany w poprzedniej aktualizacji (wykryto wczesniej indywidualna modyfikacje /3/)
    */
    function _upgradeTestFile($file) {
        global $DOCUMENT_ROOT;
        global $shop;

        if ($shop->home!=1) {
            $_file_root_path="$DOCUMENT_ROOT/../../$file";
        } else {
            $_file_root_path=preg_replace("/^soteesklep3/","",$file);
        }

        if (! file_exists($_file_root_path)) {
            return (0);
        }
        $_file_base_path=ereg_replace("soteesklep3",".",$file);  // �cie�ka typu ./admin/go/_edit.index.php

        // plik z systemu plikow
        $cvs =& new CVS($_file_root_path,CVS_FILE);
        $file_version_cvs=$cvs->getVersion();                    // numer wersji CVS np. 2.9
        $file_version=$cvs->idCVS2Int($file_version_cvs);        // numer wersji CVS INT np. 29

        // odczytaj sume kontrolna z systemu plikow
        $fc =& new FileChecksum($_file_root_path,FILE_CHECKSUM_FILE);
        $file_checksum=$fc->getChecksum();
        if ($fd=@fopen($_file_root_path,"r")) {
            $_file_source=fread($fd,filesize($_file_root_path));
            $file_source_from_path=trim($_file_source);
        } else $file_source_from_path='';

        // plik z upgrade
        $file_source_from_upgrade=trim($this->getFile($file));
        $cvs =& new CVS($file_source_from_upgrade,CVS_SOURCE);
        $file_version_upgr_cvs = $cvs->getVersion();
        $file_version_upgr = $cvs->idCVS2Int($file_version_upgr_cvs);

        $file_checksum_dat=$fc->getChecksumFromDAT($_file_base_path);

        // @since 3.1beta1.5
        // testujemy plik z pakietu aktualizacyjnego (nie plik le��cy na dysku)
        if (ereg("\\\@"."x",$file_source_from_upgrade)) {
            return (-1); // modyfikacja, kt�r� mo�na nadpisa� patchem bez komunikatu o sumie kontrolnej, suma w mod.md5
        }

        // sprawd� czy plik w pakiecie upgrade jest taki sam jak plik na dysku, je�li tak to zezwalaj na aktualizacj�
        if ($file_source_from_path==$file_source_from_upgrade) {
            return (0);
        }

        // zapami�taj  w przestrzeni globalnej obiektu warto�ci plik�w, z kt�rymi wyst�pi� problem
        $this->_files=array();
        $this->_files['path']=urlencode($file_source_from_path);
        $this->_files['upgrade']=urlencode($file_source_from_upgrade);


        if (empty($file_checksum_dat)) {
            return (0);               // brak sumy w pliku bazy sum
        }
        if ($file_checksum_dat!=$file_checksum) {
            // sprawdzamy czy klient nie zaktualizowal wczesniej zmodyfikowanego pliku
            // tj. czy jest odpowiedni wpis w mod.md5 i czy suma kontrolna tam zawarta
            // jest zgodna z sum� kontroln� pliku na dysku
            // (jest tak return (4) else return (1))
            if ($this->_testModFile($_file_base_path,$file_checksum)) return (4);
            else return (1);  // wykryto modyfikacj� pliku
        } else {
            // suma kontrolna si� zgadza
            return (0);
        }
        if ($file_version>$file_version_upgr) return (2);        // ma dysku jest nowsza wersja pliku

        // @since 3.1beta1.5
        // testujemy plik z dysku (np. po instalacji indywidualnej modyfikacji)
        if (ereg("\\\@"."x",$file_source_from_path)) {
            return (3); // zainstalowano indywidualna modyfikacj� wykonan� przez SOTE
        }

        return (0);
    } // end _upgradeTestFile()

    /**
    * Sprawd� czy wskazany plik by� wcze�niej zmodyfikowany i zmiany zosta�y zatwierdzone przez admina/developera
    *
    * @param string $file          �cie�ka do pliku np. ./admin/go/_order/html/edit.html.php
    * @param string $file_checksum suma kontrolna aktualnego pliku na dysku
    * @access private
    * @return bool true - plik zosta� wcze�niej zmodyfikowany i zatwierdzony, false w p.w.
    */
    function _testModFile($file,$file_checksum) {
        global $DOCUMENT_ROOT;

        $file_md5="$DOCUMENT_ROOT/../mod.md5";
        if (file_exists($file_md5)) {
            $fd=fopen($file_md5,"r");
            $data=fread($fd,filesize($file_md5));
            fclose($fd);

            $lines=split("\n",$data);
            foreach ($lines as $line) {
                $tab=split("  ",$line,2);
                if (! empty($tab[1])) {
                    if ((trim($tab[1])==$file) && (trim($tab[0])==$file_checksum)) return true;
                }
            }

        } else $data='';

        return false;
    } // end _testModFile()

    /**
    * Aktualizuj wskazany plik
    *
    * @param string $file        plik wzgl�dem $DOCUMENT_ROOT/../ np. soteesklep3/htdocs/index.php
    * @param string $file_source zawarto�� pliku, jesli warto�c nie jest domy�lnie pobierana z pakietu upgrade
    * @param int    $type        UPGRADE_FILE_SUM - zapisz dane w sum.md5, UPGRADE_FILE_MOD - nie zpisuj w sum.md5
    * @param int    $mode        0 - defult, UPGRADE_SAVE_MOD - zapisz zawarto�c pliku w bazie, nie instaluj go
    *
    * @access public
    * @return bool true upgrade OK, false w p.w.
    */
    function upgradeFile($file,$file_source='',$type=UPGRADE_FILE_SUM,$mode=0) {
        global $ftp,$DOCUMENT_ROOT,$config;
        global $shop;

        if ($this->_version<0) {
            global $_REQUEST;
            if (! empty($_REQUEST['file']['patch_version'])) {
                $this->_version=intval($_REQUEST['file']['patch_version']);
                if (! $this->_version>0) {
                    die ("Error: Wrong version number");
                }
            }
        }

        $db_data=array();
        $db_data['file']=ereg_replace("soteesklep3",".",$file);
        $db_data['date_add']=date("Y-m-d");
        $db_data['version_name']=$this->_version;
        $db_data['upgrade_file']=basename($this->upgradeFile);

        if (empty($file_source)) {
            $file_source=$this->getFile($file);             // pobierz zawarto�� wskazanego pliku z pakietu upgrade
            $this->_source=$file_source;
        }

        $file_name=basename($file);                         // odczytaj nazw� pliku
        $file_name_copy=$this->_version."-".$file_name;     // nazwa kopii pliku
        $file_dir=dirname($file);                           // katalog wzgl�dem $DOCUMENT_ROOT/../ np. soteesklep3/htdocs

        if (@$shop->home!=1) {
            $file_current=$DOCUMENT_ROOT."/../../$file_dir/$file_name";
        } else {
            // home.pl
            // rozr�nij katalogi soteesklep3/admin/include i soteesklep3/include
            // na home.pl /include wskazuje na soteesklep3/admin.include a nie na g��wny katalog
            // odwo�ania do g��wnego katalogu, przekieruj na soteesklep3/admin/htdocs/base/include
            foreach ($this->_base_dirs as $dir) {
                if (ereg("^soteesklep3/".$dir,$file_dir)) {
                    $file_dir=preg_replace("/^soteesklep3\/".$dir."/",'soteesklep3/admin/htdocs/base/'.$dir,$file_dir);
                }
            }
            $file_current=preg_replace("/^\/soteesklep3/","","/$file_dir/$file_name");
            $file_current=preg_replace("/^\/admin/","",$file_current);
        }

        $file_new="$DOCUMENT_ROOT/tmp/upgrade_$file_name";
        if (@$shop->home!=1) {
            $file_copy=$DOCUMENT_ROOT."/../../$file_dir/$file_name_copy";
        } else {
            // home.pl
            $file_copy=preg_replace("/^\/soteesklep3/","","/$file_dir/$file_name_copy");
            $file_copy=preg_replace("/^\/admin/","",$file_copy);
        }
        $this->_file_copy=$file_copy;

        // dla trybu UPGRADE_SAVE_MOD nie instaluj pliku tylko zapamietaj go w bazie
        if (! $mode) {
            // zapisz zrodla do tymczasowego pliku
            if ($fd=fopen($file_new,"w+")) {
                fwrite($fd,$file_source,strlen($file_source));
                fclose($fd);
                if ((file_exists($file_current)) && (! file_exists($file_copy))) {
                    // zrob kopie starej wersji pliku
                    $ftp->put($file_current,$config->ftp['ftp_dir']."/../$file_dir",$file_name_copy);
                }
                // aktualizuj katalogi, za�� odpowiednie katalogi, je�li nie ma ich w obecnym drzewie programu
                $this->_mkDir($file_dir);
                // aktualizuj plik
                $ftp->put($file_new,$config->ftp['ftp_dir']."/../$file_dir",$file_name);
                unlink($file_new);

                if ($type==UPGRADE_FILE_SUM) {
                    // oblicz sum� kontroln� zainstalowanego pliku  i zapami�taj j� w bazie sum kontrolnych
                    $file_dir2=preg_replace("/^soteesklep3/","",$file_dir);
                    $file_fc=".".$file_dir2."/$file_name";                  // np. ./admin/index.php
                    $file_fc_path=$DOCUMENT_ROOT."/..".$file_dir2."/$file_name";  // np. /home/sklep/soteesklep3/admin/index.php
                    $fc =& new FileChecksum($file_fc_path,FILE_CHECKSUM_FILE);
                    $file_checksum=$fc->getChecksum();
                    $fc->set($file_fc,$file_checksum);
                }
            } else return false;
        } else {
            // @todo dodac zapapietanie w bazie danych zawartosci pliku dla danej sesji.
            // ...
        }

        return true;
    } // end upgradeFile()

    /**
    * Odczytaj pe�n� scie�k� (z katalogiem sklepu) do kopii pliku (np. soteesklep3/htdocs/8-index.php)
    *
    * \@global string $this->_file_copy np. /usr/home/maroslaw/MYCVS2/soteesklep2/admin/../../soteesklep3/htdocs/8-index.php
    * @return string np. soteesklep3/htdocs/8-index.php
    */
    function getLastFileCopyName() {
        if (! empty($this->_file_copy)) {
            preg_match("/soteesklep[0-9]{1}(.*)$/",$this->_file_copy,$matches);
            if (! empty($matches[1])) {
                return ereg_replace('/admin/../../','',$matches[1]);
            }
        }
        return '';
    } // end getlastFileCopyName()

    /**
    * Za�� wskazany katalog, jesli nie ma go w systemie plik�w
    *
    * @param string $dir �cie�ka do katalogu wzgl�dem soteesklep3
    * @return bool
    */
    function _mkDir($dir) {
        global $DOCUMENT_ROOT,$ftp,$config;


        $dir=preg_replace("/^soteesklep[0-9]\//","",$dir);

        if (! is_dir("$DOCUMENT_ROOT/../".$dir)) {
            $this->_mkRecSubDir($dir);
            $ftp->mkdir($config->ftp['ftp_dir']."/".$dir);
        }
        return true;
    } // end _mkDir()

    /**
    * Za�� rekurencyjnie wskazany katalog (poza ostatnim)
    * Funkcja rekurencyjna.
    *
    * @param string $dir katalog wzgl�dem g��wnego katalogu soteesklep3
    *
    * @access private
    * @return bool true - katalog za�ozony, false - w p.w.
    */
    function _mkRecSubDir($dir) {
        global $ftp,$config,$DOCUMENT_ROOT;

        // obetnij ostatni katalog i sprawd�, czy poziom wy�ej mo��a za�o�y� podkatalog
        $last_dir=basename($dir);

        $dir2=$dir;

        $dir=substr($dir,0,strlen($dir)-strlen($last_dir)-1);
        $test_dir="$DOCUMENT_ROOT/../$dir";

        if (is_dir($test_dir)) {
            $ftp->mkdir($config->ftp['ftp_dir']."/".$dir2);
            return true;
        } else {
            if ($this->_mkdirCount<MKDIR_MAX_COUNT) {
                $this->_mkdirCount++;
                $this->_mkRecSubDir($dir);
                return;
            }
        }
    } // end _mkRecSubDir()

    /**
    * Odczytaj numer upgrade'u
    * @return int numer wersji aktualizacji
    */
    function getVersion() {
        return $this->_version;
    } // end getVersion();

    // {{{ saveModFile()

    /**
    * Zapisz w bazie danych zawarto�� po��czonego pliku.
    *
    * @param string $file_name     �cie�ka do pliku wzgl�dem soteesklepX + nazwa pliku
    * @param string $new_file      zawarto�c pliku, warto�� zapisywana w bazie
    * @param int    $patch_version numer wersji pakietu aktualizacyjnego
    *
    * @return bool
    */
    function saveModFile($file_name,$new_file,$patch_version) {
        global $sess,$db;
        global $mdbd;

        // sprawd� czy wpis ju� istnieje
        $query="SELECT id FROM upgrade_files WHERE path=? AND source=? AND session_id=? AND pkg_number=?";
        $prepared_query=$db->prepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,$file_name);
            $db->QuerySetText($prepared_query,2,$new_file);
            $db->QuerySetText($prepared_query,3,$sess->id);
            $db->QuerySetInteger($prepared_query,4,$patch_version);
            $result=$db->executeQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->numberOfRows($result);
                if ($num_rows>0) {
                    return true;
                }
            } else die ($db->error());
        } else die ($db->error());

        $query2="INSERT INTO upgrade_files (path,source,session_id,pkg_number) VALUES (?,?,?,?)";
        $prepared_query2=$db->prepareQuery($query2);
        if ($prepared_query2) {
            $db->QuerySetText($prepared_query2,1,$file_name);
            $db->QuerySetText($prepared_query2,2,$new_file);
            $db->QuerySetText($prepared_query2,3,$sess->id);
            $db->QuerySetInteger($prepared_query2,4,$patch_version);
            $result2=$db->executeQuery($prepared_query2);
            if ($result2!=0) {
                return true;
            }
        } else die ($db->error());

        return false;
    } // end saveModFile()

    // }}}

    // {{{ showReportUpgradeDB

    /**
    * Poka� raport o plikach zainstalowanych w buforze dla danej sesji
    * Funckja dla debugowania.
    *
    * @return void
    */
    function showReportUpgradeDB() {
        global $sess,$mdbd;
        $data=$mdbd->select("id,path,pkg_number","upgrade_files","session_id=?",array($sess->id=>"text"));
        print "pliki w buforze:<br />\n";
        print "<pre>";print_r($data);print "</pre>";
        return;
    } // end showReportUpgradeDB()

    // }}}

    // {{ getFileFromDB()

    /**
    * Sprawd� czy plik jest w buforze, je�li jest to odczytaj jego zawarto��
    *
    * @param string $file 
    * @return string zawarto�c pliku w buforze lub ci�g pusty (void)
    */
    function getFileFromDB($file) {
        global $mdbd,$sess;
        $source=$mdbd->select("source","upgrade_files","session_id=? AND path=?",array($sess->id=>"text",$file=>"text"),"LIMIT 1");
        if (! empty($source)) return $source;
        return;
    } // end getFileFromDB()

    // }}}


} // end class DiffUpgrade

?>
