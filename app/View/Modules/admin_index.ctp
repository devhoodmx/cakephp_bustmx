<?php
$this->assign('title', __d('admin', 'page-title', __('Módulos'), $config['simian']['title'], $config['simian']['version']));
$this->set('menuItemKey', 'configurations');
$this->set('submenuItemKey', 'modules');
?>

<!-- Header -->
<div class='page-header'>
	<!-- Title -->
	<h1>
		<?php
		if (empty($parent)) {
			echo __('Módulos');
		} else {
			echo __('Módulos de %s', $parent['Module']['name']);
		}
		?>

		<!-- Option buttons -->
		<span class='btn-group'>
			<?php
			$url = array(
				'controller' => 'modules',
				'action' => 'add'
			);

			if (!empty($parent)) {
				$url[] = $parent['Module']['id'];
				$url[] = Utility::slug($parent['Module']['name']);
			}

			echo $this->Html->link(
				__('add'),
				$url,
				array(
					'escape' => false,
					'class' => 'btn btn-primary btn-sm'
				)
			);
			?>
		</span>
	</h1>
</div>
<!-- End header -->

<?php echo $this->Flash->render(); ?>

<!-- Container -->
<div class='boxes columns-container' data-sortable-container>
	<?php foreach ($modules as $key => $data): ?>
	<div data-sortable data-model="Category" data-id="<?php echo $data['Category']['id']; ?>" data-name="<?php echo $data['Category']['name']; ?>" data-url = "/admin/categories">
		<?php if (empty($parent)): ?>
		<h3>
			<?php echo $data['Category']['name']; ?>

			<?php
			echo $this->Html->link(
				'<i class="fas fa-plus"></i>',
				array(
					'controller' => 'modules',
					'action' => 'add',
					'?' => array(
						'category_id' => $data['Category']['id']
					)
				),
				array(
					'escape' => false,
					'class' => 'btn btn-sm btn-primary'
				)
			);
			?>
		</h3>
		<?php endif; ?>

		<!-- Table -->
		<div class='table-responsive'>
			<table class='table table-hover'>
				<thead>
					<tr>
						<th><?php echo __('Nombre'); ?></th>
						<th>&nbsp;</th> <!-- Button options -->
					</tr>
				</thead>

				<tbody data-sortable-container>
					<?php if (empty($data['children'])): ?>
					<tr>
						<td colspan='2' class='text-muted'>
							<?php echo __('empty-list'); ?>
						</td>
					</tr>
					<?php else: ?>

					<?php
					foreach ($data['children'] as $key => $module) :
						$urlSafeName = Utility::slug($module['Module']['name']);
					?>
					<!-- Row <?php echo $key + 1; ?> -->
					<tr data-sortable data-model = "Module" data-id = "<?php echo $module['Module']['id']; ?>" data-name="<?php echo $module['Module']['name']; ?>" data-url = "/admin/modules">
						<td>
							<?php
							echo $module['Module']['children'] ?
								$this->Html->link(
									$module['Module']['name'],
									array(
										'action' => 'index',
										$module['Module']['id'],
										$urlSafeName
									)
								) : $module['Module']['name'];
							?>
						</td>

						<td>
							<div class='btn-toolbar pull-right'>
								<div class="btn-group">
									<?php
									echo $this->Html->link(
										'<i class="fas fa-plus"></i>',
										array(
											'controller' => 'modules',
											'action' => 'add',
											$module['Module']['id'],
											$urlSafeName
										),
										array(
											'escape' => false,
											'class' => 'btn btn-sm btn-info',
											'title' => __('add-submodule', $module['Module']['name'])
										)
									);
									?>
								</div>

								<?php echo $this->element('admin/widgets/actions/edit', array('controller' => 'modules', 'name' => $module['Module']['name'], 'id' => $module['Module']['id'])); ?>
								<!-- Delete -->
								<?php echo $this->element('admin/widgets/actions/delete'); ?>
							</div>
						</td>
					</tr>
					<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
		<!-- End table -->
	</div>
<?php endforeach ?>
</div>
<!-- End container -->
