<?php
$this->assign('title', __d('admin', 'page-title', __('dashboard'), $config['simian']['title'], $config['simian']['version']));
$this->set('menuItemKey', 'home');
?>

<!-- Container -->
<div class='boxes columns-container'>
	<!-- Jumbotron -->
	<div class='jumbotron'>
		<h1>
			<?php
			$name = empty($currentUser['name']) ? $currentUser['username'] : $currentUser['name'];
			echo __('Hola %s.', $name);
			?>
		</h1>

		<p>
			<?php echo __('Bienvenido al sitio de administración de %s', $config['App']['configurations']['website-title']); ?>
		</p>
	</div>
	<!-- End jumbotron -->
</div>
