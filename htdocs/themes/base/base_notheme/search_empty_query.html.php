<?php
/**
 * Skrypt wywolywany jesli wynik wyszukwiania rekordow zwrocil wartosc 0
 *
 * \@depend include/dbedit_list.inc
 */
?>


<div class="alert alert-block">

<?php
global $lang;
global $_REQUEST;
global $__new_search_action;


if (! empty($_REQUEST['search_query_words'])) {
    $search_query_words=$_REQUEST['search_query_words'];
} else $search_query_words='';

//if (empty($this->empty_list_message)) {
 //  print $lang->search_empty_list;
//} 

?>

<span id="empty_search">
  <?php echo $lang->empty_query_start; ?>:
  <span id="red"><?php echo $search_query_words; ?></span>.
  <?php echo $lang->empty_query_end; ?>
</br>
</span>
</div>