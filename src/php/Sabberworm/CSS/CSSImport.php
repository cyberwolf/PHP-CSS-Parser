<?php

namespace Sabberworm\CSS;

/**
* Class representing an @import rule.
*/
class CSSImport {
	private $oLocation;
	private $sMediaQuery;
	
	public function __construct(CSSURL $oLocation, $sMediaQuery) {
		$this->oLocation = $oLocation;
		$this->sMediaQuery = $sMediaQuery;
	}
	
	public function setLocation($oLocation) {
			$this->oLocation = $oLocation;
	}

	public function getLocation() {
			return $this->oLocation;
	}
	
	public function __toString() {
		return "@import ".$this->oLocation->__toString().($this->sMediaQuery === null ? '' : ' '.$this->sMediaQuery).';';
	}
}
