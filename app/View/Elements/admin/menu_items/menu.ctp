<?php
$level = isset($level) ? $level : 1;
$maxLevel = 3;
$website = empty($website) ? null : $website;
?>

<?php if (!empty($items)): ?>
<ul class='menu menu-level-<?php echo $level; ?>'>
	<?php foreach ($items as $key => $item): ?>
	<li
		class='menu-item'
		data-model='MenuItem'
		data-id='<?php echo $item['MenuItem']['id']; ?>'
		data-name='<?php echo h($item['MenuItem']['es_name']); ?>'
		data-url='/admin/menu_items'
	>
		<div class='menu-item-row'>
			<div class='menu-item-col menu-item-title'>
				<div class='menu-item-arrow'>
					<svg width='12' height='11' viewBox='0 0 12 11' xmlns='http://www.w3.org/2000/svg'><path class='menu-item-arrow-path' fill='#999' d='M0 0v8h8v3l4-4-4-4v2.999H2V0z' fill-rule='evenodd'/></svg>
				</div>

				<div class='menu-item-name'>
					<?php echo $item['MenuItem']['es_name']; ?>
				</div>
			</div>

			<div class='menu-item-col menu-item-link'>
				<?php
				echo $this->element('admin/menu_items/link', array(
					'item' => $item
				));
				?>
			</div>

			<div class='menu-item-col menu-item-actions'>
				<?php
				$url = array(
					'controller' => 'menu_items',
					'action' => 'add',
					$position,
					$item['MenuItem']['id']
				);
				$class = 'btn btn-xs btn-primary';

				if ($level >= $maxLevel) {
					$class .= ' disabled';
				}

				echo $this->Html->link(
					'<i class="fas fa-plus"></i>',
					$url,
					array(
						'escape' => false,
						'class' => $class,
						'title' => 'Añadir elemento'
					)
				);
				?>

				<?php
				echo $this->Html->link(
					'<i class="fas fa-edit"></i>',
					array(
						'controller' => $this->request->controller,
						'action' => 'edit',
						$item['MenuItem']['id']
					),
					array(
						'class' => 'btn btn-sm btn-info',
						'escape' => false,
						'title' => 'Editar'
					)
				);
				?>

				<?php
				echo $this->Html->link(
					'<i class="far fa-trash-alt"></i>',
					'#',
					array(
						'class' => 'btn btn-sm btn-danger',
						'escape' => false,
						'data-delete',
						'data-title' => __('delete'),
						'data-dialog' => __('delete-dialog'),
						'title' => 'Borrar'
					)
				);
				?>
			</div>
		</div>

		<?php
		if (!empty($item['children'])) {
			echo $this->element('admin/menu_items/menu', array(
				'items' => $item['children'],
				'level' => $level + 1,
				'position' => $position,
				'website' => $website
			));
		}
		?>
	</li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>
