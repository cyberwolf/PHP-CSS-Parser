<?php

namespace Sabberworm\CSS;

class CSSString extends CSSPrimitiveValue {
	private $sString;

	public function __construct($sString) {
		$this->sString = $sString;
	}

	public function setString($sString) {
		$this->sString = $sString;
	}

	public function getString() {
		return $this->sString;
	}

	public function __toString() {
		$sString = addslashes($this->sString);
		$sString = str_replace("\n", '\A', $sString);
		return '"'.$sString.'"';
	}
}