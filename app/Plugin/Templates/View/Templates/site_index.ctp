<?php
$this->Package->assign('view', 'js', array(
	'vendor.alertify.alertify',
	'app.templates.index'
));
$this->Package->assign('view', 'css', array(
	'component.alertify',
	'view.templates.index'
));

// Page properties
$this->assign('title', __('page-title', __('Templates'), __('Site')));
// $this->assign('pageDescription', '');
// $this->assign('navItemKey', null);
?>
<div class='container'>
	<div class='doc-section'>
		<?php
		$this->start('alerts');
		echo $this->element('alert', array('message' => 'Warning'));
		echo $this->element('alert', array('message' => 'Success', 'type' => 'success'));
		echo $this->element('alert', array('message' => 'Info', 'type' => 'info'));
		$this->end();
		$this->append('alerts', $this->element('alert', array('message' => 'Danger', 'type' => 'danger')));

		echo $this->fetch('alerts');
		?>
		<h1>
			<?php
			echo $this->Html->link(
				__('Templates'),
				array('controller' => 'templates', 'action' => 'index')
			);
			?>
		</h1>
		<h2>
			<?php echo __('Second title'); ?>
		</h2>

		<h3>
			<?php echo __('Third title'); ?>
		</h3>

		<h4>
			<?php echo __('Fourth title'); ?>
		</h4>

		<?php
		echo $this->element('templates', array(
			'templates' => $templates
		));
		?>

		<h2>
			<?php echo __('Widgets'); ?>
		</h2>

		<ul id='widgets' class='templates-list'>
			<li>
				<?php
				echo $this->Html->link(
					'Modal',
					'#template-widget-modal',
					array(
						'class' => 'template',
						'escape' => false,
						'data-toggle' => 'modal',
						'role' => 'button'
					)
				);
				?>
			</li>
			<li>
				<?php
				echo $this->Html->link(
					'Alertify',
					'#template-widget-alertify',
					array(
						'class' => 'template app-alertify',
						'escape' => false,
						'data-type' => 'success'
					)
				);
				?>
			</li>
		</ul>

		<h2>
			<?php echo __('Menu'); ?>
		</h2>

		<div class='navbar navbar-default'>
			<div class='navbar-header'>
				<button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#templates-menu-collapse' aria-expanded='false'>
					<span class='sr-only'>Toggle navigation</span>
					<span class='icon-bar'></span>
					<span class='icon-bar'></span>
					<span class='icon-bar'></span>
				</button>
			</div>

			<div class='collapse navbar-collapse' id='templates-menu-collapse'>
				<?php
				echo $this->element('components/nav', array(
					'templates-menu',
					'items' => array(
						'home' => array(
							'name' => 'Home',
							'url' => array('controller' => 'templates', 'action' => 'home')
						),
						'about' => array(
							'name' => 'About',
							'url' => array('controller' => 'templates', 'action' => 'about')
						),
						'contact' => array(
							'name' => 'Contact',
							'url' => array('controller' => 'templates', 'action' => 'contact')
						),
					),
					'options' => array(
						'class' => ''
					)
				));
				?>
			</div>
		</div>

		<h2>
			<?php echo __('Text'); ?>
		</h2>

		<?php for ($index = 0; $index < 5; $index++): ?>
		<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
		<?php endfor; ?>

		<h2><?php echo __('Language'); ?></h2>

		<p>
			Locale: <?php echo $locale; ?>
		</p>

		<?php
		echo $this->Html->link(
			'en',
			array('?' => array('locale' => 'en')),
			null, false, false
		);
		?> |
		<?php
		echo $this->Html->link(
			'es',
			array('?' => array('locale' => 'es')),
			null, false, false
		);
		?>
	</div>
</div>
