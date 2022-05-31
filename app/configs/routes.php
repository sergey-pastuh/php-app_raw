<?php 

$routes = [
	'API' => [
		'PostsController' => [
			'home'  =>
				['method' => 'GET', 'url' => '/posts/home'],
			'recommendations' =>
				['method' => 'GET', 'url' => '/posts/recommendations']
		],
	],
	'WEB' => [
		'PostsController' => [
			'home' =>
				['method' => 'GET', 'url' => '/']
		]
	]
];