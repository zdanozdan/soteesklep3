<?php
global $search_form_tree, $DOCUMENT_ROOT, $sess, $_SESSION, $js_code;

include_once("../../../config/tmp/adv_search_form_config.php");

function getNodeCode($node, $level = 1) {
    $code = '';
    while (list($key, $val) = each($node)) {
        $cat_id = $key;
        $cat_name = LangF::translate($val['name']);
        $indent = str_repeat('    ', $level);
        $node_name = "c_$level";
        $prev_level = $level - 1;
        if($prev_level == 0) {
            $parent_node_name = "c_root";
        }
        else {
            $parent_node_name = "c_" . $prev_level;
        }
        $code .= $indent . "$node_name = $parent_node_name.addCategoryChild($cat_id, \"$cat_name\", false);\n";
        if(!empty($val['children'])) {
            $code .= getNodeCode($val['children'], $level + 1);
        }
    }
    return $code;
}

$js_code = getNodeCode($search_form_tree);
?>