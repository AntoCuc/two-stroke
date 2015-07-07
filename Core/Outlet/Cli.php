<?php

/**
 *
 * Renders pages to the Cli format.
 *
 * PHP version 5
 *
 * @author Antonino Cucchiara <antonio_cuc@yahoo.co.uk>
 * @license http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 */

class Core_Outlet_Cli extends Core_Outlet
{

	/**
	 *
	 * Constructor.
	 *
	 * @access public
	 * @param array, no default
	 */

	function Core_Outlet_Cli($_request_data)
	{
		parent::Core_Outlet($_request_data);
	}
	
	/**
	 *
	 * Returns the Intermediate format based on the request.
	 *
	 * @access public
	 * @return void
	 */
	
	function render($_response_data)
	{
		include "Cli/Display.php";
	}
	
}