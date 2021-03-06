
<?
/*
 * driver_test_configuration.php
 *
 * @(#) $Header: /usr/local/CVS/soteesklep2/lib/Metabase/driver_test_config.php,v 2.1 2003/03/13 11:48:16 maroslaw Exp $
 *
 */

	$driver_arguments["Type"]="mysql";
	$driver_arguments["DontCaptureDebug"]=1;
	$driver_arguments["Persistent"]=0;
	$driver_arguments["LogLineBreak"]="\n";
	$driver_arguments["Options"]=array(
	);

	switch($driver_arguments["Type"])
	{
		case "ibase":
			$driver_arguments["Host"]="";
			$driver_arguments["Options"]=array(
				"DBAUser"=>"sysdba",
				"DBAPassword"=>"masterkey",
				"DatabasePath"=>"/opt/interbase/",
				"DatabaseExtension"=>".gdb"
			);
			$database_variables["create"]="0";
			break;
		case "ifx":
			$driver_arguments["Host"]="demo_on";
			$driver_arguments["User"]="webuser";
			$driver_arguments["Password"]="webuser_password";
			$driver_arguments["Options"]=array(
				"DBAUser"=>"informix",
				"DBAPassword"=>"informix_pasword",
				"Use8ByteIntegers"=>1,
				"Logging"=>"Unbuffered"
			);
			break;
		case "msql":
			break;
		case "mssql":
			$driver_arguments["User"]="sa";
			$driver_arguments["Password"]="";
			$driver_arguments["Options"]=array(
				"DatabaseDevice"=>"DEFAULT",
				"DatabaseSize"=>"10"
			);
			break;
		case "mysql":
			$driver_arguments["User"]="root";
			$driver_arguments["Options"]["UseTransactions"]=0;
			break;
		case "oci":
			$driver_arguments["User"]="drivertest";
			$driver_arguments["Password"]="drivertest";
			$driver_arguments["Options"]=array(
				"SID"=>"dboracle",
				"HOME"=>"/home/oracle/u01",
				"DBAUser"=>"SYS",
				"DBAPassword"=>"change_on_install"
			);
			break;
		case "odbc":
			$driver_arguments["User"]="webuser";
			$driver_arguments["Password"]="webuser_password";
			$driver_arguments["Options"]=array(
				"DBADSN"=>"dbadsn",
				"DBAUser"=>"dbauser",
				"DBAPassword"=>"dbapassword",
				"UseDefaultValues"=>0,
				"UseDecimalScale"=>0,
				"UseTransactions"=>0
			);
			$database_variables["create"]="0";
			$database_variables["name"]="userdsn";
			break;
		case "pgsql":
			$driver_arguments["User"]="root";
			break;
	}
?>
