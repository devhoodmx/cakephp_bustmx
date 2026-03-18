<?php
if (!empty($this->params->query['redirectURL'])) {
	$cancelAction = $this->params->query['redirectURL'];
} else {
	$cancelAction = empty($cancelAction) ? array('action' => 'index') : $cancelAction;
}
$model = empty($model) ? FALSE : $model;
$id = empty($id) ? FALSE : $id;
$dataUrl = empty($model) ? FALSE : __('/admin/%s', Inflector::tableize($model));
$size = empty($size) ? 'sm' : $size;
$deleteRedirect = empty($cancelAction) ? $this->Html->url(array('action' => 'index')) : $this->Html->url($cancelAction, TRUE);
?>

<!-- Option buttons -->
<div class='btn-toolbar pull-right'>
	<?php
	// Cancel
	echo $this->Html->link(__('cancel'),
		$cancelAction,
		array('class' => 'btn btn-link btn-' . $size . ' text-danger')
	);

	// Save
	echo $this->BootForm->submit(__('save'), array(
		'buttonType' => 'success',
		'class' => 'btn-' . $size,
		'div' => false
	));

	if (isset($delete) && $delete != false) {
		// Delete
		echo $this->Html->link(
			"<i class='far fa-trash-alt'></i>",
			'#',
			array(
				'escape' => false,
				'class' => 'btn btn-danger btn-' . $size,
				'data-delete',
				'data-dialog' => __('delete-dialog'),
				'data-redirect' => $deleteRedirect,
				'data-model' => $model,
				'data-id' => $id,
				'data-name' => $name,
				'data-url' => $dataUrl
			)
		);
	}
	?>
</div>