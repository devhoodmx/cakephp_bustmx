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
	<h1 class='pull-left'>
		<?php echo $pageTitle; ?>
		<!-- Option buttons -->
		<?php if (Utility::is('prosimian') && (!isset($configView['add']) || !empty($configView['add']))) : ?>
		<?php echo $this->element('admin/widgets/actions/add'); ?>
		<?php endif ?>
	</h1>
</div>
<!-- End header -->

<?php echo $this->Flash->render(); ?>

<!-- Container -->
<div class='boxes columns-container'>
	<?php foreach ($sections as $page => $group): ?>

	<?php if (!empty($page)): ?>
	<h2 class='h3'>
		<?php echo $page; ?>
	</h2>
	<?php endif; ?>

	<div class='table-responsive'>
		<table class='table table-hover'>
			<?php if (Utility::is('prosimian')): ?>
			<thead>
				<tr>
					<th width='35'>
						Tipo
					</th>

					<?php if (Utility::is('prosimian')): ?>
					<th>Clave</th>
					<?php endif; ?>

					<th>Nombre</th>

					<th></th>
				</tr>
			</thead>
			<?php endif; ?>

			<tbody>
				<?php foreach ($group as $section): ?>
				<tr data-model='Section' data-id='<?php echo $section['Section']['id']; ?>' data-name='<?php echo $section['Section']['name']; ?>' data-url='/admin/sections'>
					<td width='35' class='text-center'>
						<?php
						$icon = 'fa-file-invoice';

						if ($section['Section']['type'] == 'image') {
							$icon = 'fa-image';
						} elseif ($section['Section']['type'] == 'text') {
							$icon = 'fa-align-left';
						} elseif ($section['Section']['type'] == 'code') {
							$icon = 'fa-code';
						}

						printf("<i class='far %s'></i>", $icon);
						?>
					</td>

					<?php if (Utility::is('prosimian')): ?>
					<td width='100'>
						<span class='label label-info'><?php echo $section['Section']['key']; ?></span>
					</td>
					<?php endif; ?>

					<td>
						<?php
						echo $this->Html->link(
							$section['Section']['name'],
							[
								'controller' => 'sections',
								'action' => 'edit',
								$section['Section']['id'],
								Utility::slug($section['Section']['name'])
							],
							['escape' => false]
						);
						?>
					</td>

					<td>
						<div class='btn-toolbar pull-right'>
							<?php if (Utility::is('prosimian')): ?>
							<div class='btn-group'>
								<?php
								echo $this->Html->link(
									'<i class="far fa-copy"></i>',
									['action' => 'add', '?' => ['id' => $section['Section']['id']]],
									['class' => 'btn btn-info btn-sm', 'escape' => false]
								);
								?>
							</div>

							<div class='btn-group'>
								<?php
								echo $this->element('admin/widgets/actions/delete', [
									'disabled' => !$section['Section']['deletable']
								]);
								?>
							</div>

							<?php endif; ?>

							<div class='btn-group'>
								<?php
								echo $this->element('admin/widgets/actions/edit', [
									'controller' => $controllerKey, 'id' => $section['Section']['id'], 'name' => Utility::slug($section['Section']['name'])
								]);
								?>
							</div>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<?php endforeach; ?>
</div>
<!-- End container -->
