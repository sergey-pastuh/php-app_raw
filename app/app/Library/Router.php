<?php

namespace Library;

use Helpers\PathHelper;
use Helpers\StringHelper;

class Router
{
	public $routes;

	public function __construct() {
		require_once PathHelper::getRouteListPath();
		$this->routes = $routes;
	}

	public function dispatch() {

	    $reqUrl = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
	    $reqMet = $_SERVER['REQUEST_METHOD'];

	    if (strpos($reqUrl, '/api/') !== false) {
	    	$mode = 'API';
			$reqUrl = substr($reqUrl, 4);
	    } else {
	    	$mode = 'WEB';
	    }

	    foreach ($this->routes[$mode] as $controller => $routesPerController) {
	    	foreach ($routesPerController as $function => $route) {
		        // convert urls like '/users/:uid/posts/:pid' to regular expression
		        $pattern = "@^" . preg_replace('/\\\:[a-zA-Z0-9\_\-]+/', '([a-zA-Z0-9\-\_]+)', preg_quote($route['url'])) . "$@D";
		        $matches = [];

		        if($reqMet == $route['method'] && preg_match($pattern, $reqUrl, $matches)) {
		            // remove the first match
		            array_shift($matches);
		            // call the callback with the matched positions as params
		           	return ['name' => $controller, 'params' => $matches, 'method' => $function, 'mode' => $mode];
		        }
	    	}
	    }

	    return ['name' => false, 'mode' => $mode];
	}
}