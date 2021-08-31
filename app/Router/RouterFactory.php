<?php

declare(strict_types=1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList;

		$router->addRoute('[<locale=cs cs|en>/]', 'Homepage:default');

		$router->addRoute('<presenter>/<action>/[<locale=cs cs|en>/][/<id>]', 'Homepage:default');

		return $router;
	}
}
