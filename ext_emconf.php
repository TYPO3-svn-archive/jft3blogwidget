<?php

########################################################################
# Extension Manager/Repository config file for ext "jft3blogwidget".
#
# Auto generated 15-05-2012 23:44
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
	'version' => '0.6.2',
	'constraints' => array(
		'depends' => array(
			'cms' => '',
			'php' => '5.0.0-0.0.0',
			'typo3' => '4.3.0-4.99.999',
			't3blog' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:121:{s:21:"ext_conf_template.txt";s:4:"7980";s:12:"ext_icon.gif";s:4:"47f4";s:17:"ext_localconf.php";s:4:"6b88";s:14:"ext_tables.php";s:4:"d905";s:13:"locallang.xml";s:4:"e3ce";s:12:"t3jquery.txt";s:4:"8cac";s:24:"compat/flashmessages.css";s:4:"4e2c";s:20:"compat/gfx/error.png";s:4:"e4dd";s:26:"compat/gfx/information.png";s:4:"3750";s:21:"compat/gfx/notice.png";s:4:"a882";s:17:"compat/gfx/ok.png";s:4:"8bfe";s:22:"compat/gfx/warning.png";s:4:"c847";s:14:"doc/manual.sxw";s:4:"832f";s:44:"lib/class.tx_jft3blogwidget_pagerenderer.php";s:4:"d61f";s:43:"lib/class.tx_jft3blogwidget_tsparserext.php";s:4:"ad59";s:24:"res/tx_jft3blogwidget.js";s:4:"1356";s:55:"res/jquery/css/theme-1.8.20/jquery-ui-1.8.20.custom.css";s:4:"48c4";s:65:"res/jquery/css/theme-1.8.20/images/ui-bg_flat_0_aaaaaa_40x100.png";s:4:"2a44";s:66:"res/jquery/css/theme-1.8.20/images/ui-bg_glass_55_fbf9ee_1x400.png";s:4:"f8f4";s:66:"res/jquery/css/theme-1.8.20/images/ui-bg_glass_65_ffffff_1x400.png";s:4:"e5a8";s:66:"res/jquery/css/theme-1.8.20/images/ui-bg_glass_75_dadada_1x400.png";s:4:"c12c";s:66:"res/jquery/css/theme-1.8.20/images/ui-bg_glass_75_e6e6e6_1x400.png";s:4:"f425";s:66:"res/jquery/css/theme-1.8.20/images/ui-bg_glass_75_ffffff_1x400.png";s:4:"97b1";s:75:"res/jquery/css/theme-1.8.20/images/ui-bg_highlight-soft_75_cccccc_1x100.png";s:4:"72c5";s:71:"res/jquery/css/theme-1.8.20/images/ui-bg_inset-soft_95_fef1ec_1x100.png";s:4:"61ce";s:62:"res/jquery/css/theme-1.8.20/images/ui-icons_222222_256x240.png";s:4:"ebe6";s:62:"res/jquery/css/theme-1.8.20/images/ui-icons_2e83ff_256x240.png";s:4:"2b99";s:62:"res/jquery/css/theme-1.8.20/images/ui-icons_454545_256x240.png";s:4:"119d";s:62:"res/jquery/css/theme-1.8.20/images/ui-icons_888888_256x240.png";s:4:"9c46";s:62:"res/jquery/css/theme-1.8.20/images/ui-icons_cd0a0a_256x240.png";s:4:"3e45";s:33:"res/jquery/js/jquery-1.7.2.min.js";s:4:"b8d6";s:31:"res/jquery/js/jquery-cookies.js";s:4:"dcd2";s:44:"res/jquery/js/jquery-ui-1.8.20.custom.min.js";s:4:"f7f0";s:36:"res/jquery/js/i18n/jquery-ui-i18n.js";s:4:"8595";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-af.js";s:4:"3f6d";s:48:"res/jquery/js/i18n/jquery.ui.datepicker-ar-DZ.js";s:4:"75fc";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-ar.js";s:4:"bd15";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-az.js";s:4:"d137";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-bg.js";s:4:"8098";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-bs.js";s:4:"1a61";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-ca.js";s:4:"b9f0";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-cs.js";s:4:"d974";s:48:"res/jquery/js/i18n/jquery.ui.datepicker-cy-GB.js";s:4:"3ebd";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-da.js";s:4:"a20a";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-de.js";s:4:"2312";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-el.js";s:4:"46b8";s:48:"res/jquery/js/i18n/jquery.ui.datepicker-en-AU.js";s:4:"4a38";s:48:"res/jquery/js/i18n/jquery.ui.datepicker-en-GB.js";s:4:"24a2";s:48:"res/jquery/js/i18n/jquery.ui.datepicker-en-NZ.js";s:4:"af98";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-eo.js";s:4:"ae01";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-es.js";s:4:"469e";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-et.js";s:4:"91f5";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-eu.js";s:4:"80ad";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-fa.js";s:4:"4fd1";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-fi.js";s:4:"fff0";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-fo.js";s:4:"c236";s:48:"res/jquery/js/i18n/jquery.ui.datepicker-fr-CH.js";s:4:"4c40";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-fr.js";s:4:"59cc";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-ge.js";s:4:"4c66";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-gl.js";s:4:"948d";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-he.js";s:4:"3937";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-hi.js";s:4:"1e26";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-hr.js";s:4:"593a";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-hu.js";s:4:"dee2";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-hy.js";s:4:"64b7";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-id.js";s:4:"cc32";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-is.js";s:4:"c1da";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-it.js";s:4:"b1dc";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-ja.js";s:4:"c38e";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-kk.js";s:4:"016c";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-km.js";s:4:"f5c6";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-ko.js";s:4:"6851";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-kz.js";s:4:"be24";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-lb.js";s:4:"642a";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-lt.js";s:4:"ab35";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-lv.js";s:4:"2062";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-mk.js";s:4:"cdfd";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-ml.js";s:4:"8037";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-ms.js";s:4:"85de";s:48:"res/jquery/js/i18n/jquery.ui.datepicker-nl-BE.js";s:4:"60b6";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-nl.js";s:4:"f754";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-no.js";s:4:"dcb1";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-pl.js";s:4:"fbe2";s:48:"res/jquery/js/i18n/jquery.ui.datepicker-pt-BR.js";s:4:"4f41";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-pt.js";s:4:"2e4a";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-rm.js";s:4:"4158";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-ro.js";s:4:"f2c1";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-ru.js";s:4:"1789";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-sk.js";s:4:"8b44";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-sl.js";s:4:"72d8";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-sq.js";s:4:"3493";s:48:"res/jquery/js/i18n/jquery.ui.datepicker-sr-SR.js";s:4:"1a58";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-sr.js";s:4:"4065";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-sv.js";s:4:"8c79";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-ta.js";s:4:"da76";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-th.js";s:4:"ac63";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-tj.js";s:4:"af2f";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-tr.js";s:4:"9718";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-uk.js";s:4:"ef99";s:45:"res/jquery/js/i18n/jquery.ui.datepicker-vi.js";s:4:"be31";s:48:"res/jquery/js/i18n/jquery.ui.datepicker-zh-CN.js";s:4:"26ec";s:48:"res/jquery/js/i18n/jquery.ui.datepicker-zh-HK.js";s:4:"3b93";s:48:"res/jquery/js/i18n/jquery.ui.datepicker-zh-TW.js";s:4:"ef1e";s:25:"res/tagcanvas/excanvas.js";s:4:"59e0";s:40:"res/tagcanvas/jquery.tagcanvas-1.17.1.js";s:4:"1549";s:44:"res/tagcanvas/jquery.tagcanvas-1.17.1.min.js";s:4:"e922";s:25:"res/tagcloud/swfobject.js";s:4:"892a";s:28:"res/tagcloud/tagcloud-ru.swf";s:4:"677f";s:25:"res/tagcloud/tagcloud.swf";s:4:"12eb";s:29:"res/themes/default/t3blog.css";s:4:"e12d";s:20:"static/constants.txt";s:4:"9d9e";s:16:"static/setup.txt";s:4:"9924";s:46:"widgets/class.tx_jft3blogwidget_getwidgets.php";s:4:"112f";s:69:"widgets/tx_jft3blogwidget_archive/class.tx_jft3blogwidget_archive.php";s:4:"3cba";s:47:"widgets/tx_jft3blogwidget_archive/locallang.xml";s:4:"7943";s:83:"widgets/tx_jft3blogwidget_jquerycalendar/class.tx_jft3blogwidget_jquerycalendar.php";s:4:"2667";s:54:"widgets/tx_jft3blogwidget_jquerycalendar/locallang.xml";s:4:"a4fb";s:73:"widgets/tx_jft3blogwidget_tagcanvas/class.tx_jft3blogwidget_tagcanvas.php";s:4:"2bbc";s:49:"widgets/tx_jft3blogwidget_tagcanvas/locallang.xml";s:4:"b656";s:71:"widgets/tx_jft3blogwidget_tagcloud/class.tx_jft3blogwidget_tagcloud.php";s:4:"fa41";s:48:"widgets/tx_jft3blogwidget_tagcloud/locallang.xml";s:4:"269a";}',
	'suggests' => array(
	),
);

?>