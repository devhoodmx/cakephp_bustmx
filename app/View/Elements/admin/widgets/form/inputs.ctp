<?php
foreach($fields as $field => $value):
	$attributes = is_array($value) ? $value : array('type' => $value);
	$type = empty($attributes['type']) ? '' : $attributes['type'];
?>
	<?php
	// Fieldset
	if (!empty($attributes['fields']) && is_array($attributes['fields']) && $type != 'list') :
		$_fields = $attributes['fields'];
		$legend = Utility::translate(Utility::slug($field), Inflector::underscore($modelKey));

		// Legend
		if (isset($attributes['legend'])) {
			$legend = $attributes['legend'];
		}

		// Remove non fieldset tag attributes
		unset($attributes['fields']);
		unset($attributes['legend']);
	?>
	<?php echo $this->Html->tag('fieldset', null, $attributes); ?>
		<?php if ($legend): ?>
			<legend><?php echo $legend; ?></legend>
		<?php endif; ?>

		<?php
		// Fields
		echo $this->element('admin/widgets/form/inputs', [
			'fields' => $_fields,
			'modelKey' => $modelKey,
			'panel' => !empty($panel),
			'aside' => !empty($aside)
		]);
		?>
	</fieldset>

	<?php else: ?>

	<?php
	// Field

	// Check types
	if (is_array($value) && (empty($value['type']) || $value['type'] == 'panel')) {
		echo $this->element('admin/widgets/form/panel', [
			'box' => $value,
			'key' => $field,
			'modelKey' => $modelKey,
			'panel' => !empty($panel),
			'aside' => !empty($aside)
		]);
	} elseif ($type == 'media') {
		// Media
		$this->BootForm->setEntity($field);

		$mediaKey = Utility::slug($this->BootForm->field());
		$mediaConfig[$mediaKey] = Set::merge($mediaConfig[$mediaKey], $attributes);

		if (sizeof($fields) == 1) {
			$mediaConfig[$mediaKey]['mediaLabel'] = false;
		}

		echo $this->element('admin/widgets/media/manager', $mediaConfig[$mediaKey]);
	} elseif (substr($type, 0, 4) == 'date') {
		// Date
		$attributes['field'] = $field;
		$attributes['model'] = $modelKey;
		$attributes['size'] = isset($attributes['size']) ? $attributes['size'] : (empty($panel) ? false  : 12);

		echo $this->element('admin/widgets/form/datepicker', $attributes);
	} else if ($type == 'list') {
		if ($this->params['action'] != 'admin_add') {
			$modelData = Inflector::variable($modelKey);
			$modelData = $$modelData;
			echo $this->element('admin/widgets/lists/table', array('configList' => $attributes, 'listData' => empty($modelData[$field]) ? [] : $modelData[$field], 'model' => empty($attributes['model']) ? $field : $attributes['model'], 'listKey' => $field, 'secondaryItem' => true, 'panel' => !empty($panel),
				'aside' => !empty($aside), 'parentModel' => $modelKey));
		}
	} else if ($type == 'element') {
		if (!empty($attributes['location'])) {
			echo $this->element($attributes['location']);
		} else {
			echo $this->element('forms/' . Inflector::tableize($modelKey) . '/' . $field);
		}
	} else if ($type == 'map') {
		echo $this->element('admin/widgets/form/map', ['field' => is_numeric($field) || empty($field) ? '' : ($field . '_'), 'options' => $attributes]);
	} else if ($type == 'hr') {
		echo '<hr />';
	} else if ($type == 'error') {
		echo $this->BootForm->error($field);
		echo '<div id="' . Inflector::camelize(Inflector::slug($field)) . '" class="input form-group"></div>';
	} else if ($type == 'alert') {
		echo empty($attributes['content']) ? '' : ('<div class="alert alert-' .  (empty($attributes['class']) ? 'default' : $attributes['class']) . '">' . $attributes['content'] . '</div>');
	} else {
		echo $this->BootForm->input($field, $attributes);
	}
	?>
	<?php endif; ?>
<?php endforeach; ?>
