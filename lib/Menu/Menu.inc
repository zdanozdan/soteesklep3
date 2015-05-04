<?php
/**
 * Klasa pozwalajaca na budowanie wielopozioowych MENU.
 * Klasa ta jest wzorowana na projekcie Nested Menu (www.phpclasses.org)
 *
 * @author m@sote.pl & author of Nested Menu
 * @version $Id: Menu.inc,v 1.1 2007/03/20 13:38:39 tomasz Exp $
 * @package soteesklep
 */

class Menu {
    var $name="";            // nazwa aktualnego menu
    var $id="";              // id aktualnego menu
    var $items  = array();   // arary([nr](['id']['name'|'object']['url']))
    var $open   = "(-)";     // wstaw przed otwarte submenu                      // old
    var $closed = "(+)";     // wstaw przed zamkniete submenu                    // old
    var $empty  = "<td></td>";        // wciecie przed elementem z linkiem
    var $indent = "<td></td>";        // wciecie przed elementem menu
    var $param  = "idc";     // parametr przekazujacy id wybranej kategorii (open)
    var $cparam = "cidc";    // parametr przekazujacy id wybranej kategorii (close)
    var $url="";             // prefix url wywolywany w linkach
    var $current_root_id=-1; // id aktualnie wybranej glownej kategorii

    // elementy zwiazane z treeview
    var $treeview_ftv2vertline    = "/lib/Treeview/ftv2vertline.gif";
    var $treeview_ftv2node        = "/lib/Treeview/ftv2node.gif";
    var $treeview_ftv2lastnode    = "/lib/Treeview/ftv2lastnode.gif";
    var $treeview_ftv2blank       = "/lib/Treeview/ftv2blank.gif";
    var $treeview_ftv2mnode       = "/lib/Treeview/ftv2mnode.gif";
    var $treeview_ftv2pnode       = "/lib/Treeview/ftv2pnode.gif";
    var $treeview_ftv2mlastnode   = "/lib/Treeview/ftv2mlastnode.gif";
    var $treeview_ftv2plastnode   = "/lib/Treeview/ftv2plastnode.gif";

    // folder
    var $treeview_ftv2folderopen  = "/lib/Treeview/ftv2folderopen.gif";
    var $treeview_ftv2folderclose = "/lib/Treeview/ftv2folderclosed.gif";
    var $folder_open="";
    var $folder_close="";

    var $last_element=false; // czy menu jest ostatnim elementem
    var $last_mem=array();   // tablica z informacja czy kolejne elementy menu byly ostatnimi elementami na swoim poziomie [true|false]
    var $table_start="<table cellspacing=0 cellpadding=0 border=0>";
    // end

    /**
     * Wywolaj Menu
     *
     * @param string $id   id menu
     * @param string $name nazwa menu
     * @param string $url  url na ktory bedzie wskazywac nazwa
     */
    function menu($id,$name,$url="",$icons=0) {
        global $config;
        $this->id=$id;
        $this->name=$name;
        $this->url=$config->url_prefix.$url;

        // ustawienia ikonek w menu
        $this->treeview_ftv2mlastnode_bg=$this->treeview_ftv2mlastnode;
        $this->treeview_ftv2plastnode_bg=$this->treeview_ftv2plastnode;
        $this->treeview_ftv2vertline_bg=$this->treeview_ftv2vertline;
        if ($icons!=0) $this->set_icons();

        $this->set_html();

        return(0);
    } //end menu()

    /**
     * Ustaw pokazywanie ikonek(folderow) przy rozgalezeiniach menu
     */
    function set_icons() {
        global $config;

        $this->folder_open="<img src=".$config->url_prefix."$this->treeview_ftv2folderopen align=middle>";
        $this->folder_close="<img src=".$config->url_prefix."$this->treeview_ftv2folderclose align=middle>";
        return(0);
    } // end set_icons()

    /**
     * Generuj elementy HTML zwiazane z otwarciem kategorii itp.
     */
    function set_html() {
        global $config;

        // podstaw obrazki zgodne z Treeview
        if ($this->last_element!=true) {
            $this->open   = "<td valign=top background=$this->treeview_ftv2vertline_bg><img src=".$config->url_prefix."$this->treeview_ftv2mnode align=top></td>";
            $this->closed = "<td valign=top background=$this->treeview_ftv2vertline_bg><img src=".$config->url_prefix."$this->treeview_ftv2pnode align=top></td>";
        } else {
            $this->open   = "<td><img src=".$config->url_prefix."$this->treeview_ftv2mlastnode_bg align=top></td>";
            $this->closed = "<td><img src=".$config->url_prefix."$this->treeview_ftv2plastnode_bg align=top></td>";
        }
        return(0);
    } // end set_html()

