<?php

/**
 *
 * Process server requests and render an arbitrary format response.
 *
 * PHP version 5
 *
 * @author Antonino Cucchiara <antonio_cuc@yahoo.co.uk>
 * @license http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 */

/**
 * The baseline Inlet class.
 */

require_once dirname(__FILE__).'/Core/Inlet.php';

/**
 * The CLI inlet class
 */
 
if(CLI)
{
	require_once dirname(__FILE__).'/Core/Inlet/Cli.php';
}

/**
 * The baseline Outlet class.
 */

require_once dirname(__FILE__).'/Core/Outlet.php';

/**
 *
 * Process server requests and render a response in an arbitrary format.
 *
 * This is the "master" class to handle the user requests.
 *
 * @author Antonino Cucchiara <antonio_cuc@yahoo.co.uk>
 * @license http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 */

class Core
{

	/**
	 * 
	 * The request data sent to the script.
	 *
	 * The 'action' determines what Inlet processes the request.
	 *
	 * @access public
	 * @var array
	 */

	var $request_data = array();

	/**
	 * Constructor.
	 *
	 * @access public
	 * @param  array, no default
	 * @see data format at request declaration
	 */

	function Core($_request_data)
	{
		/**
		 *
		 * If the action is supported, load the request data
		 * else print an error.
		 *
		 */
		
		if(DEBUG)
		{
			echo "Core: \n"; 
			print_r($_request_data);
		}
		$this->request_data = $_request_data;
	}

	/**
	 *
	 * Process a request and provide a response.
	 *
	 * @access public
	 * @return void
	 */

	public function process()
	{
		$page_data = $this->_process_request();
		$this->_process_response($page_data);
	}

	/**
	 *
	 * Returns an intermediate format by processing the request 
	 * using an action-based Inlet.
	 *
	 * @access private
	 * @return array intermediate format.
	 */

	private function _process_request()
	{
		$inlet = $this->_get_inlet_processor();
		return $inlet->parse();
	}

	/**
	 *
	 * Returns an arbitrary format by processing the intermediate
	 * using a rendering Outlet.
	 *
	 * @access private
	 * @param  array The response data.
	 * @return String The response.
	 */

	private function _process_response($page_data)
	{
		$outlet = $this->_get_outlet_processor();
		return $outlet->render($page_data);
	}

	/**
	 * 
	 * Returns an object of Inlet type.
	 *
	 * @access private
	 * @return Object The processor (Inlet)
	 */
	
	private function _get_inlet_processor()
	{
		/**
		 * The processor file name.
		 */
		 
		$processor_file_name = $this->_build_processor_file_name('Core_Inlet');
		
		return $this->_get_processor($processor_file_name);
		
	}
	
	/**
	 * 
	 * Returns an object of Outlet type.
	 *
	 * @access private
	 * @return Object The processor (Outlet)
	 */
	
	private function _get_outlet_processor()
	{
		/**
		 * The processor file name.
		 */
		 
		$processor_file_name = $this->_build_processor_file_name('Core_Outlet');
		
		return $this->_get_processor($processor_file_name);
		
	}
	
	/**
	 *
	 * Determine whether an action is defined.
	 *
	 * @access private
	 * @return boolean
	 */
	 
	private function _an_action_is_defined()
	{
		return array_key_exists('action', $this->request_data);
	}
	
	/**
	 * Determine whether the processor exists.
	 *
	 * @access private
	 * @return boolean
	 */
	 
	private function _the_processor_exists($processor_name)
	{
		/**
		 * Create the processor file path.
		 */
		 
		$file_path = $this->_build_processor_file_path($processor_name);
		
		/**
		 * Does the processor class file exist.
		 */
		
		return file_exists($file_path);
		
	}
	
	/**
	 * Build the processor file path.
	 *
	 * @access private
	 * @return string the processor file path
	 */
	 
	private function _build_processor_file_path($processor_name)
	{
		/**
		 * Create the processor file relative path.
		 */
		 
		$file_relative_path = str_replace("_", "/", $processor_name) . ".php";
		
		/**
		 * Create the processor absolute path.
		 */
		 
		return dirname(__FILE__) . "/" . $file_relative_path;

	}
	
	/**
	 * Build the processor file name.
	 *
	 * @access private
	 * @return string the processor file name
	 */
	 
	private function _build_processor_file_name($default_name)
	{
		/**
		 * Check whether the processor name is defined.
		 */
		if(! isset($this->request_data['action']))
		{
			return $default_name;
		}
	
		/**
		 * The processor file name based on action.
		 */
		 
		$processor_file_name = $default_name . '_' . ucfirst($this->request_data['action']);
		
		/**
		 * Check whether the processor file exists.
		 */
		 
		if($this->_the_processor_exists($processor_file_name))
		{
			return $processor_file_name;
		}
		
		/**
		 * Use the default processor.
		 */
		 
		else
		{
			return $default_name;
		}
	}
	
	/**
	 * 
	 * Returns an object of either Inlet or Outlet type.
	 *
	 * @access private
	 * @return Object The processor (Inlet or Outlet)
	 */
	
	private function _get_processor($processor)
	{
		if(DEBUG)
		{
			echo 'Initialising Processor: ' . $processor . "\n";
		}
		
		/**
		 * Include the processor class file.
		 */
		 
		$file_absolute_path = $this->_build_processor_file_path($processor);
		require_once $file_absolute_path;
		
		/**
		 * Initialise the processor.
		 */
		 
		return new $processor($this->request_data);
	}
	
}
