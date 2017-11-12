<?php require_once('partials/_header.php'); ?>
	<style type="text/css">
		.help-block.with-errors {
		    color: #e82c2c;
		}
		#errors {
		    text-align: center;
		    color: #d61e1e;
		    margin-top: 20px;
		}
		#results-table_wrapper {
			margin-top: 20px;
		}
	</style>
	<div class="container">
		<!-- Form -->
		<form id="form-symbols" action="/submit" class="form d-block mx-auto mt-4" data-toggle="validator" style="max-width: 420px;">
			<div class="form-group">
				<label for="in-symbol">Company Symbol</label>
				<select name="symbol" class="form-control selectpicker with-ajax show-tick" id="in-symbol" data-live-search="true" size="1" data-size="1" data-error="Please select a symbol" required>
				</select>
				<div class="help-block with-errors"></div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label for="in-startdate">Start Date</label>
						<input type="text" name="start" class="form-control datepicker" id="in-startdate" placeholder="Start Date" data-error="Please select a date" required disabled>
						<div class="help-block with-errors"></div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label for="in-enddate">End Date</label>
						<input type="text" name="end" class="form-control datepicker" id="in-enddate" placeholder="End Date" data-error="Please select a date" required disabled>
						<div class="help-block with-errors"></div>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label for="in-email">Email</label>
				<input type="email" name="email" class="form-control" id="in-email" placeholder="Email" data-error="Please enter a valid email" required>
				<div class="help-block with-errors"></div>
			</div>

			<button type="submit" class="btn btn-primary btn-block">Submit</button>

			<div id="errors"></div>
		</form>

		<!-- Results -->
		<div class="results d-none">
			<button class="btn btn-primary btn-sm" onclick="location.reload();">Reset Form</button>
			<div class="row">
				<div class="col-md-6">
					<canvas id="results-chart" class="d-block mx-auto mt-4" width="400" height="400"></canvas>
				</div>
				<div class="col-md-6">
					<table id="results-table" class="table table-striped table-responsive" width="100%"></table>
				</div>
			</div>
		</div>
	</div>
<?php // Register JS. See app\View ?>
<?php $this->registerJs("
	APP.init();
"); ?>
<?php require_once('partials/_footer.php'); ?>

