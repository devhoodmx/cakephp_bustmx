<?php
// only displaying pagination elements when the total of records is greater than the limit
if ($this->Paginator->param('count') > $this->Paginator->param('limit')) :
?>
<!-- First / Prev -->
<ul class='pager'>
	<?php
	echo $this->Paginator->first(
		"<i class='fas fa-angle-double-left'></i>",
		array('tag' => 'li', 'escape' => false, 'title' => __('Primero'))
	);
	echo $this->Paginator->prev(
		"<i class='fas fa-angle-left'></i>",
		array('tag' => 'li', 'escape' => false, 'title' => __('Anterior')),
		"<a title='Anterior'><i class='fas fa-angle-left'></i></a>",
		array('tag' => 'li', 'escape' => false, 'class' => 'disabled')
	);
	if (!$this->Paginator->hasPrev()) :
	?>
		<li class='disabled'><?php echo $this->Html->link("<i class='fas fa-angle-double-left'></i>", '#', array('escape' => false, 'title' => __('Primero'))); ?></li>
	<?php endif; ?>
</ul>

<!-- Pagination numbers -->
<ul class='pagination'>
	<?php
	echo $numbers = $this->Paginator->numbers(array(
		'separator' => ' ',
		'tag' => 'li',
		'ellipsis' => null,
		'currentClass' => 'active',
		'currentTag' => 'a',
		'modulus' => 8
	));
	?>
</ul>

<!-- Next / Last -->
<ul class='pager'>
	<?php
	echo $this->Paginator->next(
		"<i class='fas fa-angle-right'></i>",
		array('tag' => 'li', 'escape' => false, 'title' => __('Siguiente')),
		"<a title='Siguiente'><i class='fas fa-angle-right'></i></a>",
		array('tag' => 'li', 'escape' => false, 'class' => 'disabled')
	);
	echo $this->Paginator->last(
		"<i class='fas fa-angle-double-right'></i>",
		array('tag' => 'li', 'escape' => false, 'title' => __('Último'))
	);
	if (!$this->Paginator->hasNext()) :
	?>
		<li class='disabled'><?php echo $this->Html->link("<i class='fas fa-angle-double-right'></i>", '#', array('escape' => false, 'title' => __('Último'))); ?></li>
	<?php endif; ?>
</ul>
<?php endif; ?>
