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

require_once(t3lib_extMgm::extPath('jft3blogwidget').'lib/class.tx_jft3blogwidget_pagerenderer.php');

/**
 * This class embeds the jQuery UI Calendar to T3BLOG.
 *
 * @author Juergen Furrer <juergen.furrer@gmail.com>
 * @package TYPO3
 * @subpackage tx_jft3blogwidget
 */
class tx_jft3blogwidget_jquerycalendar extends tslib_pibase
{
	public $prefixId      = 'tx_jft3blogwidget_jquerycalendar';
	public $scriptRelPath = 'widgets/tx_jft3blogwidget_archive/class.tx_jft3blogwidget_jquerycalendar.php';
	public $extKey        = 'jft3blogwidget';
	public $conf = array();
	public $piVars = array();
	public $cObj = array();
	public $blogConf = array();
	private $templateFileJS = null;
	private $piFlexForm = array();
	const DEFAULT_LANGUAGE = 'de';

	/**
	 * Produces the output.
	 *
	 * @param string $unused
	 * @param array $conf
	 * @param array $piVars
	 * @param tslib_cObj $cObj
	 */
	public function main($unused, array $conf, $piVars, tslib_cObj $cObj)
	{
		$this->pagerenderer = t3lib_div::makeInstance('tx_jft3blogwidget_pagerenderer');
		$this->pagerenderer->setConf($this->conf);

		$this->conf = $conf;
		$this->piVars = $piVars;
		$this->cObj = $cObj;
		$this->blogConf = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_t3blog_pi1.'];
		$this->blogConf['calendar.']['dateLink.']['typolink.']['returnLast'] = 'url';
		// The template for JS
		if (! $this->templateFileJS = $this->cObj->fileResource($this->conf['templateFileJS'])) {
			$this->templateFileJS = $this->cObj->fileResource("EXT:jft3blogwidget/res/tx_jft3blogwidget.js");
		}

		if (! $templateCode = trim($this->cObj->getSubpart($this->templateFileJS, "###TEMPLATE_CALENDAR_JS###"))) {
			$templateCode = $this->outputError("Template TEMPLATE_CALENDAR_JS is missing", true);
		}

		// Generate the language string
		$language = $this->cObj->cObjGetSingle($this->conf['language'], $this->conf['language.']);
		// Language fallback, if not set, try to guess the language from config
		if (! $language) {
			$language = $GLOBALS['TSFE']->tmpl->setup['config.']['language'];
			if (! $language) {
				$language = self::DEFAULT_LANGUAGE;
			}
		}

		$markerArray = array();
		$markerArray["LANGUAGE"] = $language;
		$markerArray["DATE_FROM"] = $this->piVars['blogList']['datefrom'];
		$markerArray["DATE_TO"]   = $this->piVars['blogList']['dateto'];
		$templateCode = $this->cObj->substituteMarkerArray($templateCode, $markerArray, '###|###', 0);

		$dateItem = trim($this->cObj->getSubpart($templateCode, "###DATES_ITEM###"));
		$blogdates = $this->getBlogDates();
		$dateArray = array();
		$key = 0;
		if (count($blogdates) > 0) {
			foreach ($blogdates as $date) {
				$link = t3blog_div::getSingle(
					array(
						'day' => "1",
						'date'=> $date['day'],
						'blogUid' => t3blog_div::getBlogPid()
					),
					'dateLink',
					$this->blogConf['calendar.']
				);
				$markerArray = array();
				$markerArray["KEY"] = $key;
				$markerArray["DATE"] = $date['day'];
				$markerArray["LINK"] = t3lib_div::getIndpEnv("TYPO3_SITE_URL") . $link;
				$markerArray["COUNT"] = $date['counter'];
				$class = '';
				if (strtotime($date['day']) >= strtotime($this->piVars['blogList']['datefrom']) && strtotime($date['day']) <= strtotime($this->piVars['blogList']['dateto'])) {
					$class = 'ui-state-highlight';
				}
				$markerArray["CLASS"] = $class;
				$dateArray[] = $this->cObj->substituteMarkerArray($dateItem, $markerArray, '###|###', 0);
				$key ++;
			}
		}
		$templateCode = trim($this->cObj->substituteSubpart($templateCode, '###DATES_ITEM###', implode('', $dateArray), 0));

		// Add all CSS and JS files
		if (T3JQUERY === true) {
			tx_t3jquery::addJqJS();
		} else {
			$this->pagerenderer->addJsFile($this->conf['jQueryLibrary']);
			$this->pagerenderer->addJsFile($this->conf['jQueryUI']);
			$this->pagerenderer->addJsFile(str_replace('###LANGUAGE###', $language, $this->conf['jQueryUIl18n']));
		}
		$this->pagerenderer->addCssFile($this->conf['jQueryUIstyle']);
		$this->pagerenderer->addJS($templateCode);

		$this->pagerenderer->addResources();

		return $cObj->cObjGetSingle($this->conf['datepicker'], $this->conf['datepicker.']);
	}

	/**
	 * Select all dates with blogentries
	 * 
	 * @return array
	 */
	private function getBlogDates()
	{
		$rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			'count(*) AS counter, DATE(FROM_UNIXTIME(date)) as day',
			'tx_t3blog_post',
			'pid=' . t3blog_div::getBlogPid() . $this->cObj->enableFields('tx_t3blog_post'),
			'day',
			'',
			'',
			'day'
		);

		return $rows;
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

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jft3blogwidget/widgets/tx_jft3blogwidget_jquerycalendar/class.tx_jft3blogwidget_jquerycalendar.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jft3blogwidget/widgets/tx_jft3blogwidget_jquerycalendar/class.tx_jft3blogwidget_jquerycalendar.php']);
}

?>