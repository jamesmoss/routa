<?php

namespace JamesMoss\Routa\Routes;

/**
 * Route
 *
 * Describes a URL -> action match
 * 
 * @author James Moss <email@jamesmoss.co.uk>
 */
class Basic
{
	/**
	 * Regex used to extract simple tokens from routes
	 *
	 * @var string
	 */
	const PARAMS_REGEX = '/\:([a-zA-Z0-9\-]+)/';
	
	/**
	 * The URL to use
	 *
	 * @var string
	 */
	protected $_url = null;	
	
	/**
	 * The name of the controller to return on a match
	 *
	 * @var string
	 */
	protected $_controller = null;
	
	/**
	 * The compiled regex URL
	 *
	 * @var string
	 */
	protected $_compiledUrl = '';
	
	/**
	 * Route parameters (if any)
	 *
	 * @var array
	 */
	protected $_params = array();
	
	/**
	 * Tokens
	 *
	 * @var array
	 */
	protected $_tokens = array();
	
	/**
	 * Constructor
	 *
	 * @author James Moss
	 * @param $url
	 * @param $controller
	 */
	public function __construct($url, $controller)
	{
		$this->_url = $url;
		$this->_controller = $controller;
		$this->_compile();
	}
	
	/**
	 * Takes a request and matches it against this route
	 *
	 * @author James Moss
	 * @param $request
	 * @return boolean
	 */
	public function match($request)
	{
		$url = $request->url;

		if($this->_url === $url || (count($this->_tokens) && $this->_parseParams($url))) {
			return true;
		}
				
		return false;
	}
	
	/**
	 * Return the controller name
	 *
	 * @author James Moss
	 * @param $param
	 * @return string
	 */
	public function getControllerName()
	{
		return $this->_controller;
	}
	
	/**
	 * returns the params
	 *
	 * @author James Moss
	 * @param $param
	 * @return array
	 */
	public function getParameters()
	{
		return $this->_params;
	}
	
	/**
	 * Turns a human readable route into a regex to match a URL
	 *
	 * @author James Moss
	 */
	protected function _compile()
	{
		$tokens = &$this->_tokens; // you cant pass class properties into closures in PHP <= 5.3
		$this->_compiledUrl = str_replace('/', '\/', $this->_url);
		$this->_compiledUrl = preg_replace_callback(self::PARAMS_REGEX, function($matches) use(&$tokens) {
			$tokens[] = $matches[1];
			return '(.*?)';
		}, $this->_compiledUrl);
		
		$this->_compiledUrl = '/^'.$this->_compiledUrl.'$/';
	}
	
	/**
	 * Combines the URL and tokens to make params
	 *
	 * @author James Moss
	 * @param $url
	 * @return boolean
	 */
	protected function _parseParams($url)
	{
		if(count($this->_params)) {
			return true;
		}
		
		if(preg_match_all($this->_compiledUrl, $url, $matches)) {
			array_shift($matches);
			foreach($matches as $i => $match) {
				$this->_params[$this->_tokens[$i]] = $match[0];
			}
			return true;
		}
		
		return false;
	}
}