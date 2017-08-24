<?php

return [
    'custom' => [
		'name' => [
			'required' => 'Not empty :attribute?',
			'unique' => ':attribute unique?',
			'without_spaces' => ':attribute without_spaces?',
		],
		'price' => [
			'required' => 'Not empty :attribute?',
			'unique' => ':attribute unique?',
		],
		'token' => [
			'required' => 'Not empty :attribute?',
		],
		'password' => [
			'required' => 'Not empty :attribute?',
			'min' => 'Min charter 8',
			'regex' => 'regex',
		],
		'email' => [
			'required' => 'Not empty :attribute?',
			'unique' => 'unique?',
		],
        'phone' => [
			'required' => 'Not empty :attribute?',
		],
		'g-recaptcha-response' => [
			'required' => 'Not empty recaptcha field',
			'captcha' => 'The recaptcha field is not correct.',
		]
	],
    '*.required' => 'Not empty :attribute?',
];
