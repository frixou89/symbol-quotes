	<!-- JavaScript -->
	<script src="plugins/jquery/jquery-3.2.1.min.js"></script>
	<script src="plugins/jquery/jquery-ui.min.js"></script>
	<script src="plugins/popper.min.js"></script>
	<script src="plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="plugins/bootstrap-select/js/bootstrap-select.min.js"></script>
	<script src="plugins/bootstrap-select/js/ajax-bootstrap-select.min.js"></script>
	<script src="plugins/validator.min.js"></script>
	<script src="plugins/datatables/dataTables.min.js"></script>
	<script src="plugins/Chart.bundle.min.js"></script>
	<script src="js/app.js"></script>

	<?php // Register JS dynamically ?>
	<?php if ($this->js) : ?>
	<script type="text/javascript"><?= $this->js ?></script>
	<?php endif; ?>
</body>
</html>