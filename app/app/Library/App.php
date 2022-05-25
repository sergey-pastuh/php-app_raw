<?php

namespace Library;

class App 
{
	public static $root = __DIR__.'/../..';

	public function run() {
		require ('Autoloader.php');
		Autoloader::load();

		session_start();

		$router = new Router();
		$controllerData = $router->dispatch();

		if ($controllerData['name']) {
			$controllerName = '\\Controllers\\' . $controllerData['mode'] . '\\' .$controllerData['name'];
			$controllerFunc = $controllerData['method'];
			$controller = new $controllerName($controllerData['params']);

		} else {
			$controllerName = '\\Controllers\\' . $controllerData['mode'] . '\\ErrorController';
			$controllerFunc = 'routeNotFound';
			$controller = new $controllerName();
		}

		$controller->$controllerFunc();
	}

	public static function config($value) {
		$config = file_get_contents($root . 'configs/app.php');

		foreach ($config as $configKey => $configVal) {
			if ($configKey == $value) {
				return $configVal;
			}
		}

		return false;
	}
}