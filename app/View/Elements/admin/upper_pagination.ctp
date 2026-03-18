<?php
// only displaying pagination elements when the total of records is greater than the limit
if ($this->Paginator->param('count') > $this->Paginator->param('limit')) :
?>
<!-- Pagination number -->
<span class='pagination-resume'>
	<?php echo $this->Paginator->counter('{:start} - {:end} de {:count}'); ?>
</span>

<!-- Pagination prev/next -->
<div class='btn-group'>
	<?php
	// Prev
	echo $this->Paginator->prev(
		"<i class='fas fa-chevron-left'></i>",
		array('tag' => false, 'escape' => false, 'class' => 'btn btn-default', 'title' => __('Anterior')),
		null,
		array('tag' => false, 'escape' => false, 'class' => 'btn btn-default disabled')
	);
	// Next
	echo $this->Paginator->next(
		"<i class='fas fa-chevron-right'></i>",
		array('tag' => false, 'escape' => false, 'class' => 'btn btn-default', 'title' => __('Siguiente')),
		null,
		array('tag' => false, 'escape' => false, 'class' => 'btn btn-default disabled')
	);
	?>
</div>
<?php endif; ?>