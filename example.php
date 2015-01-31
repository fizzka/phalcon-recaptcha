<?php

require_once 'src/Recaptcha.php';
require_once 'src/RecaptchaValidator.php';

use Fizz\Phalcon\Recaptcha;
use Fizz\Phalcon\RecaptchaValidator;

// setting up config & di

$config = new Phalcon\Config(array(
	"recaptcha" => array(
		'publicKey' => '[...your pub key goes here...]',
		'secretKey' => '[...your priv key goes here...]',
		'jsApiUrl' => 'https://www.google.com/recaptcha/api.js',
		'verifyUrl' => 'https://www.google.com/recaptcha/api/siteverify',
	)
));

$di = new Phalcon\DI\FactoryDefault();
$di->set('config', $config);

// creating form and recaptcha adding recaptcha to the form

$form = new Phalcon\Forms\Form;
$form->setDI($di);

$recaptcha = new Recaptcha('recaptcha');
$recaptcha->addValidator(new RecaptchaValidator(array(
	'message' => "Are you human? (custom message)"
)));

$form->add($recaptcha);

// example of validation)

$post = array(
	'g_recaptcha_response' => 'abzfoobar'
);

if ($form->isValid($post)) {
	echo 'ok';
} else {
	print_r($form->getMessages());
}
