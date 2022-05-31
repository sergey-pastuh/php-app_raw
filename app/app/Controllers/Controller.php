<?php

namespace Controllers;

use Library\App;

abstract class Controller
{
	public $routeParams = [];

	public $requestParams = [];

	public function __construct(array $params = []) {
		$this->routeParams = $params;

		if ($_GET) {
			foreach ($_GET as $key => $value) {
				$this->requestParams[$key] = $value;
			}
		} elseif ($_POST) {
			foreach ($_POST as $key => $value) {
				$this->requestParams[$key] = $value;
			}
		}

	}

	protected function renderView(string $view) {
		//getting a view category name by parsing controller name (Controllers/PostsController -> Posts)
		$viewCategory = str_replace('Controller', '', substr(get_class($this), 12));
		$viewFile = App::$root . '//resources//views//' . $viewCategory . '//' . $view .'.php';
		$content = file_get_contents($viewFile);

		print(App::parseTemplate($content));
	}
}