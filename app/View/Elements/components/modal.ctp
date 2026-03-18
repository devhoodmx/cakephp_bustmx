<?php
$id = empty($id) ? '' : $id;
$class = sprintf('modal-component modal fade%s', (empty($class) ?  '' : ' ' . $class));
$centered = isset($centered) ? $centered : true;
$size = !empty($size) && in_array($size, array('sm', 'lg', 'xl')) ? $size : '';
?>
<div <?php empty($id) ? '' : printf("id='%s'", $id); ?>  class='<?php echo $class; ?>' tabindex='-1' role='dialog' aria-hidden='true' <?= !empty($static) ? ('data-backdrop="static"') : ''?>>
	<?php
	$class = 'modal-dialog';

	if ($centered) {
		$class .= ' modal-dialog-centered';
	}
	if ($size) {
		$class .= ' modal-' . $size;
	}
	?>
	<div class='<?php echo $class; ?>' role='document'>
		<div class='modal-content'>
			<?php if (!empty($header)): ?>
			<div class='modal-header'>
				<?php
				if (is_array($header)):
					$header = array_merge(
						array(
							'title' => '',
							'close' => true
						),
						$header
					);
				?>
				<?php if ($header['title']): ?>
				<h5 class='modal-title'><?php echo $header['title']; ?></h5>
				<?php endif; ?>

				<?php if ($header['close']): ?>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					<span aria-hidden='true'>&times;</span>
				</button>
				<?php endif; ?>
				<?php else: ?>
				<?php echo $header; ?>
				<?php endif; ?>
			</div>
			<?php endif; ?>

			<?php
			if (!empty($body)):
				$opts = [
					'class' => '',
					'content' => ''
				];
				$_class = 'modal-body';

				if (!is_array($body)) {
					$body = ['content' => $body];
				}

				$opts = array_merge($opts, $body);

				// Class
				if (!empty($opts['class'])) {
					$_class .= ' ' . $opts['class'];
				}
			?>
			<div class='<?php echo $_class; ?>'>
				<?php echo $opts['content']; ?>
			</div>
			<?php endif; ?>

			<?php if (!empty($footer)): ?>
			<div class='modal-footer'>
				<?php echo $footer; ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>
