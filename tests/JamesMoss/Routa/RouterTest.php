<?php

use JamesMoss\Routa\Router;
use JamesMoss\Routa\Routes\Basic;

class RouterTest extends PHPUnit_Framework_TestCase
{
	 /**
     * @expectedException InvalidArgumentException
     */
	public function testInvalidHttpMethod()
	{
		$r = new Router('/users/list', 'POKE');
		$this->assertFalse($r->match());
	}

	public function testValidHttpMethod()
	{
		$r = new Router('/users/edit/123', 'POST');
	}

	public function testMissingRoute()
	{
		$url = '/users/list/all';
		$r = new Router($url);
		$this->assertFalse($r->match());
	}

	public function testBasicRoute()
	{
		$url = '/login';
		$router = new Router($url);
		$router
			->add('/signup',		'Account#signup')
			->add('/login',			'Account#login')
			->add('/login/recover',	'Account#recoverPassword')
			->add('/logout',		'Account#logout');
		$this->assertInstanceOf('JamesMoss\Routa\Match', $result = $router->match());

		$this->assertEquals($result->controller, 'Account');
		$this->assertEquals($result->action, 'login');
	}
}
?>