<?php
$this->Package->assign('view', 'css', array(
	'admin.component.webpage',
	'view.web-pages.admin-view',
));

$this->set('menuItemKey', 'content');
$this->set('submenuItemKey', 'web_pages');
$this->assign('title', __d('admin', 'page-title', $page[$currentLocaleModel]['name'], $config['simian']['title'], $config['simian']['version']));
?>
<!-- Header -->
<div class='page-header boxes'>
	<!-- Title -->
	<h1 class='pull-left'>
		<?php echo $page[$currentLocaleModel]['name']; ?>

		<?php
		$link = Router::url(
			array(
				'controller' => 'web_pages',
				'action' => 'view',
				'admin' => false
			)
		);

		if (!$config['App']['webpages']['pretty-urls']) {
			$link .= '/';
		}

		$link .= $page['WebPage'][$currentLocale . '_key'];

		echo $this->Html->link(
			sprintf(
				"/%s <i class='fas fa-external-link'></i>",
				$page['WebPage'][$currentLocale . '_key']
			),
			$link,
			array(
				'escape' => false,
				'class' => 'webpage-key small',
				'target' => '_blank'
			))
		;
		?>
	</h1>

	<!-- Option buttons -->
	<div class='btn-toolbar pull-right'>
		<div class='btn-group'>
			<?php
			$pageLocales = Configure::read('App.webpages.locale.options');
			$pageLocaleName = __d('web_page', 'locale-' . $currentLocale);
			?>
			<button id='dropdown-menu-actions' class='btn btn-default dropdown-toggle' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='true'>
				<?php echo $pageLocaleName; ?> <i class='fas fa-caret-down'></i>
			</button>

			<ul class='dropdown-menu dropdown-arrow-skin dropdown-menu-right' aria-labelledby='dropdown-menu-actions'>
				<?php foreach ($pageLocales as $key => $pageLocale): ?>
				<li class='<?php echo ($pageLocale == $currentLocale ? 'active' : ''); ?>'>
					<?php
					echo $this->Html->link(
						__d('web_page', 'locale-' . $pageLocale),
						array(
							'action' => 'view',
							$page['WebPage']['id'],
							'?' => array('lang' => $pageLocale)
						)
					);
					?>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div class='btn-group'>
			<?php
			echo $this->Html->link(
				"<i class='far fa-copy'></i>",
				array('action' => 'duplicate', $page['WebPage']['id'], $page['WebPage']['es_key'], 'view'),
				array(
					'class' => 'btn btn-primary btn-md',
					'title' => __('Duplicar'),
					'escape' => false
				)
			);
			?>

			<?php
			echo $this->Html->link(
				"<i class='fas fa-edit'></i>",
				array(
					'action' => 'edit',
					$page['WebPage']['id'],
					Utility::slug($page['WebPage']['name']),
					'?' => array('lang' => $currentLocale)
				),
				array(
					'class' => 'btn btn-info btn-md',
					'title' => __('Editar'),
					'escape' => false
				)
			);
			?>

			<?php
			echo $this->Html->link(
				"<i class='far fa-trash-alt'></i>",
				'#',
				array(
					'escape' => false,
					'class' => 'btn btn-danger btn-md',
					'data-delete',
					'data-dialog' => __('delete-dialog'),
					'data-redirect' => $this->Html->url(array('action' => 'index')),
					'data-model' => 'WebPage',
					'data-id' => $page['WebPage']['id'],
					'data-name' => $page['WebPage']['name'],
					'data-url' => '/admin/web_pages'
				)
			);
			?>
		</div>
	</div>
</div>
<!-- End header -->

<?php echo $this->Flash->render(); ?>

<!-- Container -->
<div class='boxes columns-container'>
	<?php echo $this->element('admin/web_pages/layout', array('page' => $page[$currentLocaleModel])); ?>
</div>
