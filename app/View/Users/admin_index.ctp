<?php
$controllerKey = Utility::slug($this->params['controller']);
$modelKey = Inflector::singularize($controllerKey);
$model = Inflector::singularize($this->name);

$pageTitle = __d('modules', $controllerKey);

$this->assign('title', __d('admin', 'page-title', $pageTitle, $config['simian']['title'], $config['simian']['version']));
?>

<!-- Header -->
<div class='page-header boxes'>
	<!-- Title -->
	<h1>
		<?php echo $pageTitle; ?>

		<!-- Option buttons -->
		<?php if (!isset($configView['add']) || !empty($configView['add'])) : ?>
		<?php echo $this->element('admin/widgets/actions/add'); ?>
		<?php endif ?>
	</h1>
</div>
<!-- End header -->

<?php echo $this->Flash->render(); ?>

<!-- Container -->
<div class='boxes columns-container'>
	<div class='row toolbar-group'>
		<div class='col-md-8'>
			<?php
			echo $this->element('admin/components/filters', [
				'filters' => [
					'role_id' => [
						'options' => $roles,
						'empty' => __('Todos los roles')
					]
				]
			]);
			?>
		</div>

		<div class='col-md-4'>
			<div class='boxes'>
				<?php echo $this->element('admin/widgets/lists/pagination', array('listKey' => $model)); ?>
			</div>
		</div>
	</div>

	<?php
	$columns = 7;
	$actions = 3;
	?>
	<div class='table-responsive'>
		<table class='table table-hover'>
			<thead>
				<tr>
					<th>
						<?php echo __d($modelKey, 'profile-picture'); ?>
					</th>

					<th>
						<?php echo Utility::translate('username', $modelKey, 'fields'); ?>
					</th>

					<th>
						<?php echo Utility::translate('name', $modelKey, 'fields'); ?>
					</th>

					<th>
						<?php echo Utility::translate('email-short', $modelKey, 'fields'); ?>
					</th>

					<th>
						<?php echo __d('modules', 'role'); ?>
					</th>

					<th>
						<?php echo __d($modelKey, 'last-login'); ?>
					</th>

					<th width='<?php echo $actions * 50; ?>'></th>
				</tr>
			</thead>

			<tbody>
				<?php if (empty($users)): ?>
				<tr>
					<td colspan='<?php echo $columns; ?>' class='text-muted text-center'><?php echo __('empty-list'); ?></td>
				</tr>
				<?php else: ?>
				<?php
				foreach ($users as $key => $user):
					$class = sprintf(
						'state-%sactive',
						$user[$model]['active'] ? '' : 'not-'
					);
				?>
				<tr class='<?php echo $class; ?>'
					data-model='<?php echo $model; ?>'
					data-id='<?php echo $user[$model]['id']; ?>'
					data-name='<?php echo $user[$model]['username']; ?>'
					data-url='/admin/<?php echo Inflector::tableize($model); ?>'>
					<td>
						<?php
						$mediaConfiguration = $mediaConfig['profile'];
						$mediaConfiguration['mediaData'] = array('MediaProfile' => $user['MediaProfile']);
						$mediaConfiguration['viewOnly'] = true;

						echo $this->element('admin/widgets/media/manager', $mediaConfiguration);
						?>
					</td>

					<td>
						<?php echo $user[$model]['username']; ?>
					</td>

					<td>
						<?php echo $user[$model]['full_name']; ?>
					</td>

					<td>
						<?php
						if (!empty($user['User']['email'])) {
							echo $this->element('components/email', [
								'email' => $user['User']['email'],
								'icon' => false
							]);
						}
						?>
					</td>

					<td>
						<?php
						echo $this->Html->link(
							$user['Role']['name'],
							[
								'controller' => 'users',
								'action' => 'index',
								'?' => ['role_id' => $user['Role']['id']]
							]
						);
						?>
					</td>

					<td>
						<?php echo $this->Time->format($user[$model]['last_login'], '%d/%b/%Y %H:%M:%S'); ?>
					</td>

					<td>
						<div class='btn-toolbar pull-right'>
							<?php
							echo $this->element('admin/widgets/actions/toggle', array(
								'field' => 'active',
								'value' => $user['User']['active'],
								'linkOnly' => true
							));

							$title = __('edit');
							echo $this->Html->link(
								"<i class='fas fa-edit'></i> <span class='btn-text'>" . $title . "</span>",
								array(
									'action' => 'edit',
									$user[$model]['id'],
									Utility::slug($user[$model]['name'])
								),
								array(
									'class' => 'btn btn-sm btn-info',
									'escape' => false,
									'title' => $title
								)
							);

							$title = __('delete');
							echo $this->Html->link(
								"<i class='far fa-trash-alt'></i> <span class='btn-text'>" . $title . "</span>",
								'#',
								array(
									'escape' => false,
									'class' => 'btn btn-sm btn-danger',
									'data-delete',
									'title' => $title,
									'data-title' => $title,
									'data-dialog' => __('delete-dialog')
								)
							);
							?>
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
