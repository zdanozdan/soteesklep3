<?

/*
 * metabase_interface.php
 *
 * @(#) $Header: /usr/local/CVS/soteesklep2/lib/Metabase/metabase_interface.php,v 2.1 2003/03/13 11:48:22 maroslaw Exp $
 *
 */

$test="xxxxx";

$metabase_databases=array();

Function MetabaseSetupInterface(&$arguments,&$db)
{
	switch(IsSet($arguments["Type"]) ? $arguments["Type"] : "")
	{
		case "ibase";
			$include="metabase_ibase.php";
			$class_name="metabase_ibase_class";
			$included="METABASE_IBASE_INCLUDED";
			break;
		case "ifx";
			$include="metabase_ifx.php";
			$class_name="metabase_ifx_class";
			$included="METABASE_IFX_INCLUDED";
			break;
		case "msql";
			$include="metabase_msql.php";
			$class_name="metabase_msql_class";
			$included="METABASE_MSQL_INCLUDED";
			break;
		case "mssql";
			$include="metabase_mssql.php";
			$class_name="metabase_mssql_class";
			$included="METABASE_MSSQL_INCLUDED";
			break;
		case "mysql";
			$include="metabase_mysql.php";
			$class_name="metabase_mysql_class";
			$included="METABASE_MYSQL_INCLUDED";
			break;
		case "pgsql";
			$include="metabase_pgsql.php";
			$class_name="metabase_pgsql_class";
			$included="METABASE_PGSQL_INCLUDED";
			break;
		case "odbc";
			$include="metabase_odbc.php";
			$class_name="metabase_odbc_class";
			$included="METABASE_ODBC_INCLUDED";
			break;
		case "oci";
			$include="metabase_oci.php";
			$class_name="metabase_oci_class";
			$included="METABASE_OCI_INCLUDED";
			break;
		default:
			$included=(IsSet($arguments["IncludedConstant"]) ? $arguments["IncludedConstant"] : "");
			if(!IsSet($arguments["Include"])
			|| !strcmp($include=$arguments["Include"],""))
				return(IsSet($arguments["Include"]) ? "it was not specified a valid database include file" : "it was not specified a valid DBMS driver type");
			if(!IsSet($arguments["ClassName"])
			|| !strcmp($class_name=$arguments["ClassName"],""))
				return("it was not specified a valid database class name");
	}
	if(!strcmp($included,"")
	|| !defined($included))
	{
		$include_path=(IsSet($arguments["IncludePath"]) ? $arguments["IncludePath"] : "");
		if($include_path!=""
		&& $include_path[strlen($include_path)-1]!="/")
			$include="/".$include;
		if(!file_exists($include_path.$include))
		{
			$directory=0;
			if(!strcmp($include_path,"")
			|| ($directory=@opendir($include_path)))
			{
				if($directory)
					closedir($directory);
				return("it was not specified an existing DBMS driver file");
			}
			else
				return("it was not specified a valid DBMS driver include path");
		}
		include($include_path.$include);
	}
	$db=new $class_name;
	if(IsSet($arguments["Host"]))
		$db->host=$arguments["Host"];
	if(IsSet($arguments["User"]))
		$db->user=$arguments["User"];
	if(IsSet($arguments["Password"]))
		$db->password=$arguments["Password"];
	if(IsSet($arguments["Persistent"]))
		$db->persistent=$arguments["Persistent"];
	if(IsSet($arguments["Debug"]))
		$db->debug=$arguments["Debug"];
	$db->decimal_places=(IsSet($arguments["DecimalPlaces"]) ? $arguments["DecimalPlaces"] : 2);
	$db->lob_buffer_length=(IsSet($arguments["LOBBufferLength"]) ? $arguments["LOBBufferLength"] : 8000);
	if(IsSet($arguments["LogLineBreak"]))
		$db->log_line_break=$arguments["LogLineBreak"];
	if(IsSet($arguments["Options"]))
		$db->options=$arguments["Options"];
	return($db->Setup());
}

