<?php
$this->assign('title', __('Dashboard') . ' | ' . __('Site'));
?>

<!-- Container -->
<div class='boxes columns-container'>
	<!-- Edit widgets -->
	<div class='boxes toolbar-group'>
		<div class='btn-group pull-right'>
			<?php echo $this->Html->link(__('Modificar widgets'), '#', array('escape' => false, 'class' => 'btn btn-default btn-sm')); ?>
		</div>
	</div>
	<!-- End edit widgets -->

	<!-- Jumbotron -->
	<div class='jumbotron'>
		<h1><?php echo __('Hola'); ?> mono.</h1>
		<p>Etiam at risus et justo dignissim congue. Donec congue lacinia dui, a porttitor lectus.</p>
	</div>
	<!-- End jumbotron -->

	<!-- Data Info -->
	<div class='row'>
		<div class='col-xs-12'>
			<div class='panel panel-default'>
				<div class='panel-body'>
					<div class='row'>
						<!-- Site Quota -->
						<div class='col-sm-6'>
							<h4><?php echo __('Espacio del sitio'); ?></h4>

							<div class='progress'>
								<div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='24' aria-valuemin='0' aria-valuemax='100' style='width:24%;'></div>
								<span class='sr-only'>24% usado</span>
							</div>
							<p class='text-muted'>Usado el 24% de 1GB</p>
						</div>
						<!-- End Site Quota -->

						<!-- Mensual Transference -->
						<div class='col-sm-6'>
							<h4><?php echo __('Transferencia mensual'); ?></h4>

							<div class='progress'>
								<div class='progress-bar progress-bar-warning' role='progressbar' aria-valuenow='89' aria-valuemin='0' aria-valuemax='100' style='width:89%;'></div>
								<span class='sr-only'>89% usado</span>
							</div>
								<p class='text-warning'>Usado el 89% de 1GB</p>
						</div>
						<!-- End Mensual Transference -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Data Info -->

	<div class="row">
		<!-- Latest Contents -->
		<div class='col-sm-6'>
			<div class='panel panel-default'>
				<!-- Panel Header -->
				<div class='panel-heading boxes'>
					<div class='pull-left'>
						<h1 class='panel-title'>&Uacute;ltimos contenidos</h1>
					</div>
					<div class='pull-right panel-header-action-links'>
						<?php
						// View All Link
						echo $this->Html->link(__('Ver todo'), '#', array('escape' => false, 'class' => 'pull-left'));
						// Close Link
						echo $this->Html->link("<i class='fas fa-times'></i>", '#', array('escape' => false, 'class' => 'close pull-left'));
						?>
					</div>
				</div>
				<!-- End Panel Header -->

				<!-- Panel Body -->
				<div class='panel-body'>
					<ul class='panel-items panel-items-hover'>
						<li class='panel-item media'>
							<div class='media-left'>
								<!-- Left Icon -->
								<span class='panel-item-icon'>
									<i class='fas fa-file fa-2x fa-fw'></i>
								</span>
								<!-- End Left Icon -->
							</div>

							<div class='media-body'>
								<!-- Date/Time -->
								<span class='text-muted'>12/12/12 - 9:45 p.m.</span>
								<!-- End Date/Time -->

								<!-- Text -->
								<p>Lorem ipsum dolor sit amet, consectetur.</p>
								<!-- End Text -->

								<!-- Edit/Delete Links -->
								<div class='util-links small'>
									<?php
									// Edit
									echo $this->Html->link(__('Editar'), '#', array('escape' => false));
									// Separator
									echo ' - ';
									// Delete
									echo $this->Html->link(__('Eliminar'), '#', array('escape' => false, 'class' => 'text-danger'));
									?>
								</div>
								<!-- End Edit/Delete Links -->
							</div>
						</li>
						<li class='panel-item media'>
							<div class='media-left'>
								<!-- Left Icon -->
								<span class='panel-item-icon'>
									<i class='fas fa-image fa-2x fa-fw'></i>
								</span>
								<!-- End Left Icon -->
							</div>

							<div class='media-body'>
								<!-- Date/Time -->
								<span class='text-muted'>12/12/12 - 9:45 p.m.</span>
								<!-- End Date/Time -->

								<!-- Text -->
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
								<!-- End Text -->

								<!-- Edit/Delete Links -->
								<div class='util-links small'>
									<?php
									// Edit
									echo $this->Html->link(__('Editar'), '#', array('escape' => false));
									// Separator
									echo ' - ';
									// Delete
									echo $this->Html->link(__('Eliminar'), '#', array('escape' => false, 'class' => 'text-danger'));
									?>
								</div>
								<!-- End Edit/Delete Links -->
							</div>
						</li>
						<li class='panel-item media'>
							<div class='media-left'>
								<!-- Left Icon -->
								<span class='panel-item-icon'>
									<i class='fas fa-comments fa-2x fa-fw'></i>
								</span>
								<!-- End Left Icon -->
							</div>

							<div class='media-body'>
								<!-- Date/Time -->
								<span class='text-muted'>12/12/12 - 9:45 p.m.</span>
								<!-- End Date/Time -->

								<!-- Text -->
								<p>Lorem ipsum dolor sit amet, consectetur.</p>
								<!-- End Text -->

								<!-- Edit/Delete Links -->
								<div class='util-links small'>
									<?php
									// Edit
									echo $this->Html->link(__('Editar'), '#', array('escape' => false));
									// Separator
									echo ' - ';
									// Delete
									echo $this->Html->link(__('Eliminar'), '#', array('escape' => false, 'class' => 'text-danger'));
									?>
								</div>
								<!-- End Edit/Delete Links -->
							</div>
						</li>
						<li class='panel-item media'>
							<div class='media-left'>
								<!-- Left Icon -->
								<span class='panel-item-icon'>
									<i class='fas fa-shopping-cart fa-2x fa-fw'></i>
								</span>
								<!-- End Left Icon -->
							</div>

							<div class='media-body'>
								<!-- Date/Time -->
								<span class='text-muted'>12/12/12 - 9:45 p.m.</span>
								<!-- End Date/Time -->

								<!-- Text -->
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex.</p>
								<!-- End Text -->

								<!-- Edit/Delete Links -->
								<div class='util-links small'>
									<?php
									// Edit
									echo $this->Html->link(__('Editar'), '#', array('escape' => false));
									// Separator
									echo ' - ';
									// Delete
									echo $this->Html->link(__('Eliminar'), '#', array('escape' => false, 'class' => 'text-danger'));
									?>
								</div>
								<!-- End Edit/Delete Links -->
							</div>
						</li>
						<li class='panel-item media'>
							<div class='media-left'>
								<!-- Left Icon -->
								<span class='panel-item-icon'>
									<i class='fas fa-file fa-2x fa-fw'></i>
								</span>
								<!-- End Left Icon -->
							</div>

							<div class='media-body'>
								<!-- Date/Time -->
								<span class='text-muted'>12/12/12 - 9:45 p.m.</span>
								<!-- End Date/Time -->

								<!-- Text -->
								<p>Lorem ipsum dolor sit amet, consectetur.</p>
								<!-- End Text -->

								<!-- Edit/Delete Links -->
								<div class='util-links small'>
									<?php
									// Edit
									echo $this->Html->link(__('Editar'), '#', array('escape' => false));
									// Separator
									echo ' - ';
									// Delete
									echo $this->Html->link(__('Eliminar'), '#', array('escape' => false, 'class' => 'text-danger'));
									?>
								</div>
								<!-- End Edit/Delete Links -->
							</div>
						</li>
					</ul>
				</div>
				<!-- End Panel Body -->
			</div>
		</div>
		<!-- End Latest Contents -->

		<!-- Bitacora -->
		<div class='col-sm-6'>
			<div class='panel panel-default'>
				<div class='panel-heading boxes'>
					<div class='pull-left'>
						<h1 class='panel-title'>Bit&aacute;cora</h1>
					</div>
					<div class='pull-right panel-header-action-links'>
						<?php
						// View All Link
						echo $this->Html->link(__('Ver todo'), '#', array('escape' =>  false, 'class' => 'pull-left'));
						// Close Link
						echo $this->Html->link("<i class='fas fa-times'></i>", '#', array('escape' => false, 'class' => 'close pull-left'));
						?>
					</div>
				</div>
				<div class='panel-body'>
					<ul class='panel-items panel-items-hover'>
						<li class='panel-item media'>
							<div class='media-left'>
								<!-- Avatar user -->
								<?php echo $this->Html->image('//placehold.it/48', array('alt' => __('Usuario'), 'class' => 'avatar-user')); ?>
								<!-- Avatar user -->
							</div>

							<div class='media-body'>
								<!-- Date/Time -->
								<span class='text-muted'>12/12/12 - 9:45 p.m.</span>
								<!-- End Date/Time -->

								<!-- Text -->
								<p>Lorem ipsum dolor sit amet, consectetur.</p>
								<!-- End Text -->

								<!-- Edit/Delete Links -->
								<div class='util-links small'>
									<?php
									// Edit
									echo $this->Html->link(__('Ver más'), '#', array('escape' => false));
									?>
								</div>
								<!-- End Edit/Delete Links -->
							</div>
						</li>

						<li class='panel-item media'>
							<div class='media-left'>
								<!-- Avatar user -->
								<?php echo $this->Html->image('//placehold.it/48', array('alt' => __('Usuario'), 'class' => 'avatar-user')); ?>
								<!-- Avatar user -->
							</div>

							<div class='media-body'>
								<!-- Date/Time -->
								<span class='text-muted'>12/12/12 - 9:45 p.m.</span>
								<!-- End Date/Time -->

								<!-- Text -->
								<p>Lorem ipsum dolor sit amet, consectetur.</p>
								<p class='text-muted'>&ldquo;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugiat ipsum, eius temporibus beatae at tempora maiores incidunt nesciunt laborum mollitia. Dicta quae reiciendis ab ducimus laboriosam doloremque delectus pariatur architecto.&rdquo;</p>
								<!-- End Text -->

								<!-- Util Links -->
								<div class='util-links small'>
									<?php
									// Exec
									echo $this->Html->link(__('[ejecutar acción]'), '#', array('escape' => false));
									echo  ' ';
									// Close
									echo $this->Html->link(__('ocultar'), '#', array('escape' => false));
									?>
								</div>
								<!-- End Util Links -->
							</div>
						</li>

						<li class='panel-item media'>
							<div class='media-left'>
								<!-- Avatar user -->
								<?php echo $this->Html->image('//placehold.it/48', array('alt' => __('Usuario'), 'class' => 'avatar-user')); ?>
								<!-- Avatar user -->
							</div>

							<div class='media-body'>
								<!-- Date/Time -->
								<span class='text-muted'>12/12/12 - 9:45 p.m.</span>
								<!-- End Date/Time -->

								<!-- Text -->
								<p>Lorem ipsum dolor sit amet, consectetur.</p>
								<!-- End Text -->

								<!-- Edit/Delete Links -->
								<div class='util-links small'>
									<?php
									// Edit
									echo $this->Html->link(__('Ver más'), '#', array('escape' => false));
									?>
								</div>
								<!-- End Edit/Delete Links -->
							</div>
						</li>

						<li class='panel-item media'>
							<div class='media-left'>
								<!-- Avatar user -->
								<?php echo $this->Html->image('//placehold.it/48', array('alt' => __('Usuario'), 'class' => 'avatar-user')); ?>
								<!-- Avatar user -->
							</div>

							<div class='media-body'>
								<!-- Date/Time -->
								<span class='text-muted'>12/12/12 - 9:45 p.m.</span>
								<!-- End Date/Time -->

								<!-- Text -->
								<p>Lorem ipsum dolor sit amet, consectetur.</p>
								<!-- End Text -->

								<!-- Edit/Delete Links -->
								<div class='util-links small'>
									<?php
									// Edit
									echo $this->Html->link(__('Ver más'), '#', array('escape' => false));
									?>
								</div>
								<!-- End Edit/Delete Links -->
							</div>
						</li>

						<li class='panel-item media'>
							<div class='media-left'>
								<!-- Avatar user -->
								<?php echo $this->Html->image('//placehold.it/48', array('alt' => __('Usuario'), 'class' => 'avatar-user')); ?>
								<!-- Avatar user -->
							</div>

							<div class='media-body'>
								<!-- Date/Time -->
								<span class='text-muted'>12/12/12 - 9:45 p.m.</span>
								<!-- End Date/Time -->

								<!-- Text -->
								<p>Lorem ipsum dolor sit amet, consectetur.</p>
								<!-- End Text -->

								<!-- Edit/Delete Links -->
								<div class='util-links small'>
									<?php
									// Edit
									echo $this->Html->link(__('Ver más'), '#', array('escape' => false));
									?>
								</div>
								<!-- End Edit/Delete Links -->
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- End Bitacora -->
	</div>

	<div class='row'>
		<!-- Site stats -->
		<div class='col-sm-4'>
			<div class='panel panel-default'>
				<!-- Panel Header -->
				<div class='panel-heading boxes'>
					<div class='pull-left'>
						<h1 class='panel-title'><?php echo __('Resúmen del sitio'); ?></h1>
					</div>
				</div>
				<!-- End Panel Header -->

				<!-- Panel body -->
				<div class='panel-body'>
					<ul class='panel-items panel-items-no-border'>
						<li class='panel-item media'>
							<div class='media-left'>
								<!-- Left Icon -->
								<span class='panel-item-icon'>
									<i class='fas fa-shopping-cart fa-2x fa-fw'></i>
								</span>
								<!-- End Left Icon -->
							</div>

							<div class='media-body'>
								<!-- Title -->
								<h2 class='panel-title'>25 Productos</h2>
								<!-- End Title -->

								<!-- Edit/Delete Links -->
								<div class='util-links small'>
									<?php
									// Edit
									echo $this->Html->link(__('Ver listado'), '#', array('escape' => false));
									?>
								</div>
								<!-- End Edit/Delete Links -->
							</div>
						</li>
						<li class='panel-item media'>
							<div class='media-left'>
								<!-- Left Icon -->
								<span class='panel-item-icon'>
									<i class='fas fa-file fa-2x fa-fw'></i>
								</span>
								<!-- End Left Icon -->
							</div>

							<div class='media-body'>
								<!-- Title -->
								<h2 class='panel-title'>12 Noticias</h2>
								<!-- End Title -->

								<!-- Edit/Delete Links -->
								<div class='util-links small'>
									<?php
									// Edit
									echo $this->Html->link(__('Ver listado'), '#', array('escape' => false));
									?>
								</div>
								<!-- End Edit/Delete Links -->
							</div>
						</li>
						<li class='panel-item media'>
							<div class='media-left'>
								<!-- Left Icon -->
								<span class='panel-item-icon'>
									<i class='fas fa-image fa-2x fa-fw'></i>
								</span>
								<!-- End Left Icon -->
							</div>

							<div class='media-body'>
								<!-- Title -->
								<h2 class='panel-title'>3 Galerías</h2>
								<!-- End Title -->

								<!-- Edit/Delete Links -->
								<div class='util-links small'>
									<?php
									// Edit
									echo $this->Html->link(__('Ver listado'), '#', array('escape' => false));
									?>
								</div>
								<!-- End Edit/Delete Links -->
							</div>
						</li>
						<li class='panel-item media'>
							<div class='media-left'>
								<!-- Left Icon -->
								<span class='panel-item-icon'>
									<i class='fas fa-list-ul fa-2x fa-fw'></i>
								</span>
								<!-- End Left Icon -->
							</div>

							<div class='media-body'>
								<!-- Title -->
								<h2 class='panel-title'>6 Artículos</h2>
								<!-- End Title -->

								<!-- Edit/Delete Links -->
								<div class='util-links small'>
									<?php
									// Edit
									echo $this->Html->link(__('Ver listado'), '#', array('escape' => false));
									?>
								</div>
								<!-- End Edit/Delete Links -->
							</div>
						</li>
					</ul>
				</div>
				<!-- End Panel body -->
			</div>
		</div>
		<!-- End Site stats -->

		<!-- Latest added -->
		<div class='col-sm-4'>
			<div class='panel panel-default'>
				<!-- Panel Header -->
				<div class='panel-heading boxes'>
					<div class='pull-left'>
						<h1 class='panel-title'>Agregados recientemente</h1>
					</div>
				</div>
				<!-- End Panel Header -->

				<!-- Panel Body -->
				<div class='panel-body'>
					<ul class='panel-items panel-items-hover'>
						<li class='panel-item media'>
							<div class='media-left'>
								<!-- Left Icon -->
								<span class='panel-item-icon'>
									<i class='fas fa-file fa-2x fa-fw'></i>
								</span>
								<!-- End Left Icon -->
							</div>

							<div class='media-body'>
								<!-- Date/Time -->
								<span class='text-muted'>12/12/12 - 9:45 p.m.</span>
								<!-- End Date/Time -->

								<!-- Text -->
								<p>Lorem ipsum dolor sit amet, consectetur.</p>
								<!-- End Text -->

								<!-- Edit/Delete Links -->
								<div class='util-links small'>
									<?php
									// Edit
									echo $this->Html->link(__('Editar'), '#', array('escape' => false));
									// Separator
									echo ' - ';
									// Delete
									echo $this->Html->link(__('Eliminar'), '#', array('escape' => false, 'class' => 'text-danger'));
									?>
								</div>
								<!-- End Edit/Delete Links -->
							</div>
						</li>
						<li class='panel-item media'>
							<div class='media-left'>
								<!-- Left Icon -->
								<span class='panel-item-icon'>
									<i class='fas fa-image fa-2x fa-fw'></i>
								</span>
								<!-- End Left Icon -->
							</div>

							<div class='media-body'>
								<!-- Date/Time -->
								<span class='text-muted'>12/12/12 - 9:45 p.m.</span>
								<!-- End Date/Time -->

								<!-- Text -->
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
								<!-- End Text -->

								<!-- Edit/Delete Links -->
								<div class='util-links small'>
									<?php
									// Edit
									echo $this->Html->link(__('Editar'), '#', array('escape' => false));
									// Separator
									echo ' - ';
									// Delete
									echo $this->Html->link(__('Eliminar'), '#', array('escape' => false, 'class' => 'text-danger'));
									?>
								</div>
								<!-- End Edit/Delete Links -->
							</div>
						</li>
						<li class='panel-item media'>
							<div class='media-left'>
								<!-- Left Icon -->
								<span class='panel-item-icon'>
									<i class='fas fa-comments fa-2x fa-fw'></i>
								</span>
								<!-- End Left Icon -->
							</div>

							<div class='media-body'>
								<!-- Date/Time -->
								<span class='text-muted'>12/12/12 - 9:45 p.m.</span>
								<!-- End Date/Time -->

								<!-- Text -->
								<p>Lorem ipsum dolor sit amet, consectetur.</p>
								<!-- End Text -->

								<!-- Edit/Delete Links -->
								<div class='util-links small'>
									<?php
									// Edit
									echo $this->Html->link(__('Editar'), '#', array('escape' => false));
									// Separator
									echo ' - ';
									// Delete
									echo $this->Html->link(__('Eliminar'), '#', array('escape' => false, 'class' => 'text-danger'));
									?>
								</div>
								<!-- End Edit/Delete Links -->
							</div>
						</li>
						<li class='panel-item media'>
							<div class='media-left'>
								<!-- Left Icon -->
								<span class='panel-item-icon'>
									<i class='fas fa-shopping-cart fa-2x fa-fw'></i>
								</span>
								<!-- End Left Icon -->
							</div>

							<div class='media-body'>
								<!-- Date/Time -->
								<span class='text-muted'>12/12/12 - 9:45 p.m.</span>
								<!-- End Date/Time -->

								<!-- Text -->
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex.</p>
								<!-- End Text -->

								<!-- Edit/Delete Links -->
								<div class='util-links small'>
									<?php
									// Edit
									echo $this->Html->link(__('Editar'), '#', array('escape' => false));
									// Separator
									echo ' - ';
									// Delete
									echo $this->Html->link(__('Eliminar'), '#', array('escape' => false, 'class' => 'text-danger'));
									?>
								</div>
								<!-- End Edit/Delete Links -->
							</div>
						</li>
						<li class='panel-item media'>
							<div class='media-left'>
								<!-- Left Icon -->
								<span class='panel-item-icon'>
									<i class='fas fa-file fa-2x fa-fw'></i>
								</span>
								<!-- End Left Icon -->
							</div>

							<div class='media-body'>
								<!-- Date/Time -->
								<span class='text-muted'>12/12/12 - 9:45 p.m.</span>
								<!-- End Date/Time -->

								<!-- Text -->
								<p>Lorem ipsum dolor sit amet, consectetur.</p>
								<!-- End Text -->

								<!-- Edit/Delete Links -->
								<div class='util-links small'>
									<?php
									// Edit
									echo $this->Html->link(__('Editar'), '#', array('escape' => false));
									// Separator
									echo ' - ';
									// Delete
									echo $this->Html->link(__('Eliminar'), '#', array('escape' => false, 'class' => 'text-danger'));
									?>
								</div>
								<!-- End Edit/Delete Links -->
							</div>
						</li>
					</ul>
				</div>
				<!-- End Panel Body -->
			</div>
		</div>
		<!-- End Latest added -->

		<!-- Bitacora -->
		<div class='col-sm-4'>
			<div class='panel panel-default'>
				<div class='panel-heading boxes'>
					<div class='pull-left'>
						<h1 class="panel-title">Bit&aacute;cora</h1>
					</div>
					<div class='pull-right panel-header-action-links'>
						<?php
						// View All Link
						echo $this->Html->link(__('Ver todo'), '#', array('escape' =>  false, 'class' => 'pull-left'));
						?>
					</div>
				</div>
				<div class='panel-body'>
					<ul class='panel-items panel-items-hover'>
						<li class='panel-item media'>
							<div class='media-left'>
								<!-- Avatar user -->
								<?php echo $this->Html->image('//placehold.it/48', array('alt' => __('Usuario'), 'class' => 'avatar-user')); ?>
								<!-- Avatar user -->
							</div>

							<div class='media-body'>
								<!-- Date/Time -->
								<span class='text-muted'>12/12/12 - 9:45 p.m.</span>
								<!-- End Date/Time -->

								<!-- Text -->
								<p>Lorem ipsum dolor sit amet, consectetur.</p>
								<!-- End Text -->

								<!-- Edit/Delete Links -->
								<div class='util-links small'>
									<?php
									// Edit
									echo $this->Html->link(__('Ver más'), '#', array('escape' => false));
									?>
								</div>
								<!-- End Edit/Delete Links -->
							</div>
						</li>

						<li class='panel-item media'>
							<div class='media-left'>
								<!-- Avatar user -->
								<?php echo $this->Html->image('//placehold.it/48', array('alt' => __('Usuario'), 'class' => 'avatar-user')); ?>
								<!-- Avatar user -->
							</div>

							<div class='media-body'>
								<!-- Date/Time -->
								<span class='text-muted'>12/12/12 - 9:45 p.m.</span>
								<!-- End Date/Time -->

								<!-- Text -->
								<p>Lorem ipsum dolor sit amet, consectetur.</p>
								<p class='text-muted'>&ldquo;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugiat ipsum, eius temporibus beatae at tempora maiores incidunt nesciunt laborum mollitia. Dicta quae reiciendis ab ducimus laboriosam doloremque delectus pariatur architecto.&rdquo;</p>
								<!-- End Text -->

								<!-- Util Links -->
								<div class='util-links small'>
									<?php
									// Exec
									echo $this->Html->link(__('[ejecutar acción]'), '#', array('escape' => false));
									echo  ' ';
									// Close
									echo $this->Html->link(__('ocultar'), '#', array('escape' => false));
									?>
								</div>
								<!-- End Util Links -->
							</div>
						</li>

						<li class='panel-item media'>
							<div class='media-left'>
								<!-- Avatar user -->
								<?php echo $this->Html->image('//placehold.it/48', array('alt' => __('Usuario'), 'class' => 'avatar-user')); ?>
								<!-- Avatar user -->
							</div>

							<div class='media-body'>
								<!-- Date/Time -->
								<span class='text-muted'>12/12/12 - 9:45 p.m.</span>
								<!-- End Date/Time -->

								<!-- Text -->
								<p>Lorem ipsum dolor sit amet, consectetur.</p>
								<!-- End Text -->

								<!-- Edit/Delete Links -->
								<div class='util-links small'>
									<?php
									// Edit
									echo $this->Html->link(__('Ver más'), '#', array('escape' => false));
									?>
								</div>
								<!-- End Edit/Delete Links -->
							</div>
						</li>

						<li class='panel-item media'>
							<div class='media-left'>
								<!-- Avatar user -->
								<?php echo $this->Html->image('//placehold.it/48', array('alt' => __('Usuario'), 'class' => 'avatar-user')); ?>
								<!-- Avatar user -->
							</div>

							<div class='media-body'>
								<!-- Date/Time -->
								<span class='text-muted'>12/12/12 - 9:45 p.m.</span>
								<!-- End Date/Time -->

								<!-- Text -->
								<p>Lorem ipsum dolor sit amet, consectetur.</p>
								<!-- End Text -->

								<!-- Edit/Delete Links -->
								<div class='util-links small'>
									<?php
									// Edit
									echo $this->Html->link(__('Ver más'), '#', array('escape' => false));
									?>
								</div>
								<!-- End Edit/Delete Links -->
							</div>
						</li>

						<li class='panel-item media'>
							<div class='media-left'>
								<!-- Avatar user -->
								<?php echo $this->Html->image('//placehold.it/48', array('alt' => __('Usuario'), 'class' => 'avatar-user')); ?>
								<!-- Avatar user -->
							</div>

							<div class='media-body'>
								<!-- Date/Time -->
								<span class='text-muted'>12/12/12 - 9:45 p.m.</span>
								<!-- End Date/Time -->

								<!-- Text -->
								<p>Lorem ipsum dolor sit amet, consectetur.</p>
								<!-- End Text -->

								<!-- Edit/Delete Links -->
								<div class='util-links small'>
									<?php
									// Edit
									echo $this->Html->link(__('Ver más'), '#', array('escape' => false));
									?>
								</div>
								<!-- End Edit/Delete Links -->
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- End Bitacora -->
	</div>
</div>
