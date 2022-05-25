<?php

namespace Controllers;

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
}