Function MetabaseSetupDatabase($arguments,&$database)
{
	global $metabase_databases;

	$database=count($metabase_databases)+1;
	if(strcmp($error=MetabaseSetupInterface($arguments,$metabase_databases[$database]),""))
	{
		Unset($metabase_databases[$database]);
		$database=0;
	}
	else
		$metabase_databases[$database]->database=$database;
	return($error);
}

Function MetabaseSetupDatabaseObject($arguments,&$db)
{
	global $metabase_databases;

	$database=count($metabase_databases)+1;
	if(strcmp($error=MetabaseSetupInterface($arguments,$db),""))
		Unset($metabase_databases[$database]);
	else
	{
		eval("\$metabase_database[\$database]= &\$db;");		
		$db->database=$database;
	}
	return($error);
}

Function MetabaseCloseSetup($database)
{
	global $metabase_databases;

	$metabase_databases[$database]->CloseSetup();
	$metabase_databases[$database]="";
}

Function MetabaseQuery($database,$query)
{
	global $metabase_databases;

	return($metabase_databases[$database]->Query($query));	
}

Function MetabaseQueryField($database,$query,&$field,$type="text")
{
	global $metabase_databases;

	return($metabase_databases[$database]->QueryField($query,$field,$type));
}

Function MetabaseQueryRow($database,$query,&$row,$types="")
{
	global $metabase_databases;

	return($metabase_databases[$database]->QueryRow($query,$row,$types));
}

Function MetabaseQueryColumn($database,$query,&$column,$type="text")
{
	global $metabase_databases;

	return($metabase_databases[$database]->QueryColumn($query,$column,$type));
}

Function MetabaseQueryAll($database,$query,&$all,$types="")
{
	global $metabase_databases;

	return($metabase_databases[$database]->QueryAll($query,$all,$types));
}

Function MetabaseReplace($database,$table,&$fields)
{
	global $metabase_databases;

	return($metabase_databases[$database]->Replace($table,$fields));
}

Function MetabasePrepareQuery($database,$query)
{
	global $metabase_databases;

	return($metabase_databases[$database]->PrepareQuery($query));
}

Function MetabaseFreePreparedQuery($database,$prepared_query)
{
	global $metabase_databases;

	return($metabase_databases[$database]->FreePreparedQuery($prepared_query));
}

Function MetabaseExecuteQuery($database,$prepared_query)
{
	global $metabase_databases;

	return($metabase_databases[$database]->ExecuteQuery($prepared_query));
}

Function MetabaseQuerySet($database,$prepared_query,$parameter,$type,$value,$is_null=0,$field="")
{
	global $metabase_databases;

	return($metabase_databases[$database]->QuerySet($prepared_query,$parameter,$type,$value,$is_null,$field));
}

Function MetabaseQuerySetNull($database,$prepared_query,$parameter,$type)
{
	global $metabase_databases;

	return($metabase_databases[$database]->QuerySetNull($prepared_query,$parameter,$type));
}

Function MetabaseQuerySetText($database,$prepared_query,$parameter,$value)
{
	global $metabase_databases;

	return($metabase_databases[$database]->QuerySetText($prepared_query,$parameter,$value));
}

Function MetabaseQuerySetCLOB($database,$prepared_query,$parameter,$value,$field)
{
	global $metabase_databases;

	return($metabase_databases[$database]->QuerySetCLOB($prepared_query,$parameter,$value,$field));
}

Function MetabaseQuerySetBLOB($database,$prepared_query,$parameter,$value,$field)
{
	global $metabase_databases;

	return($metabase_databases[$database]->QuerySetBLOB($prepared_query,$parameter,$value,$field));
}

Function MetabaseQuerySetInteger($database,$prepared_query,$parameter,$value)
{
	global $metabase_databases;

	return($metabase_databases[$database]->QuerySetInteger($prepared_query,$parameter,$value));
}

Function MetabaseQuerySetBoolean($database,$prepared_query,$parameter,$value)
{
	global $metabase_databases;

	return($metabase_databases[$database]->QuerySetBoolean($prepared_query,$parameter,$value));
}

Function MetabaseQuerySetDate($database,$prepared_query,$parameter,$value)
{
	global $metabase_databases;

	return($metabase_databases[$database]->QuerySetDate($prepared_query,$parameter,$value));
}

