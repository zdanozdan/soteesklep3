<?php
$lang->inteligo_ip_bad="connection from unentitled address";
$lang->inteligo_https_bad="connection to the page only by https protocol";
$lang->inteligo_no_files_trn="file is inappropriately loaded ";
$lang->inteligo_no_files_open="file could not be opened";
$lang->inteligo_files_bad_ext="wrong extension of the file";
$lang->inteligo_files_upload_ok="file uploaded properly ";
$lang->inteligo_file_bad_down="no name of the file to be downloaded";
$lang->inteligo_file_exists="file already exists on the server";
$lang->inteligo_files_bad_upload="file has not been uploaded properly";
$lang->pay_status=array(
                '401'=>'<font color=red>
                                Transaction conducted by Inteligo
                                ',
                '451'=>'<font color=red>
                                Transaction being confirmed has a status diffrent from 0 (zero)
                                </font>',
                '452'=>'<font color=red>
                                Transaction is not registered in the table order_register
                                </font>',
                '453'=>'<font color=red>
                               Transaction is not registered in in the Inteligo table or there are more transactions than one
                                </font>',
                );
?>