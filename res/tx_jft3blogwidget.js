
<!-- ###TEMPLATE_CALENDAR_JS### begin -->
jQuery(document).ready(function(){
	var dates = new Array();
	<!-- ###DATES_ITEM### -->
	dates[###KEY###] = ['###DATE###', '###CLASS###', '###LINK###', '###COUNT###'];
	<!-- ###DATES_ITEM### -->
	jQuery.datepicker.setDefaults(jQuery.datepicker.regional["###LANGUAGE###"]);
	jQuery('#datepicker').datepicker({
		dateFormat: 'yy-mm-dd',
		defaultDate: '###DATE_TO###',
		beforeShowDay: function(date) {
			var returnVal = false;
			var classVal = '';
			var popupVal = '';
			var dateString = jQuery.datepicker.formatDate('yy-mm-dd', date);
			jQuery.each(dates, function(i, a){
				if (a[0] == dateString) {
					returnVal = true;
					classVal = a[1];
					popupVal = a[3];
				}
			});
			return [returnVal, classVal, popupVal];
		},
		onSelect: function(selectedDate) {
			jQuery.each(dates, function(i, a){
				if (a[0] == selectedDate) {
					document.location.href = a[2];
				}
			});
		}
	});
});
<!-- ###TEMPLATE_CALENDAR_JS### end -->



<!-- ###TEMPLATE_ARCHIVE_JS### begin -->
jQuery(document).ready(function() {
	jQuery("a[id^='toggle']").each(function() {
		var $id = this.id;
		var year = $id.substr(6);
		if(jQuery.cookie('archive_'+year) == '1') {
			jQuery('#archive_'+year).toggle(false);
			jQuery('#'+$id).empty().append('###TOGGLE_OPEN###');
		} else {
			jQuery('#archive_'+year).toggle(true);
			jQuery('#'+$id).empty().append('###TOGGLE_CLOSE###');
		}
		jQuery('#'+$id).click(function(){
			jQuery('#archive_'+year).slideToggle('###SPEED###', function(i,a){
				if (jQuery('#archive_'+year).is(':visible')) {
					jQuery.cookie('archive_'+year,'0',{ path:'/'});
					jQuery('#'+$id).empty().append('###TOGGLE_CLOSE###');
				} else {
					jQuery.cookie('archive_'+year,'1',{ path:'/'});
					jQuery('#'+$id).empty().append('###TOGGLE_OPEN###');
				}
			});
			return false;
		});
	});
});
<!-- ###TEMPLATE_ARCHIVE_JS### end -->



<!-- ###TEMPLATE_TAGCLOUD_JS### begin -->
var rnumber = Math.floor(Math.random()*9999999);
var attributes = {
	bgcolor:"####BGCOLOR###"
};
var params = {
	allowfullscreen: true,
	allowScriptAccess: "always",
	wmode: "###WMODE###"
};
var flashvars = {
	tcolor: "0x###T_COLOR1###",
	tcolor2: "0x###T_COLOR2###",
	hicolor: "0x###HI_COLOR###",
	tspeed: "###SPEED###",
	distr: ###DISTR###,
	mode: "tags",
	tagcloud: "###TAGLINKS###",
}; 
var cumulusobject = swfobject;
cumulusobject.embedSWF("###SWF_TAGCLOUD###?r="+rnumber, "jft3blogwidgettagcloud", "###WIDTH###", "###HEIGHT###", "9", "", flashvars, params,attributes);
<!-- ###TEMPLATE_TAGCLOUD_JS### end -->
