<!-- Table -->
<?php
$columns = 0;
$actionsWidth = 8 * 2; // Padding
$isSortable = !empty($sortableModels) && in_array($model, $sortableModels);
$states = [];

if (!empty($parentModel)) {
	$modelData = Inflector::variable($parentModel);
	$modelData = empty($$modelData) ? [] : $$modelData;
}
?>

<?php if (!empty($secondaryItem) && empty($aside) && empty($panel)) : ?>
	<br /><hr /><br />
<?php endif ?>
<?php if ((!empty($secondaryItem) && empty($panel)) || (isset($configList['title']) && (is_array($configList['title']) || $configList['title'] !== false))) : ?>
	<h2 class='clearfix'>


		<div class='d-flex justify-content-between flex-wrap align-items-center'>
		<?php if (!empty($configList['title']) && is_array($configList['title'])) : ?>
			<?php
			echo $this->Html->link(
				empty($configList['title'][0]) ? Utility::translate(Utility::slug(Inflector::tableize($listKey)),  Inflector::underscore($parentModel), 'modules') : Utility::translate($configList['title'][0], Inflector::underscore($parentModel), 'fields'),
				Utility::redirect(empty($configList['title'][1]) ? [] : $configList['title'][1], $modelData),
				empty($configList['title'][2]) ? [] : $configList['title'][2]
			);
			?>
		<?php elseif (!isset($configList['title']) || $configList['title'] !== false) : ?>
			<?php echo empty($configList['title']) ? Utility::translate(Utility::slug(Inflector::tableize($listKey)),  Inflector::underscore($parentModel), 'modules') : Utility::translate($configList['title'], Inflector::underscore($parentModel), 'fields'); ?>
		<?php endif ?>
			<?php if (!isset($configList['add']) || !empty($configList['add'])) : ?>
				<?php

				if (empty($configList['add']) || $configList['add'] === true) {
					$addUrl = Utility::redirect(array(
						'controller' => Inflector::tableize($model),
						'action' => 'add',
						$modelData[$parentModel]['id'],
						'redirect' => true
					));
				} else {
					$addUrl =Utility::redirect($configList['add'], $modelData);
				}
				?>
				<?php echo $this->element('admin/widgets/actions/add', array('addUrl' => $addUrl, 'size' => !empty($panel) ? 'xs' : null)); ?>
			<?php endif ?>
		</div>
	</h2>
<?php endif ?>

