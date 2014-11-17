<?php
$lang->available_bar="Product availability management";
$lang->available_menu=array(
                'add'=>'New availability period',
                'list'=>'Availability list',
                'configure'=>'Configuration',
                "deliverers"=>"Store suppliers",
                "availability"=>"Availability",
                "depository"=>"Store",
                'help'=>'Help',
                );
$lang->available_edit="Edit availability properties of the product";
$lang->available_cols=array(
                'name'=>'availability name',
                'user_id'=>'id (availability identifier, integer) ',
                'num_from'=>'Store state from (number)',
                'num_to'=>'Store state to (number or *)',
                );
$lang->available_edit_form_errors=array(
                'name'=>'no availability name',
                'user_id'=>'incorrect value',
                );
$lang->available_add_bar="Add new availability";
$lang->available_export_ok="Availability status list has been exported to the shop";
$lang->available_list=array(
                'name'=>'Name',
                'num_from'=>'State from',
                'num_to'=>'State to',
                );
$lang->error_message['duplicated_from_value'] = "The same beginning of the section has been written in many times.";
$lang->error_message['no_from_zero_entry'] = "No section starting from 0";
$lang->error_message['invalid_interval_boundaries'] = "Store sections overlap or there is a gap between them. The following boundaries are incorrect: ";
$lang->error_message['interval_from_gt_interval_to'] = "The final boundary of the section is smaller than the initial boundary.";
$lang->error_message['duplicated_inf_boundary'] = "At least two sections with * have been introduced";
$lang->error_message['invalid_data_format'] = "Incorrect format of the introduced values";
$lang->error_message['no_to_inf_entry'] = "No section with *";

$lang->error_message['duplicate_depository'] = " The selected product already has its store state.";
$lang->error_message['invalid_product_id'] = "The product with this ID does not exist.";
$lang->error_message['need_to_repair'] = "The above message means that correcting the sections of store states in appropriate availabilities is necessary (see: Help). Otherwise store states will be interpreted incorrectly and the store module will not operate properly.";
$lang->error_message['not_changed'] = "Sections have not been changed.";
$lang->confirm='Approve sections';
$lang->confirm_conf='Approve';
$lang->display_availability="Show in the shop information about product availability";
?>
