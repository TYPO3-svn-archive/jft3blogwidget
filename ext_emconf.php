<?php

########################################################################
# Extension Manager/Repository config file for ext "jft3blogwidget".
#
# Auto generated 29-01-2011 11:14
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'T3BLOG Widgets',
	'description' => 'Provides some new widgets for the T3BLOG like jQuery UI Calendar. Use t3jquery for better integration with other jQuery extensions.',
	'category' => 'plugin',
	'author' => 'Juergen Furrer',
	'author_email' => 'juergen.furrer@gmail.com',
	'shy' => '',
	'dependencies' => 'cms',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 1,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.0.0',
	'constraints' => array(
		'depends' => array(
			'cms' => '',
			'php' => '5.0.0-5.3.99',
			'typo3' => '4.3.0-4.5.99',
			'jftcaforms' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:9:{s:9:"ChangeLog";s:4:"3b50";s:10:"README.txt";s:4:"3643";s:12:"ext_icon.gif";s:4:"1bdc";s:17:"ext_localconf.php";s:4:"5785";s:14:"ext_tables.php";s:4:"612a";s:16:"static/setup.txt";s:4:"1084";s:48:"widgets/class.tx_t3blogwidgetdemo_getwidgets.php";s:4:"d5d4";s:49:"widgets/trend/class.tx_t3blogwidgetdemo_trend.php";s:4:"068d";s:27:"widgets/trend/locallang.xml";s:4:"8b3b";}',
);

?>