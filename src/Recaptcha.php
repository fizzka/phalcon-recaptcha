<?php

namespace Fizz\Phalcon;

class Recaptcha extends \Phalcon\Forms\Element
{

	public function render($attributes = null) {
		return <<<HTML
<script type="text/javascript" src="{$this->getJsApiUrl()}" async defer></script>
<div class="g-recaptcha" data-sitekey="{$this->getPublicKey()}"></div>
HTML;
	}

	public function setConfig($config) {
		$this->config = $config;
	}

	public function getConfig() {
		if (!$this->config) {
			$this->config = $this->getForm()->config->recaptcha;
		}
		return $this->config;
	}

	public function getPublicKey() {
		return $this->getConfig()->publicKey;
	}

	public function getJsApiUrl() {
		return $this->getConfig()->jsApiUrl;
	}
}