Function MetabaseQuerySetTimestamp($database,$prepared_query,$parameter,$value)
{
	global $metabase_databases;

	return($metabase_databases[$database]->QuerySetTimestamp($prepared_query,$parameter,$value));
}

Function MetabaseQuerySetTime($database,$prepared_query,$parameter,$value)
{
	global $metabase_databases;

	return($metabase_databases[$database]->QuerySetTime($prepared_query,$parameter,$value));
}

Function MetabaseQuerySetFloat($database,$prepared_query,$parameter,$value)
{
	global $metabase_databases;

	return($metabase_databases[$database]->QuerySetFloat($prepared_query,$parameter,$value));
}

Function MetabaseQuerySetDecimal($database,$prepared_query,$parameter,$value)
{
	global $metabase_databases;

	return($metabase_databases[$database]->QuerySetDecimal($prepared_query,$parameter,$value));
}

Function MetabaseAffectedRows($database,&$affected_rows)
{
	global $metabase_databases;

	return($metabase_databases[$database]->AffectedRows($affected_rows));
}

Function MetabaseFetchResult($database,$result,$row,$field)
{
	global $metabase_databases;

	return($metabase_databases[$database]->FetchResult($result,$row,$field));
}

Function MetabaseFetchCLOBResult($database,$result,$row,$field)
{
	global $metabase_databases;

	return($metabase_databases[$database]->FetchCLOBResult($result,$row,$field));
}

Function MetabaseFetchBLOBResult($database,$result,$row,$field)
{
	global $metabase_databases;

	return($metabase_databases[$database]->FetchBLOBResult($result,$row,$field));
}

Function MetabaseDestroyResultLOB($database,$lob)
{
	global $metabase_databases;

	return($metabase_databases[$database]->DestroyResultLOB($lob));
}

Function MetabaseEndOfResultLOB($database,$lob)
{
	global $metabase_databases;

	return($metabase_databases[$database]->EndOfResultLOB($lob));
}

Function MetabaseReadResultLOB($database,$lob,&$data,$length)
{
	global $metabase_databases;

	return($metabase_databases[$database]->ReadResultLOB($lob,$data,$length));
}

Function MetabaseResultIsNull($database,$result,$row,$field)
{
	global $metabase_databases;

	return($metabase_databases[$database]->ResultIsNull($result,$row,$field));
}

Function MetabaseFetchDateResult($database,$result,$row,$field)
{
	global $metabase_databases;

	return($metabase_databases[$database]->FetchDateResult($result,$row,$field));
}

Function MetabaseFetchTimestampResult($database,$result,$row,$field)
{
	global $metabase_databases;

	return($metabase_databases[$database]->FetchTimestampResult($result,$row,$field));
}

Function MetabaseFetchTimeResult($database,$result,$row,$field)
{
	global $metabase_databases;

	return($metabase_databases[$database]->FetchTimeResult($result,$row,$field));
}

Function MetabaseFetchBooleanResult($database,$result,$row,$field)
{
	global $metabase_databases;

	return($metabase_databases[$database]->FetchBooleanResult($result,$row,$field));
}

Function MetabaseFetchFloatResult($database,$result,$row,$field)
{
	global $metabase_databases;

	return($metabase_databases[$database]->FetchFloatResult($result,$row,$field));
}

Function MetabaseFetchDecimalResult($database,$result,$row,$field)
{
	global $metabase_databases;

	return($metabase_databases[$database]->FetchDecimalResult($result,$row,$field));
}

Function MetabaseFetchResultField($database,$result,&$field)
{
	global $metabase_databases;

	return($metabase_databases[$database]->FetchResultField($result,$field));
}

Function MetabaseFetchResultArray($database,$result,&$array,$row)
{
	global $metabase_databases;

	return($metabase_databases[$database]->FetchResultArray($result,$array,$row));
}

Function MetabaseFetchResultRow($database,$result,&$row)
{
	global $metabase_databases;

	return($metabase_databases[$database]->FetchResultRow($result,$row));
}

Function MetabaseFetchResultColumn($database,$result,&$column)
{
	global $metabase_databases;

	return($metabase_databases[$database]->FetchResultColumn($result,$column));
}

