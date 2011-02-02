
<!-- ###TEMPLATE_CALENDAR_JS### begin -->
jQuery(document).ready(function(){
	var dates = new Array();
	<!-- ###DATES_ITEM### -->
	dates[###KEY###] = ['###DATE###', '###CLASS###', '###LINK###', '###COUNT###'];
	<!-- ###DATES_ITEM### -->
	jQuery('#datepicker').datepicker({
		dateFormat: 'yy-mm-dd',
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
	jQuery("#datepicker").datepicker("option", jQuery.datepicker.regional['###LANGUAGE###']);
});
<!-- ###TEMPLATE_CALENDAR_JS### end -->
