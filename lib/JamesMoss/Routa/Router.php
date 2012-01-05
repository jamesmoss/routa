<?php

namespace JamesMoss\Routa;

/**
 * Router
 *
 * Takes a URL and routes it to a controller
 * 
 * @author James Moss <email@jamesmoss.co.uk>
 */
class Router
{
	/**
	 * Holds the request obj
	 *
	 * @var Request
	 */
	protected $_request = null;
	
	/**
	 * An array of the route regexes
	 *
	 * @var array
	 */
	protected $_routes = array();
	
	/**
	 * Name of the controller for this URL
	 *
	 * @var string
	 */
	protected $_controllerName;
	
	/**
	 * Constructor
	 *
	 * @author James Moss
	 * @param $url
	 * @return		
	 */
	public function __construct($url, $method = '*')
	{
		// Validate the method
		if($method != '*' && !$this->isValidHttpMethod($method)) {
			throw new \InvalidArgumentException('Invalid HTTP method: '.$method);
		}

		$this->_request = (object)array(
			'url'	=> $url,
			'method'=> strtoupper($method),
		);
	}
	
	/**
	 * Returns the route name for this URL
	 *
	 * @author James Moss
	 * @return Route
	 */
	public function getRoute()
	{
		return $this->_route;
	}

	public function add($route, $action = null)
	{
		if(is_string($route)) {
			$route = new Routes\Basic($route, $action);
		}

		$route->add($this->_routes);

		return $this;
	}
	
	/**
	* Matches a route against a request
	*
	* @author James Moss
	* @param $param
	* @return null
	*/
	public function match()
	{
		// Loop over the routes and check each one
		foreach($this->_routes as $route) {
			if($route->match($this->_request)) {
				return new Match($this->_request, $route);
			}
		}

		return false;
	}
	
	protected function isValidHttpMethod($method)
	{
		$allowed = explode(',', 'GET,POST,PUT,DELETE,HEAD,TRACE,OPTIONS,CONNECT,PATCH');

		return in_array(strtoupper($method), $allowed);
	}
}