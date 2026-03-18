<!DOCTYPE html>
<html lang='<?php echo $locale ?>'>
	<head>
		<meta charset='utf-8' />

		<title><?php echo Sanitize::html($this->fetch('title'), array('double' => false)); ?></title>

		<!-- Meta -->
		<?php
		echo $this->Html->meta('description', $this->fetch('pageDescription', $config['App']['description']));
		echo $this->Html->meta(array('name' => 'author', 'content' => 'affenbits'));
		echo $this->Html->meta(array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, user-scalable=no'));
		echo $this->Html->meta(['name' => 'robots', 'content' => 'noindex']);
		echo $this->fetch('meta');
		?>

		<!-- Links -->
		<link rel='author' href='https://affenbits.com' />
		<link rel='icon' href='/<?php echo $config['simian']['favicon']; ?>'>

		<!-- Resource hints -->
		<link rel='dns-prefetch' href='//fonts.googleapis.com'>
		<link rel='preconnect' href='https://fonts.gstatic.com/' crossorigin>

		<!-- Fonts -->
		<link href='https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i&display=swap' rel='stylesheet'>

		<!-- CSS -->
		<?php
		echo $this->Package->css(
			array_merge(
				array(
					'component.bootstrap-datepicker',
					'component.font-awesome-5.fontawesome',
					'component.font-awesome-5.solid',
					'component.font-awesome-5.regular',
					'component.font-awesome-5.brands',
					'component.alertify',
					'[component]',
					'admin.module.bootstrap',
					'admin.component.bootstrap-4-utilities',
					'admin.component.chosen',
					'admin.component.fontawesome',
					'admin.core.layout'
				),
				$assets['stylesheets'],
				array('[view]')
			),
			array('compressed' => true, 'cached' => false)
		);
		?>

		<?php echo $this->fetch('style'); ?>

		<!-- JavaScript -->
		<?php
		echo $this->Package->js(
			array(
				'core.core'
			),
			array('compressed' => true, 'cached' => false)
		);
		?>
	</head>

	<!-- Document -->
	<body>
		<!-- Header -->
		<header id='doc-header' class='d-flex justify-content-between'>
			<div class='header-col d-flex'>
				<button id='doc-navbar-toggle' aria-expanded='false' class='navbar-toggle doc-nav-toggle' type='button'>
					<span class='sr-only'>Toggle navigation</span>
					<span class='icon-bar'></span>
					<span class='icon-bar'></span>
					<span class='icon-bar'></span>
				</button>

				<h1 id='doc-title'>
					<?php
					echo $this->Html->link(
						$config['App']['configurations']['website-title'],
						array('controller' => 'pages', 'action' => 'home'),
						array(
							'class' => 'dashboard'
						)
					);
					?>

					<?php
					$label = sprintf(
						"<i class='icon fas fa-arrow-right d-lg-none'></i><span class='d-none d-lg-inline-block'>%s<span>",
						__('Ver sitio')
					);
					echo $this->Html->link(
						$label,
						array('controller' => 'pages', 'action' => 'home', 'admin' => false),
						array(
							'class' => 'website small',
							'target' => '_blank',
							'escape' => false
						)
					);
					?>
				</h1>
			</div>

			<!-- Options -->
			<div class='header-col d-flex align-items-center'>
				<?php
				if (!empty($components['search'])):
					if (!is_array($components['search'])) {
						$components['search'] = array();
					}
					if (empty($components['search']['url'])) {
						$components['search']['url'] = array(
							'controller' => $this->request->controller,
							'action' => 'index'
						);
					}
				?>
				<!-- Search form -->
				<?php
				echo $this->BootForm->create(null, [
					'id' => false,
					'type' => 'GET',
					'url' => $components['search']['url'],
					'class' => 'search-form d-none d-lg-block',
					'async' => false
				]);
					if (!empty($this->request->query)) {
						foreach ($this->request->query as $key => $value) {
							if ($key != 'q') {
								echo $this->BootForm->input($key, array(
									'type' => 'hidden',
									'name' => $key,
									'value' => $value,
									'id' => false
								));
							}
						}
					}

					echo $this->BootForm->input('q', array(
						'class' => 'form-control',
						'label' => array('class' => 'sr-only', 'text' => __('Buscar')),
						'placeholder' => __('Buscar'),
						'type' => 'text',
						'value' => $this->request->query('q')
					));
				echo $this->BootForm->end();
				?>
				<?php endif; ?>

				<!-- User dropdown -->
				<div class='user-dropdown dropdown'>
					<?php
					$image = 'admin/user-avatar.svg';

					if (!empty($currentUser['MediaProfile']['key'])) {
						$image = sprintf(
							'/files/media/image/car_%s.%s',
							$currentUser['MediaProfile']['key'],
							$currentUser['MediaProfile']['format']
						);
					}

					echo $this->BootForm->button(
						sprintf(
							"%s<span class='user-name dropdown-label'>%s</span><span class='caret'></span>",
							$this->Html->image($image, array(
								'class' => 'user-avatar dropdown-image',
								'alt' => $currentUser['username']
							)),
							empty($currentUser['name']) ? $currentUser['username'] : $currentUser['name']
						),
						['type' => 'button', 'class' => 'dropdown-btn btn btn-link', 'data-toggle' => 'dropdown']
					);
					?>
					<!-- Dropdown menu -->
					<ul class='dropdown-menu dropdown-arrow-skin dropdown-menu-right' role='menu'>
						<li role='presentation'>
							<?php
							echo $this->Html->link(
								__('Cuenta'),
								array(
									'controller' => 'users',
									'action' => 'profile'
								),
								array('escape' => false, 'role' => 'menuitem', 'tabindex' => '-1')
							);
							?>
						</li>

						<li role='presentation'>
							<?php
							echo $this->Html->link(
								__('Cerrar sesión'),
								array('controller' => 'users', 'action' => 'logout'),
								array('escape' => false, 'role' => 'menuitem', 'tabindex' => '-1')
							);
							?>
						</li>
					</ul>
				</div>
			</div>
		</header>

		<!-- Nav -->
		<nav class='doc-nav'>
			<?php echo $this->element('admin/menus/main'); ?>
		</nav>

		<!-- Body -->
		<main id='doc-body' class='doc-body container-fluid'>
			<?php echo $this->fetch('content'); ?>
		</main>

		<?php echo $this->fetch('templates'); ?>

		<?php echo $this->element('admin/modals/confirm', array('id' => 'modalWindow', 'modalTitle' => null, 'modalBody' => null)); ?>
		<?php echo $this->element('admin/modals/login'); ?>
		<?php echo $this->fetch('modals'); ?>

		<!-- JavaScript -->
		<script>
			hozen.app.host = '<?php echo $_SERVER['SERVER_NAME']; ?>';
			hozen.app.baseURL = '<?php echo Router::url('/', true); ?>';
			hozen.app.locale = '<?php echo $locale; ?>';
			hozen.app.authenticated = false;
			hozen.app.authAccount = {};

			<?php if (Configure::read('debug') < 2): ?>
			CKEDITOR_BASEPATH = '/js/build/vendor/ckeditor/';
			<?php endif; ?>
		</script>

		<?php echo $this->element('locale'); ?>

		<?php echo $this->fetch('script'); ?>

		<?php
		echo $this->Package->js(
			array_merge(
				array(
					'vendor.jquery.jquery',
					'vendor.underscore.underscore',
					'vendor.bootstrap.modal',
					'vendor.bootstrap.transition',
					'vendor.bootstrap.collapse',
					'vendor.bootstrap.dropdown',
					'vendor.bootstrap.alert',
					'vendor.bootstrap.tab',
					'vendor.bootstrap.carousel',
					'vendor.alertify.alertify',
					'vendor.sortable.sortable',
					'vendor.ckeditor.ckeditor',
					'vendor.ckeditor.adapters.jquery',
					'vendor.bootstrap-datepicker.bootstrap-datepicker',
					'vendor.clipboard.clipboard',
					'[vendor]',
					'config.editor.base',
					'component.editor',
					'component.bootstrap-datepicker',
					'[component]',
					'widget.media-manager',
					'core.bootstrap-admin'
				),
				$assets['scripts'],
				array('[view]')
			),
			array('compressed' => true, 'cached' => false)
		);
		?>

		<?php echo $this->fetch('posstyle'); ?>
		<?php echo $this->fetch('posscript'); ?>

		<?php
		if (Configure::read('debug') == 0) {
			echo $this->element('components/google_analytics');
		}
		?>

		<?php echo $this->element('sql_dump'); ?>
	</body>
</html>
