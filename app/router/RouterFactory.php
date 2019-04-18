<?php

namespace App;

use Nette,
	Nette\Application\Routers\RouteList,
	Nette\Application\Routers\Route;


/**
 * Router factory.
 */
class RouterFactory
{

	/**
	 * @return \Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		$router = new RouteList();

		$admin = new RouteList('Admin');

		$admin[] = new Route('admin/login[/<id>]', 'Homepage:login');

		$admin[] = new Route('admin/register[/<id>]', 'Homepage:register');

		$admin[] = new Route('admin/<presenter>/<action>[/<id>]', 'Homepage:default');

		$front = new RouteList('Front');

		$front[] = new Route('/login[/<id>]', 'Homepage:login');

		$front[] = new Route('<presenter>/<action>[/<id>]', 'MainSubject:default');

		$router[] = $admin;
		$router[] = $front;

		return $router;
	}

}
