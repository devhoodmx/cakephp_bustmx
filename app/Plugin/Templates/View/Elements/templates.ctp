<?php
$level = isset($level) ? $level : 2;
$prefix = isset($prefix) ? $prefix : '';
?>

<?php foreach($templates as $type => $items): ?>
<h<?php echo $level; ?> id='<?php echo empty($prefix) ? $type : $prefix . '-' . $type; ?>'>
	<?php echo ucfirst($type); ?>
</h<?php echo $level; ?>>

<ul class='templates-list'>
	<?php foreach($items as $index => $template): ?>
	<li>
		<?php
		$title = $template['name'];
		$class = 'template';
		$params = array('controller' => 'templates', 'action' => $template['action']);

		if ($template['complete']) {
			$class .= ' template-complete';
		}
		if (!empty($prefix)) {
			$params = $params + array('prefix' => $prefix, $prefix => true);
		}
		
		echo $this->Html->link(
			$title,
			$params,
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