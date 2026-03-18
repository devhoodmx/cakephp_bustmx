<?php
$this->assign('title', __d('admin', 'page-title', 'Editar ajustes', $config['simian']['title'], $config['simian']['version']));
$this->set('menuItemKey', 'configurations');
$this->set('submenuItemKey', 'configurations');

// Start main form
echo $this->BootForm->create('Configuration', array(
	'data-model' => 'Configuration',
	'data-id' => $configuration['Configuration']['id']
));
?>
<!-- Header -->
<div class='page-header boxes'>
	<!-- Title -->
	<h1 class='pull-left'><?php echo $configuration['Configuration']['name']; ?></h1>
	<!-- Option buttons -->
	<?php
	echo $this->element('admin/widgets/form/actions', [
		'cancelAction' => [
			'action' => 'index',
			'?' => ['category_id' => $configuration['Configuration']['category_id']]
		]
	]);
	?>
</div>
<!-- End header -->

<!-- Main -->
<div class='doc-body-main'>
	<!-- Form -->
	<?php
	$options = array();
	$attributes = $configuration['Configuration']['attributes_map'];

	if (!empty($configuration['Configuration']['placeholder'])) {
		$options['placeholder'] = $configuration['Configuration']['placeholder'];
	}

	echo $this->BootForm->input('id');

	if ($configuration['Configuration']['type'] == 'textarea') {
		// Textarea
		echo $this->BootForm->input('value', array_merge(
			$options,
			array(
				'label' => false,
				'type' => 'textarea'
			)
		));
	} elseif ($configuration['Configuration']['type'] == 'radio') {
		// Radio
		$options = array(
			'type' => 'radio',
			'options' => empty($attributes['options']) ? array() : $attributes['options'],
			'legend' => false
		);

		echo $this->BootForm->input('value', $options);
	} elseif ($configuration['Configuration']['type'] == 'checkbox') {
		// Checkbox

		// Multiple
		if (isset($attributes['options'])) {
			$selected = null;

			if (!empty($configuration['Configuration']['value'])) {
				$values = json_decode($configuration['Configuration']['value']);
				$selected = array_combine($values, $values);
			}

			$options = [
				'multiple' => 'checkbox',
				'options' => empty($attributes['options']) ? array() : $attributes['options'],
				'label' => false,
				'value' => $selected
			];

			echo $this->BootForm->input('Configuration.value', $options);
		}
	} elseif ($configuration['Configuration']['type'] == 'bool') {
		echo $this->BootForm->input('value', array(
			'type' => 'radio',
			'options' => array(1 => 'Sí', 0 => 'No'),
			'legend' => false,
			'default' => $configuration['Configuration']['value'] ?  $configuration['Configuration']['value']  : 0
		));
	} elseif ($configuration['Configuration']['type'] == 'code') {
		// Code
		echo $this->element('components/ace', array(
			'language' => $configuration['Configuration']['language']
		));
	} elseif ($configuration['Configuration']['type'] == 'image') {
		// Image
		echo $this->element('admin/widgets/media/manager', $mediaConfig['image']);
	} elseif ($configuration['Configuration']['type'] == 'video') {
		// Video
		echo $this->element('admin/widgets/media/manager', $mediaConfig['video']);
	} elseif ($configuration['Configuration']['type'] == 'file') {
		// File
		echo $this->element('admin/widgets/media/manager', $mediaConfig['document']);
	} elseif ($configuration['Configuration']['type'] == 'editor') {
		// Rich editor
		echo $this->BootForm->input('value', array(
			'type' => 'editor',
			'label' => false
		));
	} else {
		// Text
		echo $this->BootForm->input('value', array_merge(
			$options,
			array(
				'label' => false,
				'type' => 'text'
			)
		));
	}
	?>
</div>

<?php
echo $this->BootForm->end();
// End main form
?>
