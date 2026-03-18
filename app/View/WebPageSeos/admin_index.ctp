<?php
$controllerKey = Utility::slug($this->params['controller']);
$modelKey = Inflector::singularize($controllerKey);
$model = Inflector::singularize($this->name);
$modelData = Inflector::variable($model);
$seos = $$modelData;

$pageTitle = __d('modules', $controllerKey);

$this->assign('title', __d('admin', 'page-title', $pageTitle, $config['simian']['title'], $config['simian']['version']));
?>

<!-- Header -->
<div class='page-header boxes'>
	<!-- Title -->
	<h1>
		<?php echo $pageTitle; ?>
	</h1>
</div>
<!-- End header -->

<?php echo $this->Flash->render(); ?>

<!-- Container -->
<div class='boxes columns-container'>
	<div class='boxes toolbar-group'>
		<?php echo $this->element('admin/widgets/lists/pagination', array('listKey' => $model)); ?>
	</div>

	<?php
	$columns = 3;
	$actions = 1;
	?>
	<div class='table-responsive'>
		<table class='table table-hover'>
			<thead>
				<tr>
					<th>
						<?php echo Utility::translate('name', 'web_page_seo', 'fields'); ?>
					</th>

					<th>
						<?php echo Utility::translate('title', 'web_page_seo', 'fields'); ?>
					</th>

					<th></th>

					<th width='<?php echo $actions * 44 + 10; ?>'></th>
				</tr>
			</thead>

			<tbody>
				<?php if (empty($seos)): ?>
				<tr>
					<td colspan='<?php echo $columns; ?>' class='text-muted text-center'><?php echo __('empty-list'); ?></td>
				</tr>
				<?php else: ?>
				<?php
				foreach ($seos as $key => $seo):
					$name = $this->element('i18n/value', [
						'field' => 'name',
						'data' => $seo[$model]
					]);
				?>
				<tr data-model='<?php echo $model; ?>'
					data-id='<?php echo $seo[$model]['id']; ?>'
					data-name='<?php echo $name; ?>'
					data-url='/admin/<?php echo Inflector::tableize($model); ?>'>
					<td>
						<?php
						echo $this->Html->link(
							$name,
							[
								'action' => 'edit',
								$seo[$model]['id']
							],
							[
								'class' => ''
							]
						);
						?>
					</td>

					<td>
						<?php
						echo $this->element('i18n/value', [
							'field' => 'title',
							'data' => $seo[$model]
						]);
						?>
					</td>

					<td>
						<?php
						$mediaConfiguration = $mediaConfig['image'];
						$mediaInfo = $seo['MediaImage'];

						$mediaConfiguration['mediaData'] = array('MediaImage' => $mediaInfo);
						$mediaConfiguration['mediaMultiple'] = FALSE;

						echo $this->element('admin/widgets/media/manager', $mediaConfiguration);
						?>
					</td>

					<td>
						<div class='btn-toolbar pull-right'>
							<div class='btn-group'>
								<?php
								echo $this->Html->link(
									"<i class='fas fa-edit'></i>",
									[
										'action' => 'edit',
										$seo[$model]['id']
									],
									[
										'class' => 'btn btn-sm btn-info',
										'escape' => false
									]
								);
								?>
							</div>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

	<div class='boxes toolbar-group'>
		<?php echo $this->element('admin/widgets/lists/pagination', array('listKey' => $model)); ?>
	</div>
</div>
<!-- End container -->
