<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'custom' => [
		'name' => [
			'required' => ':attribute?不能空的',
			'unique' => ':attribute unique?',
			'without_spaces' => ':attribute without_spaces?',
		],
		'price' => [
			'required' => ':attribute?不能空的',
			'unique' => ':attribute unique?',
		],
		'token' => [
			'required' => ':attribute?不能空的',
		],
		'password' => [
			'required' => ':attribute?不能空的',
			'min' => 'Min charter 8',
			'regex' => 'regex',
		],
		'email' => [
			'required' => ':attribute?不能空的',
			'unique' => 'unique?',
		],
        'phone' => [
			'required' => ':attribute?不能空的',
		],
		'g-recaptcha-response' => [
			'required' => 'Not empty recaptcha field',
			'captcha' => 'The recaptcha field is not correct.',
		]
	],
    '*.required' => ':attribute?不能空的',
];
