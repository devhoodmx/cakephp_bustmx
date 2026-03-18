<?php if (Configure::read('debug') > 0 ): ?>
<div id='exception-info'>
	<h2>Exception</h2>

	<dl>
		<dt>Type:</dt>
		<dd><?php echo h($type); ?></dd>
		<dt><?php echo __d('cake_dev', 'File'); ?>:</dt>
		<dd><?php echo h($error->getFile()); ?></dd>
		<dt><?php echo __d('cake_dev', 'Line'); ?>:</dt>
		<dd><?php echo h($error->getLine()); ?></dd>
	</dl>

	<?php echo $this->element('exception_stack_trace'); ?>
</div>
<?php endif ?>