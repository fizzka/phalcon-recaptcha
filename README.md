phalcon-recaptcha
=================

## About

This is small component to provide [Google Recaptcha](https://www.google.com/recaptcha) functionality in [Phalcon](http://www.phalconphp.com).

It uses phalcon DI.
Be sure, you supply DI this correct recaptcha configuration.


## Usage

There are 3 easy steps:

### Step 1

Setup up config & di (or ensure, you did this at application bootstrap ;) :

```php
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
```

### Step 2

Create form and add recaptcha on it:

```php
$form = new Phalcon\Forms\Form;
$form->setDI($di);

$recaptcha = new Fizz\Phalcon\Recaptcha('recaptcha');
$recaptcha->addValidator(new Fizz\Phalcon\RecaptchaValidator(array(
	'message' => "Are you human? (custom message)"
)));

$form->add($recaptcha);
```

### Step 3

Validate form after submission:

```php
//submitted data, ex
$post = array(
	'g_recaptcha_response' => 'abzfoobar'
);

if ($form->isValid($post)) {
	echo 'ok';
} else {
	print_r($form->getMessages());
}
```

## Code example

Full-working example @see [example.php](example.php)

## License

MIT
