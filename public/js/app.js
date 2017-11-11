var APP = (function () {
	var form = $('#form-symbols');

	var init = function() {
		// Selectpicker
		$('#in-symbol').selectpicker({
			minLength: 2,
			liveSearch: true,
	        maxOptions: 1,
	        size: '1',
	        showContent: true,
	    })
	    .ajaxSelectPicker({
	        ajax: {
	            url: '/search-symbols',
	            dataType: 'json',
	            type: 'POST',
	            data: {
		            q: '{{{q}}}'
		        }
	        },
	        locale: {
	            emptyTitle: 'Search for symbols...'
	        },
	    });

	    // Datepicker
	    $( '.datepicker' ).datepicker({
	    	showOtherMonths: true,
	  		selectOtherMonths: true,
	  		changeMonth: true,
	      	changeYear: true,
	      	maxDate: 'now',
	      	dateFormat: 'yy-mm-dd'
	    });

	    // Validation
	  	form.validator();
	}

	return {
		init: init,
	};
}());