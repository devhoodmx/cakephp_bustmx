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
					'vendor.font-awesome.font-awesome',
 					'admin.module.bootstrap'
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
		<!-- Content -->
		<?php echo $this->fetch('content'); ?>

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
					'vendor.bootstrap.transition',
					'vendor.bootstrap.collapse',
					'vendor.bootstrap.alert'
				),
				$assets['scripts'],
				array('[view]')
			),
			array('compressed' => false, 'cached' => false)
		);
		?>

		<?php
		if (Configure::read('debug') == 0) {
			echo $this->element('components/google_analytics');
		}
		?>

		<?php echo $this->element('sql_dump'); ?>
	</body>
</html>
