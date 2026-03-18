<?php
$this->Package->assign('view', 'js', array(
	'app.templates.admin-index'
));
$this->Package->assign('view', 'css', array(
	'view.templates.index'
));

// Page properties
$this->assign('title', __('Templates') . ' | ' . __('Site'));
?>

<div>
	<!-- Alerts -->
	<?php
	$this->start('alerts');
	echo $this->element('alert', array('message' => "<strong>Warning</strong> Duis aliquet egestas purus in blandit.Duis aliquet egestas purus in blandit. <a href='#' class='alert-link'>Link vulputate.</a>"));
	echo $this->element('alert', array('message' => "<strong>Success</strong> Duis aliquet egestas purus in blandit.Duis aliquet egestas purus in blandit. <a href='#' class='alert-link'>Link vulputate.</a>", 'type' => 'success'));
	echo $this->element('alert', array('message' => "<strong>Info</strong> Duis aliquet egestas purus in blandit.Duis aliquet egestas purus in blandit. <a href='#' class='alert-link'>Link vulputate.</a>", 'type' => 'info'));
	$this->end();
	$this->append('alerts', $this->element('alert', array('message' => "<strong>Error</strong> Duis aliquet egestas purus in blandit.Duis aliquet egestas purus in blandit. <a href='#' class='alert-link'>Link vulputate.</a>", 'type' => 'danger')));

	echo $this->fetch('alerts');
	?>

	<!-- H* tags -->
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

	<?php foreach($templates as $type => $items): ?>
	<h2 id='<?php echo $type; ?>'>
		<?php echo ucfirst($type); ?>
	</h2>

	<ul class='templates-list'>
		<?php foreach($items as $index => $template): ?>
		<li>
			<?php
			$title = $template['name'];
			$class = 'template';
			if ($template['complete']) {
				$class .= ' template-complete';
			}
			echo $this->Html->link(
				$title,
				array('controller' => 'templates', 'action' => $template['action']),
				array(
					'class' => $class,
					'escape' => false
				)
			);
			?>
		</li>
		<?php endforeach; ?>
	</ul>
	<?php endforeach; ?>

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
