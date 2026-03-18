<div class='media-item media-drop-item d-flex flex-column justify-content-center'>
	<?php if (empty($viewOnly) && empty($mediaLibrary)) : ?>
		<div class='icons'>
			<?php foreach ($mediaTypes as $type) : ?>
				<i class='fas fa-<?php echo $type ?>'></i>
			<?php endforeach ?>
		</div>
		<div class='drag-supported'>
			<?php echo __d('media', 'drag-supported', $this->Html->link(__d('media', 'click-here'), '#', array('data-media-modal' => ''))) ?>
			<div class='small text-muted mt-2'><small>(Máximo <strong><?php echo CakeNumber::toReadableSize($mediaMaxSize * 1024 * 1024) ?></strong> por archivo<?php echo empty($mediaExtensions) ? '' : (': *.' . implode(', *.', $mediaExtensions)) ?>)</small></div>
		</div>
		<div class='drag-unsupported'>
			<?php echo __d('media', 'drag-unsupported', $this->Html->link(__d('media', 'click-here'), '#', array('data-media-modal' => ''))) ?>
		</div>
	<?php endif ?>
</div>
