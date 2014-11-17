<?php
$lang->setup_title="SOTESHOP";
$lang->setup_homepl_info="User accounts, account name and password in option setting <B>hidden directory</B> should be added to administrative panel for shops installed on HOME.PL servers.";
$lang->setup_start_info="Welcome to the setup program for the internet shop SOTESHOP service.";
$lang->setup_choose_lang="Choose language";
$lang->setup_next="Next";
$lang->setup_license_accept="I accept the licence conditions";
$lang->setup_system_php="PHP option check";
$lang->setup_system_type_title="Choose installation type";
$lang->setup_system_type=array(
                'full'=>"advanced",
                'simple'=>"basic",
                'demo'=>"demo",
                'rebuild'=>"reinstallation",
                'upgrade'=>"upgrade from previous version",
                'join'=>"basic: multi-shop mode",
                );
$lang->setup_system_os_title="Choose operating system";
$lang->setup_system_os=array(
                'linux'=>"Linux",
                'freebsd'=>"FreeBSD",
                'windows'=>"Windows",
                'macosx'=>"Mac OS X",
                );
$lang->setup_system_host_title="Choose the place of installation";
$lang->setup_system_host=array(
                'local'=>"locally",
                'internet'=>"In the internet at the provider's",
                );
$lang->setup_steps=array(
                '0'=>"Start",
                '1'=>"MySQL, FTP data",
                '2'=>"FTP directory",
                '3'=>"Installation completed",
                );
$lang->setup_form_mysql=array(
                'title'=>"Access data to MySQL database",
                'dbhost'=>"database server",
                'dbname'=>"database name",
                'dbuser'=>"base user",
                'dbpass'=>"base access password",
                );
$lang->setup_form_ftp=array(
                'title'=>"Access data to FTP account",
                'ftp_host'=>"FTP server",
                'ftp_user'=>"FTP user",
                'ftp_password'=>"password",
                );
$lang->setup_simple_title="Simplified installation";
$lang->setup_simple_errors=array(
                'dbhost'=>"No entry",
                'dbname'=>"No entry",
                'admin_dbuser'=>"No entry",
                'admin_dbpassword'=>"Check data, unsuccessful connection with database server.",
                'ftp_host'=>"No entry",
                'ftp_user'=>"No entry",
                'ftp_password'=>"Check data, unsuccessful connection with FTP server.",
                'pin'=>"No PIN",
                'pin2'=>"PIN repeated incorrectly",
                'license'=>"Incorrect licence number",
                'license_who'=>"No entry",
                );
$lang->setup_ftp_dir="Choose FTP directory containg the shop";
$lang->setup_ftp_select="Choose directory";
$lang->setup_ftp_dir2="other";
$lang->setup_ftp_dir2_not_found="enter FTP directory";
$lang->setup_ftp_dir_error="Invalid FTP directory. It does not contain the shop.";
$lang->setup_pin_title="Supply shop access information and program licence";
$lang->setup_pin="Enter any PIN";
$lang->setup_pin2="Repeat the PIN";
$lang->setup_pin_info="Remember your PIN!";
$lang->setup_license_nr="Licence number";
$lang->setup_license_who="Company / Person";
$lang->setup_create_db="Creating database structure";
$lang->setup_create_table="Creating table";
$lang->setup_create_table_ok="OK";
$lang->setup_create_table_error="Table exists";
$lang->setup_ftp_save="Data coding";
$lang->setup_crypt=array(
                'ftp'=>"FTP data coding",
                'mysql'=>"Database access data coding",
                'license'=>"Licence data coding",
                'pin'=>"PIN coding",
                'keys'=>"Generating and cryptographic key coding",
                'multi_shop'=>"Multi-shop settings",
                );
$lang->setup_install_complete="<B>Congratulations!</B> <P> The shop has been installed";
$lang->setup_ftp_change="Enter new FTP password";
$lang->setup_ftp_changed="FTP password updated";
$lang->setup_license="Licence";
$lang->setup_errors=array(
                'no_frame'=>"Your web browser does not support frames. Try using Netscape7 or Internet Explorer 5(6).",
                );
?>