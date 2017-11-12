var APP = (function () {
	var form = $('#form-symbols');
	var inpSymbol = form.find('#in-symbol');
	var inpStartDate = form.find('#in-startdate');
	var inpEndDate = form.find('#in-enddate');
	var inpEmail = form.find('#in-email');

	var selectedSymbol = '';
	var quotes = [];

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
		}).on('changed.bs.select', function (e) {
	    	// Prevent from calling ajax multiple times for the same symbol
	    	if (selectedSymbol !== inpSymbol.val()) {
	    		selectedSymbol = inpSymbol.val();
	    		$.ajax({
	    			url: '/get-quotes',
	    			async: 'false',
	    			type: 'POST',
	    			data: {s: selectedSymbol},
	    			beforeSend: function() {
				    	// Reset and disable date inputs
				    	inpStartDate.attr('disabled', 'disabled');
				    	inpStartDate.val('');
				    	inpEndDate.attr('disabled', 'disabled');
				    	inpEndDate.val('');
				    },
				    success: function(response){
				    	quotes = response;
			        	// Set date range in JQuery datepicker
			        	// if (response.date_from) {
			        	// 	$('.datepicker').datepicker('option', 'minDate', new Date(response.date_from));
			        	// }
			        	// if (response.date_to) {
			        	// 	$('.datepicker').datepicker('option', 'maxDate', new Date(response.date_to));
			        	// }
			        	if (response.date_from && response.date_to) {
			        		var dateFormat = "yy-mm-dd";

			        		var from = inpStartDate.datepicker({
			        			defaultDate: new Date(response.date_from),
			        			minDate: new Date(response.date_from),
			        			maxDate: new Date(response.date_to),
			        			changeMonth: true,
			        			changeYear: true,
			        			dateFormat: dateFormat,
			        			numberOfMonths: 2
			        		})
			        		.on( "change", function() {
			        			to.datepicker( "option", "minDate", getDate( this ) );
			        		});

			        		var to = inpEndDate.datepicker({
			        			defaultDate: new Date(response.date_to),
			        			minDate: new Date(response.date_from),
			        			maxDate: new Date(response.date_to),
			        			changeMonth: true,
			        			changeYear: true,
			        			dateFormat: dateFormat,
			        			numberOfMonths: 2
			        		})
			        		.on( "change", function() {
			        			from.datepicker( "option", "maxDate", getDate( this ) );
			        		});

			        		function getDate( element ) {
			        			var date;
			        			try {
			        				date = $.datepicker.parseDate( dateFormat, element.value );
			        			} catch( error ) {
			        				date = null;
			        			}

			        			return date;
			        		}
			        	}
			        	// Enable date inputs
			        	inpStartDate.removeAttr('disabled');
			        	inpEndDate.removeAttr('disabled');
			        }
			    });
	    	}
	    });

	    // Datepicker
	    // $( '.datepicker' ).datepicker({
	    // 	showOtherMonths: true,
	    // 	selectOtherMonths: true,
	    // 	changeMonth: true,
	    // 	changeYear: true,
	    // 	maxDate: 'now',
	    // 	dateFormat: 'yy-mm-dd'
	    // });

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

	  	function loadingHtml() {
	  		return '<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div></div>';
	  	}
	  }


	  return {
	  	init: init,
	  };
	}());