    /**
     * Dodaj element Menu
     */
    function add(&$id,$name="",$url="",$level=1) {
        $n = count ($this->items); // kolejny numer elementu tablicy, ciekawa metoda:)

        if (is_object($id)) {
            $this->items[$n]=$id;
        } else {
            $this->items[$n]['id']=$id;
            $this->items[$n]['name']=$name;
            $this->items[$n]['url']=$url;
            $this->items[$n]['level']=$level;
        }
    } // end add()

    /**
     * Wyswietl menu (submenu)
     *
     * @param int   $nest     zaglebienie, poziom podkategorii
     * @param bool  $last     czy element jest ostatnim elementem poziomu kategorii
     * @param-> array $last_mem tablica z informacja o tym czy dana kategoria jest osttnia na swoim poziomie
     */
    function show($nest = 0,$last=false,$last_mem=array())  {
        global $HTTP_SERVER_VARS;
        global $_SESSION;
        global $_REQUEST;
        global $config;

        // inicjuj glowna tabele pamieci zamkniecia kategorii, chodzi o wstawienie
        // kreski lub pustego pola dla glownej kategorii
        if ($nest==0) {
            if ($last==true) $last_mem[0]=true;
            else $last_mem[0]=false;
        }

        // ustal prefix url
        if (empty($this->url)) {
            $this->url=$HTTP_SERVER_VARS['PHP_SELF'];
        }

        // ustaw wciecie przed wyswietleniem elementu menu
        $indent="";
        if ($nest>0) {
            for ($i_nest=0;$i_nest<$nest;$i_nest++) {
                $last_m=my(@$last_mem[$i_nest]);
                if ($last_m==true) {
                    $indent.="<td valign=top><img src=".$config->url_prefix."$this->treeview_ftv2blank valign=top></td>";
                } else {
                    $indent.="<td valign=top background=$this->treeview_ftv2vertline><img src=".$config->url_prefix."$this->treeview_ftv2vertline valign=top></td>";
                }
            } // end foreach
        }

        // utworz zmienna np. idc_4, idc-> $this->param; 4-> id kategorii
        $param_name=$this->param."_".$this->id;

        // #1452
        global $$param_name;
        // end #1452
        
        // odczytaj, czy wczesniej wywolano ta kategorie
        if (! empty($_SESSION[$param_name])) {
            $param_val=$_SESSION[$param_name];
        } else $param_val="";

        // jesli zostala wybrana kategoria, to zapisz to w sesji
        // pod wygenerowana wyzej nazwa zmiennej
        if ((! empty($_REQUEST[$this->param])) && ($_REQUEST[$this->param]==$this->id)) {
            $$param_name="registered";
            $GLOBALS[$param_name]=$$param_name;
             
            // #1452 2005-05-23 m@sote.pl poprawka zamykania siê kategorii dla neiktórych instalacji
            global $sess;
            $param_val=$$param_name;
	    //TZ
	    $_SESSION[$param_name]=$param_val;
            //$sess->register($param_name,$param_val);
            // session_register($param_name);            
            // end #1452
            //session_register($param_name);                        
        }

        // jesli zostala wybrana kategoria do zamkniecia, to wykasuj informajce
        // o tej kategorii z sesji
        if ((! empty($_REQUEST[$this->cparam]))  && ($_REQUEST[$this->cparam]==$this->id)) {
            // zamknij kategorie, jesli kategoria, nie jest kategoria 1 poziomu
            if (! ereg("^id_",$_REQUEST[$this->cparam])) {
                $$param_name="";
                $GLOBALS[$param_name]=$$param_name;
		//TZ
		unset($_SESSION[$param_name]);
                //session_unregister($param_name);
                $param_val="";
            }
        }

        if (empty($$param_name)) {
            $$param_name="";
        }

        // TZ 11/10/2007
        // odczytaj wybrana kategorie uzytkownika
        if (! empty($_REQUEST['idc'])) {
           $get_idc=$_REQUEST['idc'];
        }
        if ((empty($_REQUEST['idc'])) && (! empty($_REQUEST['cidc']))) {
           $get_idc=$_REQUEST['cidc'];
        }

        // TZ 11/10/2007
        global $rec;
        $rec_id = $rec->data['id'];
        
        if ($rec_id > 0)
        {
           if ($rec->data['id_category1'] > 0)
           {
              $idc = $rec->data['id_category1'];
              if ($rec->data['id_category2'] > 0)
              {
                 $idc = $idc . "_" . $rec->data['id_category2'];
                 if ($rec->data['id_category3'] > 0)
                 {
                    $idc = $idc . "_" . $rec->data['id_category3'];;
                    if ($rec->data['id_category4'] > 0)
                    {
                       $idc = $idc . "_" . $rec->data['id_category4'];
                       if ($rec->data['id_category4'] > 0)
                       {
                          $idc = $idc . "_" . $rec->data['id_category5'];
                       }
                    }
                 }
              }                 
           }                                       
        }

        // podejmij decyzje czy otworzyc menu/podmenu dla danej kategorii
        $root_id=ereg_replace("id_","",$this->id);
        if ((($param_val=="registered") || ($$param_name=="registered")) && (($nest>0) || (($nest==0) && ($root_id==$this->current_root_id)))) {

            $litems=sizeof($this->items); // ilosc elementow na danym poziomie kategorii
            $this->last_element=$last;$this->set_html();

            ereg("([0-9]+)$",$param_name, $match);
            ereg("([0-9]+)$",$this->id, $match_1);
            if (stristr($get_idc, $match[0]) || stristr($idc, $match_1[0]))
            {
               print $this->table_start."<tr>".$indent.$this->open.
               " <td>$this->folder_open<div id=\"active_category_final\"><a href=/$this->cparam$this->url>$this->name</a></div></td></tr></table>\n";
            }
            else
            {
               print $this->table_start."<tr>".$indent.$this->open.
               " <td>$this->folder_open<div id=\"active_category\"><a href=/$this->cparam$this->url>$this->name</a></div></td></tr></table>\n";
            }
             
            // wyswietl elementy menu
            // odczytaj ilosc elementow menu
            $i=1;reset($this->items);
            while (list(,$item) = each ($this->items)) {
                if ($i==$litems) {
                    $this->last_element=true;
                    array_push($last_mem,true);
                } else {
                    $this->last_element=false;
                    array_push($last_mem,false);
                }

                // debug
                // $o="";
                // foreach ($last_mem as $x) {
                //     if ($x==true) {
                //         $o.="1";
                //     } else $o="0";
                // }
                // print $o;
                // end debug

                if (is_object($item)) {
                    // drzewo
                    $item->show($nest+1,$this->last_element,$last_mem);
                } else {

                    // lisc
                    $id=$item['id'];
                    $name=$item['name'];
                    $url=$item['url'];

                    print $this->table_start;
                    print "<tr>";
                    print $indent;

                    if ($this->last_element!=true){
                        if ($i<$litems) {
                            print "<td valign=top ";
                            if ($last!=true) print "background=$this->treeview_ftv2vertline";
                            print ">";
                        } else{
                            print "<td valign=top>";
                        }
                        print "<img src=".$config->url_prefix."$this->treeview_ftv2blank align=top>";
                        print "</td><td valign=top>";
                    } else {
                        print "<td valign=top ";
                        if ($last!=true) print "background=$this->treeview_ftv2vertline";
                        print ">";
                        print "<img src=".$config->url_prefix."$this->treeview_ftv2blank align=top>";
                        print "</td><td>";
                    }

                    if ($i<$litems) {
                        print "<img src=".$config->url_prefix."$this->treeview_ftv2node align=top>";
                    } else {
                        // ostatni element menu
                        print "<img src=".$config->url_prefix."$this->treeview_ftv2lastnode align=top>";
                    }
                    print "</td>";
                                       
                    if ($get_idc == $id || $idc == $id)
                       print "<td valign=top><div id=\"active_category_final\"><a href=$config->url_prefix"."$url>$name</a></div></td></tr></table>\n";
                    else
                       print "<td valign=top><a href=$config->url_prefix"."$url>$name</a></td></tr></table>\n";

                    // TZ 11/10/2007
                }
                $i++;
            } // end while
        } else {
            // nie wybrano zadnego elementu, wyswietl glowny(e) element(y) menu
            $litems=sizeof($this->items); // ilosc elementow na danym poziomie kategorii
            $this->last_element=$last; $this->set_html();

            // nowe podmenu zamkniete

            if ($get_idc == $this->id)
            {
               print $this->table_start."<tr>".$indent.$this->closed.
               "<td>$this->folder_close<div id=\"active_category_closed\"><a href=/$this->param$this->url>$this->name</a></div></td></tr></table>\n";
            }
            else
            {
               print $this->table_start."<tr>".$indent.$this->closed.
               "<td>$this->folder_close<a href=/$this->param$this->url>$this->name</a></td></tr></table>\n";
            }
        }

        return;
    } // end show()
} // end class Menu

?>