<?php

namespace JamesMoss\Routa;

/**
 * Route
 *
 * Parses a route so that it can be used to determine whihc controller to load.
 * 
 * @author James Moss <email@jamesmoss.co.uk>
 */
class Match
{
	protected $_delimiter = '#';

	public function __construct($request, $route)
	{
		list($this->controller, $this->action) = explode($this->_delimiter, $route->getControllerName());
		$this->params = $route->getParams();
	}
}