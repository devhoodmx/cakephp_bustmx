<?php foreach ($boxes as $key => $box) : ?>
	<?php if (!empty($box) && ($this->params['action'] != 'admin_add' || empty($box[key($box)]['type']) || $box[key($box)]['type'] != 'list')) : ?>

		<?php $title = Utility::translate($key, Inflector::underscore($modelKey), 'fields') ?>

		<div class='panel panel-default'>
			<div class='panel-heading'>
				<h2 class='panel-title'>
					<?php echo $title ?>
					<?php if (!empty($box[key($box)]['type']) && $box[key($box)]['type'] == 'list' && (!isset($box[key($box)]['add']) || !empty($box[key($box)]['add']))) : ?>
						<?php
						$modelData = Inflector::variable($modelKey);
						$modelData = $$modelData;

						if (empty($box[key($box)]['add']) || $box[key($box)]['add'] === true) {
							$addUrl = Utility::redirect(array(
								'controller' => Inflector::tableize(key($box)),
								'action' => 'add',
								$modelData[$modelKey]['id'],
								'redirect' => true
							));
						} else {
							$addUrl =Utility::redirect($box[key($box)]['add'], $modelData);
						}
						?>
						<?php echo $this->element('admin/widgets/actions/add', array('class' => 'pull-right', 'size' => 'xs', 'addUrl' => $addUrl)); ?>
					<?php endif ?>
				</h2>
			</div>
			<div class='panel-body'>
				<?php echo $this->element('admin/widgets/form/inputs', array('fields' => $box, 'modelKey' => $modelKey, 'aside' => true)); ?>
			</div>

		</div>
	<?php endif ?>
<?php endforeach ?>
