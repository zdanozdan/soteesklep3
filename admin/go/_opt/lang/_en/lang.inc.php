<?php
$lang->opt_info="Optimization system is intended to proccess shop data in such a way that your shop will work fast and effectively.";
$lang->opt_select_action="Choose optimization type";
$lang->opt_buttons=array(
                'category'=>'Categories',
                'producers'=>'Producers',
                'category_producers'=>'Categories and producers',
                );
$lang->opt_description=array(
                'category'=>'Update category list. This option should be called if changes were made in product categories, e.g. a new category has been added or deleted, categor names have been changed',
                'producers'=>'Update producer list. This option should be called if changes were made in producers, e.g. new producer has been added or deleted, a producers name has been changed',
                'category_producers'=>'Update category and producer lists (this option replaces calling the two above-mentioned options).',
                );
$lang->opt_ok="Optimization finished: 100%<BR>
<P>
<div align=left>
<OL>
 <LI> Categories have been updated
 <LI> Producer lists have been updated
</OL>
</div>
";
$lang->opt_category_ok="Optimization finished: 100%<BR><B>Categories have been updated</B>";
$lang->opt_producers_ok="Optimization finished: 100%<BR><B>Producers have been updated</B>";
$lang->opt_menu=array(
                'help'=>'Help',
                );
$lang->error_category_tree="Optimization finished with an error: incorrect category data.
System made an auto-repair.
Try to call optimization once again";
?>