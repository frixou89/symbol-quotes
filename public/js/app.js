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

	  	// Ajax submit form for server validation
	  	form.on('submit', function(e) {
	  		e.preventDefault();
	  		// Remove previous error messages
	  		form.find('.help-block').html('');

	  		$.ajax({
		        url: '/submit',
		        async: 'false',
		        type: 'POST',
		        data: form.serialize(),
		        success: function(response){
		        	// if response.errors exists and is array means we have errors
		            if ( response.errors && typeof response.errors === 'object') {
		            	var errors = response.errors;
		            	for (var er in errors) {
					        if (errors.hasOwnProperty(er)) {
					    		form.find('[name="'+er+'"]').parent().find('.help-block').html(errors[er]);
					        }
					    }
					}
		        }
		    });

	  		return false;
	  	})
	}

	return {
		init: init,
	};
}());