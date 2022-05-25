<?php

namespace Helpers;

class StringHelper 
{
	public static function deleteCharactersBetween(string $string, int $start, int $end) {
		return substr($string, $start, $end - $start);
	}	
}