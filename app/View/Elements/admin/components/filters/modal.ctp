<?php
$id = empty($id) ? null : $id;
$class = 'filters-modal modal fade';
$title = __('Filtros avanzados');
$inputs =  !empty($inputs) ? $inputs : '';
$attrs = array(
	'id' => $id,
	'tabindex' => -1,
	'role' => 'dialog'
);
?>
<?php echo $this->Html->div($class, null, $attrs); ?>
	<div class='modal-dialog' role='document'>
		<div class='modal-content'>
			<?php
			echo $this->BootForm->create(false, [
				'id' => false,
				'type' => 'get',
				'async' => false,
				'class' => 'filters-form'
			]);
			?>
				<!-- Header -->
				<div class='modal-header'>
					<button type='button' class='close' data-dismiss='modal' aria-label='<?php echo __('close'); ?>'><span aria-hidden='true'>&times;</span></button>

					<h4 class='modal-title'>
						<?php echo $title; ?>
					</h4>
				</div>

				<!-- Body -->
				<div class='modal-body'>
					<?php echo $inputs; ?>
				</div>

				<!-- Footer -->
				<div class='modal-footer'>
					<button type='button' class='btn btn-default' data-dismiss='modal'><?php echo __('cancel'); ?></button>
					<button type='submit' class='btn btn-primary'><?php echo __('filter'); ?></button>
				</div>
			<?php echo $this->BootForm->end(); ?>
		</div>
	</div>
</div>
