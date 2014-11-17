<?php
/**
* Klasa porownujaca dwie bazy danych i tworzaca plik roznicowy
*
* @author  r@sote.pl
* @version $Id: table_compare.inc.php,v 1.10 2004/08/04 14:34:30 maroslaw Exp $
* @package soteesklep
*/

class Tablecompare {
    
    var $changes='';		// zmiany w postaci tablicy
    var $_drop='';
    var $fields=array();			// dodatkowe indywidulane pola
    
    /**
     * Konstruktor obiektu
     *
     * @return array roznica pomiedzy tablicami
     */
    function tablecompare($drop) {
        $this->_drop=$drop;
        return true;
    } // end Tablecompare
    
    /**
    * Funkcja wraca pola tablicy main ktore sa w starej tablicy
    *
    * @return array roznica pomiedzy tablicami
    */
    function getFields() {
    	return $this->fields;
    }

    /**
    * Funkcja glowna porownania dwoch baz danych
    *
    * @return array roznica pomiedzy tablicami
    */
    function dbDiff(&$db_old, &$db_new) {
        $changes=array();
        //print "<pre>";print_r($db_old);print "</pre>";print "<pre>";print_r($db_new);print "</pre>";
        foreach($db_old as $key=>$value_old) {
            // nazwa tablicy
            $name=$key;
            if(!empty($db_new[$name])) {
                $value_new = $db_new[$name];
                array_push($changes,$this->TablesDiff($name,$value_old,$value_new));
            } else {
                if($this->_drop) {
                    array_push($changes,"DROP TABLE $name;\n\n");
                }
            }
        }
        foreach($db_new as $key=>$value) {
            $name = $key;
            if(empty($db_old[$name])) {
                array_push($changes,$db_new[$name]['def']."\n");
            }
        }
        $this->saveDiff($changes);
        return $this->changes;
    } // end DbDiff
    
    /**
    * Funkcja zamienia tablice roznicowa w string
    * Funkcja jest wywolywana rekurencyjnie
    *
    * @return array roznica pomiedzy tablicami
    */
    function saveDiff(&$changes) {
        foreach($changes as $key=>$value) {
            if(is_array($value)) {
                $this->SaveDiff($value);
            } else {
                if($value != 1) {
                    $this->changes.=$value;
                }
            }
        }
        return true;
    } // end SaveDiff
    
    /**
    * Funkcja wywoluje prownania tabel
    *
    * @return array roznica pomiedzy tablicami
    */
    function tablesDiff($name,&$value_old, &$value_new) {
        $changes=array();
        array_push($changes,$this->FieldsDiff($name,$value_old, $value_new));
        array_push($changes,$this->IndicesDiff($name,$value_old, $value_new));
        array_push($changes,$this->FullTextDiff($name,$value_old, $value_new));
        array_push($changes,$this->PrimaryKeyDiff($name,$value_old, $value_new));
        array_push($changes,$this->OptionsDiff($name,$value_old, $value_new));
        return $changes;
    } // end TablesDiff
    
    /**
    * Funkcja porownuje pola w tabeleach i generuje roznice
    * w postaci alterow
    *    
    * @return array roznica pomiedzy tablicami
    */
    function fieldsDiff($name,&$value_old, &$value_new) {
        $fields1 = $value_old['fields'];
        $fields2 = $value_new['fields'];
        $changes = array();
        foreach ($fields1 as $key=>$value) {
            $f1 = $fields1[$key];
            if(!empty($fields2[$key])) {
                $f2=$fields2[$key];
                if ($f1 != $f2) {
                    if (!ereg("$f2\(\d+,\d+\)",$f1) && ($f1 != "$f2 DEFAULT '' NOT NULL")  &&($f1 != "$f2 NOT NULL")) {
                        $change = "ALTER TABLE $name CHANGE COLUMN $key $key $f2;";
                        $change .= "\n";
                        array_push($changes,$change);
                    }
                }
            } else {
                if ($this->_drop) {
                    $change = "ALTER TABLE $name DROP COLUMN $key;\n";
                    array_push($changes,$change);
                } else {
                	// dopisz indywidulane pola tablicy do configa
					if($name == 'main')	array_push($this->fields, $key);      	
                }  
            }
        }
        foreach($fields2 as $key=>$value) {
            if (empty($fields1[$key])) {
                $change = "ALTER TABLE $name ADD COLUMN $key ".$fields2[$key].";\n";
                array_push($changes,$change);
            }
        }
        return $changes;
    } // end FieldsDiff
    
