<?php if (!empty($element['MediaArchive'])) : ?>
	<table class='table table-condensed table-responsive'>
		<thead>
			<tr>
				<th width="50">&nbsp;</th>
				<th>Nombre</th>
				<th class='text-right'>Tamaño</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($element['MediaArchive'] as $archive) : ?>
			<tr>
				<td>
					<?php
					echo $this->Html->link(
						'<i class="far fa-download"></i>',
						array('controller' => 'media', 'action' => 'download', $archive['id'], 'admin' => false),
						array('escape' => false, 'class' => 'btn btn-sm btn-info')
					);
					?>
				</td>
				<td>
					<?php echo $archive['name'] ?>
				</td>
				<td class='text-right'>
					<?php echo $this->Number->toReadableSize($archive['size']); ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php else : ?>
	<i>Elemento de archivos vacío</i>
<?php endif; ?>
