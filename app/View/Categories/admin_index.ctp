<?php
$controllerKey = Utility::slug($this->params['controller']);
$modelKey = Inflector::singularize($controllerKey);
$model = Inflector::singularize($this->name);

$pageTitle = __d('modules', 'categories') . (empty($current) ? '' : ' de ' . $current['Category']['name']);
$addURL = array('controller' => 'categories', 'action' => 'add');

if (!empty($current)) {
	$addURL[] = $current['Category']['id'];
}

$this->Package->assign('view', 'css', array(
	'view.categories.admin-index'
));

$this->assign('title', __d('admin', 'page-title', $pageTitle, $config['simian']['title'], $config['simian']['version']));
$this->set('menuItemKey', 'configurations');
$this->set('submenuItemKey', 'categories');
?>

<?php $this->start('posstyle'); ?>
<style>
	<?php
	foreach ($categories as $key => $category) {
		if (!empty($category['Category']['color'])) {
			printf('.category-%s {background-color: %s}', $category['Category']['id'], $category['Category']['color']);
		}
	}
	?>
</style>
<?php $this->end(); ?>

<!-- Header -->
<div class='page-header'>
	<?php if ($current): ?>
	<!-- Breadcrumb -->
	<ol class='breadcrumb'>
		<li>
			<?php
			echo $this->Html->link(
				__('Inicio'),
				array(
					'controller' => 'categories',
					'action' => 'index'
				)
			);
			?>
		</li>

		<?php foreach ($parents as $key => $category): ?>
		<li>
			<?php
			echo $this->Html->link(
				$category['Category']['name'],
				array(
					'controller' => 'categories',
					'action' => 'index',
					$category['Category']['id'],
					Utility::slug($category['Category']['name'])
				)
			);
			?>
		</li>
		<?php endforeach; ?>
	</ol>
	<?php endif; ?>

	<!-- Title -->
	<h1>
		<?php echo $pageTitle; ?>

		<!-- Option buttons -->
		<span class='btn-group'>
			<?php
			echo $this->Html->link(
				__('add'),
				$addURL,
				array(
					'escape' => false,
					'title' => __('add'),
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
<div class='boxes columns-container'>
	<div class='boxes toolbar-group'>
		<?php echo $this->element('admin/widgets/lists/pagination', ['listKey' => $model]); ?>
	</div>

	<!-- Table -->
	<div class='table-responsive'>
		<table class='table table-hover'>
			<thead>
				<tr>
					<th width='36'></th>
					<th><?php echo __d('fields', 'name'); ?></th>
					<th width='142'></th>
				</tr>
			</thead>

			<tbody data-sortable-container >
				<?php
				foreach ($categories as $key => $category):
					$slug = Utility::slug($category['Category']['name']);
				?>
				<tr data-sortable data-model='Category' data-id="<?php echo $category['Category']['id']; ?>" data-name='<?php echo $category['Category']['name']; ?>' data-url='/admin/categories'>
					<td>
						<div class='category-color category-<?php echo $category['Category']['id']; ?>'></div>
					</td>

					<td>
						<?php
						echo $this->Html->link(
							$category['Category']['name'],
							array(
								'controller' => 'categories',
								'action' => 'index',
								$category['Category']['id'],
								$slug
							)
						);
						?>
						<?php if (!empty($category['Category']['code'])): ?>
						<span class='text-muted'><?php echo $category['Category']['code']; ?></span>
						<?php endif; ?>
					</td>

					<td>
						<div class='btn-toolbar pull-right'>
							<div class='btn-group'>
								<?php
								$title = __('add');
								echo $this->Html->link(
									"<i class='fas fa-plus'></i> <span class='btn-text'>" . $title . "</span>",
									array(
										'action' => 'add',
										$category['Category']['id']
									),
									array(
										'class' => 'btn btn-sm btn-success',
										'escape' => false,
										'title' => $title
									)
								);
								?>
							</div>

							<?php
							echo $this->element(
								'admin/widgets/actions/edit',
								array(
									'controller' => 'categories',
									'id' => $category['Category']['id'],
									'name' => $slug
								)
							);
							?>

							<?php
							$options = array(
								'disabled' => isset($category['Category']['deletable']) && !$category['Category']['deletable']
							);

							echo $this->element('admin/widgets/actions/delete', $options);
							?>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<!-- End table -->

	<div class='boxes toolbar-group'>
		<?php echo $this->element('admin/widgets/lists/pagination', ['listKey' => $model]); ?>
	</div>
</div>
<!-- End container -->
