<?php
/**
* Element formularza - data
*
* Plik generuje fragment formularza do wprowadzania daty. Data sk³ada siê z trzech
* list rozwijanych (SELECT) o nazwach: date_data[numer][y] (4-cyfrowy rok),
* date_data[numer][m] (2-cyfrowy miesi±c) i date_data[numer][d] (2-cyfrowy dzieñ).
* Indeks "numer" wynosi 0, ale jest inkrementowany przy ka¿dorazowym inkludowaniu
* pliku (gdy do formularza nale¿y wpisaæ np. dwie daty, wystarczy dwukrotnie
* za³±czyæ ten plik - pierwsza data bêdzie mia³a pola o nazwach date_data[0][y],
* date_data[0][m] i date_data[0][d], a druga  date_data[1][y], date_data[1][m] i
* date_data[1][d].
*
* @author  lech@sote.pl
* @version $Id: input_date.html.php,v 1.4 2004/12/20 17:59:02 maroslaw Exp $
* @package    report
*/

if(@$date_num == '')
    $date_num = 0;

//$date_num = @$date_cnf['date_num'];

if($date_num == '')
    $date_num = 0;

    $date_data[$date_num] = $this->_correctDate(@$date_data[$date_num]);

// *************** ROK ****************
$now_year = date('Y');
$start_year = $now_year - 20;
if(@$date_data[$date_num]['y'] == '')
    $date_data[$date_num]['y'] = $now_year;

$selected = array();
$selected[$date_data[$date_num]['y']] = 'selected';
    echo "
    <select class=date name=date_data[$date_num][y] style='width: 55px;'>\n";
for ($i = $start_year; $i <= $now_year; $i++){
    echo "
        <option value=$i " . @$selected[$i] . ">$i</option>\n";
}
echo "
    </select>\n";


// *************** MIESIAC **************

$now_month = date('m');
if(@$date_data[$date_num]['m'] == '')
    $date_data[$date_num]['m'] = $now_month;
$selected = array();
$selected[$date_data[$date_num]['m']] = 'selected';
echo"
    - <select class=date name=date_data[$date_num][m] style='width: 38px;'>\n";
for ($i = 1; $i <= 12; $i++){
    $i_s = sprintf("%02d", $i);
    echo "
        <option value='$i_s' " . @$selected[$i_s] . ">$i_s</option>\n";
}
echo "
    </select>\n";


// *************** DZIEN **************
if(@$no_day != 1){
    $now_day = date('d');
    if(@$date_data[$date_num]['d'] == '')
        $date_data[$date_num]['d'] = $now_day;
    $selected = array();
    $selected[$date_data[$date_num]['d']] = 'selected';
    
    echo"
        - <select class=date name=date_data[$date_num][d] style='width: 38px;'>\n";
    for ($i = 1; $i <= 31; $i++){
        $i_s = sprintf("%02d", $i);
        echo "
            <option value='$i_s' " . @$selected[$i_s] . ">$i_s</option>\n";
    }
    echo "
        </select>\n";
}

$date_num++;


?>
