<?php

/**
 * XML_Element - represents XML node data
 *
 * PHP versions 4 and 5
 *
 */


class XML_Element {

	/* XML node data */
	var $name = '';
	/* attributes for nodes are stored in an array - empty array means no attributes */
	var $attributes = array();
	var $data = '';
	/* depth relative to root */
	var $depth = 0;
}

?>
