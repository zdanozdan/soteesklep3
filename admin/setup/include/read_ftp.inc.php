<?php
/**
* Odczytaj liste katalogow konta FTP, wskazanie katalogu instalacji sklepu
*
* @author  m@sote.pl
* @version $Id: read_ftp.inc.php,v 2.6 2004/12/20 18:01:17 maroslaw Exp $
*
* \@verified 2004-03-16 m@sote.pl
* @package    setup
*/

class FTPClient {
    
    var $max_ftp_depth=2;                       // maksymalna liczba zagniedzen katalogow w poszukiwaniu instlacji sklepu
    var $deny_dir=array("src","devel","mail");  // list katalogow FTP, ktore nie beda sprawdzane w poszukiwaniu instalacji sklepu
    var $checked="checked";
    var $found=false;                           // informacja czy znaleziono jakis pasujacy do instalacji sklepu katalog
    
    /**
    * Polacz sie z serwerem FTP.
    *
    * Je¶li funkcja nie zakoñczy siê sukcesesm, spowoduje zakoñcznie dzia³ania programu.
    *
    * @param string $server          serwer FTP
    * @param string $user            login konta FTP
    * @param string $password        haslo do konta FTP
    * \@global unknown $this->conn_id uchwyt polaczenia FTP
    * @return bool  true udalo sie nawiazac polaczeni
    */
    function connect($server,$user,$password) {
        global $error;
        
        $this->conn_id = @ftp_connect($server);
        $login_result  = @ftp_login($this->conn_id,$user,$password);
        
        if (! $this->conn_id)  die($error->ftp_error_conn);
        if (! $login_result)   die($error->ftp_error_login);
        
        // odczytaj sciezke do katalogu domowego uzytkownika
        $this->home_dir=ftp_pwd($this->conn_id);
        
        return true;
    } // end connect()
    
    /**
    * Sprawd¼ czy plik na koncie ftp jest katalogiem
    *
    * @param  string $file testowany plik
    * @return bool   true - wskazany plik jest katalogiem, false - nie jest katalogiem
    */
    function is_dir($file) {
        if (ereg("^drwx",$file)) {
            return true;
        }
        return false;
    } // end is_dir()
    
    /**
    * Sprawdz, czy w wybranym katalogu jest sklep. Sprawdz katalog htdocs/go
    *
    * @param string $dir katalog
    * @return bool true we wskazanym katalogu jest sklep
    */
    function is_soteesklep($dir) {
        $list=array();
        $list=ftp_nlist($this->conn_id,$dir."/htdocs/go");
        if (! empty($list))
        return true;
        return false;
    } // end is_soteesklep()
    
    /**
    * Wyswietl ikonke katalogu + link
    *
    * @param string $dir katalog
    * @return none
    */
    function show_ftp_dir($dir) {
        print "<img src=./html/_img/folder_open.png>&nbsp;\n";
        print "\t <input type=radio name=ftp_dir value='$dir' checked> \n";
        print "\t<a href=?><u> $dir </u></a><BR>\n";
        $this->found=true;
        return;
    } // end show_ftp_dir()
    
    /**
    * Wstaw pole formularza do wprowadzenie innego katalogu FTP
    */
    function input_ftp_dir() {
        global $lang;
        print "<img src=./html/_img/folder.png> ";
        if ($this->found==true) {
            print $lang->setup_ftp_dir2;
        } else {
            print $lang->setup_ftp_dir2_not_found;
        }
        print " <input type=text size=30 name=ftp_dir2>\n";
        return;
    } // end input_ftp_dir()
    
