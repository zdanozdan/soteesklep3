<?php
global $search_form_tree, $DOCUMENT_ROOT, $sess, $_SESSION, $js_code;

include("config/tmp/category.php");

function parseTree($cat, $nestLevel=1)
{
	$code='';

	$node_name = "c_$nestLevel";
	$prev_level = $nestLevel - 1;

	foreach ($cat as $key=>$val)
	{
		// jesli klucz jest liczba sprawdz czy jest to podkategoria z kolejnym poziomem zaglebienia
		if (is_numeric($key))
		{
			if (is_array($val))
			{
				// w przypadku kolejnego poziomu zaglebienia przekaz dalej
				$code .= parseTree($val, $nestLevel);
			}
			else
			{
				$parent_node_name = "c_" . $prev_level;
				// w przypadku braku kolejnego poziomu wyswietl podkategorie
				$cat_id=explode("_",$val);
				$cat_name = LangF::translate($key);
				// w przypadku braku kolejnego poziomu wyswietl podkategorie
				$code .= "$node_name = $parent_node_name.addCategoryChild(".end($cat_id).", \"$cat_name\", false);\n";
			}
		}
		else
		if (is_array($val))
		{
			if (array_key_exists("elements",$val)) {
				$count=count($val["elements"]);
			}
			else {
				$count = 0;
			}

			if ($nestLevel==1) {
				$parent_node_name = "c_root";
			} else {
				$parent_node_name = "c_" . $prev_level;
			}

			$cat_name = LangF::translate($val['name']);
			$cat_id=explode("_",$key);
				
			$code .= "$node_name = $parent_node_name.addCategoryChild(".end($cat_id).", \"$cat_name\", false);\n";

			if ($count)
			{
				$code .= parseTree($val["elements"], $nestLevel+1);
			}
		}
		else
		{
			$parent_node_name = "c_" . $prev_level;
			$cat_id=explode("_",$val);
			$cat_name = LangF::translate($key);
			// w przypadku braku kolejnego poziomu wyswietl podkategorie
			$code .= "$node_name = $parent_node_name.addCategoryChild(".end($cat_id).", \"$cat_name\", false);\n";
		}
	}
	return $code;
}

$js_code = parseTree($__category);
?>