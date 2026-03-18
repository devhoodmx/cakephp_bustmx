<?php if (empty($linkOnly) && empty($dropwdown)) : ?>
	<div class='btn-toolbar pull-right'>
<?php endif ?>

<?php foreach ($actions as $key => $action) : ?>
	<?php if (empty($itemData[$model][(is_string($key) || is_array($action) ? $key : $action) . '_disabled_action'])) : ?>
		<?php if (empty($linkOnly) && empty($dropwdown)) : ?>
			<div class='btn-group'>
		<?php endif ?>
		<?php if (is_string($key) || is_string($action)) : ?>

			<?php if (!empty($dropwdown)) : ?>
				<?php
				$itemClass = '';
				if (is_string($key) && $key == 'header' && is_string($action)) {
					$itemClass = ' class="dropdown-header"';
				} else if (is_string($action) && $action == '-') {
					$itemClass = ' class="divider"';
				}
				?>
				<li role='presentation'<?php echo $itemClass ?>>
			<?php endif ?>
				<?php
				if ($action == 'edit' || (!empty($action['type']) && $action['type'] == 'edit')) {
					if (empty($isHeader)) {
						// Delete
						$options = array(
							'linkOnly' => TRUE,
							'menuItem' => !empty($dropwdown),
							'showTitle' => !empty($dropwdown)
						);

						if (is_array($action)) {
							$options = Set::merge($options, $action);
						}

						if (!empty($options['url'])) {
							$options['editUrl'] = Utility::redirect($options['url'], $itemData);
						} else {
							$options['url'] = array('controller' => !empty($secondaryItem) ? Inflector::tableize($model) : $this->params['controller'], 'action' => 'edit', 'params' => array($model . '.id', $model . '.name'), 'redirect' => !empty($secondaryItem));
							$options['editUrl'] = Utility::redirect($options['url'], $itemData);
						}

						echo $this->element('admin/widgets/actions/edit', $options);
					}
				} else if ($action == 'delete' || (!empty($action['type']) && $action['type'] == 'delete')) {
					if (empty($isHeader)) {
						// Delete
						$options = array(
							'linkOnly' => TRUE,
							'menuItem' => !empty($dropwdown),
							'showTitle' => !empty($dropwdown),
							'disabled' => isset($itemData[$model]['deletable']) && !$itemData[$model]['deletable']
						);

						if (is_array($action)) {
							$options = Set::merge($options, $action);
						}

						echo $this->element('admin/widgets/actions/delete', $options);
					}
				} else if ($action == 'toggle' || (!empty($action['type']) && $action['type'] == 'toggle')) {
					// Toggle
					$fieldName = is_string($key) ? $key : $field;
					$fieldExplode = explode('.', $fieldName);
					$fieldName = sizeof($fieldExplode) > 1 ? $fieldName : $model . '.' . $fieldName;
					$fieldKey = $fieldExplode[sizeof($fieldExplode) - 1];
					$modelKey = sizeof($fieldExplode) > 1 ? $fieldExplode[sizeof($fieldExplode) - 2] : $model;

					$options = array(
						'linkOnly' => TRUE,
						'menuItem' => !empty($dropwdown),
						'showTitle' => !empty($dropwdown),
						'field' => $fieldKey,
						'value' => Hash::get($itemData, $fieldName),
						'toggleModel' => $modelKey
					);

					if ($modelKey != $model) {
						$relatedModelData = Hash::get($itemData, str_replace('.' . $fieldKey, '', $fieldName));

						if (!empty($relatedModelData['id'])) {

							if (!empty($relatedModelData['name'])) {
								$relatedName = $relatedModelData['name'];
							} else if (!empty($relatedModelData['title'])) {
								$relatedName = $relatedModelData['name'];
							} else if (!empty($relatedModelData['display_name'])) {
								$relatedName = $relatedModelData['name'];
							} else {
								$relatedName = '';
							}

							$options['toggleId'] = $relatedModelData['id'];
							$options['toggleName'] = $relatedName;
							$options['toggleUrl'] = '/admin/' . Inflector::tableize($modelKey);
						}
					}

					if (is_array($action)) {
						$options = Set::merge($options, $action);
					}

					echo $this->element('admin/widgets/actions/toggle', $options);

				} else if (($key == 'options' || (!empty($action['type']) && $action['type'] == 'options')) && !empty($action) && empty($dropwdown)) {
					// Dropdown
					$options = array(
						'icon' => 'cog',
						'actionClass' => 'btn-default dropdown-toggle',
						'linkOnly' => TRUE,
						'data-toggle' => 'dropdown'
					);

					unset($action['icon']);
					unset($action['type']);

					echo $this->element('admin/widgets/actions/action', array('actionOptions' => $options));

					echo "<ul class='dropdown-menu dropdown-arrow-skin dropdown-menu-right' role='menu'>";

					echo $this->element('admin/widgets/lists/actions', array('actions' => $action, 'itemData' => $itemData, 'model' => $model, 'dropwdown' => TRUE));
					echo "</ul>";

				} else if ($key != 'header' && !empty($action) && is_array($action)){
					// General Actions
					$options = $action;
					$options['icon'] = $key;
					$options['title'] = isset($options['title']) ? $options['title'] : $key;
					$options['actionClass'] = empty($options['class']) ? NULL : $options['class'];
					$options['actionTitle'] = empty($options['title']) ? NULL : Utility::translate($options['title'], Inflector::underscore($model));
					$options['actionUrl'] = empty($options['url']) ? NULL : Utility::redirect($options['url'], $itemData);
					$options['linkOnly'] = TRUE;
					$options['menuItem'] = !empty($dropwdown);
					$options['showTitle'] = !empty($dropwdown);

					unset($options['url']);

					echo $this->element('admin/widgets/actions/action', array('actionOptions' => $options));
				} else if ($key == 'header' && is_string($action)) {
					echo Utility::translate($action, Inflector::underscore($model));
				}
				?>
			<?php if (!empty($dropwdown)) : ?>
				</li>
			<?php endif ?>
		<?php else: ?>
			<?php echo $this->element('admin/widgets/lists/actions', array('actions' => $action, 'itemData' => $itemData, 'model' => $model, 'linkOnly' => TRUE)); ?>
		<?php endif ?>
		<?php if (empty($linkOnly) && empty($dropwdown)) : ?>
			</div>
		<?php endif ?>
	<?php endif ?>
<?php endforeach ?>

<?php if (empty($linkOnly) && empty($dropwdown)) : ?>
	</div>
<?php endif ?>
