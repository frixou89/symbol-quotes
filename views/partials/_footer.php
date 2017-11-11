	<!-- JavaScript -->
	<script src="plugins/jquery-3.2.1.slim.min.js"></script>
	<script src="plugins/popper.min.js"></script>
	<script src="plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="plugins/typeahead.bundle.min.js"></script>

	<?php // Register JS dynamically ?>
	<?php if ($this->js) : ?>
		<script type="text/javascript">
			<?= $this->js ?>
		</script>
	<?php endif; ?>
</body>
</html>