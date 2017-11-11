<?php require_once('partials/_header.php'); ?>
	<div class="container">
		<form action="/submit" class="d-block mx-auto mt-4" style="max-width: 320px;">
			<div class="form-group">
				<label for="in-symbol">Company Symbol</label>
				<input type="email" name="symbol" class="typeahead form-control" id="in-symbol" placeholder="Company Symbol" required>

			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label for="in-startdate">Start Date</label>
						<input type="text" name="start" class="form-control" id="in-startdate" placeholder="Start Date" required>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label for="in-enddate">End Date</label>
						<input type="text" name="end" class="form-control" id="in-enddate" placeholder="End Date" required>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label for="in-email">Email</label>
				<input type="email" name="email" class="form-control" id="in-email" placeholder="Email" required>
			</div>

			<button type="submit" class="btn btn-primary btn-block">Submit</button>
		</form>
	</div>
	<?php // Regiser JS for typeahead.js ?>
	<?php $this->registerJs("
	   
	"); ?>
<?php require_once('partials/_footer.php'); ?>

