<?php

namespace Sabberworm\CSS;

/**
 * A CSSRuleSet constructed by an unknown @-rule. @font-face rules are rendered into CSSAtRule objects.
 */
class CSSAtRule extends CSSRuleSet {
	private $sType;

	public function __construct($sType) {
		parent::__construct();
		$this->sType = $sType;
	}

	public function __toString() {
		$sResult = "@{$this->sType} {";
		$sResult .= parent::__toString();
		$sResult .= '}';
		return $sResult;
	}
}
