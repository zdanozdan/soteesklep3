<?php
$lang->offline_record_deleted="Number of deleted records";
$lang->offline_record_updated="Number of updated records";
$lang->offline_record_added="Number of added records";
$lang->offline_size="ATTENTION!!!
The size of the file which has been loaded onto the server equals 0.
If the file you were attaching was not empty, it means that  errors occurred while transferring the file to the server.
Try to send the file once more. If this information appears again, contact the administrator.
<p>
<ul>
<li>If you want to update product base, select the bookmark
<a
href=/go/_offline/_main/><u>price list</u></a>
<li>If you want to introduce the list of product attributes, select the bookmark <a
href=/go/_offline/_attributes/><u>attributes</u></a>
<li> ATTENTION! If you update a price list and attributes, remember about updating order. First you should introduce a new price list, next the list of new attributes.
</ul>";
$lang->offline_no_file="<font color>=red>ATTENTION!
</font>The has not been loaded properly on the server.
Try once again. If the same message appears contact the administrator.
<p>
<ul>
<li> If you want to update product base choose the bookmark
<a
href=/go/_offline/_main/><u>price list</u></a>
<li> If you want to introduce the list of product attributes, choose the bookmark <a
href=/go/_offline/_attributes/><u>attributes</u></a>
<li> ATTENTION!!! If you
update a price list and attributes, you should remember about updating order. First you introduce a new list, next a list of new attributes.
</ul>";
$lang->offline_product_update_info="Product base updating:";
$lang->offline_field="Field";
$lang->offline_record_info="Message";
$lang->offline_record="Record";
$lang->offline_date="Date";
$lang->offline_update_errors="Errors generated during last updating";
$lang->offline_submit_data="Update data";
$lang->offline_continue="Complete interupted updating";
$lang->offline_update_action="I update price list";
$lang->offline_load_all="I load full price list";
$lang->offline_upload_info="Attach the file with pins. The file should contain two columns - in the first column there is denomination, in the second one PIN.";
$lang->offline_menu=array(
                'load'=>"Load pins",
                'update'=>"Update",
                'status'=>"Status",
                'examples'=>"Pin examples",
                );
$lang->offline_legend=array(
                'green'=>"Record loaded properly to the base",
                'blue'=>"Error during data verification",
                'red'=>"Error while loading data to the base",
                'fiol'=>"Records ignored because of limitations in this version of the shop ",
                'sel'=>"Other errors",
                'info'=>"Legend",
                );
$lang->offline_money=array(
                '50'=>"Pins for 50zl",
                '20'=>"Pins for 20zl",
                '10'=>"Pins for 10zl",
                );
$lang->offline_update_error="<font color=red><b>
ERROR!!!</b></font>
While loading the price list errors occurred. Click the bookmark <b>Status</b>
to get the information about errors.";
$lang->offline_update_ok="Price list loaded correctly";
$lang->offline_update="Price list updating";
$lang->offline_category_error=array(
                'category1_load'=>"Error while loading categories to database",
                );
$lang->offline_load_errors=array(
                'not_user_id'=>"If we update a record, user_id must be one of the fields",
                );
$lang->offline_file_errors=array(
                'not_open'=>"Unsuccessful data file opening",
                'less'=>"There are fewer fields in the record than in the structure we are loading data into",
                'more'=>"There are more fields in the record than in the structure we are loading data into",
                'load_ignore'=>"Record has not been loaded because of product limit in this version of the shop",
                'load_database'=>"Error while loading record to the database",
                'error_update'=>"Attempt to update the record which does not exist in the base",
                'error_insert'=>"Attempt to add the record which already exists in the base",
                'error_delete'=>"Attempt to delete the record which does not exist in the base",
                );
$lang->offline_examples_price_list="Download the example of file with pins:<ul>
<li> <a
href=date/pins10zl.csv>Pins for 10zl </a>
<li> <a
href=date/pins20zl.csv>Pins for 20zl </a>
<li> <a
href=date/pins50zl.csv>Pins for 50zl </a>";
$lang->offline_sql_info="<B>ATTENTION!</b><BR>Base will be completed with pins from loaded
<a
href=/go/_offline/_pins/index.php><B><u>";
$lang->offline_check_errors=array(
                'main_key'=>array(
                                '1'=>"Pin contains characters other than digits",
                                '2'=>"Pin is too short",
                                '3'=>"Pin is too long",
                                ),
                                );
?>