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
 
abstract class Core_Inlet_Cli extends Core_Inlet
{

	/**
	 *
	 * Constructor.
	 *
	 * @access public
	 * @param array, no default
	 */

	function Core_Inlet_Cli($_request_data)
	{
		parent::Core_Inlet($_request_data);
	}
	
	/**
	 *
	 * Ask for Command Line Input.
	 *
	 * @access public
	 * @return array The intermediate format.
	 */
	protected function get_input()
	{
		$handle = fopen ("php://stdin","r");
		$padded_input = fgets($handle);
		return trim($padded_input);
	}
}