<div <?php echo empty($listKey) ? '' : "data-paginated='" . $listKey . "'" ?> class='table-responsive'>
	<table class='table table-hover'>
		<thead>
			<tr>
				<?php if (false && !empty($configList['actions'])) : ?>
					<?php $columns++; ?>
					<th></th>
				<?php endif ?>

				<?php foreach($configList['fields'] as $key => $field): ?>
					<?php $columns++; ?>
					<th class='<?php echo is_array($field) && !empty($field['class']) ? $field['class'] : '' ?>'>
						<?php
						$fieldName = explode('.', is_string($key) ? $key : $field);

						if ($field != 'list-counter') {
							$fieldModel = sizeof($fieldName) > 1 ? $fieldName[sizeof($fieldName) - 2] : $model;
							$fieldKey = Utility::slug($fieldName[sizeof($fieldName) - 1]);

							if ($fieldModel != $model && in_array($fieldKey, array('name', 'title', 'display-name'))) {
								echo Utility::translate(Utility::slug(Inflector::underscore($fieldModel)), 'modules');
							} else {
								echo Utility::translate($fieldKey, Inflector::underscore($fieldModel), 'fields');
							}
						}
						?>
					</th>
				<?php endforeach ?>

				<?php
				if (!empty($configList['actions'])):
					$columns++;
					$actionsWidth += sizeof($configList['actions']) * 42;

					foreach ($configList['actions'] as $key => $action) {
						if ($action == 'toggle' || (!empty($action['type']) && $action['type'] == 'toggle')) {
							$field = $key;
							$fieldParts = explode('.', $field);
							$fieldKey = $fieldParts[sizeof($fieldParts) - 1];
							$fieldModel = sizeof($fieldParts) > 1 ? $fieldParts[sizeof($fieldParts) - 2] : $model;

							if ($fieldModel == $model) {
								$states[$fieldKey] = $fieldKey;
							}
						}
					}
				?>
				<th width='<?php echo $actionsWidth; ?>'></th>
				<?php endif; ?>
			</tr>
		</thead>
		<tbody <?php echo $isSortable ? 'data-sortable-container' : '' ?>>
			<?php if (empty($listData)): ?>
				<tr>
					<td colspan='<?php echo $columns?>' class='text-empty text-center'><?php echo __('empty-list') ?></td>
				</tr>
			<?php else : ?>
				<?php foreach ($listData as $itemKey => $listItem): ?>
					<?php
					if (!empty($secondaryItem)) {
						$listItem[$model] = $listItem;
					}

					$name = '';
					$class = '';
					$classes = [];

					if (!empty($configList['nameField'])) {
						$nameField = $configList['nameField'];
					} else if (!empty($listItem[$model]['display_name'])) {
						$nameField = $model . '.display_name';
					} else if (!empty($listItem[$model]['name'])) {
						$nameField = $model . '.name';
					} else if (!empty($listItem[$model]['title'])) {
						$nameField = $model . '.title';
					} else {
						$nameField = '';
					}

					$name = Hash::get($listItem, $nameField);

					// Class
					if (!empty($states)) {
						foreach ($states as $_key => $state) {
							if (isset($listItem[$model][$state]) &&  empty($listItem[$model][$state . '_disabled_action'])) {
								$classes[] = sprintf(
									'state%s-%s',
									$listItem[$model][$state] ? '' : '-not',
									$state
								);
							}
						}
					}

					if (!empty($listItem[$model]['row_class'])) {
						$classes[] = $listItem[$model]['row_class'];
					}

					if (!empty($classes)) {
						$class = implode(' ', $classes);
					}
					?>
					<tr class='<?php echo $class; ?>'
						<?php echo $isSortable ? 'data-sortable' : '' ?> data-model='<?php echo $model ?>' data-id='<?php echo $listItem[$model]['id']?>' data-name='<?php echo $name ?>' data-url='/admin/<?php echo Inflector::tableize($model) ?>'>
						<?php if (false && !empty($configList['actions'])) : ?>
							<td></td>
						<?php endif ?>

						<?php foreach($configList['fields'] as $key => $field): ?>
							<td class='<?php echo is_array($field) && !empty($field['class']) ? $field['class'] : '' ?>'>
								<?php
								$fieldName = is_string($key) ? $key : $field;
								$fieldType = is_string($key) ? (!empty($field['type']) ? $field['type'] : $field) : 'default';
								$fieldExplode = explode('.', $fieldName);
								$fieldName = sizeof($fieldExplode) > 1 ? $fieldName : $model . '.' . $fieldName;
								$fieldKey = $fieldExplode[sizeof($fieldExplode) - 1];
								$modelKey = sizeof($fieldExplode) > 1 ? $fieldExplode[sizeof($fieldExplode) - 2] : $model;

								if ($fieldType == 'element') {
									echo $this->element('admin/list/' . Inflector::underscore($modelKey) . '/' .  Inflector::underscore($key), ['item' => $listItem]);
								} else if ($fieldType == 'link') {
									echo $this->Html->link(
										Hash::get($listItem, $fieldName),
										Utility::redirect(
											$field['url'],
											$listItem
										),
										array('escape' => false)
									);
								} else {
									if ($modelKey == 'Media') {
										$mediaConfiguration = sizeof($fieldExplode) > 2 ? $mediaConfig[$fieldExplode[sizeof($fieldExplode) - 3]][Utility::slug($fieldKey)] : $mediaConfig[Utility::slug($fieldKey)];
										$collectionName = 'Media' . Inflector::camelize(Inflector::slug($fieldKey));

										$mediaPath = '/' . str_replace('Media/' . $fieldKey, $collectionName . '/.', str_replace('.', '/', $fieldName));
										$mediaInfo = Set::extract($listItem, $mediaPath);

										if (is_array($field)) {
											$mediaConfiguration = Set::merge($mediaConfiguration, $field);
										}

										$mediaConfiguration['mediaData'] = empty($mediaInfo[0]) ? array() : array($collectionName => $mediaInfo[0]);
										$mediaConfiguration['mediaMultiple'] = FALSE;

										echo $this->element('admin/widgets/media/manager', $mediaConfiguration);
									} else if ($fieldName == $nameField) {
										if (is_array($configList['fields'][$key]) && !empty($configList['fields'][$key]['link'])) {
											switch ($configList['fields'][$key]['link']) {
												case 'view':
													echo $this->Html->link(
														$listItem[$modelKey][$fieldKey],
														array(
															'action' => 'view',
															$listItem[$modelKey]['id'],
															Utility::slug($listItem[$modelKey][$fieldKey])
														),
														array('escape' => false)
													);
													break;

												default:
													# code...
													break;
											}
										} else {
											echo $this->Html->link(
												Hash::get($listItem, $fieldName),
												Utility::redirect(
													!empty($configList['actions']['edit']['url']) ?
													$configList['actions']['edit']['url'] :
													array(
														'controller' => !empty($secondaryItem) ? Inflector::tableize($model) : $this->params['controller'],
														'action' => 'edit',
														$listItem[$modelKey]['id'],
														Utility::slug($listItem[$modelKey][$fieldKey]),
														'redirect' => !empty($secondaryItem)
													),
													$listItem
												),
												array('escape' => false)
											);
										}
									} else if ($field == 'list-counter') {
										echo '<span class="text-muted">' . ($itemKey + 1) . '</span>';
									} else {
										echo $this->Text->autoLink(Hash::get($listItem, $fieldName), array('target' => '_blank', 'escape' => false));
									}
								}
								?>
							</td>
						<?php endforeach ?>

						<?php if (!empty($configList['actions'])) : ?>
							<td>
								<?php echo $this->element('admin/widgets/lists/actions', array('actions' => $configList['actions'], 'itemData' => $listItem, 'model' => $model, 'secondaryItem' => !empty($secondaryItem))); ?>
							</td>
						<?php endif ?>
					</tr>
				<?php endforeach ?>
			<?php endif ?>
		</tbody>
	</table>
</div>
<!-- End table -->
