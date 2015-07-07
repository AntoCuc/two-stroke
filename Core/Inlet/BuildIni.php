<?php

/**
 *
 * Builds initialisation scripts.
 *
 * PHP version 5
 *
 * @author Antonino Cucchiara <antonio_cuc@yahoo.co.uk>
 * @license http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 */

class Core_Inlet_BuildIni extends Core_Inlet_Cli
{

	/**
	 *
	 * Constructor.
	 *
	 * @access public
	 * @param array, no default
	 */

	function Core_Inlet_BuildIni($_request_data)
	{
		parent::Core_Inlet_Cli($_request_data);
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
	
		/**
		 * The file name.
		 */
		
		echo "Enter a file name... [default.ini] \n";
		$file_name = parent::get_input();
		
		
		if($file_name == "")
		{
			$file_name = 'default.ini';
		}
		
		/**
		 * The output content.
		 */
		
		$ini_content = ';This ini file was generated on ' . date("F j, Y, g:i a") . "\n";
		
		/**
		 * The Ini file sections.
		 */
		 
		$sections = array();
		
		/**
		 * Gather the section names.
		 */
		 
		while(true)
		{
			echo "Enter a section name [done]... \n";
			$section_name = parent::get_input();
			if($section_name != "")
			{
				$sections[$section_name] = array();
			}
			else
			{
				break;
			}
		}
		
		/**
		 * Create the property fields and values.
		 */
		 
		foreach($sections as $section_name => $values)
		{
			while(true)
			{
				echo 'Enter a property name for section ' . $section_name . ' [done]...';
				$property_name = parent::get_input();
				if($property_name != "")
				{
					echo 'Enter a property value for property ' . $property_name . '...';
					$property_value = parent::get_input();
					$sections[$section_name][$property_name] = $property_value;
				}
				else
				{
					break;
				}
			}
		}
		
		/**
		 * Create the file content.
		 */
		foreach($sections as $section_name => $values)
		{
			$ini_content .= '[' . $section_name . "]\n";
			foreach($sections[$section_name] as $property_name => $property_value)
			{
				$ini_content .= $property_name . '=' . $property_value . "\n";
			}
		}
		
		$result = file_put_contents($file_name, $ini_content);
		if($result === false)
		{
			$output = "Failed to create the Ini file. Below the generated content to manually create the file\n" . $ini_content;
		}
		else
		{
			$output = 'Ini file ' . $file_name . ' created successfully';
		}
		
		return $output;
	}
	
}