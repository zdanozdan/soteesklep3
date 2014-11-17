<?php
global $intervals;
global $mdbd;

reset($intervals);

while (list($user_id, $val) = each($intervals)) {
    $from = $val['from'];
    $to = $val['to'];
    $mdbd->update("available","num_from=?, num_to=?", "user_id=?", array('1,' . $from => "text", '2,' . $to => "text", '3,' . $user_id => "int"));
}
?>