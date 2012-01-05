<?php

namespace JamesMoss\Routa\Routes;

/**
 * Route
 *
 * Describes a URL -> action match
 * 
 * @author James Moss <email@jamesmoss.co.uk>
 */
class Basic extends Route
{
	/**
	 * Regex used to extract simple tokens from routes
	 *
	 * @var string
	 */
	const PARAMS_REGEX = '/\:([a-zA-Z0-9\-]+)/';
}