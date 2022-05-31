<?php

namespace Controllers;

use Controllers\Controller;

class ErrorController extends Controller
{
	public function routeNotFound() {
		echo '404';
	}
}