
<!-- ###TEMPLATE_CALENDAR_JS### begin -->
jQuery(document).ready(function(){
	var dates = new Array();
	<!-- ###DATES_ITEM### -->
	dates[###KEY###] = ['###DATE###', '###LINK###', '###COUNT###'];
	<!-- ###DATES_ITEM### -->
	jQuery('#datepicker').datepicker({
		dateFormat: 'yy-mm-dd',
		beforeShowDay: function(date) {
			var returnVal = false;
			var popupVal = '';
			var dateString = jQuery.datepicker.formatDate('yy-mm-dd', date);
			jQuery.each(dates, function(i, a){
				if (a[0] == dateString) {
					returnVal = true;
					popupVal = a[2];
				}
			});
			return [returnVal, '', popupVal];
		},
		onSelect: function(selectedDate) {
			jQuery.each(dates, function(i, a){
				if (a[0] == selectedDate) {
					document.location.href = a[1];
				}
			});
		}
	});
});
<!-- ###TEMPLATE_CALENDAR_JS### end -->
