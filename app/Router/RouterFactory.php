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
		$router->addRoute('<presenter>/<action>[/<id>]', 'Homepage:default');
        $router->addRoute('<presenter>/<action>[/<id>]', 'Homepage:omne');
        $router->addRoute('<presenter>/<action>[/<id>]', 'Kontakt:kontakt');
        $router->addRoute('<presenter>/<action>[/<id>]', 'Kontakt:potvrzeniMailu');
        $router->addRoute('<presenter>/<action>[/<id>]', 'Repertoar:repertoar');
        $router->addRoute('<presenter>/<action>[/<id>]', 'Vystoupeni:vystoupeni');
        $router->addRoute('<presenter>/<action>[/<id>]', 'Fotogalerie:fotogalerie');
        $router->addRoute('<presenter>/<action>[/<id>]', 'Homepage:videa');
        $router->addRoute('<presenter>/<action>[/<id>]', 'Prihlaseni:prihlaseni');
        $router->addRoute('<presenter>/<action>[/<id>]', 'AdminSekce:default');
        $router->addRoute('<presenter>/<action>[/<id>]', 'AdminSekce:spravaFotogalerie');
        $router->addRoute('<presenter>/<action>[/<id>]', 'AdminSekce:spravaRepertoaru');
        $router->addRoute('<presenter>/<action>[/<id>]', 'AdminSekce:spravaVidea');
        $router->addRoute('<presenter>/<action>[/<id>]', 'AdminSekce:spravaVystoupeni');
		return $router;
	}
}
