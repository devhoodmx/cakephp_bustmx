<?php
// Menu items
$menu = empty($menu) ? array() : $menu;

$menuItemKey = empty($menuItemKey) ? null : $menuItemKey;
$subMenuItemKey = empty($subMenuItemKey) ? null : $subMenuItemKey;
?>
<ul id='main-menu' class='main-menu'>
	<?php foreach($menu as $key => $item): ?>
	<li class='main-menu-item'>
		<?php
		$icon = (isset($item['class']) && $item['class']) ? "<i class='fas fa-fw fa-$item[class]'></i>" : '';
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
