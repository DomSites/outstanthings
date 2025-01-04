/* global confirm, redux, redux_change */

!function($) {
	$(document).ready(function() {
	    if( $('.redux-container-datetime').length > 0 ) {
	    	$('.redux-container-datetime').each(function() {
	    		$(this).find('input[type="text"]').datetimepicker({
		            format:'Y/m/d H:i:s',
		            minDate: '0'
		        });
	    	});
	    };
	});
}(jQuery);
