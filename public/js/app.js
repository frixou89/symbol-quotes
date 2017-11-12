var APP = (function () {
	var form = $('#form-symbols');
	var inpSymbol = form.find('#in-symbol');
	var inpStartDate = form.find('#in-startdate');
	var inpEndDate = form.find('#in-enddate');
	var inpEmail = form.find('#in-email');
	var resultsContainer = $('.results');
	var resultsTableContainer = $('#results-table');
	var resultsTable = null;
	var resultsChartContainer = $('#results-chart');
	var resultsChart = null;
	var errorsContainer = form.find('#errors');
	var loading = $('#loading');

	var selectedSymbol = '';
	var quotes = [];

	/**
	 * Initialize UI and plugins
	 */
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
	    			error: function() {
		  				resetForm();
		  				errorsContainer.html("Couldn't get data for current symbol. Please choose another symbol and try again.");
		  			},
	    			beforeSend: function() {
				    	// Reset and disable date inputs
				    	inpStartDate.attr('disabled', 'disabled');
				    	inpStartDate.val('');
				    	inpEndDate.attr('disabled', 'disabled');
				    	inpEndDate.val('');
				    	errorsContainer.html('');
				    	resultsTableContainer.html('');
				    },
				    success: function(response){
				    	quotes = response.quotes;
			        	// Set date range in JQuery datepicker
			        	if (response.date_from && response.date_to) {
			        		var dateFormat = "yy-mm-dd";
			        		var fromDate = new Date(response.date_from);
							var toDate = new Date(response.date_to);

			        		var from = inpStartDate.datepicker({
			        			defaultDate: fromDate,
			        			minDate: fromDate,
			        			maxDate: toDate,
			        			changeMonth: true,
			        			changeYear: true,
			        			dateFormat: dateFormat,
			        			numberOfMonths: 2
			        		})
			        		.on( "change", function() {
			        			to.datepicker( "option", "minDate", getDate(this));
			        		});

			        		var to = inpEndDate.datepicker({
			        			defaultDate: toDate,
			        			minDate: fromDate,
			        			maxDate: toDate,
			        			changeMonth: true,
			        			changeYear: true,
			        			dateFormat: dateFormat,
			        			numberOfMonths: 2
			        		})
			        		.on( "change", function() {
			        			from.datepicker( "option", "maxDate", getDate(this));
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
	  			beforeSend: function() {
	  				form.addClass('d-none');
	  				loading.removeClass('d-none');
	  			},
	  			error: function(response) {
	  				form.removeClass('d-none');
	  				// if response.errors exists and is array means we have errors
		        	if ( response.errors && typeof response.errors === 'object') {
		        		var errors = response.errors;
		        		for (var er in errors) {
		        			// Display error in corresponding input
		        			if (errors.hasOwnProperty(er)) {
		        				form.find('[name="'+er+'"]').parent().find('.help-block').html(errors[er]);
		        			}
		        		}
		        	}
	  			},
	  			success: function(response){
	  				// Hide form
	  				form.removeClass('d-block');
	  				form.addClass('d-none');

	        		var quotesFiltered = filterQuotes(quotes, new Date(inpStartDate.val()), new Date(inpEndDate.val()));
	        		if (resultsTableContainer.hasClass('initialized')) {
		        		resultsTable.destroy();
		        		resultsTableContainer.empty();
		        		resultsTableContainer.removeClass('initialized');
	        		}
	        		// Create table
	        		resultsTable = resultsTableContainer.addClass('initialized').DataTable( {
					    data: quotesFiltered,
					    columns: [
				            { data: 'date', title: 'Date' },
				            { data: 'open', title: 'Open' },
				            { data: 'high', title: 'High' },
				            { data: 'low', title: 'Low' },
				            { data: 'close', title: 'Close' },
				            { data: 'volume', title: 'Volume' }
				        ]
					});

					// Create Chart
					var openPrices = [];
					var closePrices = [];
					var chartLabels = [];
					var chartTitle = '';

					$(quotesFiltered).each(function() {
						chartLabels.push(this.date);
						openPrices.push(parseFloat(this.open));
						closePrices.push(parseFloat(this.open));
					})
					chartTitle = 'Open & Close prices for: ' + inpSymbol.val();

					var comiinedPrices = openPrices.concat(closePrices);

					var minYaxisValue = comiinedPrices.reduce(function(a, b) {
					    return Math.min(a, b);
					});

					var maxYaxisValue = comiinedPrices.reduce(function(a, b) {
					    return Math.max(a, b);
					});

					// Set chart data
		            var lineChartData = {
				        labels: chartLabels,
				        datasets: [{
				            label: "Open price",
				            borderColor: 'rgb(54, 162, 235)',
				            backgroundColor: 'rgb(54, 162, 235)',
				            fill: false,
				            data: openPrices,
				            yAxisID: "y-axis-1",
				        }, {
				            label: "Close Price",
				            borderColor: 'rgb(255, 99, 132)',
				            backgroundColor: 'rgb(255, 99, 132)',
				            fill: false,
				            data: closePrices,
				            yAxisID: "y-axis-2"
				        }]
				    };

				    // Render chart
			        resultsChart = Chart.Line(resultsChartContainer, {
			            data: lineChartData,
			            options: {
			                responsive: true,
			                hoverMode: 'index',
			                stacked: false,
			                title:{
			                    display: true,
			                    text: chartTitle
			                },
			                scales: {
			                    yAxes: [
			                    {
			                        type: "linear",
			                        display: true,
			                        position: "left",
			                        id: "y-axis-1",
			                        ticks: {
			                            min: minYaxisValue,
			                            max: maxYaxisValue,
			                            autoSkip: true, // Auto skip step size
    									maxTicksLimit: 24
			                        }
			                    }, 
			                    {
			                        type: "linear",
			                        display: false,
			                        position: "right",
			                        id: "y-axis-2",
			                        // grid line settings
			                        gridLines: {
			                            drawOnChartArea: false,
			                        },
			                    }],
			                }
			            }
			        });

				    // Show results container
				    loading.addClass('d-none');
				    resultsContainer.removeClass('d-none');
		        }
				    
		    });

		    // Prevent form submission
	  		return false;
	  	})
  	}

  	/**
  	 * Filter quotes from date range
  	 * @param  {object} quotes
  	 * @param  {date} from 
  	 * @param  {date} to
  	 * @return {objet}
  	 */
  	var filterQuotes = function(quotes, from, to) {
  		var filtered = [];
	  	$(quotes).each(function() {
	  		var q = this;
	  		var qTime = new Date(q.date).getTime();
	  		// if quote date is with from and to range add it to filtered object
	  		if (qTime >= from.getTime() && qTime <= to.getTime()) {
	  			filtered.push(q);
	  		}
	  	})
	  	return filtered;
  	}

  	/**
  	 * Reset all form fields
  	 */
  	var resetForm = function() {
  		inpSymbol.selectpicker('val', '');
  		inpStartDate.datepicker('setDate', '').attr('disabled', 'disabled');
  		inpEndDate.datepicker('setDate', '').attr('disabled', 'disabled');
  		inpEmail.val('');
  	}

  	return {
	  	init: init,
  	};

}());