Function MetabaseFetchResultAll($database,$result,&$all)
{
	global $metabase_databases;

	return($metabase_databases[$database]->FetchResultAll($result,$all));
}

Function MetabaseNumberOfRows($database,$result)
{
	global $metabase_databases;

	return($metabase_databases[$database]->NumberOfRows($result));
}

Function MetabaseNumberOfColumns($database,$result)
{
	global $metabase_databases;

	return($metabase_databases[$database]->NumberOfColumns($result));
}

Function MetabaseGetColumnNames($database,$result,&$column_names)
{
	global $metabase_databases;

	return($metabase_databases[$database]->GetColumnNames($result,$column_names));
}

Function MetabaseSetResultTypes($database,$result,&$types)
{
	global $metabase_databases;

	return($metabase_databases[$database]->SetResultTypes($result,$types));
}

Function MetabaseFreeResult($database,$result)
{
	global $metabase_databases;

	return($metabase_databases[$database]->FreeResult($result));
}

Function MetabaseError($database)
{
	global $metabase_databases;

	return($metabase_databases[$database]->Error());
}

Function MetabaseSetErrorHandler($database,$function)
{
	global $metabase_databases;

	return($metabase_databases[$database]->SetErrorHandler($function));
}

Function MetabaseCreateDatabase($database,$name)
{
	global $metabase_databases;

	return($metabase_databases[$database]->CreateDatabase($name));
}

Function MetabaseDropDatabase($database,$name)
{
	global $metabase_databases;

	return($metabase_databases[$database]->DropDatabase($name));
}

Function MetabaseSetDatabase($database,$name)
{
	global $metabase_databases;

	return($metabase_databases[$database]->SetDatabase($name));
}

Function MetabaseGetIntegerFieldTypeDeclaration($database,$name,&$field)
{
	global $metabase_databases;

	return($metabase_databases[$database]->GetIntegerFieldTypeDeclaration($name,$field));
}

Function MetabaseGetTextFieldTypeDeclaration($database,$name,&$field)
{
	global $metabase_databases;

	return($metabase_databases[$database]->GetTextFieldTypeDeclaration($name,$field));
}

Function MetabaseGetCLOBFieldTypeDeclaration($database,$name,&$field)
{
	global $metabase_databases;

	return($metabase_databases[$database]->GetCLOBFieldTypeDeclaration($name,$field));
}

Function MetabaseGetBLOBFieldTypeDeclaration($database,$name,&$field)
{
	global $metabase_databases;

	return($metabase_databases[$database]->GetBLOBFieldTypeDeclaration($name,$field));
}

Function MetabaseGetBooleanFieldTypeDeclaration($database,$name,&$field)
{
	global $metabase_databases;

	return($metabase_databases[$database]->GetBooleanFieldTypeDeclaration($name,$field));
}

Function MetabaseGetDateFieldTypeDeclaration($database,$name,&$field)
{
	global $metabase_databases;

	return($metabase_databases[$database]->GetDateFieldTypeDeclaration($name,$field));
}

Function MetabaseGetTimestampFieldTypeDeclaration($database,$name,&$field)
{
	global $metabase_databases;

	return($metabase_databases[$database]->GetTimestampFieldTypeDeclaration($name,$field));
}

Function MetabaseGetTimeFieldTypeDeclaration($database,$name,&$field)
{
	global $metabase_databases;

	return($metabase_databases[$database]->GetTimeFieldTypeDeclaration($name,$field));
}

Function MetabaseGetFloatFieldTypeDeclaration($database,$name,&$field)
{
	global $metabase_databases;

	return($metabase_databases[$database]->GetFloatFieldTypeDeclaration($name,$field));
}

Function MetabaseGetDecimalFieldTypeDeclaration($database,$name,&$field)
{
	global $metabase_databases;

	return($metabase_databases[$database]->GetDecimalFieldTypeDeclaration($name,$field));
}

Function MetabaseGetTextFieldValue($database,$value)
{
	global $metabase_databases;

	return($metabase_databases[$database]->GetTextFieldValue($value));
}

