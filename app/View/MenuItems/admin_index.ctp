<?php
$this->Package->assign('view', 'js', array(
	'app.menu-items.admin-index'
));
$this->Package->assign('view', 'css', array(
	'view.menu-items.admin-index'
));

$pageTitle = __('Menús');

$this->assign('title', __d('admin', 'page-title', $pageTitle, $config['simian']['title'], $config['simian']['version']));
$this->set('menuItemKey', 'content');
$this->set('submenuItemKey', 'menu_items');
?>
<div class='page-header boxes'>
	<h1 class='pull-left'>
		<?php echo $pageTitle; ?>
	</h1>

	<?php if (sizeof($websites) > 1): ?>
	<!-- Option buttons -->
	<div class='btn-toolbar pull-right'>
		<div class='btn-group'>
			<button id='dropdown-menu-websites' class='btn btn-default dropdown-toggle' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='true'>
				<?php echo $currentWebsite['Website']['name']; ?> <i class='fas fa-caret-down'></i>
			</button>

			<ul class='dropdown-menu dropdown-arrow-skin dropdown-menu-right' aria-labelledby='dropdown-menu-websites'>
				<?php foreach ($websites as $key => $website): ?>
				<li class='<?php echo ($key == $currentWebsite['Website']['id'] ? 'active' : ''); ?>'>
					<?php
					echo $this->Html->link(
						$website['Website']['name'],
						array(
							'action' => 'index',
							'?' => array('website_id' => $website['Website']['id'])
						)
					);
					?>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
	<?php endif; ?>
</div>

<?php echo $this->Flash->render(); ?>

<!-- Container -->
<div class='boxes columns-container'>
	<?php foreach ($menus as $position => $items): ?>
	<div class='menu-panel panel panel-default'>
		<div id='<?php printf('%s-panel-heading', $position); ?>' class='panel-heading'>
			<h3 class='panel-title'>
				<?php
				$target = sprintf('%s-panel-collapse', $position);

				echo $this->Html->link(
					__d('menu_item', 'position-' . $position),
					'#' . $target,
					array(
						'escape' => false,
						'role' => 'button',
						'data-toggle' => 'collapse',
						'aria-expanded' => 'true',
						'aria-controls' => $target
					)
				);
				?>
			</h3>
		</div>

		<div id='<?php echo $target; ?>' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='<?php printf('%s-panel-heading', $position); ?>'>
			<div class='panel-body'>
				<?php
				$url = array(
					'controller' => 'menu_items',
					'action' => 'add',
					$position
				);
				if (!empty($currentWebsite)) {
					$url['?'] = array('website_id' => $currentWebsite['Website']['id']);
				}

				echo $this->Html->link(
					"<svg width='12' height='11' viewBox='0 0 12 11' xmlns='http://www.w3.org/2000/svg'><path fill='#999' d='M0 0v8h8v3l4-4-4-4v2.999H2V0z' fill-rule='evenodd'/></svg>" .
					'Agregar nuevo elemento',
					$url,
					array(
						'escape' => false,
						'class' => 'btn btn-link btn-add'
					)
				);
				?>
				<?php if (!empty($items)): ?>
				<div class='row'>
					<?php
					echo $this->element('admin/menu_items/menu', array(
						'items' => $items,
						'level' => 1,
						'position' => $position,
						'website' => $currentWebsite
					));
					?>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
</div>
