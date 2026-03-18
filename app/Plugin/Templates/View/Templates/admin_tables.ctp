<?php
$this->assign('title', __('Tables') . ' | ' . __('Site'));
?>

<!-- Header -->
<div class='page-header'>
	<!-- Title -->
	<h1>
		<?php echo __('Usuarios'); ?>
		<!-- Option buttons -->
		<span class='btn-group'>
			<?php
			// New user
			echo $this->Html->link(__('Nuevo'), array('controller' => 'templates', 'action' => 'add_user', 'admin' => true), array('escape' => false, 'class' => 'btn btn-primary btn-sm'));
			?>
		</span>
	</h1>
</div>
<!-- End header -->

<!-- Container -->
<div class='boxes columns-container'>
	<!-- Toolbar -->
	<div class='boxes toolbar-group'>
		<!-- Left Toolbar -->
		<div class='btn-toolbar pull-left'>
			<!-- Button Group -->
			<div class='btn-group'>
				<?php
				// Dropdown
				?>
				<div class='btn-group'>
					<?php
					$img = $this->Html->image('admin/transparent.gif', array('alt' => '', 'width' => 16, 'height' => 16, 'class' => 'checkbox-img checkbox-half'));
					$img .= " <span class='caret'></span>";
					echo $this->Html->link($img, '#', array('escape' => false, 'class' => 'btn btn-default dropdown-toggle', 'data-toggle' => 'dropdown'));
					?>
					<ul class='dropdown-menu' role='menu'>
						<li role = 'presentation'><?php echo $this->Html->link(__('Opción 1'), '#', array('escape' => false, 'role' => 'menuitem', 'tabindex' => '-1')); ?></li>
						<li role = 'presentation'><?php echo $this->Html->link(__('Opción 2'), '#', array('escape' => false, 'role' => 'menuitem', 'tabindex' => '-1')); ?></li>
						<li class='divider' role = 'presentation'></li>
						<li role = 'presentation'><?php echo $this->Html->link(__('Otra opción'), '#', array('escape' => false, 'role' => 'menuitem', 'tabindex' => '-1')); ?></li>
					</ul>
				</div>
				<?php
				// Buttons
				echo $this->Html->link(__('Boton 1'), '#', array('escape' => false, 'class' => 'btn btn-default'));
				echo $this->Html->link(__('Boton 2'), '#', array('escape' => false, 'class' => 'btn btn-default'));
				?>
			</div>
			<!-- Delete -->
			<div class='btn-group'>
				<?php echo $this->Html->link("<i class='far fa-trash-alt'></i>", '#', array('escape' => false, 'class' => 'btn btn-danger')); ?>
			</div>
		</div>

		<!-- Right toolbar -->
		<div class='pull-right pagination-info'>
			<!-- Pagination number -->
			<span class='pagination-resume'>1 - 10 de 10</span>

			<!-- Pagination prev/next -->
			<div class='btn-group'>
				<?php
				// Prev
				echo $this->Html->link("<i class='fas fa-chevron-left'></i>", '#', array('escape' => false, 'class' => 'btn btn-default'));
				// Next
				echo $this->Html->link("<i class='fas fa-chevron-right'></i>", '#', array('escape' => false, 'class' => 'btn btn-default'));
				?>
			</div>

			<!-- Configuration -->
			<div class='btn-group'>
				<?php echo $this->Html->link("<i class='fas fa-cog'></i>", '#', array('escape' => false, 'class' => 'btn btn-default dropdown-toggle', 'data-toggle' => 'dropdown')); ?>
				<!-- Dropdown options -->
				<div class='dropdown-menu dropdown-arrow-skin dropdown-menu-right' role='menu'>
					<li class='dropdown-header' role='presentation'><?php echo __('Items por página'); ?></li>
					<li role='presentation'><?php echo $this->Html->link('10', '#', array('escape' => false, 'role' => 'menuitem', 'tabindex' => '-1')); ?></li>
					<li role='presentation'><?php echo $this->Html->link('25', '#', array('escape' => false, 'role' => 'menuitem', 'tabindex' => '-1')); ?></li>
					<li role='presentation'><?php echo $this->Html->link('50', '#', array('escape' => false, 'role' => 'menuitem', 'tabindex' => '-1')); ?></li>
					<li role='presentation'><?php echo $this->Html->link('100', '#', array('escape' => false, 'role' => 'menuitem', 'tabindex' => '-1')); ?></li>
				</div>
			</div>
		</div>
	</div>
	<!-- End toolbar -->

	<!-- Table -->
	<div class='table-responsive'>
		<table class='table table-hover'>
			<thead>
				<tr>
					<th>
						<?php
						echo $this->BootForm->checkbox('selected');
						echo $this->BootForm->label('selected', '&nbsp;');
						?>
					</th>
					<th><?php echo $this->Html->link(__('Nombre'), '#', array('escape' => false)); ?></th>
					<th><?php echo $this->Html->link(__('Descripción'), '#', array('escape' => false)); ?></th>
					<th><?php echo $this->Html->link(__('Email'), '#', array('escape' => false)); ?></th>
					<th><?php echo $this->Html->link(__('Grupo'), '#', array('escape' => false)); ?></th>
					<th>&nbsp;</th> <!-- Button options -->
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<?php
						echo $this->BootForm->checkbox('selected');
						echo $this->BootForm->label('selected', '&nbsp;');
						?>
					</td>
					<td>hanuman</td>
					<td>&nbsp;</td>
					<td>monos@affenbits.com</td>
					<td>Prosimian</td>
					<td>
						<div class='btn-toolbar'>
							<!-- Edit -->
							<div class='btn-group'>
								<?php echo $this->Html->link("<i class='fas fa-edit'></i>", '#', array('escape' => false, 'class' => 'btn btn-info btn-sm', 'title' => __('Editar'))); ?>
							</div>
							<!-- Delete -->
							<div class='btn-group'>
								<?php echo $this->Html->link("<i class='far fa-trash-alt'></i>", '#', array('escape' => false, 'class' => 'btn btn-sm btn-danger', 'title' => __('Eliminar'))); ?>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<?php
						echo $this->BootForm->checkbox('selected2');
						echo $this->BootForm->label('selected2', '&nbsp;');
						?>
					</td>
					<td>administrador</td>
					<td>Soporte Egresados</td>
					<td>monos@affenbits.com</td>
					<td>Administradores</td>
					<td>
						<div class='btn-toolbar'>
							<!-- Edit -->
							<div class='btn-group'>
								<?php echo $this->Html->link("<i class='fas fa-edit'></i>", '#', array('escape' => false, 'class' => 'btn btn-info btn-sm', 'title' => __('Editar'))); ?>
							</div>
							<!-- Delete -->
							<div class='btn-group'>
								<?php echo $this->Html->link("<i class='far fa-trash-alt'></i>", '#', array('escape' => false, 'class' => 'btn btn-sm btn-danger', 'title' => __('Eliminar'))); ?>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<?php
						echo $this->BootForm->checkbox('selected3', array('checked' => true));
						echo $this->BootForm->label('selected3', '&nbsp;');
						?>
					</td>
					<td>sfmoguel</td>
					<td>Susana Moguel</td>
					<td>monos@affenbits.com</td>
					<td>Administradores</td>
					<td>
						<div class='btn-toolbar'>
							<!-- Edit -->
							<div class='btn-group'>
								<?php echo $this->Html->link("<i class='fas fa-edit'></i>", '#', array('escape' => false, 'class' => 'btn btn-info btn-sm', 'title' => __('Editar'))); ?>
							</div>
							<!-- Delete -->
							<div class='btn-group'>
								<?php echo $this->Html->link("<i class='far fa-trash-alt'></i>", '#', array('escape' => false, 'class' => 'btn btn-sm btn-danger', 'title' => __('Eliminar'))); ?>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<?php
						echo $this->BootForm->checkbox('selected4');
						echo $this->BootForm->label('selected4', '&nbsp;');
						?>
					</td>
					<td>angcsoto</td>
					<td>Angélica Soto</td>
					<td>monos@affenbits.com</td>
					<td>Coordinación General Académica</td>
					<td>
						<div class='btn-toolbar'>
							<!-- Edit -->
							<div class='btn-group'>
								<?php echo $this->Html->link("<i class='fas fa-edit'></i>", '#', array('escape' => false, 'class' => 'btn btn-info btn-sm', 'title' => __('Editar'))); ?>
							</div>
							<!-- Delete -->
							<div class='btn-group'>
								<?php echo $this->Html->link("<i class='far fa-trash-alt'></i>", '#', array('escape' => false, 'class' => 'btn btn-sm btn-danger', 'title' => __('Eliminar'))); ?>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<?php
						echo $this->BootForm->checkbox('selected5', array('checked' => true));
						echo $this->BootForm->label('selected5', '&nbsp;');
						?>
					</td>
					<td>usuarioprueba</td>
					<td>José Farías</td>
					<td>monos@affenbits.com</td>
					<td>Administradores</td>
					<td>
						<div class='btn-toolbar'>
							<!-- Edit -->
							<div class='btn-group'>
								<?php echo $this->Html->link("<i class='fas fa-edit'></i>", '#', array('escape' => false, 'class' => 'btn btn-info btn-sm', 'title' => __('Editar'))); ?>
							</div>
							<!-- Delete -->
							<div class='btn-group'>
								<?php echo $this->Html->link("<i class='far fa-trash-alt'></i>", '#', array('escape' => false, 'class' => 'btn btn-sm btn-danger', 'title' => __('Eliminar'))); ?>
							</div>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<!-- End table -->

	<!-- Pagination -->
	<div class='text-center'>
		<!-- First / Prev -->
		<ul class='pager'>
			<li class='disabled'><?php echo $this->Html->link("<i class='fas fa-angle-double-left'></i>", '#', array('escape' => false, 'title' => __('Primero'))); ?></li>
			<li><?php echo $this->Html->link("<i class='fas fa-angle-left'></i>", '#', array('escape' => false, 'title' => __('Anterior'))); ?></li>
		</ul>
		<!-- Pagination numbers -->
		<ul class='pagination'>
			<li class='active'><?php echo $this->Html->link('1', array('escape' => false));  ?></li>
			<li><?php echo $this->Html->link('2', array('escape' => false));  ?></li>
			<li><?php echo $this->Html->link('3', array('escape' => false));  ?></li>
			<li><?php echo $this->Html->link('4', array('escape' => false));  ?></li>
			<li><?php echo $this->Html->link('5', array('escape' => false));  ?></li>
			<li><?php echo $this->Html->link('6', array('escape' => false));  ?></li>
		</ul>
		<!-- Next / Last -->
		<ul class='pager'>
			<li><?php echo $this->Html->link("<i class='fas fa-angle-right'></i>", '#', array('escape' => false, 'title' => __('Siguiente'))); ?></li>
			<li><?php echo $this->Html->link("<i class='fas fa-angle-double-right'></i>", '#', array('escape' => false, 'title' => __('Último'))); ?></li>
		</ul>
	</div>
	<!-- End pagination -->
</div>
<!-- End container -->
