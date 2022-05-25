<?php

namespace Controllers\WEB;

use Controllers\Controller;

class ErrorController extends Controller
{
	public function routeNotFound() {
		echo '404';
	}
}