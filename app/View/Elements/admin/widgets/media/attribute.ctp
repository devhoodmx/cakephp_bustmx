<?php if (empty($mediaContent)) : ?>
	<div id='media-attribute-modal' class="modal fade" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Editar atributos</h4>
				</div>
	  			<div class="modal-body"></div>
			</div>
		</div>
</div>
<?php else : ?>
	<div class=''>
		<?php
		echo $this->BootForm->create(
			'Media',
			array(
				'data-model' => 'Media',
				'data-id' => $media['id'],
				'data-name' => $media['name'],
				'data-url' => '/admin/media'
			)
		);
		?>
		<?php
		echo $this->element('admin/widgets/form/inputs', array('fields' => $mediaFields, 'modelKey' => 'Media'));
		?>

		<div class='d-flex justify-content-end align-items-center'>
			<?php
			echo $this->Html->link(
				__('cancel'),
				'#',
				[
					'data-dismiss' => 'modal',
					'class' => 'mr-4 text-danger'
				]
			);
			?>
			<?php
			echo $this->BootForm->submit('Guardar', array(
				'buttonType' => 'success',
				'class' => 'btn',
				'div' => false
			));
			?>
		</div>

		<?php
		echo $this->BootForm->end();
		?>
	</div>
<?php endif ?>
