<?php
$controllerKey = Utility::slug($this->params['controller']);
$modelKey = Inflector::singularize($controllerKey);
$model = Inflector::singularize($this->name);

$pageTitle = __d('modules', 'media-libraries');
$addURL = array('controller' => 'media_libraries', 'action' => 'add');

if (!empty($mediaLibrary)) {
	$addURL[] = $mediaLibrary['MediaLibrary']['id'];

	$addURL = Utility::redirect($addURL);
}

$this->Package->assign('view', 'css', array(
	'view.media-libraries.admin-index'
));

$this->assign('title', __d('admin', 'page-title', $pageTitle . (empty($mediaTitle) ? '' : $mediaTitle['MediaLibrary']['name']), $config['simian']['title'], $config['simian']['version']));

$this->set('menuItemKey', 'content');
$this->set('submenuItemKey', 'media_libraries');
?>

<!-- Header -->
<div class='page-header'>
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


	<!-- Breadcrumb -->
	<ol class='breadcrumb'>
		<li>
			<?php
			echo $this->Html->link(
				__('Inicio'),
				array(
					'controller' => 'media_libraries',
					'action' => 'index'
				)
			);
			?>
		</li>

		<?php if (!empty($path)) : ?>
			<?php foreach ($path as $key => $folder): ?>
			<li>
				<?php
				echo $this->Html->link(
					$folder['MediaLibrary']['name'],
					array(
						'controller' => 'media_libraries',
						'action' => 'index',
						$folder['MediaLibrary']['id'],
						Utility::slug($folder['MediaLibrary']['name'])
					)
				);
				?>
				<?php
				if ($key + 1 == sizeof($path)) {
					echo $this->Html->link(
						'<i class="fa fa-edit"></i>',
						Utility::redirect([
							'action' => 'edit',
							$folder['MediaLibrary']['id'],
							Utility::slug($folder['MediaLibrary']['name']),
							'redirect' => true
						]),
						['escape' => false, 'class' => 'small']
					);
				}
				?>
			</li>
			<?php endforeach; ?>
		<?php endif ?>
	</ol>
</div>
<!-- End header -->

<?php echo $this->Flash->render(); ?>

<?php if (!empty($libraries)) : ?>
<div class='folders d-flex flex-wrap' data-sortable-container>
	<?php foreach($libraries as $library) : ?>
		<div class='mr-4 mb-3 d-flex  align-items-center btn' style='background: <?php echo $library['MediaLibrary']['color'] ?>;' data-model='MediaLibrary' data-id='<?php echo $library['MediaLibrary']['id'] ?>' data-name='<?php echo $library['MediaLibrary']['name'] ?>' data-sortable data-url='/admin/media_libraries'>
			<div>
				<?php
				echo $this->Html->link(
					'<i class="fa fa-folder mr-2"></i> ' . $library['MediaLibrary']['name'],
					[
						'action' => 'index',
						$library['MediaLibrary']['id'],
						Utility::slug($library['MediaLibrary']['name'])
 					],
 					[
 						'escape' => false,
 						'class' => 'btn',
 						'style' => 'color: #' . (Utility::isDark($library['MediaLibrary']['color']) ? 'fff' : '000') . ';'
 					]
 				);
				?>
			</div>
			<div class='ml-4'>
				<?php
				echo $this->element(
					'admin/widgets/actions/edit',
					array(
						'editUrl' => Utility::redirect([
							'controller' => 'media_libraries',
							'action' => 'edit',
							$library['MediaLibrary']['id'],
							Utility::slug($library['MediaLibrary']['name']),
							'redirect' => true
						]),
						'size' => 'xs mr-1'
					)
				);

				echo $this->element('admin/widgets/actions/delete', ['size' => 'xs']);
				?>
			</div>
		</div>
	<?php endforeach ?>
</div>
<?php endif ?>

<hr />

<!-- Container -->
<div class='boxes columns-container mt-5'>
	<div class='boxes columns-container'>
		<div class='boxes toolbar-group'>
			<div class='d-flex flex-column flex-md-row flex-wrap align-items-center justify-content-between'>
				<div class='flex-fill'>
				<?php
				$filters = [
					'model' => [
						'empty' => 'Todos',
						'div' => 'mr-5 col-xs-6',
						'options' => empty($models) ? [] : $models
					],
					'type' => [
						'legend' => false,
						'empty' => false,
						'class' => 'd-inline-block mt-5 mr-2',
						'multiple' => 'checkbox',
						'options' => $types
					]
				];

				if (!empty($mediaLibrary) || empty($models)) {
					unset($filters['model']);
				}

				echo $this->element('admin/components/filters', [
					'listKey' => 'Media',
					'filters' => $filters
				]);
				?>
				</div>

				<div class='text-right flex-fill'>
					<?php echo $this->element('admin/widgets/lists/pagination', ['listKey' => 'Media']); ?>
				</div>
			</div>

		</div>
	</div>

	<div id='file-area'>
		<?php if (empty($mediaLibrary)) : ?>
			<?php
			$this->Package->append('view', 'js', array(
				'vendor.dropzone.dropzone',
				'widget.media-manager'
			));

			$this->Package->append('view', 'css', array(
				'admin.widget.media-manager'
			));
			?>
			<div class='d-flex flex-wrap justify-content-center'>
				<?php foreach ($files as $file) : ?>
					<?php if (!empty($mediaConfig[$file['Media']['model']][$file['Media']['collection']])) : ?>
						<div data-model='<?php echo $file['Media']['model'] ?>' data-id='<?php echo $file['Media']['foreign_key'] ?>'?>
							<?php
							$config = $mediaConfig[$file['Media']['model']][$file['Media']['collection']];

							$config['mediaLabel'] = false;
							$config['mediaMultiple'] = false;
							$config['mediaData'] = [$config['mediaField'] => $file['Media']];
							$config['mediaLibrary'] = true;

							if ($file['Media']['type'] == 'image' && empty($config['mediaPreview'])) {
							 	$config['mediaPreview'] = !empty($config['mediaVersions']['raw']) ? 'raw' : (!empty($config['mediaVersions']['img']) ? 'img' : $config['mediaVersions'][0]);
							}


							echo $this->element('admin/widgets/media/manager', $config);
							?>
						</div>
					<?php endif ?>
				<?php endforeach ?>
			</div>
		<?php else : ?>
			<div class='media-folder-files' data-model='MediaLibrary' data-id='<?php echo $mediaLibrary['MediaLibrary']['id'] ?>'?>
				<?php
				$config = $mediaConfig['MediaLibrary']['main'];
				$config['mediaLabel'] = false;
				$config['mediaLibrary'] = false;
				$config['mediaData'] = ['MediaMain' => Hash::extract($files, '{n}.Media')];

				echo $this->element('admin/widgets/media/manager', $config);
				?>
			</div>
		<?php endif ?>
	</div>


	<div class='boxes toolbar-group'>
		<?php echo $this->element('admin/widgets/lists/pagination', ['listKey' => 'Media']); ?>
	</div>
</div>
<!-- End container -->
