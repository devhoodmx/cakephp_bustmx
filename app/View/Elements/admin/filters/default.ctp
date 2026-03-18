<div class='row'>
	<div class='col-sm-9'>
		<?php
		// Filters
		$filters = empty($filters) ? [] : $filters;

		echo $this->element('admin/components/filters', [
			'filters' => $filters
		]);
		?>
	</div>
	<div class='col-sm-3 text-right'>
	</div>
</div>
