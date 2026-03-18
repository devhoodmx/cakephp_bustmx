<?php
$from = isset($from) ? $from : null;
?>
<div class='d-flex flex-column media-item media-loaded<?php echo empty($viewOnly) ? ' app-media-editable' : '' ?> <?php echo !empty($mediaItem['shared']) ? ' shared' : '' ?>' data-sortable data-model='Media' data-id='<?php echo $mediaItem['id'] ?>' data-name='<?php echo $mediaItem['name'] ?>' data-url="/admin/media">

	<div class='media-actions d-flex justify-content-between'>
		<?php
		echo $this->Html->link(
			"<i class='fas fa-share-alt'></i>",
			'#',
			array(
				'class' => 'btn btn-xs btn-primary app-media-share',
				'target' => '_blank',
				'title' => 'Compartir',
				'escape' => false
			)
		);
		?>
		<div class='btn-group'>
			<?php
			if (empty($viewOnly) && !empty($mediaAttributes[$mediaItem['type']]['fields'])) {
				echo $this->Html->link(
					'<i class="fa fa-ellipsis-h"></i>',
					'#',
					[
						'escape' => false,
						'title' => 'Editar atributos',
						'class' => 'btn btn-xs btn-success app-media-attributes'
					]
				);
			}

			if ($mediaItem['type'] == 'file') {
				echo $this->Html->link(
					"<i class='fas fa-download'></i>",
					array(
						'controller' => 'media',
						'action' => 'download',
						$mediaItem['id'],
						$mediaItem['key']
					),
					array(
						'class' => 'btn btn-xs btn-info',
						'target' => '_blank',
						'title' => 'Descargar',
						'escape' => false
					)
				);
			}

			if ($mediaItem['type'] == 'video') {
				echo $this->Html->link(
					"<i class='fas fa-expand'></i>",
					'#',
					array(
						'class' => 'btn btn-xs btn-info media-fullscreen',
						'title' => 'Pantalla Completa',
						'escape' => false
					)
				);
			}



			if (empty($viewOnly)) {
				echo $this->Html->link(
					"<i class='fas fa-retweet'></i>",
					'#',
					array(
						'escape' => false,
						'title' => __d('media', 'replace-media'),
						'class' => 'btn btn-xs btn-default media-edit'
					)
				);

				if (empty($mediaNotEmpty)) {
					echo $this->element('admin/widgets/actions/delete', array('linkOnly' => TRUE, 'size' => 'xs'));
				}
			}
			?>
		</div>
	</div>

	<div class='media-thumbnail'>
		<?php if ($mediaItem['type'] == 'image') : ?>
			<?php
			echo $this->Html->image(
				'/files/' . $mediaPath . '/image/thn_' . $mediaItem['key'] . '.' . $mediaItem['format'],
				array(
					'alt' => $mediaItem['name'],
					'data-preview' => empty($mediaPreview) ? null : '/files/' . $mediaPath . '/image/' . $mediaPreview . '_' . $mediaItem['key'] . '.' . $mediaItem['format'],
					'class' => empty($mediaPreview) ? null : 'app-media-preview'
				)
			);
			?>
		<?php elseif ($mediaItem['type'] == 'svg') : ?>
			<?php
			echo $this->Html->image(
				'/files/' . $mediaPath . '/svg/file_' . $mediaItem['key'] . '.' . $mediaItem['format'],
				array(
					'alt' => $mediaItem['name']
				)
			);
			?>
		<?php elseif ($mediaItem['type'] == 'video') : ?>
			<div class='media-control'>
				<i class='fa fa-play play-action media-control-action'></i>
				<i class='fa fa-pause pause-action media-control-action hidden'></i>
			</div>
			<video width="100%" height="100%" class='media-player'>
				<source src="<?php echo $this->Html->url(array(
					'controller' => 'media',
					'action' => 'video',
					'admin' => true,
					$mediaItem['id'],
					$mediaItem['key']
				)) ?>" type="video/mp4">
			</video>
		<?php elseif ($mediaItem['type'] == 'audio') : ?>
			<audio width="100%" height="100%" controls style='position: absolute; top: 50%; left: 3px; transform: translateY(-50%);'>
				<source src="<?php echo '/files/media/audio/file_' . $mediaItem['key'] . '.' . $mediaItem['format'] ?>" type="audio/mpeg">
			</audio>
		<?php else : ?>
			<i class='fas fa-<?php echo $mediaItem['type'] ?>'></i>
		<?php endif ?>
	</div>

	<div class='media-data flex-fill' data-media-name='<?php echo $mediaItem['name'] ?>'>
		<span class='media-name'><?php echo $mediaItem['name'] ?></span>
		<span class='media-size'><?php echo empty($mediaItem['size']) ? '' : CakeNumber::toReadableSize($mediaItem['size']) ?></span>
		<textarea class='media-name-textarea'><?php echo $mediaItem['name'] ?></textarea>
	</div>

	<?php
	if (!empty($mediaLibrary)) {
		echo $this->Html->link(
			'Ir a ' . mb_strtolower(Utility::translate(Utility::slug($mediaItem['model']), 'modules')),
			array_merge([
				'controller' => Inflector::tableize($mediaItem['model']),
				'action' => 'edit',
				$mediaItem['foreign_key']
			], $mediaUrl),
			[
				'escape' => false,
				'target' => '_blank',
				'class' => 'btn btn-primary btn-xs media-model-btn text-wrap'
			]
		);
	}
	?>
</div>
