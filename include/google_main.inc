<?php
/**
* Klasa globalna z funkcjami zwi±zanymi z Google.
*
* @author  m@sote.pl
* @version $Id: google_main.inc,v 2.1 2005/08/10 09:21:12 maroslaw Exp $
* @package google
*/

/**
* Konfiguracja Google
*/
include_once ("config/auto_config/google_config.inc.php");

/**
* @package google
*/
class GoogleMain {

    /**
    * Konstruktor
    */
    function GoogleMain() {
        return true;
    } // end GoogleMain()

    /**
    * Sprawd¼ jaki agent(HTTP) po³±czy³ siê z witryn±. W zale¿no¶ci od warto¶ci, zmieñ temat.
    *
    * @return string nazwa agenta "google"|"other"|"admin"
    */
    function changeTheme() {
        global $config,$google_config;
        global $shop;

        if ($shop->admin) return "admin";

        reset ($google_config->http_user_agents);
        $config->google_active=0;
        foreach ($google_config->http_user_agents as $key=>$agent) {
            if (ereg($agent,$_SERVER['HTTP_USER_AGENT'])) {
                $config->google_active=1;
                $replace = ereg_replace("(&sess_id=[0-9a-zA-Z]*)","",$_SERVER['REQUEST_URI']);

                if (strcmp($replace, $_SERVER['REQUEST_URI']) != 0)
                {
                   //robimy redirect 301 jesli zostalo sess_id wykryte w stringu
                   header("HTTP/1.1 301 Moved Permanently");
                   header("Location: $replace");
                }
                // $config->theme="google";
                // $config->theme_dir();
                return "google";
            }
        }

        return "other";
    } // end changeTheme()

    /**
    * Generuj wpis keywords
    *
    * @return string warto¶æ keywords wg konfiguracji
    */
    function keywords() {
        global $google_config;
        $o='';reset($google_config->keywords);
        foreach ($google_config->keywords as $id=>$keyword) {
            $o.="$keyword, ";
        }
        $o=substr($o,0,strlen($o)-2);
        return $o;
    } // end keywords()


    /**
    * Generuj tytu³ strony.
    *
    * @return string 
    */
    function title() {
        global $google_config,$config;
        if (! empty($google_config->title)) {
            return $google_config->title;
        } else return $config->google['title'];
    } // end title()

    /**
    * Generuj opis strony.
    *
    * @return string 
    */
    function description() {
        global $google_config,$config;
        if (! empty($google_config->description)) {
            return $google_config->description;
        } else return $config->google['description'];
    } // end description()

    /**
    * Odczytaj ostatni katalog podany w URL w URI
    *
    * @return string
    */
    function getLastURI() {
        global $_SERVER;
        $uri=$_SERVER['REQUEST_URI'];
        if (ereg(".php\/",$uri)) {
            if (ereg("\/$",$uri)) $uri=substr($uri,0,strlen($uri)-1);
            $uri=split("/",$uri,100);
            $l=sizeof($uri);
            if (ereg("&",$uri[$l-1])) {
                $ret=$uri[$l-2];
            } else {
                $ret=$uri[$l-1];
            }
        } else {
            $ret='';
        }        
        return $ret;
    } // end getLastURI()

} // end class GoogleMain
?>