<!-- Modal -->
<div id='<?php echo $id; ?>' class='modal fade' tabindex='-1' role='dialog'>
	<div class='modal-dialog' role='document'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='<?php echo __('close'); ?>'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title'><?php echo $modalTitle; ?></h4>
			</div>

			<div class='modal-body'>
				<?php echo $modalBody; ?>
			</div>

			<div class='modal-footer'>
				<button type='button' class='btn btn-default' data-dismiss='modal'><?php echo __('cancel'); ?></button>
				<button type='button' id='success-url' href='#' class='btn btn-primary'><?php echo __('accept'); ?></button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
