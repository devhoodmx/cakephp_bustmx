<div class='modal-files'>
	<div class='modal fade' id='<?php echo $id; ?>' tabindex='-1' role='dialog' aria-labelledby='<?php echo $name; ?>' aria-hidden='true'>
		<div class='modal-dialog'>
			<div class='modal-content'>
				<!-- Header -->
				<div class='modal-header'>
					<!-- Close Button -->
					<?php echo $this->Form->button('&times;', array('type' => 'button', 'class' => 'close', 'data-dismiss' => 'modal', 'aria-hidden' => 'true')); ?>
					<!-- End Close Button -->

					<!-- Title -->
					<h1><?php echo __('Agregar un archivo'); ?></h1>
					<!-- End Title -->
				</div>
				<!-- End Header -->

				<!-- Body -->
				<div class='modal-body'>
					<!-- Nav Tabs -->
					<ul class='nav nav-tabs'>
						<li class='active'><?php echo $this->Html->link(__('De tus archivos'), '#local-files', array('escape' => false, 'data-toggle' => 'tab')); ?></li>
						<li><?php echo $this->Html->link(__('De la biblioteca'), '#library', array('escape' => false, 'data-toggle' => 'tab')); ?></li>
						<li><?php echo $this->Html->link(__('De otro sitio'), '#external', array('escape' => false, 'data-toggle' => 'tab')); ?></li>
					</ul>
					<!-- End Nav Tabs -->

					<!-- Tab Panes -->
					<div class='tab-content'>
						<!-- Local Files -->
						<div class='tab-pane active' id='local-files'>
							<p>Nulla facilisi. Duis aliquet egestas purus in blandit.</p>

							<?php
							echo $this->Form->input($name .'Local', array(
								'div' => 'input file form-group',
								'label' => false,
								'type' => 'file'
							));
							?>
						</div>
						<!-- End Local Files -->

						<!-- Library -->
						<div class='tab-pane' id='library'>
							<p>Mauris iaculis porttitor posuere. Praesent id metus massa, ut blandit.</p>

							<!-- <div class='media-dropzone'>
								<?php for ($i = 0; $i < 7; $i ++) : ?>
								<div class='media-item media-loaded <?php echo $i%2===0 ? 'selected' : ''; ?>' data-sortable data-model='Media' data-id='test' data-name='test' data-url="/admin/media">
									<div class='media-actions btn-group'>
										<?php
											echo $this->element('admin/widgets/actions/toggle', array('linkOnly' => TRUE, 'size' => 'xs', 'field' => 'main', 'value' => 'test', 'toggleModel' => 'Media'));
											echo $this->Html->link(
												"<i class='fas fa-edit'></i>",
												'#',
												array(
													'escape' => false,
													'title' => __d('media', 'edit-media'),
													'class' => 'btn btn-xs btn-default',
													'data-media-modal' => ''
												)
											);
											echo $this->element('admin/widgets/actions/delete', array('linkOnly' => TRUE, 'size' => 'xs'));
										?>
									</div>

									<div class='media-thumbnail'>
										<?php
										echo $this->Html->image(
											'http://placehold.it/170x124',
											array(
												'alt' => 'test'
											)
										);
										?>
									</div>

									<div class='media-data'>
										<span class='media-name'>This is a test</span>
										<span class='media-size'><?php echo CakeNumber::toReadableSize(1024) ?></span>
									</div>
								</div>
								<?php endfor; ?>
							</div> -->

							<?php
							echo $this->element('admin/widgets/media/manager', array(
								'mediaName' => 'test',
								'mediaField' => 'test',
								'mediaCollection' => 'test',
								'mediaModel' => 'test',
								'mediaTypes' => array('jpg', 'png'),
								'mediaItems' => array()
							));
							?>
						</div>
						<!-- End Library -->

						<!-- External -->
						<div class='tab-pane' id='external'>
							<p>Nulla facilisi. Duis aliquet egestas purus in blandit.</p>

							<div class='row'>
								<?php
								// Input text
								echo $this->Form->input($name . 'External', array(
									'class' => 'form-control',
									'div' => 'input text form-group col-xs-6',
									'label' => false,
									'placeholder' => 'Ej. http://youtu.be/878-LYQEcPs',
									'type' => 'text'
								));
								?>
							</div>
						</div>
						<!-- End External -->
					</div>
					<!-- End Tab Panes -->
				</div>
				<!-- End Body -->

				<!-- Footer -->
				<div class='modal-footer'>
					<?php
					// Button Close
					echo $this->Form->button("<i class='fas fa-times'></i>", array('class' => 'btn btn-default', 'type' => 'button', 'data-dismiss' => 'modal'));

					// Button Send
					echo $this->Form->button("<i class='fas fa-check'></i>", array('class' => 'btn btn-primary', 'type' => 'button'));
					?>
				</div>
				<!-- End Footer -->
			</div>
		</div>
	</div>
</div>
