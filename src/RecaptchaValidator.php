<?php

namespace Fizz\Phalcon;

use Phalcon\Validation\Validator;
use Phalcon\Validation\ValidatorInterface;
use Phalcon\Validation\Message;

class RecaptchaValidator extends Validator implements ValidatorInterface
{

	/**
	 * @see phalcon docs
	 */
	public function validate($validation, $attribute) {
		$this->setConfig($validation->config->recaptcha);

		$value = $validation->getValue('g-recaptcha-response');
		$ip = $validation->request->getClientAddress();

		if (!$this->verify($value, $ip)) {
			$message = $this->getOption('message');
			if (!$message) {
				$message = 'Please, confirm you are human';
			}

			$validation->appendMessage(new Message($message, $attribute, 'Recaptcha'));

			return false;
		}

		return true;
	}

	protected function setConfig($config) {
		$this->config = $config;
	}

	protected function getConfig() {
		return $this->config;
	}

	protected function getSecretKey() {
		return $this->getConfig()->secretKey;
	}

	protected function getVerifyUrl() {
		return $this->getConfig()->verifyUrl;
	}

	protected function verify($data, $ip = null) {
		$params = array(
			'secret' => $this->getSecretKey(),
			'response' => $data
		);

		if ($ip) {
			$params['remoteip'] = $ip;
		}

		$url = $this->getVerifyUrl() . '?' .http_build_query($params);
		$response = json_decode(file_get_contents($url));
		return $response->success;
	}
}
