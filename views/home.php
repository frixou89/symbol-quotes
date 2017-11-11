<?php require_once('partials/_header.php'); ?>
	<style type="text/css">
		.help-block.with-errors {
		    color: #e82c2c;
		}
	</style>
	<div class="container">
		<form id="form-symbols" action="/submit" class="d-block mx-auto mt-4" style="max-width: 320px;" data-toggle="validator">
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
						<input type="text" name="start" class="form-control datepicker" id="in-startdate" placeholder="Start Date" data-error="Please select a date"required>
						<div class="help-block with-errors"></div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label for="in-enddate">End Date</label>
						<input type="text" name="end" class="form-control datepicker" id="in-enddate" placeholder="End Date" data-error="Please select a date"required>
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
		</form>
	</div>
<?php // Regiser JS ?>
<?php $this->registerJs("
	APP.init();
"); ?>
<?php require_once('partials/_footer.php'); ?>

