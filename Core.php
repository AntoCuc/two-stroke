<?php

require_once dirname(__FILE__) . '/Core/Exceptions/ProcessorNotFoundException.php';

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
			echo "Core: "; 
			print_r($_request_data);
		}
		$this->request_data = $_request_data;
	}

	/**
	 *
	 * Prints the arbitrary format to the screen.
	 *
	 * @access public
	 * @return void
	 */

	public function process()
	{
		$page_data = $this->_process_request();
		$this-> _process_response($page_data);
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
		 * If an action has been defined.
		 */
		
		if(array_key_exists('action', $this->request_data))
		{
			$processor = 'Core_Inlet_' . ucfirst($this->request_data['action']);
		}
		
		/**
		 * Use the default Inlet processor.
		 */
		
		else
		{
			$processor = 'Core_Inlet';
		}
		
		return $this->_get_processor($processor);
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
		 * If a render preference has been defined.
		 */
		
		if(array_key_exists('render', $this->request_data))
		{
			$processor = 'Core_Outlet_' . ucfirst($this->request_data['render']);
		}
		
		/**
		 * Use the default Outlet processor.
		 */
		 
		else
		{
			$processor = 'Core_Outlet';
		}
		
		return $this->_get_processor($processor);
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
		/**
		 * Create the processor file relative path.
		 */
		 
		$file_relative_path = str_replace("_", "/", $processor) . ".php";
		
		/**
		 * Create the processor absolute path.
		 */
		 
		$file_absolute_path = dirname(__FILE__) . "/" . $file_relative_path;
		
		/**
		 * Does the processor class file exist.
		 */
		
		if(DEBUG)
		{
			echo "Loading: " . $file_absolute_path . " ..";
		}
		if(file_exists($file_absolute_path))
		{
			require_once($file_absolute_path);
			
			if(DEBUG)
			{
				echo ". Done.\n";
			}
			
			return new $processor($this->request_data);
		}
		
		/**
		 * The Processor does not exist.
		 */
		
		else
		{
			if(DEBUG)
			{
				echo ". Fail.\n";
			}
			
			throw new ProcessorNotFoundException();
		}
	}
}
