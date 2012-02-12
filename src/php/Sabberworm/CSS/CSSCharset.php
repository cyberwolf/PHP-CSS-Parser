<?php

namespace Sabberworm\CSS;

/**
 * Class representing an @charset rule.
 * The following restrictions apply:
 * • May not be found in any CSSList other than the CSSDocument.
 * • May only appear at the very top of a CSSDocument’s contents.
 * • Must not appear more than once.
 */
class CSSCharset {
	private $sCharset;

	public function __construct($sCharset) {
		$this->sCharset = $sCharset;
	}

	public function setCharset($sCharset) {
		$this->sCharset = $sCharset;
	}

	public function getCharset() {
		return $this->sCharset;
	}

	public function __toString() {
		return "@charset {$this->sCharset->__toString()};";
	}
}