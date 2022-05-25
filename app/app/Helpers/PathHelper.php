<?php

namespace Helpers;

class PathHelper 
{
	public static function getRootDir() {
		return __DIR__.'/../..';
	}

	public static function getConfigPath() {
		return self::getRootDir() . '/configs/app.php';
	}

	public static function getRouteListPath() {
		return self::getRootDir() . '/configs/routes.php';
	}	
}