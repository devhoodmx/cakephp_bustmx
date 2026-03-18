<?php
$fields = $box;
$class = 'default';
$collapse = null;
$actions = [];

if (!empty($fields['class'])) {
	$class = $fields['class'];
	unset($fields['class']);
}

if (isset($fields['collapse']) && $fields['collapse'] !== null) {
	$collapse = $fields['collapse'];
	$uuid = $this->uuid('panel', []);

	if (is_string($collapse)) {
		$modelData = Inflector::variable($modelKey);
		$modelData = $$modelData;
		$validatedField = Hash::get($modelData, $collapse);

		if (!empty($validatedField)) {
			$collapse = false;
		}
	}
	unset($fields['collapse']);
}

if (!empty($fields['legend'])) {
	$key = $fields['legend'];
	unset($fields['legend']);
}

if (!empty($fields['type'])) {
	unset($fields['type']);
}

if (!empty($fields['actions'])) {
	$actions = $fields['actions'];
	unset($fields['actions']);
}
?>
<?php if (!empty($fields) && ($this->params['action'] != 'admin_add' || empty($fields[key($fields)]['type']) || $fields[key($fields)]['type'] != 'list')) : ?>

	<?php $title = Utility::translate($key, Inflector::underscore($modelKey), 'fields') ?>

	<div class='panel panel-<?php echo $class ?> overflow-visible'>
		<div class='panel-heading'>
			<h2 class='panel-title d-flex flex-wrap align-items-center justify-content-between'>
				<?php 
				if ($collapse !== null) {
					echo $this->Html->link($title, '#' . $uuid, ['escape' => false, 'data-toggle' => 'collapse']);
				} else {
					echo $title;
				}
				?>

				<div>
					<?php
					$modelData = Inflector::variable($modelKey);
					$modelData = empty($$modelData) ? null : $$modelData;
					?>


					<?php if (!empty($fields[key($fields)]['type']) && $fields[key($fields)]['type'] == 'list' && (!empty($actions) || (!empty($fields[key($fields)]['actions']) && sizeof($fields) <= 1))) : ?>
						<?php
						if (empty($actions)) {
							$actions = $fields[key($fields)]['actions'];
							$fields[key($fields)]['actions'] = [];
						}
						?>
					<?php endif ?>

					<?php if (!empty($fields[key($fields)]['type']) && $fields[key($fields)]['type'] == 'list' && (!isset($fields[key($fields)]['add']) || !empty($fields[key($fields)]['add'])) && sizeof($fields) <= 1) : ?>
						<?php
						if (empty($fields[key($fields)]['add']) || $fields[key($fields)]['add'] === true) {
							$addUrl = Utility::redirect(array(
								'controller' => Inflector::tableize(key($fields)),
								'action' => 'add',
								$modelData[$modelKey]['id'],
								'redirect' => true
							));
						} else {
							$addUrl =Utility::redirect($fields[key($fields)]['add'], $modelData);
						}

						$fields[key($fields)]['add'] = false;

						if (empty($actions)) {
							echo $this->element('admin/widgets/actions/add', array('size' => 'xs', 'addUrl' => $addUrl));
						} else  {
							$actions['plus'] = [
								'class' => 'btn-primary',
								'title' => __('add'),
								'url' => $addUrl
							];
						}
						?>
					<?php endif ?>


					<?php if (!empty($actions)) : ?>
						<?php echo $this->element('admin/widgets/lists/actions', array('actions' => $actions, 'itemData' => $modelData, 'model' => $modelKey, 'isHeader' => true)); ?>
					<?php endif ?>


				</div>
			</h2>
		</div>
		<div class='panel-body <?php echo $collapse === null ? '' : ('collapse ' . ($collapse ? '' : 'in')) ?>' <?php echo $collapse !== null ? ('id="' . $uuid . '"') : '' ?>>
			<?php echo $this->element('admin/widgets/form/inputs', array('fields' => $fields, 'modelKey' => $modelKey, 'panel' => true, 'aside' => !empty($aside))); ?>
		</div>

	</div>
<?php endif ?>
