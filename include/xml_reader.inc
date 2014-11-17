<?php

/**
 * XML_Reader - parses an xml document into an array of element objects
 *
 * PHP versions 4 and 5
 *
 */


/* requires XML_Element class */
require_once("xml_element.inc");

	
class XML_Reader {

	/* initial variables for parsing operation */
	var $stack = array();
	var $elements = array();
	var $depth = 0;
	var $count = 0;
	var $contents;
	var $xmlstring;
	var $xmlparser;


	/*
     * Processes each node into a node object
     * 
     * @param  xmlparser    $parser    parser object
     * @param  string		$name      name of node
     * @param  array		$attribs   node attributes array
     * 
     */
	function startElementHandler($parser, $name, $attribs)
	{	  
		/* get count - use as id */
		$id = $this->count;
		/* create new element object */
		$this->element = new XML_Element;
		$this->elements[$id] = $this->element;	  
		$this->elements[$id]->name = $name;
	  
		/* assign attributes */
		while(list($key, $value) = each($attribs)) {
			$this->elements[$id]->attributes[$key] = $value;
		}
		/* assign node depth */
		$this->elements[$id]->depth = $this->depth;
	  
		/* push stack and increase depth, count */	  
		array_push($this->stack, $id);
		$this->count++;
		$this->depth++;
	}


	/*
     * finish processing an xml node
     * 
     * @param  xml_parser   $parser    parser object
     * @param  string		$name      name of node
     * 
     */
	function endElementHandler($parser, $name)
	{
		/* pop stack and decrease depth */
		array_pop($this->stack);  
		$this->depth--;
	}


	/*
     * handles CDATA sections
     * 
     * @param  xml_parser   $parser    parser object
     * @param  string		$data      node value
     * 
     */
	function characterDataHandler($parser, $data)
	{
		/* push CDATA into element class */
		$this->elements[$this->stack[count($this->stack)-1]]->data .= $data;
	}


	/*
     * Prints information about all node objects
     * 
	 */
	function printNodeObjects()
	{
		/* print array for each node object */
		for($k = 0; $k < count($this->elements); $k++) {
			print_r(get_object_vars($this->elements[$k]));
			echo "<br/>";
		}
	}


	/*
     * create the parser (UTF-8), read in xml document and parse it
     * 
     * @param  string   $xmlstring     string containing a complete xml document
     * @param  string   $filepath      path to an xml document (default null)
     * @param  integer  $maxreadlen    filesize limit on read (bytes) (default 4096)
     * 
     */
	function startXmlReader($xmlstring, $filepath = null, $maxreadlen = 4096)
	{	
		/* create parser object and set options */
		$this->xmlparser = xml_parser_create("UTF-8");
        xml_set_object($this->xmlparser, $this);  
		xml_parser_set_option($this->xmlparser, XML_OPTION_CASE_FOLDING, 0);
		xml_set_element_handler($this->xmlparser, "startElementHandler", "endElementHandler");
		xml_set_character_data_handler($this->xmlparser, "characterDataHandler");

		/* check if filepath or string passed */
		if ($filepath != null) {
			/* open the file for reading - default encoding */
			if (!($handle = fopen($filepath, "r"))) {
				/* show error on bad read */
				die("<p>Cannot open \"$filepath\".</p>\n</body>\n</html>");
			}

			/* parse file contents during read */
			$this->xmlstring = "";
			while($contents = fread($handle, $maxreadlen)) {
				$this->xmlstring .= $contents;
				xml_parse($this->xmlparser, $contents, feof($handle));
			}
			/* close file handler */
			fclose($handle);
		} else {
			/* just process string */
			$this->xmlstring = $xmlstring;
			xml_parse($this->xmlparser, $xmlstring, true);
		}

		/* free the parser object */		
		xml_parser_free($this->xmlparser);
	}

}

?>
