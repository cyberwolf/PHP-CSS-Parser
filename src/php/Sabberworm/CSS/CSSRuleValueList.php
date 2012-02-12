<?php

namespace Sabberworm\CSS;

class CSSRuleValueList extends CSSValueList {
	public function __construct($sSeparator = ',') {
		parent::__construct(array(), $sSeparator);
	}
}