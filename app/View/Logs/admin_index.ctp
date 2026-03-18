<?php
$this->Package->append('vendor', 'js', array(
	'vendor.bootstrap-datepicker.locales.' . $locale
));
$this->Package->assign('view', 'js', [
	'app.logs.admin-index'
]);
$this->Package->assign('view', 'css', [
	'view.logs.admin-index'
]);

$pageTitle = 'Actividad de usuarios';

$this->assign('title', __d('admin', 'page-title', $pageTitle, $config['simian']['title'], $config['simian']['version']));
$this->set('menuItemKey', 'configurations');
$this->set('submenuItemKey', 'logs');

$this->Paginator->options([$this->passedArgs]);
?>

<div class='page-header boxes'>
	<!-- Title -->
	<h1>
		<?php echo $pageTitle; ?>
	</h1>
</div>

<div class='doc-body-main'>
	<div class='row toolbar-group'>
		<div class='col-xs-12 col-lg-9'>
			<?php
			echo $this->element('admin/components/filters', [
				'filters' => [
					'start' => [
						'type' => 'date',
						'size' => '12',
						'value' => $this->request->query('start') ? $this->request->query('start') : date('Y-m-01'),
						'format' => 'Y-m-d',
						'language' => $locale
					],
					'end' => [
						'type' => 'date',
						'size' => '12',
						'value' =>  $this->request->query('end') ? $this->request->query('end') : date('Y-m-t'),
						'format' => 'Y-m-d',
						'language' => $locale
					],
					'user_id' => [
						'options' => $users,
						'empty' => __('Todos los usuarios')
					],
					'model' => [
						'options' => $models,
						'empty' => __('Todos los objetos')
					]
				]
			]);
			?>
		</div>

		<div class='col-xs-12 col-lg-3'>
			<div class='boxes'>
				<?php echo $this->element('admin/widgets/lists/pagination', ['listKey' => 'Log']) ?>
			</div>
		</div>
	</div>

	<div class='table-responsive'>
		<table id='logs-catalogue' class='table table-hover'>
			<thead>
				<tr>
					<th><?php echo __d('log', 'user'); ?></th>
					<th><?php echo __d('log', 'model'); ?></th>
					<th><?php echo __d('log', 'name'); ?></th>
					<th width='100'><?php echo __d('log', 'action'); ?></th>
					<th><?php echo __d('log', 'date'); ?></th>
					<th></th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($logs as $log): ?>
				<tr>
					<td>
						<?php
						$userFullName = $log['User']['name'] . ' ' . $log['User']['last_name'];
						$username = $log['User']['username'];
						$userId = $log['User']['id'];

						if ($log['Log']['user_model'] == 'PublicUser') {
							$userFullName = 'Usuario';
							$username = 'public';
						}

						echo $this->Html->link(
							sprintf(
								"%s <small class='text-muted'>%s</small>",
								$userFullName,
								$username
							),
							[
								'action' => 'index',
								'?' => [
									'start' => $this->request->query('start') ? $this->request->query('start') : date('Y-m-01'),
									'end' => $this->request->query('end') ? $this->request->query('end') : date('Y-m-t'),
									'user_id' => $userId,
									'model' => $this->request->query('model')
								]
							],
							['escape' => false]
						);
						?>
					</td>

					<td>
						<?php echo __d('modules', str_replace('_', '-', Inflector::underscore($log['Log']['model']))); ?>
					</td>

					<td>
						<?php echo $log['Log']['name']; ?>
					</td>

					<?php
					$class = '';

					switch ($log['Log']['action']) {
						case 'CREATE':
							$class = 'success';
							$actionIcon = '<i class="fas fa-plus"></i> ';
							break;
						case 'UPDATE':
							$class = 'info';
							$actionIcon = '<i class="fas fa-edit"></i> ';
							break;
						case 'DELETE':
							$class = 'danger';
							$actionIcon = '<i class="fas fa-trash-alt"></i> ';
							break;
						case 'LOGIN':
							$class = 'success';
							$actionIcon = '<i class="fas fa-arrow-right"></i> ';
							break;
						case 'LOGOUT':
							$class = 'danger';
							$actionIcon = '<i class="fas fa-arrow-left"></i> ';
							break;
					}
					?>
					<td>
						<span class='label label-<?php echo $class; ?>'>
							<?php echo $actionIcon . __d('default', $log['Log']['action']); ?>
						</span>
					</td>

					<td><?php echo $this->Time->format($log['Log']['created'], '%d/%b/%Y %H:%M:%S'); ?></td>

					<th>
						<?php
						if (!empty($log['Log']['change'])) {
							echo $this->Html->link(
								'<i class="fas fa-chevron-down"></i>',
								'#',
								['class' => 'toggle', 'data-id' => $log['Log']['id'], 'escape' => false]
							);
						}
						?>
					</th>
				</tr>

				<?php if (!empty($log['Log']['change'])): ?>
				<tr id='log-<?php echo $log['Log']['id']; ?>' class='changes' data-mode='hidden'>
					<td colspan='6'>
						<?php
						$changes = json_decode($log['Log']['change'], true);

						if (!$changes):
						?>
						<div class='changes-text'>
							<?php echo $log['Log']['change']; ?>
						</div>
						<?php else: ?>
						<table class='table changes-table'>
							<?php foreach ($changes as $field => $change): ?>
							<tr>
								<th width='15%' scope='row'><?php echo $field; ?></th>
								<?php
								if (is_array($change)){
									$editions = $change;
									$change = '';

									foreach ($editions as $key => $edit){
										$change .= sprintf('<strong>%s:</strong> %s ', $key, $edit);
									}
								}
								?>
								<td><?php echo $change; ?></td>
							</tr>
							<?php endforeach; ?>
						</table>
						<?php endif; ?>
					</td>
				</tr>
				<?php endif; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>

	<div class='boxes toolbar-group'>
		<?php echo $this->element('admin/widgets/lists/pagination', ['listKey' => 'Log']) ?>
	</div>
</div>
