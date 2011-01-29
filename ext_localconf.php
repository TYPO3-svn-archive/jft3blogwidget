<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['t3blog']['getWidgets'][$_EXTKEY . '_1'] = 'EXT:' . $_EXTKEY . '/widgets/class.tx_jft3blogwidget_getwidgets.php:tx_jft3blogwidget_getwidgets->getWidgets';

?>