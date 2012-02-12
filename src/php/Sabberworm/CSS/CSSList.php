<?php

namespace Sabberworm\CSS;

/**
 * A CSSList is the most generic container available. Its contents include CSSRuleSet as well as other CSSList objects.
 * Also, it may contain CSSImport and CSSCharset objects stemming from @-rules.
 */
abstract class CSSList {
	private $aContents;

	public function __construct() {
		$this->aContents = array();
	}

	public function append($oItem) {
		$this->aContents[] = $oItem;
	}

	/**
	* Removes an item from the CSS list.
	* @param CSSRuleSet|CSSImport|CSSCharset|CSSList $oItemToRemove May be a CSSRuleSet (most likely a CSSDeclarationBlock), a CSSImport, a CSSCharset or another CSSList (most likely a CSSMediaQuery)
	*/
	public function remove($oItemToRemove) {
		$iKey = array_search($oItemToRemove, $this->aContents, true);
		if($iKey !== false) {
			unset($this->aContents[$iKey]);
		}
	}

	public function removeDeclarationBlockBySelector($mSelector, $bRemoveAll = false) {
		if($mSelector instanceof CSSDeclarationBlock) {
			$mSelector = $mSelector->getSelectors();
		}
		if(!is_array($mSelector)) {
			$mSelector = explode(',', $mSelector);
		}
		foreach($mSelector as $iKey => &$mSel) {
			if(!($mSel instanceof CSSSelector)) {
				$mSel = new CSSSelector($mSel);
			}
		}
		foreach($this->aContents as $iKey => $mItem) {
			if(!($mItem instanceof CSSDeclarationBlock)) {
				continue;
			}
			if($mItem->getSelectors() == $mSelector) {
				unset($this->aContents[$iKey]);
				if(!$bRemoveAll) {
					return;
				}
			}
		}
	}

	public function __toString() {
		$sResult = '';
		foreach($this->aContents as $oContent) {
			$sResult .= $oContent->__toString();
		}
		return $sResult;
	}
	
	public function getContents() {
		return $this->aContents;
	}
	
	protected function allDeclarationBlocks(&$aResult) {
		foreach($this->aContents as $mContent) {
			if($mContent instanceof CSSDeclarationBlock) {
				$aResult[] = $mContent;
			} else if($mContent instanceof CSSList) {
				$mContent->allDeclarationBlocks($aResult);
			}
		}
	}
	
	protected function allRuleSets(&$aResult) {
		foreach($this->aContents as $mContent) {
			if($mContent instanceof CSSRuleSet) {
				$aResult[] = $mContent;
			} else if($mContent instanceof CSSList) {
				$mContent->allRuleSets($aResult);
			}
		}
	}
	
	protected function allValues($oElement, &$aResult, $sSearchString = null, $bSearchInFunctionArguments = false) {
		if($oElement instanceof CSSList) {
			foreach($oElement->getContents() as $oContent) {
				$this->allValues($oContent, $aResult, $sSearchString, $bSearchInFunctionArguments);
			}
		} else if($oElement instanceof CSSRuleSet) {
			foreach($oElement->getRules($sSearchString) as $oRule) {
				$this->allValues($oRule, $aResult, $sSearchString, $bSearchInFunctionArguments);
			}
		} else if($oElement instanceof CSSRule) {
			$this->allValues($oElement->getValue(), $aResult, $sSearchString, $bSearchInFunctionArguments);
		} else if($oElement instanceof CSSValueList) {
			if($bSearchInFunctionArguments || !($oElement instanceof CSSFunction)) {
				foreach($oElement->getListComponents() as $mComponent) {
					$this->allValues($mComponent, $aResult, $sSearchString, $bSearchInFunctionArguments);
				}
			}
		} else {
			//Non-List CSSValue or String (CSS identifier)
			$aResult[] = $oElement;
		}
	}

	protected function allSelectors(&$aResult, $sSpecificitySearch = null) {
		foreach($this->getAllDeclarationBlocks() as $oBlock) {
			foreach($oBlock->getSelectors() as $oSelector) {
				if($sSpecificitySearch === null) {
					$aResult[] = $oSelector;
				} else {
					$sComparison = "\$bRes = {$oSelector->getSpecificity()} $sSpecificitySearch;";
					eval($sComparison);
					if($bRes) {
						$aResult[] = $oSelector;
					}
				}
			}
		}
	}
}
