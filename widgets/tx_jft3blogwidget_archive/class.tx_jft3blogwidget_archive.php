<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Juergen Furrer (juergen.furrer@gmail.com)
*  All rights reserved
*
*  This script is part of the Typo3 project. The Typo3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

require_once(t3lib_extMgm::extPath('t3blog').'pi1/widgets/archive/class.archive.php');
require_once(t3lib_extMgm::extPath('jft3blogwidget').'lib/class.tx_jft3blogwidget_pagerenderer.php');

/**
 * This class embeds the jQuery UI Calendar to T3BLOG.
 *
 * @author Juergen Furrer <juergen.furrer@gmail.com>
 * @package TYPO3
 * @subpackage tx_jft3blogwidget
 */
class tx_jft3blogwidget_archive extends archive
{
	public $prefixId      = 'tx_jft3blogwidget_archive';
	public $scriptRelPath = 'widgets/tx_jft3blogwidget_archive/class.tx_jft3blogwidget_archive.php';
	public $extKey        = 'jft3blogwidget';
	private $archiveConf  = array();
	private $templateFileJS = null;
	private $jsFiles      = array();
	private $js           = array();
	private $cssFiles     = array();
	private $css          = array();
	private $piFlexForm   = array();

	/**
	 * The main method of the PlugIn
	 * @author 	snowflake <typo3@snowflake.ch>
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf, $piVars)
	{
		$this->pagerenderer = t3lib_div::makeInstance('tx_jft3blogwidget_pagerenderer');
		$this->pagerenderer->setConf($this->conf);

		$this->archiveConf = $conf;
		$this->conf = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_t3blog_pi1.']['archive.'];

		// Init
		$this->init();
		// Use the labels from t3blog / archive
		$languageBasePath = 'EXT:t3blog/pi1/widgets/archive/locallang.xml';
		$this->LOCAL_LANG = t3lib_div::readLLfile($languageBasePath, $this->LLkey, $GLOBALS['TSFE']->renderCharset);
		if ($this->altLLkey) {
			$tempLOCAL_LANG   = t3lib_div::readLLfile($languageBasePath, $this->altLLkey);
			$this->LOCAL_LANG = array_merge(is_array($this->LOCAL_LANG) ? $this->LOCAL_LANG : array(), $tempLOCAL_LANG);
		}

		// The template for JS
		if (! $this->templateFileJS = $this->cObj->fileResource($this->conf['templateFileJS'])) {
			$this->templateFileJS = $this->cObj->fileResource("EXT:jft3blogwidget/res/tx_jft3blogwidget.js");
		}

		if (! $templateCode = trim($this->cObj->getSubpart($this->templateFileJS, "###TEMPLATE_ARCHIVE_JS###"))) {
			$templateCode = $this->outputError("Template TEMPLATE_ARCHIVE_JS is missing", true);
		}

		$markerArray = array();
		$markerArray["SPEED"]        = $this->archiveConf['animation.']['speed'];
		$markerArray["TOGGLE_OPEN"]  = t3lib_div::slashJS($this->conf['toggle.']['open']);
		$markerArray["TOGGLE_CLOSE"] = t3lib_div::slashJS($this->conf['toggle.']['close']);
		$templateCode = $this->cObj->substituteMarkerArray($templateCode, $markerArray, '###|###', 0);

		// Add all CSS and JS files
		if (T3JQUERY === true) {
			tx_t3jquery::addJqJS();
		} else {
			$this->pagerenderer->addJsFile($this->archiveConf['jQueryLibrary']);
		}
		$this->pagerenderer->addJsFile($this->archiveConf['jQueryCookies']);
		$this->pagerenderer->addJS($templateCode);

		$this->pagerenderer->addResources();

		list($firstYear, $lastYear) = $this->getFirstAndLastYear();
		for ($this->currentYear = $firstYear; $this->currentYear >= $lastYear; $this->currentYear--) {
			$this->processOneYear();
		}
		$content = $this->assembleContent();

		return $content;
	}

	/**
	 * Creates a common javascript for toggling nodes.
	 *
	 * @param  string $id
	 * @return string
	 */
	protected function getToggleJS($id)
	{
		return '';
	}

	/**
	* Set the piFlexform data
	*
	* @return void
	*/
	protected function setFlexFormData()
	{
		if (! count($this->piFlexForm)) {
			$this->pi_initPIflexForm();
			$this->piFlexForm = $this->cObj->data['pi_flexform'];
		}
	}

	/**
	 * Extract the requested information from flexform
	 * @param string $sheet
	 * @param string $name
	 * @param boolean $devlog
	 * @return string
	 */
	protected function getFlexformData($sheet='', $name='', $devlog=true)
	{
		$this->setFlexFormData();
		if (! isset($this->piFlexForm['data'])) {
			if ($devlog === true) {
				t3lib_div::devLog("Flexform Data not set", $this->extKey, 1);
			}
			return null;
		}
		if (! isset($this->piFlexForm['data'][$sheet])) {
			if ($devlog === true) {
				t3lib_div::devLog("Flexform sheet '{$sheet}' not defined", $this->extKey, 1);
			}
			return null;
		}
		if (! isset($this->piFlexForm['data'][$sheet]['lDEF'][$name])) {
			if ($devlog === true) {
				t3lib_div::devLog("Flexform Data [{$sheet}][{$name}] does not exist", $this->extKey, 1);
			}
			return null;
		}
		if (isset($this->piFlexForm['data'][$sheet]['lDEF'][$name]['vDEF'])) {
			return $this->pi_getFFvalue($this->piFlexForm, $name, $sheet);
		} else {
			return $this->piFlexForm['data'][$sheet]['lDEF'][$name];
		}
	}

	/**
	 * Return a errormessage if needed
	 * @param string $msg
	 * @param boolean $js
	 * @return string
	 */
	function outputError($msg='', $js=false)
	{
		t3lib_div::devLog($msg, $this->extKey, 3);
		return ($js ? "alert(".t3lib_div::quoteJSvalue($msg).")" : "<p>{$msg}</p>");
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jft3blogwidget/widgets/tx_jft3blogwidget_archive/class.tx_jft3blogwidget_archive.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jft3blogwidget/widgets/tx_jft3blogwidget_archive/class.tx_jft3blogwidget_archive.php']);
}

?>