<?php

return [
    'custom' => [
		'name' => [
			'required' => 'Not empty :attribute?',
			'unique' => ':attribute unique?',
		],
		'price' => [
			'required' => 'Not empty :attribute?',
			'unique' => ':attribute unique?',
		],
		'token' => [
			'required' => 'Not empty :attribute?',
		],
	],
];
