<?php
$lang->offline_record_deleted="Number of deleted records";
$lang->offline_record_updated="Number of updated records";
$lang->offline_record_added="Number of added records";
$lang->offline_size="ATTENTION!!!
Size of file that has been loaded on the server equals 0.
If the file you were attaching is not empty, it means that errors occurred while transferring it to the server.
Try to transfer the file once again.
If this information appears once more, contact the administrator.
<p>
<ul>
<li> If you want to update product database, choose the bookmark 
<a
href=/go/_offline/_main/><u>pricelist</u></a>
<li> If you want to enter attribute list for products choose the bookmark <a
href=/go/_ooline/_attributes/><u>attributes</u></a>
ATTENTION!!! If you update price list and attributes, you have to remember about updating order. First you enter new price list and then new attribute list.
</ul>/=/";
$lang->offline_no_file="ATTENTION!!! File has not been correctly loaded on the server.
Try once again. If the same information appears, contact the administrator.
<p>
<ul>
<li> If you want to update product database, choose the bookmark
<a
href=/go/_offline/_main/><u>price list</u></a>
<li>If you want to enter attribute list for products, choose the bookmark <a
href=/go/_offline/_attributes/><u>attributes</u></a>
<li>ATTENTION!
If you update price list and attributes, remember about updating order. First enter new price list and then new attribute list.
</ul>
";
$lang->offline_product_update_info="Shop product base updating";
$lang->offline_field="Field";
$lang->offline_record_info="Message";
$lang->offline_record="Record";
$lang->offline_date="Date";
$lang->offline_update_errors="Errors generated during last updating";
$lang->offline_examples_price_list="Download an exemplary file containing pins:<ul>
<li><a
href=date/pins10zl.csv>Pins for 10 zl</a>
<li> <a
href=date/pins20zl.csv.>Pins
for 20zl</a>
<li> <a
href=date/pins50zl.csv>Pins for 50zl <a/>";
$lang->offline_sql_info="<B>ATTENTION!</B><BR>Base will be completed with pins from
<a
href=/go/_offline/_pins/index.php><B><u>of loaded file. </u></b></a>
";
$lang->offline_submit_data="Update data";
$lang->offline_continue="Finish interrupted updating";
$lang->offline_update_action="I update price list";
$lang->offline_load_all="I load full price list";
$lang->offline_upload_info="Attach the file containing pins. The file should contain two columns - the first column contains the value, the second PIN.";
$lang->offline_menu=array(
                'load'=>'Load pins',
                'update'=>'Update',
                'status'=>'Status',
                'examples'=>'Examples of pins',
                );
$lang->offline_legend=array(
                'green'=>'Record correctly loaded to base',
                'blue'=>'Error during data verification',
                'red'=>'Error while loading data to database',
                'fiol'=>'Records ignored because of limitations in this version of the shop',
                'sel'=>'Other errors',
                'info'=>'Legend',
                );
$lang->offline_money=array(
                '50'=>'Pins for 50zl',
                '20'=>'Pins for 20zl',
                '10'=>'Pins for 10zl',
                );
$lang->offline_update_error="<font color=red><b>
ERRORR!!!</b></font>
Errors occurred while loading the price list. Click the bookmark <b>Status</b>to get information about errors";
$lang->offline_update_ok="Price list has been loaded correctly";
$lang->offline_update="Price list updating";
$lang->offline_category_error=array(
                'category1_load'=>'Error occurred while loading categories to database',
                );
$lang->offline_load_errors=array(
                'not_user_id'=>'If you update record, user_id must be one of the fields',
                );
$lang->offline_file_errors=array(
                'not_open'=>'Unsuccessful attempt to open data file',
                'less'=>'There are fewer fields in the record than in the structure we are loading data into',
                'more'=>'There are more fields in the record than in the structure we are loading data into',
                'load_ignore'=>'Record has not been loaded because of product limit in this version of the shop',
                'load_database'=>'Error occurred while loading record to database',
                'error_update'=>'Attempt to update record which does not exist in database',
                'error_insert'=>'Attempt to add record which already exists in database',
                'error_delete'=>'Attempt to delete record which does not exist in database',
                );
$lang->offline_check_errors=array(
                'user_id_main'=>'You trying to downlowd PINs whose face value is different from what you have marked',
                'main_key'=>array(
                                '1'=>'PIN contains signs different than digits',
                                '2'=>'PIN is too short',
                                '3'=>'PIN is too long',
                                ), );
?>
