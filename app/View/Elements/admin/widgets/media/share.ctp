<?php if (empty($mediaContent)) : ?>
	<div id='media-share-modal' class="modal fade" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Compartir</h4>
				</div>
	  			<div class="modal-body"></div>
			</div>
		</div>
	</div>
<?php else : ?>
	<div data-model='Media' data-id='<?php echo $media['id'] ?>' data-name='<?php echo $media['name'] ?>' data-url="/admin/media">
		<div class='text-center'>
			<?php echo $this->element('admin/widgets/actions/toggle', array('linkOnly' => true, 'size' => 'xs', 'field' => 'shared', 'value' => $media['shared'], 'toggleModel' => 'Media', 'directToggle' => true)); ?>
		</div>

		<?php if (!empty($mediaLink)) : ?>
			<?php $mediaVersions = $media['type'] == 'image' ? $mediaConfig['mediaVersions'] : ['file'] ?>

			<?php
			echo $this->BootForm->create('Media', ['url' => ['action' => 'change_share_key', $media['id']]]);
			?>
				<div class='d-flex justify-content-center align-items-top border-top pt-4 mt-3'>
					<?php
					echo $this->BootForm->input('share_key',[
						'type' => 'text',
						'label' => false,
						'prepend' => '<i class="fa fa-key"></i>',
						'div' => 'm-0',
						'value' => $media['share_key']
					]);
					?>
					<div>
						<?php
						echo $this->BootForm->button('<i class="fa fa-check"></i>', array(
							'escape' => false,
							'class' => 'btn btn-success ml-4',
							'div' => false
						));
						?>
					</div>
				</div>
			<?php
			echo $this->BootForm->end();
			?>

			<div class='table-responsive mt-4'>
				<table class='table table-hover'>
						<tr>
							<?php if (sizeof($mediaVersions) > 1) : ?>
								<th></th>
							<?php endif ?>
							<th></th>
							<th><i class='fa fa-download'></i></th>
							<th><i class='fa fa-link'></i></th>
						</tr>
					<?php foreach($mediaVersions as $version) : ?>
						<?php $shareUrl = ['controller' => 'media', 'action' => 'share', 'admin' => false, 'full_base' => true, empty($media['share_key']) ? $mediaLink['hash'] : $media['share_key'], 'ext' => $media['format'], 'version' => $version]; ?>
						<tr>
							<?php if (sizeof($mediaVersions) > 1) : ?>
								<td><?php echo $version ?></td>
							<?php endif ?>
							<td><?php echo $this->Html->link(Router::url(array_merge($shareUrl, ['full_base' => false])), $shareUrl, ['target' => '_blank']) ?></td>
							<td>
								<?php
								echo $this->Html->link(
									'<i class="fa fa-copy"></i>',
									array_merge($shareUrl, ['download' => true]),
									['escape' => false, 'data-clipboard' => 'href']
								);
								?>
							</td>
							<td>
								<?php
								echo $this->Html->link(
									'<i class="fa fa-copy"></i>',
									$shareUrl,
									['escape' => false, 'data-clipboard' => 'href']
								);
								?>
							</td>
						</tr>
					<?php endforeach ?>
				</table>
			</div>
		<?php endif ?>
	</div>
<?php endif ?>
