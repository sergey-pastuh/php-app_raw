<?php

namespace Library;

use PDO;

class DB 
{
	public static function connect() {
		try {
			$host = App::config('DB_HOST');
			$port = App::config('DB_PORT');
			$name = App::config('DB_NAME');
			$user = App::config('DB_USER');
			$pass = App::config('DB_PASS');

			$dsn = "pgsql:host=$host;port=$port;dbname=$name;";

			$pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

			if ($pdo) {
				echo "Connected to the $name database successfully!";
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}
}