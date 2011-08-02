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

require_once(t3lib_extMgm::extPath('t3blog').'pi1/widgets/tagCloud/class.tagCloud.php');

/**
 * This class embeds the jQuery UI Calendar to T3BLOG.
 *
 * @author Juergen Furrer <juergen.furrer@gmail.com>
 * @package TYPO3
 * @subpackage tx_jft3blogwidget
 */
class tx_jft3blogwidget_tagcloud extends tagCloud
{
	public $prefixId      = 'tx_jft3blogwidget_tagcloud';
	public $scriptRelPath = 'widgets/tx_jft3blogwidget_tagcloud/class.tx_jft3blogwidget_tagcloud.php';
	public $extKey        = 'jft3blogwidget';
	private $tagcloudConf  = array();
	private $jsFiles = array();
	private $js = array();
	private $cssFiles = array();
	private $css = array();

	/**
	 * The main method of the PlugIn
	 * @author 	snowflake <typo3@snowflake.ch>
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	public function main($content, $conf, $piVars)
	{
		$this->cObj = t3lib_div::makeInstance('tslib_cObj');
		$this->conf = $conf;

		// The template for JS
		if (! $this->templateFileJS = $this->cObj->fileResource($this->conf['templateFileJS'])) {
			$this->templateFileJS = $this->cObj->fileResource("EXT:jft3blogwidget/res/tx_jft3blogwidget.js");
		}

		if (! $templateCode = trim($this->cObj->getSubpart($this->templateFileJS, "###TEMPLATE_TAGCLOUD_JS###"))) {
			$templateCode = $this->outputError("Template TEMPLATE_TAGCLOUD_JS is missing", true);
		}

		$markerArray = array();

		if (! is_numeric($this->conf['width'])) {
			$this->conf['width'] = 200;
		}
		if (! is_numeric($this->conf['height'])) {
			$this->conf['height'] = 200;
		}
		
		if (! is_numeric($this->conf['speed'])) {
			$this->conf['speed'] = 100;
		}
		if (! $this->conf['bgColor']) {
			$this->conf['bgColor'] = 'ffffff';
		}
		if (! $this->conf['tagColor1']) {
			$this->conf['tagColor1'] = '333333';
		}
		if (! $this->conf['tagColor2']) {
			$this->conf['tagColor2'] = '999999';
		}
		if (! $this->conf['highlightColor']) {
			$this->conf['highlightColor'] = '5599ff';
		}

		$markerArray["SWF_TAGCLOUD"] = $this->getPath($this->conf['tagCloudSWF']);
		$markerArray["WIDTH"]  = $this->conf['width'];
		$markerArray["HEIGHT"] = $this->conf['height'];
		$markerArray["SPEED"]  = $this->conf['speed'];
		$markerArray["DISTR"]  = ($this->conf['distr'] ? 'true' : 'false');
		$markerArray["WMODE"]  = $this->conf['wmode'];
		$markerArray["BGCOLOR"] = $this->conf['bgColor'];
		$markerArray["T_COLOR1"] = $this->conf['tagColor1'];
		$markerArray["T_COLOR2"] = $this->conf['tagColor2'];
		$markerArray["HI_COLOR"] = $this->conf['highlightColor'];

		// Generate the tags
		$link_code = $this->getTagCode();
		$GLOBALS['TSFE']->register['taglinks'] = $link_code;
		// Generate the xml for th SWF-Object
		$markerArray["TAGLINKS"] = urlencode($this->cObj->cObjGetSingle($this->conf['tagcloudswf'], $this->conf['tagcloudswf.']));

		// Set te Marks
		$templateCode = $this->cObj->substituteMarkerArray($templateCode, $markerArray, '###|###', 0);

		// Add Javascript
		$this->addJsFile($this->conf['tagCloudJS']);
		$this->addJS($templateCode);

		$this->addResources();

		$content = $this->cObj->cObjGetSingle($this->conf['tagcloud'], $this->conf['tagcloud.']);

		return $content;
	}

	/**
	 * Render the links of all tags
	 * 
	 * @return string
	 */
	private function getTagCode()
	{
		$link_rows = $this->getTagsArray();
		$link_code = null;
		for ($c=0; $c<sizeof($link_rows); $c++) {
			$aTagParam = 'class="tag-link-' . $c . '" title="' . $link_rows[$c]['link_name'] . '" rel="tag" style="font-size: ' . $link_rows[$c]['link_size'] . 'pt;"';
			$conf = array(
				'additionalParams' => $link_rows[$c]['link_additionalParams'],
				'parameter' => $link_rows[$c]['link_url'],
				'ATagParams' => $aTagParam
			);
			$link_code .= $this->cObj->typoLink($link_rows[$c]['link_name'], $conf);
		}
		return $link_code;

	}

