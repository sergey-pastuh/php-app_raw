<?php

namespace Controllers;

use Controllers\Controller;
use Library\App;

class PostsController extends Controller
{
	public function home() {
		$this->renderView('home');
	}
}