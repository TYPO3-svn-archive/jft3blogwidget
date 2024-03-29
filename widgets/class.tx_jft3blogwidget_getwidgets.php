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
 * This class is a hook to return widget information to t3blog.
 *
 * @author Juergen Furrer <juergen.furrer@gmail.com>
 * @package TYPO3
 * @subpackage tx_jft3blogwidget_getwidgets
 */
class tx_jft3blogwidget_getwidgets
{
	/**
	 * Provides information about widgets in this extension
	 *
	 * @param array $unusedParams
	 * @return array
	 */
	public function getWidgets(array $unusedParams) {
		return array(
			'tx_jft3blogwidget_jquerycalendar' => 'EXT:jft3blogwidget/widgets/tx_jft3blogwidget_jquerycalendar/',
			'tx_jft3blogwidget_archive'        => 'EXT:jft3blogwidget/widgets/tx_jft3blogwidget_archive/',
			'tx_jft3blogwidget_tagcloud'       => 'EXT:jft3blogwidget/widgets/tx_jft3blogwidget_tagcloud/',
			'tx_jft3blogwidget_tagcanvas'      => 'EXT:jft3blogwidget/widgets/tx_jft3blogwidget_tagcanvas/',
		);
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jft3blogwidget/widgets/class.tx_jft3blogwidget_getwidgets.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jft3blogwidget/widgets/class.tx_jft3blogwidget_getwidgets.php']);
}

?>