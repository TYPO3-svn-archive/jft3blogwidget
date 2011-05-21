<?php

########################################################################
# Extension Manager/Repository config file for ext "jft3blogwidget".
#
# Auto generated 21-05-2011 15:57
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'T3BLOG Widgets',
	'description' => 'Provides some new widgets for the T3BLOG like jQuery UI Calendar, jQuery Archive and Flash tagcloud. Use t3jquery for better integration with other jQuery extensions.',
	'category' => 'plugin',
	'author' => 'Juergen Furrer',
	'author_email' => 'juergen.furrer@gmail.com',
	'shy' => '',
	'dependencies' => 'cms,t3blog',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 1,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.5.0',
	'constraints' => array(
		'depends' => array(
			'cms' => '',
			'php' => '5.0.0-5.3.99',
			'typo3' => '4.3.0-4.5.99',
			't3blog' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:108:{s:21:"ext_conf_template.txt";s:4:"53d4";s:12:"ext_icon.gif";s:4:"47f4";s:17:"ext_localconf.php";s:4:"6b88";s:14:"ext_tables.php";s:4:"d905";s:13:"locallang.xml";s:4:"e3ce";s:12:"t3jquery.txt";s:4:"8cac";s:24:"compat/flashmessages.css";s:4:"4e2c";s:20:"compat/gfx/error.png";s:4:"e4dd";s:26:"compat/gfx/information.png";s:4:"3750";s:21:"compat/gfx/notice.png";s:4:"a882";s:17:"compat/gfx/ok.png";s:4:"8bfe";s:22:"compat/gfx/warning.png";s:4:"c847";s:14:"doc/manual.sxw";s:4:"f010";s:43:"lib/class.tx_jft3blogwidget_tsparserext.php";s:4:"a1e8";s:24:"res/tx_jft3blogwidget.js";s:4:"ed6a";s:55:"res/jquery/css/theme-1.8.13/jquery-ui-1.8.13.custom.css";s:4:"5c50";s:76:"res/jquery/css/theme-1.8.13/images/ui-bg_diagonals-thick_18_b81900_40x40.png";s:4:"95f9";s:76:"res/jquery/css/theme-1.8.13/images/ui-bg_diagonals-thick_20_666666_40x40.png";s:4:"f040";s:66:"res/jquery/css/theme-1.8.13/images/ui-bg_flat_10_000000_40x100.png";s:4:"c18c";s:67:"res/jquery/css/theme-1.8.13/images/ui-bg_glass_100_f6f6f6_1x400.png";s:4:"5f18";s:67:"res/jquery/css/theme-1.8.13/images/ui-bg_glass_100_fdf5ce_1x400.png";s:4:"d26e";s:66:"res/jquery/css/theme-1.8.13/images/ui-bg_glass_65_ffffff_1x400.png";s:4:"e5a8";s:73:"res/jquery/css/theme-1.8.13/images/ui-bg_gloss-wave_35_9f2614_500x100.png";s:4:"da5d";s:76:"res/jquery/css/theme-1.8.13/images/ui-bg_highlight-soft_100_eeeeee_1x100.png";s:4:"384c";s:75:"res/jquery/css/theme-1.8.13/images/ui-bg_highlight-soft_75_ffe45c_1x100.png";s:4:"b806";s:62:"res/jquery/css/theme-1.8.13/images/ui-icons_222222_256x240.png";s:4:"ebe6";s:62:"res/jquery/css/theme-1.8.13/images/ui-icons_228ef1_256x240.png";s:4:"79f4";s:62:"res/jquery/css/theme-1.8.13/images/ui-icons_65160b_256x240.png";s:4:"8250";s:62:"res/jquery/css/theme-1.8.13/images/ui-icons_ef8c08_256x240.png";s:4:"ef9a";s:62:"res/jquery/css/theme-1.8.13/images/ui-icons_ffd27a_256x240.png";s:4:"ab8c";s:62:"res/jquery/css/theme-1.8.13/images/ui-icons_ffffff_256x240.png";s:4:"342b";s:33:"res/jquery/js/jquery-1.6.1.min.js";s:4:"a34f";s:31:"res/jquery/js/jquery-cookies.js";s:4:"dcd2";s:44:"res/jquery/js/jquery-ui-1.8.12.custom.min.js";s:4:"dc4e";s:44:"res/jquery/js/jquery-ui-1.8.13.custom.min.js";s:4:"e232";s:38:"res/jquery/js/i18n/ui.datepicker-af.js";s:4:"3f6d";s:41:"res/jquery/js/i18n/ui.datepicker-ar-DZ.js";s:4:"75fc";s:38:"res/jquery/js/i18n/ui.datepicker-ar.js";s:4:"bd15";s:38:"res/jquery/js/i18n/ui.datepicker-az.js";s:4:"d137";s:38:"res/jquery/js/i18n/ui.datepicker-bg.js";s:4:"8098";s:38:"res/jquery/js/i18n/ui.datepicker-bs.js";s:4:"1a61";s:38:"res/jquery/js/i18n/ui.datepicker-ca.js";s:4:"b9f0";s:38:"res/jquery/js/i18n/ui.datepicker-cs.js";s:4:"d974";s:38:"res/jquery/js/i18n/ui.datepicker-da.js";s:4:"a20a";s:38:"res/jquery/js/i18n/ui.datepicker-de.js";s:4:"ba8b";s:38:"res/jquery/js/i18n/ui.datepicker-el.js";s:4:"46b8";s:41:"res/jquery/js/i18n/ui.datepicker-en-AU.js";s:4:"4a38";s:41:"res/jquery/js/i18n/ui.datepicker-en-GB.js";s:4:"24a2";s:41:"res/jquery/js/i18n/ui.datepicker-en-NZ.js";s:4:"af98";s:38:"res/jquery/js/i18n/ui.datepicker-eo.js";s:4:"ae01";s:38:"res/jquery/js/i18n/ui.datepicker-es.js";s:4:"469e";s:38:"res/jquery/js/i18n/ui.datepicker-et.js";s:4:"9894";s:38:"res/jquery/js/i18n/ui.datepicker-eu.js";s:4:"80ad";s:38:"res/jquery/js/i18n/ui.datepicker-fa.js";s:4:"09d5";s:38:"res/jquery/js/i18n/ui.datepicker-fi.js";s:4:"c796";s:38:"res/jquery/js/i18n/ui.datepicker-fo.js";s:4:"c236";s:41:"res/jquery/js/i18n/ui.datepicker-fr-CH.js";s:4:"4c40";s:38:"res/jquery/js/i18n/ui.datepicker-fr.js";s:4:"59cc";s:38:"res/jquery/js/i18n/ui.datepicker-gl.js";s:4:"948d";s:38:"res/jquery/js/i18n/ui.datepicker-he.js";s:4:"1ee7";s:38:"res/jquery/js/i18n/ui.datepicker-hr.js";s:4:"593a";s:38:"res/jquery/js/i18n/ui.datepicker-hu.js";s:4:"4e49";s:38:"res/jquery/js/i18n/ui.datepicker-hy.js";s:4:"64b7";s:38:"res/jquery/js/i18n/ui.datepicker-id.js";s:4:"cc32";s:38:"res/jquery/js/i18n/ui.datepicker-is.js";s:4:"c1da";s:38:"res/jquery/js/i18n/ui.datepicker-it.js";s:4:"b1dc";s:38:"res/jquery/js/i18n/ui.datepicker-ja.js";s:4:"c38e";s:38:"res/jquery/js/i18n/ui.datepicker-ko.js";s:4:"16ca";s:38:"res/jquery/js/i18n/ui.datepicker-kz.js";s:4:"be24";s:38:"res/jquery/js/i18n/ui.datepicker-lt.js";s:4:"ab35";s:38:"res/jquery/js/i18n/ui.datepicker-lv.js";s:4:"2062";s:38:"res/jquery/js/i18n/ui.datepicker-ml.js";s:4:"8037";s:38:"res/jquery/js/i18n/ui.datepicker-ms.js";s:4:"85de";s:38:"res/jquery/js/i18n/ui.datepicker-nl.js";s:4:"b170";s:38:"res/jquery/js/i18n/ui.datepicker-no.js";s:4:"dcb1";s:38:"res/jquery/js/i18n/ui.datepicker-pl.js";s:4:"fbe2";s:41:"res/jquery/js/i18n/ui.datepicker-pt-BR.js";s:4:"4f41";s:38:"res/jquery/js/i18n/ui.datepicker-pt.js";s:4:"2e4a";s:38:"res/jquery/js/i18n/ui.datepicker-rm.js";s:4:"4158";s:38:"res/jquery/js/i18n/ui.datepicker-ro.js";s:4:"f2c1";s:38:"res/jquery/js/i18n/ui.datepicker-ru.js";s:4:"1789";s:38:"res/jquery/js/i18n/ui.datepicker-sk.js";s:4:"c1ec";s:38:"res/jquery/js/i18n/ui.datepicker-sl.js";s:4:"72d8";s:38:"res/jquery/js/i18n/ui.datepicker-sq.js";s:4:"3493";s:41:"res/jquery/js/i18n/ui.datepicker-sr-SR.js";s:4:"1a58";s:38:"res/jquery/js/i18n/ui.datepicker-sr.js";s:4:"4065";s:38:"res/jquery/js/i18n/ui.datepicker-sv.js";s:4:"8c79";s:38:"res/jquery/js/i18n/ui.datepicker-ta.js";s:4:"da76";s:38:"res/jquery/js/i18n/ui.datepicker-th.js";s:4:"ac63";s:38:"res/jquery/js/i18n/ui.datepicker-tj.js";s:4:"af2f";s:38:"res/jquery/js/i18n/ui.datepicker-tr.js";s:4:"9718";s:38:"res/jquery/js/i18n/ui.datepicker-uk.js";s:4:"9ae7";s:38:"res/jquery/js/i18n/ui.datepicker-vi.js";s:4:"be31";s:41:"res/jquery/js/i18n/ui.datepicker-zh-CN.js";s:4:"26ec";s:41:"res/jquery/js/i18n/ui.datepicker-zh-HK.js";s:4:"3b93";s:41:"res/jquery/js/i18n/ui.datepicker-zh-TW.js";s:4:"ef1e";s:25:"res/tagcloud/swfobject.js";s:4:"892a";s:25:"res/tagcloud/tagcloud.swf";s:4:"12eb";s:29:"res/themes/default/t3blog.css";s:4:"e12d";s:20:"static/constants.txt";s:4:"73b4";s:16:"static/setup.txt";s:4:"aea4";s:46:"widgets/class.tx_jft3blogwidget_getwidgets.php";s:4:"b2cf";s:69:"widgets/tx_jft3blogwidget_archive/class.tx_jft3blogwidget_archive.php";s:4:"6329";s:47:"widgets/tx_jft3blogwidget_archive/locallang.xml";s:4:"e888";s:83:"widgets/tx_jft3blogwidget_jquerycalendar/class.tx_jft3blogwidget_jquerycalendar.php";s:4:"7487";s:54:"widgets/tx_jft3blogwidget_jquerycalendar/locallang.xml";s:4:"9656";s:71:"widgets/tx_jft3blogwidget_tagcloud/class.tx_jft3blogwidget_tagcloud.php";s:4:"91b2";s:48:"widgets/tx_jft3blogwidget_tagcloud/locallang.xml";s:4:"7715";}',
	'suggests' => array(
	),
);

?>