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
		echo $this->Html->meta('favicon.ico', '/simian.ico', array('type' => 'icon'));
		echo $this->fetch('meta');
		?>

		<!-- Links -->
		<link rel='author' href='' />

		<!-- Fonts -->
		<link href='https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i' rel='stylesheet'>

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
					'admin.module.bootstrap',
					'admin.component.bootstrap-4-utilities',
					'admin.core.layout'
				),
				$assets['stylesheets'],
				array('[view]')
			),
			array('compressed' => true, 'cached' => false)
		);
		?>

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
		<header id='doc-header' class='clearfix'>
			<div class='pull-left'>
				<button id='doc-navbar-toggle' aria-expanded='false' class='navbar-toggle doc-nav-toggle' type='button'>
					<span class='sr-only'>Toggle navigation</span>
					<span class='icon-bar'></span>
					<span class='icon-bar'></span>
					<span class='icon-bar'></span>
				</button>

				<h1 id='doc-title' class='pull-left'>
					<?php
					echo $this->Html->link(
						'Website title',
						array('controller' => 'templates', 'action' => 'index'),
						array(
							'class' => 'dashboard'
						)
					);
					?>

					<?php
					$label = sprintf(
						"<i class='visible-xs-inline-block icon fas fa-arrow-right'></i><span class='hidden-xs'>%s<span>",
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
			<div class='pull-right'>
				<!-- Search form -->
				<?php
				echo $this->BootForm->create('search', array(
					'url' => array('controller' => 'templates', 'action' => 'search', 'admin' => true),
					'id' => 'search-form',
					'class' => 'pull-left'
				));

					echo $this->BootForm->input('q', array(
						'class' => 'form-control',
						'label' => array('class' => 'sr-only', 'text' => __('Buscar')),
						'placeholder' => __('Buscar'),
						'type' => 'text'
					));

				echo $this->BootForm->end();
				?>

				<!-- User menu -->
				<div id='user-dropdown-options' class='dropdown pull-left'>
					<?php
					$image = 'admin/user-avatar.svg';
					$dropdownContent = $this->Html->image($image, array(
						'id' => 'user-avatar',
						'alt' => 'mono'
					));
					$dropdownContent .= 'mono';
					$dropdownContent .= " <span class='caret'></span>";
					echo $this->BootForm->button($dropdownContent, array('class' => 'btn btn-link', 'data-toggle' => 'dropdown'));
					?>
					<!-- Dropdown menu -->
					<ul class='dropdown-menu dropdown-arrow-skin dropdown-menu-right' role='menu'>
						<li role='presentation'>
							<?php
							echo $this->Html->link(
								'Cuenta',
								array(
									'controller' => 'users',
									'action' => 'edit',
									1,
									'mono',
									'admin' => true
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

		<?php echo $this->element('admin/modals/confirm', array('id' => 'modalWindow', 'modalTitle' => null, 'modalBody' => null)); ?>
		<?php echo $this->fetch('modals'); ?>

		<!-- JavaScript -->
		<script>
			hozen.app.host = '<?php echo $_SERVER['SERVER_NAME']; ?>';
			hozen.app.baseURL = '<?php echo Router::url('/', true); ?>';
			hozen.app.locale = '<?php echo $locale; ?>';
			hozen.app.authenticated = false;
			hozen.app.authAccount = {};
		</script>

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
					'vendor.alertify.alertify',
					'vendor.jquery-ui.core',
					'vendor.jquery-ui.widget',
					'vendor.jquery-ui.mouse',
					'vendor.jquery-ui.sortable',
					'vendor.ckeditor.ckeditor',
					'vendor.ckeditor.adapters.jquery',
					'vendor.bootstrap-datepicker.bootstrap-datepicker',
					'widget.media-manager',
					'core.bootstrap-admin'
				),
				$assets['scripts'],
				array('[view]')
			),
			array('compressed' => false, 'cached' => false)
		);
		?>

		<?php echo $this->fetch('posscript'); ?>

		<?php if (Configure::read('debug') == 0): ?>
			<!--CKEditor BasePath -->
			<script>
				CKEDITOR.basePath = '/js/build/vendor/ckeditor/'
			</script>
		<?php endif ?>

		<?php
		if (Configure::read('debug') == 0) {
			echo $this->element('components/google_analytics');
		}
		?>

		<?php echo $this->element('sql_dump'); ?>
	</body>
</html>
