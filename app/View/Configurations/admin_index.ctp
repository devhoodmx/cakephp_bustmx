<?php
$this->Package->assign('view', 'css', array(
	'view.configurations.admin-index'
));

$controllerKey = Utility::slug($this->params['controller']);
$modelKey = Inflector::singularize($controllerKey);
$model = Inflector::singularize($this->name);

$this->assign('title', __d('admin', 'page-title', __('Ajustes'), $config['simian']['title'], $config['simian']['version']));
$this->set('menuItemKey', 'configurations');
$this->set('submenuItemKey', 'configurations');

$activeCategory = empty($this->request->query['category_id']) ? FALSE : $this->request->query['category_id'];
?>

<!-- Header -->
<div class='page-header boxes'>
	<!-- Title -->
	<h1><?php echo __('Ajustes'); ?></h1>
</div>
<!-- End Header -->

<?php echo $this->Flash->render(); ?>

<!-- Container -->
<div class='boxes columns-container'>
	<!-- Main -->
	<div class='doc-body-main'>
		<!-- Tabs -->
		<ul class='nav nav-tabs'>
			<?php
			foreach ($categories as $key => $category):
				$activeClass = '';
				if (!$activeCategory && $key == 0) {
					$activeClass = 'active';
				} else if ($activeCategory == $category['Category']['id']) {
					$activeClass = 'active';
				}
			?>
			<li class="<?php echo $activeClass ?>">
				<?php
				echo $this->Html->link(
					$category['Category']['name'],
					__('#%s', Utility::slug($category['Category']['name'])),
					array(
						'escape' => false,
						'data-toggle' => 'tab'
					)
				);
				?>
			</li>
			<?php endforeach ?>
		</ul>
		<!-- End tabs -->

		<!-- Tab content -->
		<div class='tab-content'>
			<?php
			$actions = 1;
			$count = 0;

			if (Utility::is('prosimian')) {
				$actions++;
			}

			foreach ($configurations as $category => $configuration):
				$activeClass = '';
				if (!$activeCategory && $count == 0) {
					$activeClass = 'active';
				} else if ($activeCategory == $configuration[0]['Configuration']['category_id']) {
					$activeClass = 'active';
				}
			?>
			<div class='tab-pane <?php echo $activeClass ?>' id='<?php echo Utility::slug($category); ?>'>
				<div class='table-responsive'>
					<table class='table table-hover configurations-table'>
						<tbody>
							<?php
							foreach ($configuration as $key => $value):
								$class = sprintf(
									'state-%shidden',
									$value[$model]['hidden'] ? '' : 'not-'
								);
								$attributes = $value['Configuration']['attributes_map'];
								$urlSafeName = Utility::slug($value['Configuration']['name']);
							?>
							<tr class='<?php echo $class; ?>'
								data-model='<?php echo $model; ?>'
								data-id='<?php echo $value[$model]['id']; ?>'
								data-name='<?php echo $value[$model]['name']; ?>'
								data-url='/admin/<?php echo Inflector::tableize($model); ?>'>
								<td class='configuration-name-col'>
									<?php
									echo $this->Html->link(
										$value['Configuration']['name'],
										array(
											'controller' => 'configurations',
											'action' => 'edit',
											$value['Configuration']['id'],
											$urlSafeName
										)
									);
									?>
									<?php if (!empty($value['Configuration']['description'])): ?>
									<div class='small text-muted'><?php echo h($value['Configuration']['description']); ?></div>
									<?php endif; ?>
								</td>

								<td>
									<?php
									$_value = $value['Configuration']['value'];

									if (!empty($_value)) {
										if ($value['Configuration']['type'] == 'textarea') {
											echo $this->Text->autoParagraph($_value);
										} elseif ($value['Configuration']['type'] == 'radio') {
											if (isset($attributes['options'][$_value])) {
												echo $attributes['options'][$_value];
											}
										} elseif ($value['Configuration']['type'] == 'checkbox') {
											// Multiple
											if (isset($attributes['options'])) {
												$selectedValues = json_decode($_value);

												$buffer = [];
												foreach ($selectedValues as $selectedValue) {
													if (isset($value['Configuration']['attributes_map']['options'][$selectedValue])) {
														$buffer[] = $value['Configuration']['attributes_map']['options'][$selectedValue];
													}
												}

												echo implode(', ', $buffer);
											}
										} elseif ($value['Configuration']['type'] == 'code') {
											echo h($_value);
										} elseif ($value['Configuration']['type'] == 'image') {
											printf(
												"<div class='configuration-media'>%s</div>",
												$this->Html->image('/files/media/image/thn_' . $_value)
											);
										} elseif ($value['Configuration']['type'] == 'video') {
											printf(
												"<div class='configuration-media'>%s</div>",
												$this->element('components/video', [
													'source' => '/files/media/video/file_' . $_value
												])
											);
										} elseif ($value['Configuration']['type'] == 'file') {
											echo $this->Html->link(
												$_value,
												'/files/media/file/file_' . $value['MediaDocument']['key'] . '.' . $value['MediaDocument']['format'],
												array('target' => '_blank')
											);
										} else {
											echo $_value;
										}
									}
									?>
								</td>

								<td class='configuration-name-actions' width='<?php echo $actions * 50; ?>'>
									<div class='btn-toolbar pull-right'>
										<?php
										if (Utility::is('prosimian')) {
											echo $this->element('admin/widgets/actions/toggle', [
												'field' => 'hidden',
												'value' => $value[$model]['hidden'],
												'linkOnly' => true
											]);
										}

										echo $this->element(
											'admin/widgets/actions/edit',
											array(
												'controller' => 'configurations',
												'id' => $value['Configuration']['id'],
												'name' => $urlSafeName
											)
										);
										?>
									</div>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			<?php
			$count++;
			endforeach;
			?>
		</div>
		<!-- End tab content -->
	</div>
</div>
<!-- End container -->
