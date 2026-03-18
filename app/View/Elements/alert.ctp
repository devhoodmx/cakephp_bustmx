<?php
$id = isset($id) ? $id : null;
$type = isset($type) ? $type : 'warning';
$dismissible = isset($dismissible) ? $dismissible : true;
$class = 'alert alert-' . $type;

if ($dismissible) {
	$class .= ' alert-dismissible fade in show';
}
?>
<div <?php echo (empty($id) ? '' : "id='$id'"); ?> class='<?php echo $class; ?>' role='alert'>
	<?php if ($dismissible): ?>
	<button type='button' class='close' data-dismiss='alert' aria-label='<?php echo __('close'); ?>'>
		<span aria-hidden='true'>&times;</span>
	</button>
	<?php endif; ?>
	<?php echo $message; ?>
</div>
