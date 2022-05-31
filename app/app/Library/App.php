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
			$controllerName = '\\Controllers\\' . $controllerData['name'];
			$controllerFunc = $controllerData['method'];
			$controller = new $controllerName($controllerData['params']);

		} else {
			$controllerName = '\\Controllers\\' . 'ErrorController';
			$controllerFunc = 'routeNotFound';
			$controller = new $controllerName();
		}

		$controller->$controllerFunc();
	}

	public static function config($value) {
		require_once self::$root . '/configs/app.php';

		foreach ($config as $configKey => $configVal) {
			if ($configKey == $value) {
				return $configVal;
			}
		}

		return false;
	}

	public static function parseTemplate($template) {
		require_once self::$root . '/configs/templates.php';
		$defTempsDir = self::$root . '/resources/views/DefaultTemplates/';

		foreach ($defTemps as $defTemp) {
			$template = str_replace(":{$defTemp}", file_get_contents($defTempsDir . $defTemp .'.php'), $template);
		}

		return $template;
	}	
}