	/**
	 * Return all tags to build the links
	 * Allmost coppied from t3mcumulustagcloud
	 * 
	 * @return array
	 */
	private function getTagsArray()
	{
		// get news
		$this->extractAndCountTags();
		// sort most counted
		$tags = $this->arraySort2D($this->tagArray, 'count', 'desc');
		// reduce array size
		if (isset($numberTags) && $numberTags != '' && is_numeric($numberTags) && $numberTags > 0) {
			array_splice($tags, $numberTags);
		}
		// get blog pid
		$blogPid = t3blog_div::getBlogPid();
		foreach ($tags as $v) {
			if (empty($maxcount) || $v['count'] > $maxcount) {
				$maxcount = $v['count'];
			}
			if (empty($mincount) || $v['count'] < $mincount) {
				$mincount = $v['count'];
			}
		}
		$link_rows = array();
		// build array
		foreach ($tags as $value) {
			$linksize = $this->getTagSizeLinear($value['count'], $mincount, $maxcount, 15, 40, 0);
			$link_rows[] = array(
				"link_name" => $value['tag'],
				"link_size" => $linksize,
				"link_url" => $blogPid,
				"link_additionalParams" => "&tx_t3blog_pi1[blogList][tags]=" . $value['tag']
			);
		}
		return $link_rows;
	}

	/**
	 * Include all defined resources (JS / CSS)
	 *
	 * @return void
	 */
	private function addResources()
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
							if ($this->conf['jsInFooter'] || $allJsInFooter) {
								$pagerender->addJsFooterFile($file, 'text/javascript', $this->conf['jsMinify']);
							} else {
								$pagerender->addJsFile($file, 'text/javascript', $this->conf['jsMinify']);
							}
						} else {
							$temp_file = '<script type="text/javascript" src="'.$file.'"></script>';
							if ($this->conf['jsInFooter'] || $allJsInFooter) {
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
	private function getPath($path="")
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
	private function addJsFile($script="", $first=false)
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
	private function addJS($script="")
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
	private function addCssFile($script="")
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
	private function addCSS($script="")
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
	private function getExtensionVersion($key)
	{
		if (! t3lib_extMgm::isLoaded($key)) {
			return '';
		}
		$_EXTKEY = $key;
		include(t3lib_extMgm::extPath($key) . 'ext_emconf.php');
		return $EM_CONF[$key]['version'];
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
		$this->pi_initPIflexForm();
		$piFlexForm = $this->cObj->data['pi_flexform'];
		if (! isset($piFlexForm['data'])) {
			if ($devlog === true) {
				t3lib_div::devLog("Flexform Data not set", $this->extKey, 1);
			}
			return null;
		}
		if (! isset($piFlexForm['data'][$sheet])) {
			if ($devlog === true) {
				t3lib_div::devLog("Flexform sheet '{$sheet}' not defined", $this->extKey, 1);
			}
			return null;
		}
		if (! isset($piFlexForm['data'][$sheet]['lDEF'][$name])) {
			if ($devlog === true) {
				t3lib_div::devLog("Flexform Data [{$sheet}][{$name}] does not exist", $this->extKey, 1);
			}
			return null;
		}
		if (isset($piFlexForm['data'][$sheet]['lDEF'][$name]['vDEF'])) {
			return $this->pi_getFFvalue($piFlexForm, $name, $sheet);
		} else {
			return $piFlexForm['data'][$sheet]['lDEF'][$name];
		}
	}

	/**
	 * Return a errormessage if needed
	 * @param string $msg
	 * @param boolean $js
	 * @return string
	 */
	private function outputError($msg='', $js=false)
	{
		t3lib_div::devLog($msg, $this->extKey, 3);
		return ($js ? "alert(".t3lib_div::quoteJSvalue($msg).")" : "<p>{$msg}</p>");
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jft3blogwidget/widgets/tx_jft3blogwidget_tagcloud/class.tx_jft3blogwidget_tagcloud.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jft3blogwidget/widgets/tx_jft3blogwidget_tagcloud/class.tx_jft3blogwidget_tagcloud.php']);
}

?>