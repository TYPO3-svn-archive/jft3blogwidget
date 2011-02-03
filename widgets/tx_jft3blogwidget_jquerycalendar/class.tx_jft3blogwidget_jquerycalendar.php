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
	private $contentKey = null;
	private $jsFiles = array();
	private $js = array();
	private $cssFiles = array();
	private $css = array();
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
			$this->addJsFile($this->conf['jQueryLibrary']);
			$this->addJsFile($this->conf['jQueryUI']);
			$this->addJsFile(str_replace('###LANGUAGE###', $language, $this->conf['jQueryUIl18n']));
		}
		$this->addCssFile($this->conf['jQueryUIstyle']);
		$this->addJS($templateCode);

		$this->addResources();

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
	 * Include all defined resources (JS / CSS)
	 *
	 * @return void
	 */
	function addResources()
	{
		if (t3lib_div::int_from_ver(TYPO3_version) >= 4003000) {
			$pagerender = $GLOBALS['TSFE']->getPageRenderer();
		}
		// Fix moveJsFromHeaderToFooter (add all scripts to the footer)
		if ($GLOBALS['TSFE']->config['config']['moveJsFromHeaderToFooter']) {
			$allJsInFooter = true;
		} else {
			$allJsInFooter = false;
		}
		// add all defined JS files
		if (count($this->jsFiles) > 0) {
			foreach ($this->jsFiles as $jsToLoad) {
				if (T3JQUERY === true) {
					$conf = array(
						'jsfile' => $jsToLoad,
						'tofooter' => ($this->conf['jsInFooter'] || $allJsInFooter),
						'jsminify' => $this->conf['jsMinify'],
					);
					tx_t3jquery::addJS('', $conf);
				} else {
					$file = $this->getPath($jsToLoad);
					if ($file) {
						if (t3lib_div::int_from_ver(TYPO3_version) >= 4003000) {
							if ($allJsInFooter) {
								$pagerender->addJsFooterFile($file, 'text/javascript', $this->conf['jsMinify']);
							} else {
								$pagerender->addJsFile($file, 'text/javascript', $this->conf['jsMinify']);
							}
						} else {
							$temp_file = '<script type="text/javascript" src="'.$file.'"></script>';
							if ($allJsInFooter) {
								$GLOBALS['TSFE']->additionalFooterData['jsFile_'.$this->extKey.'_'.$file] = $temp_file;
							} else {
								$GLOBALS['TSFE']->additionalHeaderData['jsFile_'.$this->extKey.'_'.$file] = $temp_file;
							}
						}
					} else {
						t3lib_div::devLog("'{$jsToLoad}' does not exists!", $this->extKey, 2);
					}
				}
			}
		}
		// add all defined JS script
		if (count($this->js) > 0) {
			foreach ($this->js as $jsToPut) {
				$temp_js .= $jsToPut;
			}
			$conf = array();
			$conf['jsdata'] = $temp_js;
			if (T3JQUERY === true && t3lib_div::int_from_ver($this->getExtensionVersion('t3jquery')) >= 1002000) {
				$conf['tofooter'] = ($this->conf['jsInFooter'] || $allJsInFooter);
				$conf['jsminify'] = $this->conf['jsMinify'];
				$conf['jsinline'] = $this->conf['jsInline'];
				tx_t3jquery::addJS('', $conf);
			} else {
				// Add script only once
				$hash = md5($temp_js);
				if ($this->conf['jsInline']) {
					$GLOBALS['TSFE']->inlineJS[$hash] = $temp_css;
				} elseif (t3lib_div::int_from_ver(TYPO3_version) >= 4003000) {
					if ($this->conf['jsInFooter'] || $allJsInFooter) {
						$pagerender->addJsFooterInlineCode($hash, $temp_js, $this->conf['jsMinify']);
					} else {
						$pagerender->addJsInlineCode($hash, $temp_js, $this->conf['jsMinify']);
					}
				} else {
					if ($this->conf['jsMinify']) {
						$temp_js = t3lib_div::minifyJavaScript($temp_js);
					}
					if ($this->conf['jsInFooter'] || $allJsInFooter) {
						$GLOBALS['TSFE']->additionalFooterData['js_'.$this->extKey.'_'.$hash] = t3lib_div::wrapJS($temp_js, true);
					} else {
						$GLOBALS['TSFE']->additionalHeaderData['js_'.$this->extKey.'_'.$hash] = t3lib_div::wrapJS($temp_js, true);
					}
				}
			}
		}
		// add all defined CSS files
		if (count($this->cssFiles) > 0) {
			foreach ($this->cssFiles as $cssToLoad) {
				// Add script only once
				$file = $this->getPath($cssToLoad);
				if ($file) {
					if (t3lib_div::int_from_ver(TYPO3_version) >= 4003000) {
						$pagerender->addCssFile($file, 'stylesheet', 'all', '', $this->conf['cssMinify']);
					} else {
						$GLOBALS['TSFE']->additionalHeaderData['cssFile_'.$this->extKey.'_'.$file] = '<link rel="stylesheet" type="text/css" href="'.$file.'" media="all" />'.chr(10);
					}
				} else {
					t3lib_div::devLog("'{$cssToLoad}' does not exists!", $this->extKey, 2);
				}
			}
		}
		// add all defined CSS Script
		if (count($this->css) > 0) {
			foreach ($this->css as $cssToPut) {
				$temp_css .= $cssToPut;
			}
			$hash = md5($temp_css);
			if (t3lib_div::int_from_ver(TYPO3_version) >= 4003000) {
				$pagerender->addCssInlineBlock($hash, $temp_css, $this->conf['cssMinify']);
			} else {
				// addCssInlineBlock
				$GLOBALS['TSFE']->additionalCSS['css_'.$this->extKey.'_'.$hash] .= $temp_css;
			}
		}
	}

	/**
	 * Return the webbased path
	 * 
	 * @param string $path
	 * return string
	 */
	function getPath($path="")
	{
		return $GLOBALS['TSFE']->tmpl->getFileName($path);
	}

	/**
	 * Add additional JS file
	 * 
	 * @param string $script
	 * @param boolean $first
	 * @return void
	 */
	function addJsFile($script="", $first=false)
	{
		if ($this->getPath($script) && ! in_array($script, $this->jsFiles)) {
			if ($first === true) {
				$this->jsFiles = array_merge(array($script), $this->jsFiles);
			} else {
				$this->jsFiles[] = $script;
			}
		}
	}

	/**
	 * Add JS to header
	 * 
	 * @param string $script
	 * @return void
	 */
	function addJS($script="")
	{
		if (! in_array($script, $this->js)) {
			$this->js[] = $script;
		}
	}

	/**
	 * Add additional CSS file
	 * 
	 * @param string $script
	 * @return void
	 */
	function addCssFile($script="")
	{
		if ($this->getPath($script) && ! in_array($script, $this->cssFiles)) {
			$this->cssFiles[] = $script;
		}
	}

	/**
	 * Add CSS to header
	 * 
	 * @param string $script
	 * @return void
	 */
	function addCSS($script="")
	{
		if (! in_array($script, $this->css)) {
			$this->css[] = $script;
		}
	}

	/**
	 * Returns the version of an extension (in 4.4 its possible to this with t3lib_extMgm::getExtensionVersion)
	 * @param string $key
	 * @return string
	 */
	function getExtensionVersion($key)
	{
		if (! t3lib_extMgm::isLoaded($key)) {
			return '';
		}
		$_EXTKEY = $key;
		include(t3lib_extMgm::extPath($key) . 'ext_emconf.php');
		return $EM_CONF[$key]['version'];
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