    /**
    * Wyszukaj instlacji sklepu w katalogu, wyswietl liste katalgow do wyboru. Funkcja rekurencyjna.
    *
    * @param string $dir przeszukiwany katalog
    * @depth int poziom zagnie¿d¿enia podkatalogów wzglêdem g³ównego katalogu konta
    *
    * @return none
    */
    function explore($dir='',$depth=1) {
        global $error;
        global $DOCUMENT_ROOT;
        
        // ustaw odpowiednio katalog programu z pominieciem katalogu domowego
        $http_DR=preg_replace("/\/admin$/","",$DOCUMENT_ROOT);
        $http_DR=ereg_replace($this->home_dir,"",$http_DR);
        
        // odczytaj liste katalogow
        if (empty($dir)) {
            $dir=ftp_pwd($this->conn_id);
            if ($dir="/") $dir="";
        }
        $list=array();
        $list=ftp_rawlist($this->conn_id, "$dir");      // lista nazw plikow z pelnymi sciezkami
        
        $i=1;
        if (! empty($list)) {
            foreach ($list as $file) {
                $file_line=preg_split("/[\s]+/",$file);
                $basename=@$file_line[8];
                if (! in_array($basename,$this->deny_dir)) {
                    if ((ereg("soteesklep3$",$file))  || (ereg("public_html$",$file))) {
                        if (($this->is_dir($file)) && ($this->is_soteesklep("$dir/$basename"))) {
                            // porownaj wyszukany katalog z ustawieniem "DOCUMENT_ROOT" i ustaw domylsnie
                            // odpowieni katalog jako zaznaczony
                            // odczytaj dir from home
                            $dirfh=ereg_replace($this->home_dir,"",$dir);
                            if (ereg("$dirfh/$basename$",$http_DR)) {
                                if (empty($this->checked)) {
                                    $this->checked="checked";
                                    print "<img src=./html/_img/folder_open.png>\n";
                                } else  print "<img src=./html/_img/folder.png>&nbsp;\n";
                            } else {
                                print "<img src=./html/_img/folder.png>&nbsp;\n";
                            }
                            print "\t<input type=radio name=ftp_dir value='$dir/$basename' $this->checked>\n";
                            print "\t<a href=?><u> $dir/$basename </u></a><BR>\n";
                            $this->found=true;
                        }
                    } else {
                        if ($this->is_dir($file)) {
                            if ($depth<=$this->max_ftp_depth) {
                                $new_depth=$depth+1;
                                $this->explore("$dir/$basename",$new_depth);
                            }
                        }
                    } // end if
                } // end if (! in_array($this->deny_dir,$basename))
                $i++;
            } // end foreach
        } // end if (! empty($list))
        
        return;
    } // end ftp_explore()
    
    /**
    * Sprawd¼ katalog FTP klienta, postaraj sie dopasowac katalog na podstawie DOCUMENT_ROOT.
    *
    * Wywo³aj wyszukiwanie katalogów, które mog± byæ katalogami zawieraj±cymi instalowan± aplikacjê.
    *
    * @return bool true je¶li znaleziono pasuj±cy katalo 
    */
    function print_ftp_dir() {
        global $DOCUMENT_ROOT;
        
        // ustaw odpowiednio katalog programu z pominieciem katalogu domowego
        $http_DR1=preg_replace("/\/admin$/","",$DOCUMENT_ROOT);
        if ($this->home_dir!="/") {
            $http_DR2=ereg_replace($this->home_dir,"",$http_DR1);
        } else {
            $http_DR2=$http_DR1;
        }
        
        // odczytaj zawartosc katalogu domowego
        $list_home=ftp_nlist($this->conn_id,$this->home_dir);
        // odczytaj zawartosc katalogu /
        $list_root=ftp_nlist($this->conn_id,"/");
        // jesli $list_root jest takie jak $list_home, to oznacza to ze / jest katalogiem domowym uzytkownika
        // na serwerze jest zainstalowane ograniczone srodowisko FTP, nie mozna wyjsc poza katalog domowy, ktory jest widziany jako /
        if ($list_home==$list_root) {
            if (! $this->is_soteesklep($http_DR2)) {
                $this->explore();
                $this->input_ftp_dir();
                return;
            } else {
                $this->show_ftp_dir($http_DR2);  // wyswietl ikonke + info
                return true;
            }
        } else {
            if (! $this->is_soteesklep($http_DR1)) {
                $this->explore();
                $this->input_ftp_dir();
                return;
            } else {
                $this->show_ftp_dir($http_DR1);  // jw.
                return true;
            }
        } // end if ($list_home==$list_root)
    } // end get_ftp_dir()
    
    /**
    * Zamknij polaczenie FTP
    *
    * @return bool true - uda³o siê zamkn±æ po³±czenie FTP, false w p.w.
    */
    function quit() {
        if (ftp_quit(@$this->conn_id)) return true;
        return false;
    } // end quit()
    
} // end class FTPClient
?>
