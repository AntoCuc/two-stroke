<?php

/**
 *
 * Process server request and transform in intermediate format.
 *
 * PHP version 5
 *
 * @author Antonino Cucchiara <antonio_cuc@yahoo.co.uk>
 * @license http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 */

class Core_Inlet
{

	/**
	 *
	 * The request data sent to the browser.
	 *
	 * @access private
	 * @var array
	 */

	var $request_data = array();

	/**
	 * Constructor.
	 *
	 * @access public
	 * @param array, no default.
	 */

	function Core_Inlet($_request_data)
	{
		$_request_data = $this->sanity_check_input($_request_data);
		$this->request_data = $_request_data;
		
		if(DEBUG)
		{
			echo "Inlet: "; 
			print_r($this->request_data);
		}
	}

	/**
	 *
	 * Return the intermediate format based on the request.
	 *
	 * @access public
	 * @return array The intermediate format.
	 */

	function parse()
	{
	}

	/**
	 *
	 * Returns the sanitised input array.
	 *
	 * @access public
	 * @return array The sanitised array
	 */

	function sanity_check_input($input_data = array())
	{
		$output_data = array();
		foreach($input_data as $key => $value)
		{
			if($key != '')
			{
				if($value == null)
				{
					$value = '';
				}
				$output_data[$key] = $value;
			}
		}
		return $output_data;
	}
	
}