Function MetabaseGetBooleanFieldValue($database,$value)
{
	global $metabase_databases;

	return($metabase_databases[$database]->GetBooleanFieldValue($value));
}

Function MetabaseGetDateFieldValue($database,$value)
{
	global $metabase_databases;

	return($metabase_databases[$database]->GetDateFieldValue($value));
}

Function MetabaseGetTimestampFieldValue($database,$value)
{
	global $metabase_databases;

	return($metabase_databases[$database]->GetTimestampFieldValue($value));
}

Function MetabaseGetTimeFieldValue($database,$value)
{
	global $metabase_databases;

	return($metabase_databases[$database]->GetTimeFieldValue($value));
}

Function MetabaseGetFloatFieldValue($database,$value)
{
	global $metabase_databases;

	return($metabase_databases[$database]->GetFloatFieldValue($value));
}

Function MetabaseGetDecimalFieldValue($database,$value)
{
	global $metabase_databases;

	return($metabase_databases[$database]->GetDecimalFieldValue($value));
}

Function MetabaseSupport($database,$feature)
{
	global $metabase_databases;

	return($metabase_databases[$database]->Support($feature));
}

Function MetabaseCreateTable($database,$name,&$fields)
{
	global $metabase_databases;

	return($metabase_databases[$database]->CreateTable($name,$fields));
}

Function MetabaseDropTable($database,$name)
{
	global $metabase_databases;

	return($metabase_databases[$database]->DropTable($name));
}

Function MetabaseAlterTable($database,$name,&$changes,$check=0)
{
	global $metabase_databases;

	return($metabase_databases[$database]->AlterTable($name,$changes,$check));
}

Function MetabaseCreateSequence($database,$name,$start)
{
	global $metabase_databases;

	return($metabase_databases[$database]->CreateSequence($name,$start));
}

Function MetabaseDropSequence($database,$name)
{
	global $metabase_databases;

	return($metabase_databases[$database]->DropSequence($name));
}

Function MetabaseGetSequenceNextValue($database,$name,&$value)
{
	global $metabase_databases;

	return($metabase_databases[$database]->GetSequenceNextValue($name,$value));
}

Function MetabaseGetSequenceCurrentValue($database,$name,&$value)
{
	global $metabase_databases;

	return($metabase_databases[$database]->GetSequenceCurrentValue($name,$value));
}

Function MetabaseAutoCommitTransactions($database,$auto_commit)
{
	global $metabase_databases;

	return($metabase_databases[$database]->AutoCommitTransactions($auto_commit));
}

Function MetabaseCommitTransaction($database)
{
	global $metabase_databases;

	return($metabase_databases[$database]->CommitTransaction());
}

Function MetabaseRollbackTransaction($database)
{
	global $metabase_databases;

	return($metabase_databases[$database]->RollbackTransaction());
}

Function MetabaseCreateIndex($database,$table,$name,$definition)
{
	global $metabase_databases;

	return($metabase_databases[$database]->CreateIndex($table,$name,$definition));
}

Function MetabaseDropIndex($database,$table,$name)
{
	global $metabase_databases;

	return($metabase_databases[$database]->DropIndex($table,$name));
}

Function MetabaseNow()
{
	return(strftime("%Y-%m-%d %H:%M:%S"));
}

Function MetabaseToday()
{
	return(strftime("%Y-%m-%d"));
}

Function MetabaseTime()
{
	return(strftime("%H:%M:%S"));
}

Function MetabaseSetSelectedRowRange($database,$first,$limit)
{
	global $metabase_databases;

	return($metabase_databases[$database]->SetSelectedRowRange($first,$limit));
}

Function MetabaseEndOfResult($database,$result)
{
	global $metabase_databases;

	return($metabase_databases[$database]->EndOfResult($result));
}

Function MetabaseCaptureDebugOutput($database,$capture)
{
	global $metabase_databases;

	$metabase_databases[$database]->CaptureDebugOutput($capture);
}

Function MetabaseDebugOutput($database)
{
	global $metabase_databases;

	return($metabase_databases[$database]->DebugOutput());
}

Function MetabaseDebug($database,$message)
{
	global $metabase_databases;

	return($metabase_databases[$database]->Debug($message));
}

?>