<?php
$lang->upgrade_title="Automatic program upgrading";
$lang->upgrade_get_info="Attach shop upgrading";
$lang->upgrade_file_uploaded="Package upgrade file has been attached";
$lang->upgrade_files="List of updated files";
$lang->upgrade_done="Upgrading completed";
$lang->upgrade_pkg=array(
                '1.01'=>"Enter upgrading marked with number 30003 into the shop. This upgrading is necessary if you want to install next improvements in the shop. ",
                );
$lang->upgrade_checksums_upgrade_error="Unsuccessful control sum base updating";
$lang->upgrade_checksums_upgraded="Control sum base has been updated";
$lang->upgrade_file_status=array(
                '2'=>"Ignored. Disk version is newer than update version. ",
                '1'=>"File has not been updated. Customer modification has been detected.",
                '3'=>"Ignored. Individual modification file",
                '4'=>"Approved in previous updating",
                );
$lang->upgrade_file_status_simulation=array(
                '2'=>"Test: Disk version is newer than update version. ",
                '1'=>"Test: Customer modification has been detected.",
                '3'=>"Test: Individual modification file",
                '4'=>"Test: Approved in previous updating",
                );
$lang->upgrade_name_theme="Theme name for updating";
$lang->upgrade_25_description="Version updating 2.5->3.0";
$lang->upgrade_25_error="Data has not been updated";
$lang->upgrade_25_done="Data has been updated";
$lang->upgrade_25_menu=array(
                'order'=>"Update transaction data from version 2.5->3",
                'users'=>"Update customer data from version 2.5->3.0",
                'themes'=>"Update version theme 2.5->3.0",
                );
$lang->upgrade_prev="Upgrading installed in the shop";
$lang->upgrade_updates="Install upgrades";
$lang->upgrade_check_new="Check available upgrades";
$lang->upgrade_nomd5_info="No control sum base of the program";
$lang->upgrade_md5_install="Load base";
$lang->upgrade_md5_installed="Contrtol sum base installed";
$lang->upgrade_md5_continue="Move to upgrading system";
$lang->upgrade_to_install="Upgrade packets available to be installed (packet available on the page <a
href=http://service.soteshop.com>http://service.soteshop.com</a>)";
$lang->upgrade_check_new_version_title="Available upgrades check";
$lang->upgrade_new_not_found="At the moment all upgrades available for the version are installed in the shop.<br />
There are no new upgrades. ";
$lang->upgrade_database_updated="Database has been updated";
$lang->upgrade_diff_title="Automatic connection of changes in file with changes in update packet";
$lang->upgrade_file_repair="Analyse/Connect changes";
$lang->upgrade_file_not_found="No file data";
$lang->upgrade_file=array(
                'path'=>"File version on a disk",
                'upgrade'=>"File version in an update packet",
                'diff'=>"<b>File from a disk with modifications from update packet</b>",
                );
$lang->upgrade_diff_patch="Detected differences/preview";
$lang->upgrade_unknown_gid="No GID number. Graphic files have not been updated";
$lang->upgrade_individual_mod="individual modification";
$lang->upgrade_error_ext="Wrong file format";
$lang->upgrade_wrong_format="Error: Unknown version: wrong patch format.";
$lang->upgrade_devel_config="Configuration for DEVELOPERS";
$lang->upgrade_modified="Modified";
$lang->upgrade_diff_file_upgraded="File saved and it will be installed during this session together with package installation.<br> Attention! After logging out repeat the operation of connecting changes.";
$lang->upgrade_files_list="List of files in upgrade package";
$lang->upgrade_files_simulation="Result of simulated installation of upgrade package. Control sum verification.";
$lang->upgrade_already_installed="Package installed";
$lang->upgrade_wrong_pkg_number="Incorrect package number. Packages should be installed in correct order";
$lang->upgrade_legend_title="Legend";
$lang->upgrade_legend=array(
                '0'=>"Correct file",
                '1'=>"Modified file",
                '2'=>"File on disc is newer than file from upgrading",
                '3'=>"Modified file, individual modification",
                '4'=>"Modified file, approved during previous upgrading",
                'repair'=>"File modification edit. <b> Option only for advanced PHP programmers",
                );
$lang->upgrade_update="Install upgrade";
$lang->upgrade_update_not_allowed="System found conflicts in files. Upgrade cannot be installed.";
$lang->upgrade_hard_install="Ignore conflicts. Install files from upgrade package.";
$lang->upgrade_terms="<B>ATTENTION!</B>
<OL>
<LI>Upgrade installation will cause overwriting these files in which 
modification in relation to the original file version was found.
<LI>It can cause disappearance of changes individually introduced to the file.
In order to connect changes, after installing the package they should be introduced
once again (the system will copy files from the shop).
<LI>Quarantee DOES NOT COMPRISE introducing individual changes to files
installed from the upgrade package.
</OL>";
$lang->upgrade_file_info="The system tested automatic connection of changes introduced in the upgrade package with changes individually introduced to a given file.<BR>
<B>ATTENTION!</B>
<OL>
<LI>Make a copy of the file being installed in order to ensure the possibility of restoring the original version.
<LI>Quarantee DOES NOT COMPRISE installation of changes. If you are not sure about connected changes, DO NOT INSTALL the file.
<LI>Quarantee DOES NOT COMPRISE introducing individual changes to files installed from the upgrade package.
</OL>";
$lang->upgrade_accept="Accept";
$lang->bugs_download_source="Look through the file to be installed (with connected changes)";
$lang->bugs_download_diff_result="Look through the differences found between the package file and the original version.";
$lang->upgrade_repo_not_exists="Changes cannot be connected automatically. No repositorium of the version. Information has been sent to the administrator. Try later.";
$lang->upgrade_info_code="Optional code";
$lang->upgrade_code_error="Incorrect package activating code.";
$lang->upgrade_error_save_pkg="Package cannot be saved in ./admin/upgrade";
$lang->upgrade_img="[IMG]";
?>
