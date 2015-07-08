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
 * The baseline Core class.
 */

require dirname(__FILE__).'/Core.php';

/**
 * The script run environment.
 */
 
define('CLI', PHP_SAPI === 'cli');

/**
 * The script run mode.
 */
 
define('DEBUG', true);

/**
 *
 * Process server requests and render a response in an arbitrary
 * format.
 *
 * This is the "master" class to handle all user requests.
 *
 * @author Antonino Cucchiara <antonio_cuc@yahoo.co.uk>
 * @license http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 */

class Index
{

	/**
	 * 
	 * The request data sent to the browser.
	 *
	 * The 'action' determines which Inlet processes the request.
	 *
	 * @access public
	 * @var array
	 */

	var $request_data = array();

	/**
	 * Contructor.
	 *
	 * @access public
	 * @param  array, no default
	 * @see data format at request declaration
	 */

	function Index($_request)
	{
		if(DEBUG)
		{
			echo "Request: "; 
			print_r($_request);
		}
		
		$this->request_data = $_request;
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
		$core = new Core($this->request_data);
		$core->process();
	}
}

/**
 *
 * Attempt to process the request.
 *
 */

try
{
	$request_data = array();
	
	/**
	 * Are we running the script from the command line.
	 */
	 
	if(CLI)
	{
		/**
		 * The script arguments.
		 */
		 
		$args = getopt("", array('action:', 'data:'));
		
		/**
		 * Has an action been defined.
		 */
		 
		if(isset($args['action']))
		{
			$request_data['action'] = $args['action'];
			unset($args['action']);
		}
		
		/**
		 * No action defined.
		 */
		 
		else
		{
			if(DEBUG)
			{
				echo "Warning: No action defined. Usage: index.php --action=<action>\n";
			}
		}
		
		/**
		 * Load the script arguments.
		 */
		 
		$request_data['args'] = $args;

	}
	
	/**
	 * We are running in a browser.
	 */
	 
	else
	{
		
		/**
		 * Has an action been defined.
		 */
		 
		if(isset($_GET['action']))
		{
			$request_data['action'] = $_GET['action'];
		}
		
		/**
		 * No action defined.
		 */
		 
		else
		{
			if(DEBUG)
			{
				echo "Warning: No action defined. <br/>Usage: index.php?action=&lt;action&gt;<br/>";
			}
		}
		
		/**
		 * Load the page data.
		 */
		 
		$request_data['data']['get'] = $_GET;
		$request_data['data']['post'] = $_POST;

	}
	
	$index = new Index($request_data);
	$index->process();
	
}

/**
 * Could not find the Processor.
 */

catch(ProcessorNotFoundException $e)
{
	echo "The processor could not be found.\n";
	die();
}

?>
