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
		$this->archiveConf = $conf;
		$this->conf = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_t3blog_pi1.']['archive.'];

		$this->init();
		list($firstYear, $lastYear) = $this->getFirstAndLastYear();
		for ($this->currentYear = $firstYear; $this->currentYear >= $lastYear; $this->currentYear--) {
			$this->processOneYear();
		}
		$content = $this->assembleContent();

		$openBlock = t3lib_div::slashJS($this->conf['toggle.']['open']);
		$closeBlock = t3lib_div::slashJS($this->conf['toggle.']['close']);

		$js = "
jQuery(document).ready(function() {
	jQuery(\"a[id^='toggle']\").each(function() {
		var year = this.id.substr(6);
		if(jQuery.cookie('archive_'+year)=='1') {
			jQuery('#archive_'+year).slideUp('fast');
			jQuery('#'+this.id).text('{$openBlock}');
		} else {
			jQuery('#'+this.id).text('{$closeBlock}');
		}
		jQuery('#'+this.id).click(function() {
			if(jQuery('#'+this.id).text()=='{$closeBlock}') {
				jQuery('#archive_'+year).slideUp('fast');
				jQuery.cookie('archive_'+year,'1',{ path:'/'});
				jQuery('#'+this.id).text('{$openBlock}');
			} else {
				jQuery('#archive_'+year).slideDown('fast');
				jQuery.cookie('archive_'+year,'0',{ path:'/'});
				jQuery('#'+this.id).text('{$closeBlock}');
			}
			return false;
		});
	});
});";

		// Add all CSS and JS files
		if (T3JQUERY === true) {
			tx_t3jquery::addJqJS();
		} else {
			$this->addJsFile($this->archiveConf['jQueryLibrary']);
		}
		$this->addJsFile($this->archiveConf['jQueryCookies']);
		$this->addJS($js);

		$this->addResources();

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
						'tofooter' => ($this->archiveConf['jsInFooter'] || $allJsInFooter),
						'jsminify' => $this->archiveConf['jsMinify'],
					);
					tx_t3jquery::addJS('', $conf);
				} else {
					$file = $this->getPath($jsToLoad);
					if ($file) {
						if (t3lib_div::int_from_ver(TYPO3_version) >= 4003000) {
							if ($allJsInFooter) {
								$pagerender->addJsFooterFile($file, 'text/javascript', $this->archiveConf['jsMinify']);
							} else {
								$pagerender->addJsFile($file, 'text/javascript', $this->archiveConf['jsMinify']);
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
				$conf['tofooter'] = ($this->archiveConf['jsInFooter'] || $allJsInFooter);
				$conf['jsminify'] = $this->archiveConf['jsMinify'];
				$conf['jsinline'] = $this->archiveConf['jsInline'];
				tx_t3jquery::addJS('', $conf);
			} else {
				// Add script only once
				$hash = md5($temp_js);
				if ($this->archiveConf['jsInline']) {
					$GLOBALS['TSFE']->inlineJS[$hash] = $temp_css;
				} elseif (t3lib_div::int_from_ver(TYPO3_version) >= 4003000) {
					if ($this->archiveConf['jsInFooter'] || $allJsInFooter) {
						$pagerender->addJsFooterInlineCode($hash, $temp_js, $this->archiveConf['jsMinify']);
					} else {
						$pagerender->addJsInlineCode($hash, $temp_js, $this->archiveConf['jsMinify']);
					}
				} else {
					if ($this->archiveConf['jsMinify']) {
						$temp_js = t3lib_div::minifyJavaScript($temp_js);
					}
					if ($this->archiveConf['jsInFooter'] || $allJsInFooter) {
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
						$pagerender->addCssFile($file, 'stylesheet', 'all', '', $this->archiveConf['cssMinify']);
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
				$pagerender->addCssInlineBlock($hash, $temp_css, $this->archiveConf['cssMinify']);
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

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jft3blogwidget/widgets/tx_jft3blogwidget_archive/class.tx_jft3blogwidget_archive.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jft3blogwidget/widgets/tx_jft3blogwidget_archive/class.tx_jft3blogwidget_archive.php']);
}

?>