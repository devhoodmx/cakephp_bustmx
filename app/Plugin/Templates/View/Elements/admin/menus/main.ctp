<?php
// Menu items
$menu = array(
	'comments' => array(
		'text' => __('Comentarios'),
		'class' => 'comments',
		'url' => array('controller' => 'templates', 'action' => 'add_comment', 'admin' => true),
		'submenu' => array(
			'add-user' => array(
				'text' => __('Añadir nuevo'),
				'notifications' => 3,
				'url' => array('controller' => 'templates', 'action' => 'add_comment', 'admin' => true)
			),
			'category' => array(
				'text' => __('Categorías'),
				'notifications' => null,
				'url' => '#'
			),
			'labels' => array(
				'text' => __('Etiquetas'),
				'notifications' => 1,
				'url' => '#'
			)
		)
	),
	'pages' => array(
		'text' => __('Páginas'),
		'class' => 'file-alt',
		'url' => array('controller' => 'templates', 'action' => 'add_page', 'admin' => true),
		'submenu' => array(
			'add-page' => array(
				'text' => __('Añadir nueva'),
				'notifications' => false,
				'url' => array('controller' => 'templates', 'action' => 'add_page', 'admin' => true)
			),
			'category' => array(
				'text' => __('Categorías'),
				'url' => '#'
			)
		)
	),
	'archives' => array(
		'text' => __('Archivos'),
		'class' => 'archive',
		'url' => '#',
		'submenu' => false
	),
	'content' => array(
		'text' => __('Contenido'),
		'class' => 'folder-close',
		'url' => '#',
		'submenu' => false
	),
	'params' => array(
		'text' => __('Ajustes'),
		'class' => 'cog',
		'url' => '#',
		'submenu' => array(
			'user' => array(
				'text' => __('Usuario'),
				'url' => '#'
			),
			'account' => array(
				'text' => __('Cuenta'),
				'notifications' => 2,
				'url' => '#'
			),
			'pages' => array(
				'text' => __('Páginas'),
				'url' => '#'
			)
		)
	)
);

$menuItemKey = empty($menuItemKey) ? null : $menuItemKey;
$subMenuItemKey = empty($subMenuItemKey) ? null : $subMenuItemKey;
?>
<ul id='main-menu' class='main-menu'>
	<?php foreach($menu as $key => $item): ?>
	<li class='main-menu-item'>
		<?php
		$icon = (isset($item['class']) && $item['class']) ? "<i class='fas fa-$item[class]'></i>" : '';
		$class = 'menu-item-link';
		$class .= (isset($menuItemKey) && $menuItemKey === $key) ? ' active' : '';
		$opts = array(
			'escape' => false,
			'class' => $class
		);

		if (!empty($item['submenu'])) {
			$opts['data-submenu'] = 'submenu-' . Utility::slug($item['text']);
		}

		echo $this->Html->link(
			$icon . $item['text'],
			$item['url'],
			$opts
		);

		if (!empty($item['submenu'])):
		?>
		<ul id='submenu-<?php echo Utility::slug($item['text']); ?>' class='submenu'>
			<?php
			foreach($item['submenu'] as $k => $i):
				$class = (isset($submenuItemKey) && $submenuItemKey === $k) ? ' active' : '';
			?>
			<li class='submenu-item<?php echo $class; ?>'>
				<?php
				$class = (isset($submenuItemKey) && $submenuItemKey === $k) ? 'badge-primary' : '';
				$txt = (isset($i['notifications']) && $i['notifications']) ? "<span class='badge pull-right $class'>$i[notifications]</span>" : '';
				$txt .= $i['text'];

				echo $this->Html->link(
					$txt,
					$i['url'],
					array(
						'escape' => false,
						'class' => 'submenu-item-link'
					)
				);
				?>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
	</li>
	<?php endforeach; ?>
</ul>
