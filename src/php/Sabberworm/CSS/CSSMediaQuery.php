<?php

namespace Sabberworm\CSS;

/**
* A CSSList consisting of the CSSList and CSSList objects found in a @media query.
*/
class CSSMediaQuery extends CSSList {
	private $sQuery;

	public function __construct() {
		parent::__construct();
		$this->sQuery = null;
	}

	public function setQuery($sQuery) {
		$this->sQuery = $sQuery;
	}

	public function getQuery() {
		return $this->sQuery;
	}

	public function __toString() {
		$sResult = "@media {$this->sQuery} {";
		$sResult .= parent::__toString();
		$sResult .= '}';
		return $sResult;
	}
}