<?
if(!defined("METABASE_MYSQL_INCLUDED"))
{
    define("METABASE_MYSQL_INCLUDED",1);

    /*
    * metabase_mysql.php
    *
    * @(#) $Header: /usr/local/CVS/soteesklep2/lib/Metabase/metabase_mysql.php,v 2.7 2005/01/28 15:28:25 maroslaw Exp $
    *
    */

    class metabase_mysql_class extends metabase_database_class
    {
        var $connection=0;
        var $connected_host;
        var $connected_user;
        var $connected_password;
        var $connected_port;
        var $opened_persistent="";
        var $decimal_factor=1.0;
        var $highest_fetched_row=array();
        var $columns=array();
        var $fixed_float=0;
        var $escape_quotes="\\";
        var $demo="no";     // demo=yes zonacza, ze system zezwala tylko na wykonywania zapytan SELECT
        var $_soteSetMod=1; // 1 dodaj opcje modyfikowania SQL multi_shop

        Function Connect()
        {
            $port=(IsSet($this->options["Port"]) ? $this->options["Port"] : "");
            if($this->connection!=0)
            {
                if(!strcmp($this->connected_host,$this->host)
                && !strcmp($this->connected_user,$this->user)
                && !strcmp($this->connected_password,$this->password)
                && !strcmp($this->connected_port,$port)
                && $this->opened_persistent==$this->persistent)
                return(1);
                mysql_Close($this->connection);
                $this->connection=0;
                $this->affected_rows=-1;
            }
            $this->fixed_float=30;
            $function=($this->persistent ? "mysql_pconnect" : "mysql_connect");
            if(!function_exists($function))
            return($this->SetError("Connect","MySQL support is not available in this PHP configuration"));
            if(($this->connection=@$function($this->host.(!strcmp($port,"") ? "" : ":".$port),$this->user,$this->password))<=0)
            return($this->SetError("Connect",IsSet($php_errormsg) ? $php_errormsg : "Could not connect to MySQL server"));
            if(IsSet($this->options["FixedFloat"]))
            $this->fixed_float=$this->options["FixedFloat"];
            else
            {
                if(($result=mysql_query("SELECT VERSION()",$this->connection)))
                {
                    $version=explode(".",mysql_result($result,0,0));
                    $major=intval($version[0]);
                    $minor=intval($version[1]);
                    $revision=intval($version[2]);
                    if($major>3
                    || ($major==3
                    && $minor>=23
                    && ($minor>23
                    || $revision>=6)))
                    $this->fixed_float=0;
                    mysql_free_result($result);
                }
            }
            if(IsSet($this->supported["Transactions"])
            && !$this->auto_commit)
            {
                if(!mysql_query("SET AUTOCOMMIT=0",$this->connection))
                {
                    mysql_Close($this->connection);
                    $this->connection=0;
                    $this->affected_rows=-1;
                    return(0);
                }
                $this->RegisterTransactionShutdown(0);
            }
            $this->connected_host=$this->host;
            $this->connected_user=$this->user;
            $this->connected_password=$this->password;
            $this->connected_port=$port;
            $this->opened_persistent=$this->persistent;

            return(1);
        }

        Function Close()
        {
            if($this->connection!=0)
            {
                if(IsSet($this->supported["Transactions"])
                && !$this->auto_commit)
                $this->AutoCommitTransactions(1);
                mysql_Close($this->connection);
                $this->connection=0;
                $this->affected_rows=-1;
            }
        }

        /**
        * Zmieñ SELECT i INSERT tak, ¿eby uwzglêdniæ obs³ugê pola id_shop.
        * Do ka¿dego SELECT dodaj warunke id_shop=X, oraz do ka¿dego INSERT dodaj ustawianie warto¶æi id_shop=X
        *
        * @tmp tymczasowe ograniczenie do tabeli main
        *
        * @param string $query zapytaanie/instrukcja SQL
        *
        * @access private
        * @return sting zapytanie z modyfikacjami
        */
        function _soteMultiSQL($query) {
            global $config;
            $query=trim($query);
            if (ereg(";$",$query)) $query=substr($query,0,strlen($query)-1);
            if (eregi("^SELECT",$query)) {
                //print "_soteMUltiSelect()<br>";
                $query=$this->_soteMultiSelect($query);
            } elseif (eregi("^INSERT",$query)) {             
                $query=$this->_soteMultiInsert($query);
            }            
            
            return $query;
        } // end _soteMultiSQL()

        /**
        * Zmieñ instrukcjê SELECT
        *
        * @param string $query zapytanie SQL
        *
        * @access private
        * @return string zmodyfikowane zapytanie SQL (+id_shop=1)
        */
        function _soteMultiSelect($query) {
            global $config;
            
            if (eregi("where",$query)) {
                // jest WHERE
                $new_query=preg_replace("/ FROM[\s]+([a-zA-Z0-9_]+)[\s]+WHERE/i"," FROM \$1 WHERE id_shop=$config->id_shop AND (",$query);
                if (eregi("group by",$new_query)) {
                    $new_query=preg_replace("/GROUP[\s]+BY/i",") GROUP BY",$new_query);
                } elseif (eregi("order by",$new_query)) {
                    $new_query=preg_replace("/ORDER[\s]+BY/i",") ORDER BY",$new_query);
                } elseif (eregi("limit",$new_query)) {
                    $new_query=preg_replace("/LIMIT/i",") LIMIT",$new_query);
                } else {                    
                    $new_query.=")";
                }
            } else {
                // nie ma WHERE
                $new_query=preg_replace("/ FROM[\s]+([a-zA-Z0-9_]+)[\s]+/i"," FROM \$1 WHERE id_shop=$config->id_shop ",$query);
            }
            return $new_query;
        } // end _soteMultiSelect()
        
        /**
        * Zmieñ instrukcjê INSERT
        *
        * @param string $query instrukcja dodania SQL INSERT ...        
        *
        * @access private
        * @return string zmodyfikowane instrukcja dodania SQL
        */
        function _soteMultiInsert($query) {
            global $config;                        
            $new_query=preg_replace("/^INSERT[\s]+INTO[\s]+([a-zA-Z0-9_]+)[\s]+\(/","INSERT INTO \$1 (id_shop,",$query);            
            $new_query=preg_replace("/ VALUES[\s]+\(/"," VALUES ('$config->id_shop',",$new_query);
            return $new_query;
        } // end soteMultiInsert()
        
        /**
        * Wy³±cz modyfikowanie SQL
        */
        function soteSetModSQLOff() {
            $this->_soteSetMod=0;
            return;
        }
        
        /**
        * W³±cz modyfikowanie SQL
        */
        function soteSetModSQLOn() {
            $this->_soteSetMod=1;
            return;
        }
        

        Function Query($query)
        {
            
            $this->Debug("Query: $query");
            $first=$this->first_selected_row;
            $limit=$this->selected_row_limit;
            $this->first_selected_row=$this->selected_row_limit=0;
            if(!strcmp($this->database_name,""))
            return($this->SetError("Query","it was not specified a valid database name to select"));
            if(!$this->Connect())
            return(0);
            if(($select=(substr(strtolower(ltrim($query)),0,strlen("select"))=="select"))
            && $limit>0)
            $query.=" LIMIT $first,$limit";

            //
            global $config,$_SESSION;
            //print "before $query<br />";
            if ((@$config->id_shop>0) && (empty($_SESSION['multi_shop']))) {
                if ($this->_soteSetMod) {
                    $query=$this->_soteMultiSQL($query);
                }
            }
            //print "+after $query<br />";
            if ((! eregi("^select",$query)) && ($this->demo=="yes")) {
                return 1;
            }
            // end SOTE

            if(mysql_select_db($this->database_name,$this->connection)
            && ($result=@mysql_query($query,$this->connection)))
            {
                if($select)
                $this->highest_fetched_row[$result]=-1;
                else
                $this->affected_rows=mysql_affected_rows($this->connection);
            }
            else
            return($this->SetError("Query",mysql_error($this->connection)));
            return($result);
        }

        Function Replace($table,&$fields)
        {
            $count=count($fields);
            for($keys=0,$query=$values="",Reset($fields),$field=0;$field<$count;Next($fields),$field++)
            {
                $name=Key($fields);
                if($field>0)
                {
                    $query.=",";
                    $values.=",";
                }
                $query.=$name;
                if(IsSet($fields[$name]["Null"])
                && $fields[$name]["Null"])
                $value="NULL";
                else
                {
                    if(!IsSet($fields[$name]["Value"]))
                    return($this->SetError("Replace","it was not specified a value for the $name field"));
                    switch(IsSet($fields[$name]["Type"]) ? $fields[$name]["Type"] : "text")
                    {
                        case "text":
                        $value=$this->GetTextFieldValue($fields[$name]["Value"]);
                        break;
                        case "boolean":
                        $value=$this->GetBooleanFieldValue($fields[$name]["Value"]);
                        break;
                        case "integer":
                        $value=strval($fields[$name]["Value"]);
                        break;
                        case "decimal":
                        $value=$this->GetDecimalFieldValue($fields[$name]["Value"]);
                        break;
                        case "float":
                        $value=$this->GetFloatFieldValue($fields[$name]["Value"]);
                        break;
                        case "date":
                        $value=$this->GetDateFieldValue($fields[$name]["Value"]);
                        break;
                        case "time":
                        $value=$this->GetTimeFieldValue($fields[$name]["Value"]);
                        break;
                        case "timestamp":
                        $value=$this->GetTimestampFieldValue($fields[$name]["Value"]);
                        break;
                        default:
                        return($this->SetError("Replace","it was not specified a supported type for the $name field"));
                    }
                }
                $values.=$value;
                if(IsSet($fields[$name]["Key"])
                && $fields[$name]["Key"])
                {
                    if($value=="NULL")
                    return($this->SetError("Replace","key values may not be NULL"));
                    $keys++;
                }
            }
            if($keys==0)
            return($this->SetError("Replace","it were not specified which fields are keys"));
            return($this->Query("REPLACE INTO $table ($query) VALUES($values)"));
        }

        Function EndOfResult($result)
        {
            if(!IsSet($this->highest_fetched_row[$result]))
            {
                $this->SetError("End of result","attempted to check the end of an unknown result");
                return(-1);
            }
            return($this->highest_fetched_row[$result]>=$this->NumberOfRows($result)-1);
        }

        Function FetchResult($result,$row,$field)
        {
            @$this->highest_fetched_row[$result]=max($this->highest_fetched_row[$result],$row);
            return(@mysql_result($result,$row,$field));
        }

        Function FetchResultArray($result,&$array,$row)
        {
            if(!mysql_data_seek($result,$row)
            || !($array=mysql_fetch_row($result)))
            return($this->SetError("Fetch result array",mysql_error($this->connection)));
            $this->highest_fetched_row[$result]=max($this->highest_fetched_row[$result],$row);
            return($this->ConvertResultRow($result,$array));
        }

        Function FetchCLOBResult($result,$row,$field)
        {
            return($this->FetchLOBResult($result,$row,$field));
        }

        Function FetchBLOBResult($result,$row,$field)
        {
            return($this->FetchLOBResult($result,$row,$field));
        }

        Function ConvertResult(&$value,$type)
        {
            switch($type)
            {
                case METABASE_TYPE_BOOLEAN:
                $value=(strcmp($value,"Y") ? 0 : 1);
                return(1);
                case METABASE_TYPE_DECIMAL:
                $value=sprintf("%.".$this->decimal_places."f",doubleval($value)/$this->decimal_factor);
                return(1);
                case METABASE_TYPE_FLOAT:
                $value=doubleval($value);
                return(1);
                case METABASE_TYPE_DATE:
                case METABASE_TYPE_TIME:
                case METABASE_TYPE_TIMESTAMP:
                return(1);
                default:
                return($this->BaseConvertResult($value,$type));
            }
        }

        Function NumberOfRows($result)
        {
            return(mysql_num_rows($result));
        }

        Function FreeResult($result)
        {
            UnSet($this->highest_fetched_row[$result]);
            UnSet($this->columns[$result]);
            UnSet($this->result_types[$result]);
            return(mysql_free_result($result));
        }

        Function CreateDatabase($name)
        {
            if(!$this->Connect())
            return(0);
            if(!mysql_create_db($name,$this->connection))
            return($this->SetError("Create database",mysql_error($this->connection)));
            return(1);
        }

        Function DropDatabase($name)
        {
            if(!$this->Connect())
            return(0);
            if(!mysql_drop_db($name,$this->connection))
            return($this->SetError("Drop database",mysql_error($this->connection)));
            return(1);
        }

        Function GetCLOBFieldTypeDeclaration($name,&$field)
        {
            if(IsSet($field["length"]))
            {
                $length=$field["length"];
                if($length<=255)
                $type="TINYTEXT";
                else
                {
                    if($length<=65535)
                    $type="TEXT";
                    else
                    {
                        if($length<=16777215)
                        $type="MEDIUMTEXT";
                        else
                        $type="LONGTEXT";
                    }
                }
            }
            else
            $type="LONGTEXT";
            return("$name $type".(IsSet($field["notnull"]) ? " NOT NULL" : ""));
        }

        Function GetBLOBFieldTypeDeclaration($name,&$field)
        {
            if(IsSet($field["length"]))
            {
                $length=$field["length"];
                if($length<=255)
                $type="TINYBLOB";
                else
                {
                    if($length<=65535)
                    $type="BLOB";
                    else
                    {
                        if($length<=16777215)
                        $type="MEDIUMBLOB";
                        else
                        $type="LONGBLOB";
                    }
                }
            }
            else
            $type="LONGBLOB";
            return("$name $type".(IsSet($field["notnull"]) ? " NOT NULL" : ""));
        }

        Function GetIntegerFieldTypeDeclaration($name,&$field)
        {
            return("$name ".(IsSet($field["unsigned"]) ? "INT UNSIGNED" : "INT").(IsSet($field["default"]) ? " DEFAULT ".$field["default"] : "").(IsSet($field["notnull"]) ? " NOT NULL" : ""));
        }

        Function GetDateFieldTypeDeclaration($name,&$field)
        {
            return($name." DATE".(IsSet($field["default"]) ? " DEFAULT '".$field["default"]."'" : "").(IsSet($field["notnull"]) ? " NOT NULL" : ""));
        }

        Function GetTimestampFieldTypeDeclaration($name,&$field)
        {
            return($name." DATETIME".(IsSet($field["default"]) ? " DEFAULT '".$field["default"]."'" : "").(IsSet($field["notnull"]) ? " NOT NULL" : ""));
        }

        Function GetTimeFieldTypeDeclaration($name,&$field)
        {
            return($name." TIME".(IsSet($field["default"]) ? " DEFAULT '".$field["default"]."'" : "").(IsSet($field["notnull"]) ? " NOT NULL" : ""));
        }

        Function GetFloatFieldTypeDeclaration($name,&$field)
        {
            if(IsSet($this->options["FixedFloat"]))
            $this->fixed_float=$this->options["FixedFloat"];
            else
            {
                if($this->connection==0)
                $this->Connect();
            }
            return("$name DOUBLE".($this->fixed_float ? "(".($this->fixed_float+2).",".$this->fixed_float.")" : "").(IsSet($field["default"]) ? " DEFAULT ".$this->GetFloatFieldValue($field["default"]) : "").(IsSet($field["notnull"]) ? " NOT NULL" : ""));
        }

        Function GetDecimalFieldTypeDeclaration($name,&$field)
        {
            return("$name BIGINT".(IsSet($field["default"]) ? " DEFAULT ".$this->GetDecimalFieldValue($field["default"]) : "").(IsSet($field["notnull"]) ? " NOT NULL" : ""));
        }

        Function GetCLOBFieldValue($prepared_query,$parameter,$clob,&$value)
        {
            for($value="'";!MetabaseEndOfLOB($clob);)
            {
                if(MetabaseReadLOB($clob,$data,$this->lob_buffer_length)<0)
                {
                    $value="";
                    return($this->SetError("Get CLOB field value",MetabaseLOBError($clob)));
                }
                $this->EscapeText($data);
                $value.=$data;
            }
            $value.="'";
            return(1);
        }

        Function FreeCLOBValue($prepared_query,$clob,&$value,$success)
        {
            Unset($value);
        }

        Function GetBLOBFieldValue($prepared_query,$parameter,$blob,&$value)
        {
            for($value="'";!MetabaseEndOfLOB($blob);)
            {
                if(!MetabaseReadLOB($blob,$data,$this->lob_buffer_length))
                {
                    $value="";
                    return($this->SetError("Get BLOB field value",MetabaseLOBError($clob)));
                }
                $value.=AddSlashes($data);
            }
            $value.="'";
            return(1);
        }

        Function FreeBLOBValue($prepared_query,$blob,&$value,$success)
        {
            Unset($value);
        }

        Function GetFloatFieldValue($value)
        {
            return(!strcmp($value,"NULL") ? "NULL" : "$value");
        }

        Function GetDecimalFieldValue($value)
        {
            return(!strcmp($value,"NULL") ? "NULL" : strval(round(doubleval($value)*$this->decimal_factor)));
        }

        Function GetColumnNames($result,&$column_names)
        {
            $result_value=intval($result);
            if(!IsSet($this->highest_fetched_row[$result_value]))
            return($this->SetError("Get column names","it was specified an inexisting result set"));
            if(!IsSet($this->columns[$result_value]))
            {
                $this->columns[$result_value]=array();
                $columns=mysql_num_fields($result);
                for($column=0;$column<$columns;$column++)
                $this->columns[$result_value][strtolower(mysql_field_name($result,$column))]=$column;
            }
            $column_names=$this->columns[$result_value];
            return(1);
        }

        Function NumberOfColumns($result)
        {
            if(!IsSet($this->highest_fetched_row[intval($result)]))
            {
                $this->SetError("Get column names","it was specified an inexisting result set");
                return(-1);
            }
            return(mysql_num_fields($result));
        }

        Function CreateTable($name,&$fields)
        {
            if(!IsSet($name)
            || !strcmp($name,""))
            return($this->SetError("Create table","it was not specified a valid table name"));
            if(count($fields)==0)
            return($this->SetError("Create table","it were not specified any fields for table \"$name\""));
            $query_fields="";
            if(!$this->GetFieldList($fields,$query_fields))
            return(0);
            if(IsSet($this->supported["Transactions"]))
            $query_fields.=", dummy_primary_key INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (dummy_primary_key)";
            return($this->Query("CREATE TABLE $name ($query_fields)".(IsSet($this->supported["Transactions"]) ? " TYPE=BDB" : "")));
        }

        Function AlterTable($name,&$changes,$check)
        {
            if($check)
            {
                for($change=0,Reset($changes);$change<count($changes);Next($changes),$change++)
                {
                    switch(Key($changes))
                    {
                        case "AddedFields":
                        case "RemovedFields":
                        case "ChangedFields":
                        case "RenamedFields":
                        case "name":
                        break;
                        default:
                        return($this->SetError("Alter table","change type \"".Key($changes)."\" not yet supported"));
                    }
                }
                return(1);
            }
            else
            {
                $query=(IsSet($changes["name"]) ? "RENAME AS ".$changes["name"] : "");
                if(IsSet($changes["AddedFields"]))
                {
                    $fields=$changes["AddedFields"];
                    for($field=0,Reset($fields);$field<count($fields);Next($fields),$field++)
                    {
                        if(strcmp($query,""))
                        $query.=", ";
                        $query.="ADD ".$fields[Key($fields)]["Declaration"];
                    }
                }
                if(IsSet($changes["RemovedFields"]))
                {
                    $fields=$changes["RemovedFields"];
                    for($field=0,Reset($fields);$field<count($fields);Next($fields),$field++)
                    {
                        if(strcmp($query,""))
                        $query.=", ";
                        $query.="DROP ".Key($fields);
                    }
                }
                $renamed_fields=array();
                if(IsSet($changes["RenamedFields"]))
                {
                    $fields=$changes["RenamedFields"];
                    for($field=0,Reset($fields);$field<count($fields);Next($fields),$field++)
                    $renamed_fields[$fields[Key($fields)]["name"]]=Key($fields);
                }
                if(IsSet($changes["ChangedFields"]))
                {
                    $fields=$changes["ChangedFields"];
                    for($field=0,Reset($fields);$field<count($fields);Next($fields),$field++)
                    {
                        if(strcmp($query,""))
                        $query.=", ";
                        if(IsSet($renamed_fields[Key($fields)]))
                        {
                            $field_name=$renamed_fields[Key($fields)];
                            UnSet($renamed_fields[Key($fields)]);
                        }
                        else
                        $field_name=Key($fields);
                        $query.="CHANGE $field_name ".$fields[Key($fields)]["Declaration"];
                    }
                }
                if(count($renamed_fields))
                {
                    for($field=0,Reset($renamed_fields);$field<count($renamed_fields);Next($renamed_fields),$field++)
                    {
                        if(strcmp($query,""))
                        $query.=", ";
                        $old_field_name=$renamed_fields[Key($renamed_fields)];
                        $query.="CHANGE $old_field_name ".$changes["RenamedFields"][$old_field_name]["Declaration"];
                    }
                }
                return($this->Query("ALTER TABLE $name $query"));
            }
        }

        Function CreateSequence($name,$start)
        {
            if(!$this->Query("CREATE TABLE _sequence_$name (sequence INT DEFAULT 0 NOT NULL AUTO_INCREMENT, PRIMARY KEY (sequence))"))
            return(0);
            if($start==1
            || $this->Query("INSERT INTO _sequence_$name (sequence) VALUES (".($start-1).")"))
            return(1);
            $error=$this->Error();
            if(!$this->Query("DROP TABLE _sequence_$name"))
            $this->warning="could not drop inconsistent sequence table";
            return($this->SetError("Create sequence",$error));
        }

        Function DropSequence($name)
        {
            return($this->Query("DROP TABLE _sequence_$name"));
        }

        Function GetSequenceNextValue($name,&$value)
        {
            if(!$this->Query("INSERT INTO _sequence_$name (sequence) VALUES (NULL)"))
            return(0);
            $value=intval(mysql_insert_id());
            if(!$this->Query("DELETE FROM _sequence_$name WHERE sequence<$value"))
            $this->warning="could delete previous sequence table values";
            return(1);
        }

        Function GetSequenceCurrentValue($name,&$value)
        {
            if(($result=$this->Query("SELECT MAX(sequence) FROM _sequence_$name"))==0)
            return(0);
            $value=intval($this->FetchResult($result,0,0));
            $this->FreeResult($result);
            return(1);
        }

        Function CreateIndex($table,$name,$definition)
        {
            $query="ALTER TABLE $table ADD ".(IsSet($definition["unique"]) ? "UNIQUE" : "INDEX")." $name (";
            for($field=0,Reset($definition["FIELDS"]);$field<count($definition["FIELDS"]);$field++,Next($definition["FIELDS"]))
            {
                if($field>0)
                $query.=",";
                $query.=Key($definition["FIELDS"]);
            }
            $query.=")";
            return($this->Query($query));
        }

        Function DropIndex($table,$name)
        {
            return($this->Query("ALTER TABLE $table DROP INDEX $name"));
        }

        Function AutoCommitTransactions($auto_commit)
        {
            $this->Debug("AutoCommit: ".($auto_commit ? "On" : "Off"));
            if(!IsSet($this->supported["Transactions"]))
            return($this->SetError("Auto-commit transactions","transactions are not in use"));
            if(((!$this->auto_commit)==(!$auto_commit)))
            return(1);
            if($this->connection)
            {
                if($auto_commit)
                {
                    if(!$this->Query("COMMIT")
                    || !$this->Query("SET AUTOCOMMIT=1"))
                    return(0);
                }
                else
                {
                    if(!$this->Query("SET AUTOCOMMIT=0"))
                    return(0);
                }
            }
            $this->auto_commit=$auto_commit;
            return($this->RegisterTransactionShutdown($auto_commit));
        }

        Function CommitTransaction()
        {
            $this->Debug("Commit Transaction");
            if(!IsSet($this->supported["Transactions"]))
            return($this->SetError("Commit transaction","transactions are not in use"));
            if($this->auto_commit)
            return($this->SetError("Commit transaction","transaction changes are being auto commited"));
            return($this->Query("COMMIT"));
        }

        Function RollbackTransaction()
        {
            $this->Debug("Rollback Transaction");
            if(!IsSet($this->supported["Transactions"]))
            return($this->SetError("Rollback transaction","transactions are not in use"));
            if($this->auto_commit)
            return($this->SetError("Rollback transaction","transactions can not be rolled back when changes are auto commited"));
            return($this->Query("ROLLBACK"));
        }

        Function Setup()
        {
            $this->supported["Sequences"]=
            $this->supported["Indexes"]=
            $this->supported["AffectedRows"]=
            $this->supported["SummaryFunctions"]=
            $this->supported["OrderByText"]=
            $this->supported["GetSequenceCurrentValue"]=
            $this->supported["SelectRowRanges"]=
            $this->supported["LOBs"]=
            $this->supported["Replace"]=
            1;
            if(IsSet($this->options["UseTransactions"])
            && $this->options["UseTransactions"])
            $this->supported["Transactions"]=1;
            $this->decimal_factor=pow(10.0,$this->decimal_places);
            return("");
        }
    };

}
?>
