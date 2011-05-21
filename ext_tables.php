<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_extMgm::addStaticFile($_EXTKEY, 'static/', 'T3BLOG jQuery Widgets');

if (TYPO3_MODE == 'BE') {
	$confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);

	if ($confArr['t3blogThemeEnable']) {
		$GLOBALS['TBE_STYLES']['skins'][$_EXTKEY] = array(
			"name" => $_EXTKEY,
			"stylesheetDirectories" => array(
				"sprites" => $confArr['t3blogTheme']
			)
		);
	}
	// define the icon, if not
	if (! isset($ICON_TYPES['t3blog'])) {
		$ICON_TYPES['t3blog'] = array(
			'icon' => t3lib_extMgm::extRelPath('t3blog') . 'ext_icon.gif'
		);
	}
}
?>