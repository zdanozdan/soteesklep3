<?php
/**
 * PHP Template:
 * Prezentacja wiersza rekordu
 * 
 * @author piotrek@sote.pl
 * \@template_version Id: row.html.php,v 1.3 2003/02/06 11:55:15 maroslaw Exp
 * @version $Id: row.html.php,v 2.11 2005/04/01 08:35:33 maroslaw Exp $
* @package    discounts
 */

$onclick="onclick=\"window.open('','window','width=500,height=200,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
$id=$rec->data['id'];
global $lang;
global $__row_type;
global $database;
global $discounts;

// zapamietaj globalnie dane rabatow 
global $__mem_discounts_cat;
if (empty($__mem_discounts_cat)) {
    $__mem_discounts_cat=array();
}

// zapamietaj jakie kategorie byly juz wyswietlane, zmiena sluzy do zapobiezenia wielokrotnemu wysweitlaniu edycji tych 
// samych kategorii
global $__mem_show_cat;
if (empty($__mem_show_cat)) {
    $__mem_show_cat=array();
}

if (! function_exists("form_input")) {
    /**
     * Wyswietl pole input firmularza typu input
     *
     * \@global array  $__mem_form tablica zawierajaca wartosci pol formularza z rabatami, sluzy ona do rozpoznania zmian w rabatach
     * @param  string $item       nazwa tablicy pola formularza
     * @param  string $name       nazwa pola tablicy item[] -> $item[$name]
     * @param  string $value      domyslna wartosc pola
     */
    function form_input($item,$name,$value,$size=5) {
        global $__mem_form;                     
        if (empty($__mem_form)) $__mem_form=array();
        if ($value>0) {
            if (ereg(".",$value)) {
                $value=preg_replace("/[0]+$/","",$value);         // usun zera po przecinku
                // usun kropke jesli jest na koncu (moze zostac po usunieciu zer)
                if (ereg(".$",$value)) $value=preg_replace("/\.$/","",$value);
            }
        }
        print "<input type=text size=$size name=".$item."[$name] value='$value'>";
        $__mem_form[$name]=$value;
        return(0);
    }  // end form_input
    
} // end if
?>
 
<tr>

<?php

if ($__row_type!="producer") { 
    if (! empty($rec->data['idc_name'])) {           
        
        // dzielimy ciag na kawalki i zapisujemy do tablicy $split_array
        for ($i=0;$i<=5;$i++) {
            $split_array=split("/",$rec->data['idc_name'],$i);
        }

        // zapamietaj rabat dla danej kategorii
        if (! empty($rec->data['discount_cat'])) {
            $__mem_discounts_cat[$rec->data['idc']]=$rec->data['discount_cat'];
        } else $__mem_discounts_cat[$rec->data['idc']]=0;         
        
        // dla kazdego podciagu tworzymy link
        $deep_count=0;$td=$deep_count; 
        foreach ($split_array as $value) {
            $deep_count++;
            // do pliku edit.php przekazujemy id oraz deep-glebokosc kategorii 
            // np. kat1/kat2 to dla kat2 deep=2 a dla kat1 deep=1  

            // kategorie z nadanym rabatem oznacz innym kolorem
            if (@$rec->data['discount_cat']>0) {
                //$bg_color=$theme->bg_bar_color2;
                $bg_color=$theme->bg_bar_color_light; 
            } else {
                $bg_color=$theme->bg_bar_color_light;                             
            }
            print "<td bgcolor=$bg_color>";            
            /*print "<a href=edit.php?id=$id&deep=$deep_count&only_category=1 $onclick target=window>$value</a>";*/
            print $value;
            print "</td>";
            
            print "<td>";
            
            // odczytaj rabat dla wyzszej kategorii (z tablicy $__mem_discounts)
            $mem_split=split("_",$rec->data['idc'],5);$sub_idc="";
            for ($i=0;$i<$deep_count;$i++) {
                if  (! empty($mem_split[$i])) {
                    $sub_idc.=$mem_split[$i]."_";
                }
            }
            $sub_idc=substr($sub_idc,0,strlen($sub_idc)-1);
            if (@$__mem_discounts_cat[$sub_idc]>0) {
                $discounts_sub_idc=$__mem_discounts_cat[$sub_idc];        
            } else {
                // nie wywolano wczesniej kategorii z tym IDC odczytaj z bazy rabat
                $discounts_sub_idc=$discounts->get_discount($database->sql_select("discount_cat","discounts","idc=$sub_idc"));
            }

            // nie wyswietlaj juz pokazywanej kategorii do edycji na liscie 
            if (! in_array($sub_idc,$__mem_show_cat)) {
                form_input("item_dc",$id."__".$sub_idc,$discounts_sub_idc);
            }
            
            // zapamietaj ktora kategoria/podkategoria byla juz wyswietlana do edycji
            array_push($__mem_show_cat,$sub_idc);

            print "</td>";
            $td=$deep_count;
        } // end foreach

    } // end if (! empty($rec->data['idc_name']))

    // zapamietaj rabat w przegladanej kategorii
    if (@$rec->data['discount_cat']>0) {
        $__mem_discounts[$rec->data['idc']]=$rec->data['discount_cat'];
    } // end if

    if (empty($td)) $td=0;
    for ($xtd=$td*2+1;$xtd<=10;$xtd++) {
        print "<td>&nbsp; </td>";
    } // end for

} // end if ($__row_type!="producer")


