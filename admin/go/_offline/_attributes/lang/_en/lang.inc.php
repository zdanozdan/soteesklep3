<?php
$lang->offline_file_errors=array(
                'not_open'=>"Unsuccessful data file opening",
                'less'=>"There are fewer fields in record that in structure you load data into.",
                'more'=>"There are more fields in record than in stucture you load data into",
                'load_ignore'=>"Record has not been loaded because of product limit in this version of the shop",
                'load_database'=>"Error while record loading to database",
                'error_update'=>"Attempt to update record which does not exist in base",
                'error_insert'=>"Attempt to add record which already exists in base",
                'error_delete'=>"Attempt to remove record which does not exist in base",
                'no_user_id'=>"Product for which you want to load attributes does not exist in base",
                'file_error'=>"Incorrect file format. Program did not find correct records in the file. Create a file corresponding to the example you can find in the bookmark\" ",
                );
$lang->offline_load_errors=array(
                'not_user_id'=>"If you update record, user_id must be one of fields",
                );
$lang->offline_check_errors=array(
                'id_main'=>"No id_main field or incorrect format",
                'attribute1'=>"No attribute 1",
                );
$lang->offline_category_error=array(
                'category1_load'=>"Error while loading categories to database",
                );
$lang->offline_update="Attribute updating";
$lang->offline_update_ok="Attributes loaded correctly";
$lang->offline_update_error="ERROR!!!</b><font>
Errors while loading attributes.
Click the bookmark <b>Status</b> to see information about errors.
";
$lang->offline_money=array(
                '50'=>"I load full list",
                '20'=>"Pins for 20zl",
                '10'=>"Pins for 10zl",
                );
$lang->offline_legend=array(
                'green'=>"Record loaded correctly to database",
                'blue'=>"Error during data verification",
                'red'=>"Error while data loading to base",
                'fiol'=>"Records ignored because of limits in this version of shop",
                'sel'=>"Other errors",
                'info'=>"Legend",
                );
$lang->offline_menu=array(
                'load'=>"Load attributes",
                'update'=>"Update",
                'status'=>"Status",
                'examples'=>"Attribute file example",
                'export'=>"Data export to shop",
                'doc'=>"Documentation",
                'help'=>"Help",
                );
$lang->offline_upload_info="Attach attribute file. File should contain at least 2 columns.";
$lang->offline_load_all="I load all attributes";
$lang->offline_update_action="I update attributes";
$lang->offline_continue="Finish interrupted updating";
$lang->offline_sql_info="<B> ATTENTION!</B><BR>Base will be filled with data from
<a href=/go/_offline/_attributes/index.php>loaded file</a><B><u>";
$lang->offline_doc="Attribute module documentation";
$lang->offline_submit_data="Update data";
$lang->offline_examples_price_list="Download example of attribute file: <ul>
<li> <a
href=data/attributes_excel.txt>Attributes</a>
";
$lang->offline_examples_doc="Download documentation file:<ul>
<li> <a
href=data/attributes.pdf>Documentation
";
$lang->offline_update_errors="Errors generated during last updating";
$lang->offline_date="Date";
$lang->offline_record="Record";
$lang->offline_record_info="Message";
$lang->offline_field="Field";
$lang->offline_product_update_info="Attribute updating";
$lang->offline_no_file="ATTENTION!!!
File has not been loaded on the server";
$lang->offline_size="ATTENTION!!!
Size of file which has been loaded on the server equals 0.
If the file you were attaching is not empty, it means that errors occured while transferring it to the server.";
$lang->offline_record_added="Number of added records";
$lang->offline_record_updated="Number of updated records";
$lang->offline_record_deleted="Number of deleted records";
$lang->attributes_export="Attribute export";
$lang->attributes_export_ok="Attribute export finished correctly";
$lang->offline_no_error="No errors while loading data to database";
?>