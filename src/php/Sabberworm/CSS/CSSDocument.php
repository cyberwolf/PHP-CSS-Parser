<?php

namespace Sabberworm\CSS;

/**
* The root CSSList of a parsed file. Contains all top-level css contents, mostly declaration blocks, but also any @-rules encountered.
*/
class CSSDocument extends CSSList {
	/**
	 * Gets all CSSDeclarationBlock objects recursively.
	 */
	public function getAllDeclarationBlocks() {
		$aResult = array();
		$this->allDeclarationBlocks($aResult);
		return $aResult;
	}

	/**
	 * @deprecated use getAllDeclarationBlocks()
	 */
	public function getAllSelectors() {
		return $this->getAllDeclarationBlocks();
	}

	/**
	 * Returns all CSSRuleSet objects found recursively in the tree.
	 */
	public function getAllRuleSets() {
		$aResult = array();
		$this->allRuleSets($aResult);
		return $aResult;
	}

	/**
	 * Returns all CSSValue objects found recursively in the tree.
	 * @param (object|string) $mElement the CSSList or CSSRuleSet to start the search from (defaults to the whole document). If a string is given, it is used as rule name filter (@see{CSSRuleSet->getRules()}).
	 * @param (bool) $bSearchInFunctionArguments whether to also return CSSValue objects used as CSSFunction arguments.
	 */
	public function getAllValues($mElement = null, $bSearchInFunctionArguments = false) {
		$sSearchString = null;
		if($mElement === null) {
			$mElement = $this;
		} else if(is_string($mElement)) {
			$sSearchString = $mElement;
			$mElement = $this;
		}
		$aResult = array();
		$this->allValues($mElement, $aResult, $sSearchString, $bSearchInFunctionArguments);
		return $aResult;
	}

	/**
	 * Returns all CSSSelector objects found recursively in the tree.
	 * Note that this does not yield the full CSSDeclarationBlock that the selector belongs to (and, currently, there is no way to get to that).
	 * @param $sSpecificitySearch An optional filter by specificity. May contain a comparison operator and a number or just a number (defaults to "==").
	 * @example getSelectorsBySpecificity('>= 100')
	 */
	public function getSelectorsBySpecificity($sSpecificitySearch = null) {
		if(is_numeric($sSpecificitySearch) || is_numeric($sSpecificitySearch[0])) {
			$sSpecificitySearch = "== $sSpecificitySearch";
		}
		$aResult = array();
		$this->allSelectors($aResult, $sSpecificitySearch);
		return $aResult;
	}

	/**
	 * Expands all shorthand properties to their long value
	 */
	public function expandShorthands()
	{
		foreach($this->getAllDeclarationBlocks() as $oDeclaration)
		{
			$oDeclaration->expandShorthands();
		}
	}

	/*
	 * Create shorthands properties whenever possible
	*/
	public function createShorthands()
	{
		foreach($this->getAllDeclarationBlocks() as $oDeclaration)
		{
			$oDeclaration->createShorthands();
		}
	}
}