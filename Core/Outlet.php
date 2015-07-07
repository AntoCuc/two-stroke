<?php

/**
 *
 * Process intermediate and transform it in arbitrary format.
 *
 * PHP version 5
 *
 * @author Antonino Cucchiara <antonio_cuc@yahoo.co.uk>
 * @license http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 */

class Core_Outlet
{

	/**
	 *
	 * The response data to send to the browser.
	 *
	 * @access private
	 * @var array
	 */

	var $rendering_data = array();

	/**
	 *
	 * Constructor.
	 *
	 * @access public
	 * @param array, no default. 
	 */

	function Core_Outlet($_rendering_data)
	{
		$this->rendering_data = $_rendering_data;
		
		if(DEBUG)
		{
			echo "Outlet: "; 
			print_r($this->rendering_data);
		}
	}

	/**
	 *
	 * Returns the arbitrary format based on the intermediate.
	 *
	 * @access public
	 * @param array The response data.
	 * @return void
	 */

	function render($response_data)
	{
	}
	
}
