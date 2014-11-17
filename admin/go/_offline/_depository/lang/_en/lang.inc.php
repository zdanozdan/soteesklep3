<?php
$lang->offline_file_errors=array(
                'not_open'=>"data file opening unsuccessful",
                'less'=>"There are fewer fields in the record than in structure we load data into",
                'more'=>"There are more fields in the record than in structure we load data into",
                'load_ignore'=>"Record has been not loaded because of product limit in this version of shop",
                'load_database'=>"Error while loading record to database",
                'error_update'=>"Attempt to update the record which does not exist in base",
                'error_insert'=>"Attempt to add the record which already exists in base",
                'error_delete'=>"Attempt to delete the record which does not exist in base",
                'error_struct'=>"ERROR!!! < Incorrect file structure. File has not been loaded",
                'error_file'=>"No file -",
                'no_record'=>"Record with this user_id does not exist in database",
                );
$lang->offline_load_errors=array(
                'not_user_id'=>"If you update record, user_id must be one of fields",
                );
$lang->offline_check_errors=array(
               /* 'command'=>array(
                                '1'=>"There is no information what to do with a record. Field should contain one of the following letters A U D",
                                '2'=>"There is not proper sign in the field (only A U D are allowed)",
                                ),
                                
                'photo'=>array(
                                '1'=>"No photo's name",
                                '2'=>"Bad photo's format (only GIF JPG or PNG are allowed)",
                                ),
                 */               
                'user_id'=>"No user_id field or bad format",
                /*'name'=>"No name or bad format",
                'price_brutto'=>"Bad price format",
                'promotion'=>"Promotion field must contain only 0 1 values or can be empty",
                'newcol'=>"Newcol field must contain only 0 1 values or can be empty",
                'bestseller'=>"Bestseller field must contain only 0 1 values or can be empty",
                'active'=>"Active field must contain only 0 1 values or can be empty",
*/                );
$lang->offline_category_error=array(
                'category1_load'=>"Error while loading categories to database",
                );
$lang->offline_update="Descritption list updating";
$lang->offline_update_ok="Description list has been loaded correctly";
$lang->offline_update_error="Errors while loading price list. Click bookmark <b>Status</b>  to see information about errors";
$lang->offline_legend=array(
                'green'=>"Record loaded correctly to database",
                'blue'=>"Error during data verification",
                'red'=>"Error while loading data to database",
                'fiol'=>"Records ignored because of limitations in this shop version",
                'sel'=>"Other errors",
                'info'=>"Legend",
                );
$lang->offline_menu=array(
                'load'=>"Load  translated product descriptions",
                'update'=>"Update",
                'status'=>"Status",
                'examples'=>"Examples translated product descritptions",
                'config'=>"Configuration",
                'help'=>"Help",
                'export'=>"Descriptions export",
                );
$lang->offline_upload_info="Attach price list file. Save file from Excel with tab as separation character";
$lang->offline_load_all="Load full description list";
$lang->offline_update_action="Update descriptions";
$lang->offline_continue="Finish interrupted updating";
$lang->offline_sql_info="<B> Attention!</B><BR>The data in the database will be replaced with the descriptions from the uploaded file<a href=/go/_offline/index.php><B><u> translated descriptions list file. </u></b></a><BR>After updating you should call  
<a href=/go/_opt/><B><u>optimization button</u></B></a> in order to update category data.";
$lang->offline_submit_data="Update data";
$lang->offline_examples_price_list="Download example of language file:<ul>
<li> <a href=data/lang_en.csv>TXT </a>
</ul>Descritptions lists in sdc,xls and dbf formats require converting to txt files using StarOffice, OpenOffice or Excel programs.";
$lang->offline_update_errors="Errors generated during last update:";
$lang->offline_date="Date";
$lang->offline_record="Record";
$lang->offline_record_info="Message";
$lang->offline_field="Field";
$lang->offline_product_update_info="Shop product database updating:";
$lang->offline_no_file="<font color=red>ATTENTION! Price list file has not been attached";
$lang->offline_size="<font color=red>ATTENTION!!!</font> Size of the file that has been loaded on the server equals 0. If the file you were attaching  is not empty, it means that errors occured while transferirng it to the server.
Try to transfer the file once again";
$lang->offline_record_added="Number of added records";
$lang->offline_record_updated="Number of updated records";
$lang->offline_record_deleted="Number of deleted records";
$lang->offline_update_ok_but="errors during process
Click bookmark <b>Status</b> to see information about errors";
$lang->offline_money=array(
                '50'=>"Pins for 50zl",
                '20'=>"Pins for 20zl",
                '10'=>"Pins for 10zl",
                );
$lang->offline_config=array(
                'option'=>"Updating options",
                'type_file'=>"Imported file type",
                'main_table'=>"Table name",
                );
$lang->offline_no_error="No errors while loading data to database";
$lang->offline_names_column=array(
                'user_id'=>"Product ID",
                'price_brutto'=>"Gross price",
                'xml_description'=>"Product full description",
                'xml_short_description'=>"Product short description",
                'photo'=>"Product photo",
                'flash'=>"Flash photo",
                'flash_html'=>"Flash photo code",
                'pdf'=>"PDF photo",
                'xml_options'=>"Options to product",
                'promotion'=>"Promotional products",
                'newcol'=>"New product",
                'bestseller'=>"Bestseller",
                'main_page'=>"Main page",
                'active'=>"Active",
                'name'=>"Product name",
                'producer'=>"Producer",
                'category1'=>"Category 1",
                'category2'=>"Category 2",
                'category3'=>"Category 3",
                'category4'=>"Category 4",
                'category5'=>"Category 5",
                'id_currency'=>"Currency",
                'vat'=>"VAT rate",
                'price_brutto_detal'=>"Old price",
                'id_available'=>"Availability",
                'price_brutto_2'=>"Wholesale price",
                'hidden_price'=>"Hide the price",
                'discount'=>"Discount",
                'accessories'=>"Accessories",
                'price_currency'=>"Price in currency",
                'max_discount'=>"Maximum discount",
                'onet_category'=>"Onet category",
                'onet_export'=>"Onet export",
                'onet_status'=>"Onet status",
                'onet_image_export'=>"Onet export image",
                'onet_image_desc'=>"Onet description image",
                'onet_image_title'=>"Onet title image",
                'onet_attrib'=>"Onet attribites",
                'google_title'=>"Google title",
                'google_keywords'=>"Google keywords",
                'google_description'=>"Google description",
                'category_multi_1'=>"Product in category 2",
                'category_multi_2'=>"Product in category 3",
                'en_name'=>"Lang 1 name",
                'en_xml_description'=>"Lang 1 description",
                'en_xml_short_description'=>"Lang 1 short description",
                'de_name'=>"Lang 2 name",
                'de_xml_description'=>"Lang 2 description",
                'de_xml_short_description'=>"Lang 2 short description",
                'ask4price'=>"Ask about price",
                );
?>