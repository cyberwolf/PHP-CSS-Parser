<?php

namespace Sabberworm\CSS;

class CSSURL extends CSSPrimitiveValue {
	private $oURL;

	public function __construct(CSSString $oURL) {
		$this->oURL = $oURL;
	}

	public function setURL(CSSString $oURL) {
		$this->oURL = $oURL;
	}

	public function getURL() {
		return $this->oURL;
	}

	public function __toString() {
		return "url({$this->oURL->__toString()})";
	}
}

