<?php

namespace Library;

class Autoloader 
{
	public static $appDir = __DIR__.'/..';

	public static function load() {		
		self::loadRecursive(self::$appDir, 1);
	}

	public static function loadRecursive($directory) {
		$files = scandir($directory);

		$url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
		$exclMode = strpos($url, '/api/') !== false ? 'WEB' : 'API';

		$dirsToLoad = [];
		for ($i=2; $i < count($files); $i++) {
			$fullPath = $directory . '/' . $files[$i];
			if (is_dir($fullPath)) {
				$dirsToLoad[] = $fullPath;
			} else {
				$checkControllerPath = strpos($fullPath, '/'.$exclMode.'/') === false;
				$checkExtension = pathinfo($fullPath)['extension'] == 'php';

				if ($checkExtension && $checkControllerPath) {
					require_once($fullPath);
				}
			}
		}
		if ($dirsToLoad) {
			foreach ($dirsToLoad as $path) {
				self::loadRecursive($path);
			}
		}
	}
}