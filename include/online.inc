<?php
/**
* Zarzadzanie uzytkwonikami online, sprawzdenie ilosci uzytkwonikow
*
* @author m@sote.pl
* @version $Id: online.inc,v 2.7 2004/12/20 18:02:54 maroslaw Exp $
* @package    include
*/

class Online {
    var $timeout=600;          // ilosc sekund, po ktorej uznajemy uzytkownika ze nie jest online
    
    /**
    * Odczytaj ilu uzytkownikow jest teraz online
    *
    * @public
    * @return int liczba uzytkownikow online
    */
    function check_users_online() {
        global $DOCUMENT_ROOT;
        global $config;
        global $shop;
        
        // odczytaj pliki z sesji i sprawdz ich ostatni czas dostepu
        $i=0;
        if ($shop->home!=1) {
            $dir_sess="$DOCUMENT_ROOT/../sessions/$config->salt/";
        } else {
            $dir_sess="/base/sessions/$config->salt/";
        }
        if ($handle = opendir($dir_sess)) {
            
            while (false != ($file = readdir($handle))) {
                if (ereg("^sess",$file)) {
                    $test=$this->check_file($file);
                    if ($test>0) {
                        $i++;
                    }
                }
            } // end while
            closedir($handle);
        } // end if
        
        return $i;
    } // end check_users_online()
    
    /**
    * Sprawdz uzytlwonika korzysta z danej sesji
    *
    * @param  string $file plik sesji
    * @return bool 1 - tak , 0 - nie, zbyt dlugo nie wywolal zadnej strony
    */
    function check_file($file) {
        global $DOCUMENT_ROOT;
        global $config;
        
        $file="$DOCUMENT_ROOT/../sessions/$config->salt/$file";
        if (file_exists($file)) {
            $lastvisit=fileatime($file);
            $currenttime = getdate(time());
            $currentdate = $currenttime["0"];
            $difference = $currentdate - $lastvisit;
            if ($difference<=$this->timeout) return 1;
        } // end if
        return 0;
    } // end check_file()
    
} // end class Online

$online = new ONline;

?>