    /**
    * Funkcja indeksy w tablicach i generuje roznice
    * w postaci alterow
    *
    * @return array roznica pomiedzy tablicami
    */
    function indicesDiff($name,&$value_old, &$value_new) {
        $indices1 = $value_old['indices'];
        $indices2 = $value_new['indices'];
        $changes = array();
        foreach($indices1 as $index=>$value) {
            //$old_type = $value_old['unique_index'][$index] ? 'UNIQUE' : 'INDEX';
            if (!empty($indices2[$index])) {
                if (($indices1[$index] != $indices2[$index]) or
                ($value_old['unique_index'][$index] xor $value_new['unique_index'][$index])) {
                    
                    $new_type = $value_new['unique_index'][$index] ? 'UNIQUE' : 'INDEX';
                    $change = "ALTER TABLE $name DROP INDEX $index;\n";
                    $change .= "ALTER TABLE $name ADD $new_type $index ($indices2[$index]);\n";
                    array_push($changes, $change);
                }
            } else {
                $auto = $this->CheckForAutoCol($value_old, $indices1[$index]);
                $change = $auto ? $this->IndexAutoCol($name,$table1,$indices1{$index}) : '';
                $change .= "ALTER TABLE $name DROP INDEX $index;\n";
                array_push($changes, $change);
            }
        }
        foreach ($indices2 as $index=>$value) {
            if (empty($indices1[$index])) {
                $new_type = $value_new['unique_index'][$index] ? 'UNIQUE' : 'INDEX';
                $change="ALTER TABLE $name ADD $new_type $index ($indices2[$index]);\n";
                array_push($changes,$change);
            }
        }
        return $changes;
    } // end IndecesDiff
    
    
    /**
    * Funkcja sprawdza pelnoteksotwe indeksy w tablicach i generuje roznice
    * w postaci alterow
    *
    * @return array roznica pomiedzy pelnoteksotwymi indexami
    */
    function fullTextDiff($name,&$value_old, &$value_new) {
        $fulltext1 = $value_old['fulltext'];
        $fulltext2 = $value_new['fulltext'];
        $changes = array();
        foreach($fulltext1 as $index=>$value) {
            // jesli w drugiej tablicy ten index instanie
            if (!empty($fulltext2[$index])) {
                if (($fulltext1[$index] != $fulltext2[$index]) or
                ($value_old['fulltext'][$index] xor $value_new['fulltext'][$index])) {
                    $new_type = "FULLTEXT";
                    $change = "ALTER TABLE $name DROP INDEX $index;\n";
                    $change .= "ALTER TABLE $name ADD $new_type $index ($fulltext2[$index]);\n";
                    array_push($changes, $change);
                }
            } else {
                $change .= "ALTER TABLE $name DROP INDEX $index;\n";
                array_push($changes, $change);
            }
        }
        foreach($fulltext2 as $index=>$value) {
            // jesli w starej tablicy ten index nie istnieje
            if (empty($fulltext1[$index])) {
                $new_type = "FULLTEXT";
                $change="ALTER TABLE $name ADD $new_type $index ($fulltext2[$index]);\n";
                array_push($changes,$change);
            }
        }
        return $changes;
    } // end FullTextDiff
    
    /**
    * Funkcja porownuje klucze glowne i generuje roznice
    * w postaci alterow
    *
    * @return array roznica pomiedzy kluczami
    */
    function primaryKeyDiff($name,&$value_old, &$value_new) {
        $primary1 = @$value_old['primary_key'];
        $primary2 = @$value_new['primary_key'];
        if(empty($primary1) || empty($primary2)) {
            return true;
        }
        $changes = array();
        if ($primary1 && !$primary2) {
            $change .= "ALTER TABLE $name DROP PRIMARY KEY;";
            return ("$change\n");
        }
        if (!$primary1 && $primary2) {
            return ("ALTER TABLE $name ADD PRIMARY KEY $primary2;\n");
        }
        if ($primary1 != $primary2) {
            $auto = $this->CheckForAutoCol($value_old, $primary1);
            $change = $auto ? $this->IndexAutoCol($name,$value_new, $auto) : '';
            $change .= "ALTER TABLE $name DROP PRIMARY KEY;";
            $change .= "ALTER TABLE $name ADD PRIMARY KEY $primary2;";
            $change .= "ALTER TABLE $name DROP INDEX $auto;";
            array_push($changes, $change);
        }
        return $changes;
    } // end PrimaryKeyDiff
    
    /**
    * Funkcja sprawdza czy kolumna nie jest  auto_increment i generuje roznice
    * w postaci alterow
    *
    * @return array roznica pomiedzy kluczami
    */
    function CheckForAutoCol(&$value_old, &$fields) {
        preg_match ("/\s*\((.*)\)\s*/",$fields,$keys);
        if(!empty($keys[1])) {
            $fields=$keys[1];
        }
        $fields1 = split("/\s*,\s*/", $fields);
        $changes = '';
        foreach ($fields1 as $value) {
            $temp=$value_old['fields'][$value];
            if(ereg("auto_increment",$temp) && empty($value_old['indices'][$value])) {
                return $value;
            }
        }
        return false;
    } // end CheckForAutoCol
    
    /**
    * Funkcja porownuje opcje ( typ tabeli ) i generuje roznice
    * w postaci alterow
    *
    * @return array roznica pomiedzy opcjami
    */
    function optionsDiff($name,&$value_old, &$value_new) {
        $options1 = $value_old['options'];
        $options2 = $value_new['options'];
        $changes = array();
        if ($options1 != $options2) {
            $change = "ALTER TABLE $name $options2;\n";
            array_push($changes, $change);
        }
        return $changes;
    } // end OptionsDiff
    
    /**
    * Funkcja dodaje index na kolumy auto_increment
    *
    * @return string polecenie sql
    */
    function indexAutoCol(&$name,&$value_old, &$fields) {
        return "ALTER TABLE $name ADD INDEX ($fields);\n";
    } // end IndexAutoCol
}    
?>