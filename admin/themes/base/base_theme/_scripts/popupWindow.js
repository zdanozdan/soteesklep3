<!-- Begin
/**
* Funkcja [popupWindow]
*
* @desc funkcja wywolujaca nowe okienko z zawartoscia
* @author rp@fraxinus.pl

* @param string url    nazwa wyswietlanego pliku
* @param int    width  szerokosc generowanego okienka
* @param int    height wysokosc generowanego okienka
* @param int    y      polozenie okienka wzgledem osi y
* @param int    x      polozenie okienka wzgledem osi x
*
* @example <A href="javascript:popup('contact.html','490','340','20','20','1')" onMouseOver="window.status=' '; return true;">Open Window</a>
*
* @return void
*/

var scrollbars=0;
var resizable=0;
var menubar="no";
var scrolling="no";
var status="no";
var directories="no";
var toolbar="no";
var locationBar="no";
var popupName="Popup";
var _win;

function popup(url, width, height, y, x, scrollbars) {

    _win=window.open(url,popupName,'width=' + width + ',height=' + height + ',top=' +y+ ',left=' +x+ ',resizable=' +resizable+ ',scrollbars=' +scrollbars+ ',menubar=' +menubar+ ',scrolling=' +scrolling+ ',status=' +status+ ',directories=' +directories+ ',toolbar=' +toolbar+ ',location=' +locationBar); 
    _win.focus();
    return;
}

// End -->