if ($__row_type!="category") {
    $p_dis="";
    if (@$rec->data['discount_producer']>0) {      
        $p_dis=$rec->data['discount_producer'];
    } elseif (! empty($rec->data['discount'])) {        
        $p_dis=$rec->data['discount'];
    } elseif (! empty($rec->data['discount_cat'])) {
        $p_dis=$rec->data['discount_cat'];
    }  
    
    if (! empty($p_dis)) {
        //$bg_color=$theme->bg_bar_color2; 
        $bg_color=$theme->bg_bar_color_light; 
    } else $bg_color=$theme->bg_bar_color_light;
    print "<td bgcolor=$bg_color>";
        
    if (! empty($rec->data['producer_name'])) {         
        /*
        if ($__row_type!="producer") {
            print "<a href=edit.php?id=$id $onclick target=window><u>".$rec->data['producer_name']."</u></a>\n";
        } else {
            print "<a href=edit.php?id=$id&only_producer=1 $onclick target=window><u>".$rec->data['producer_name']."</u></a>\n";
        }
        */
        print $rec->data['producer_name'];
    } // end if (! empty())

    print "</td>\n";
    print "<td>\n";

    if ($__row_type!="producer") {
        if (! empty($rec->data['producer_name'])) {
            // jesli nie ma rabatu dla kategorii i producenta razem, to wyswietl rabat glowny dla producenta
            // o ile taki rabat jest zdefiniowany
            #if ((! $rec->data['discount']>0) && ($rec->data['discount_producer'])) {
            #    $disc_prod=$rec->data['discount_producer'];
            #} else {
            #    // nie zedefiniowano rabatu globalnego dla producenta lub rabat dla kategorii i producenta,
            #    // ktory ma wyzszy priorytet, jest > 0 
                $disc_prod=$rec->data['discount'];
            #}
            form_input("item_dcp",$id."__".@$sub_idc."+".@$rec->data['id_producer'],$disc_prod);
        }
    } else {
        if (! empty($rec->data['producer_name'])) {
            form_input("item_p",$id."__".@$rec->data['id_producer'],@$rec->data['discount_producer']);
        }
    }
    print "</td>\n";  
} // end if ($__row_type!="category")
      
// wstaw link do produktow z danej kategorii
if ($__row_type!="producer") {
    print "<td>\n";
    $idc=$rec->data['idc'];
    if (ereg("^[0-9]+$",$idc)) {
        // 1 kategoria dodaj id_$idc
        $idc="id_$idc";
    }
    print "<a href=/go/_category/?idc=$idc>$lang->discounts_idc</a>";
    print "</td>";
} else {
    // wstaw link do produktow danego producenta
    $id_producer=$rec->data['id_producer'];
    print "<td>\n";
    print "<a href=producer_categories.php?producer_filter=$id_producer>$lang->discounts_producer_products".$rec->data['producer_name']."</a>";
    print "</td>";
}

?>

<td>
    <nobr><input type=checkbox name=del[<?php print $id;?>]><?php print $lang->delete;?></nobr>  
</td>
</tr>
<?php
global $theme;
$theme->lastRow(13,'window');
?>
