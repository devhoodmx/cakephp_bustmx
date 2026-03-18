<?php
$this->Package->assign('view', 'css', array(
	'admin.component.webpage',
	'view.web-pages.admin-index'
));

$pageTitle = __d('modules', 'web-pages');
$this->assign('title', __d('admin', 'page-title', $pageTitle, $config['simian']['title'], $config['simian']['version']));
$this->set('menuItemKey', 'content');
$this->set('submenuItemKey', $this->request->controller);
?>

<div class='page-header boxes'>
	<h1>
		<?php echo $pageTitle; ?>
		<?php echo $this->element('admin/widgets/actions/add'); ?>
	</h1>
</div>

<?php echo $this->Flash->render(); ?>

<!-- Container -->
<div class='boxes columns-container'>
	<?php
	$actions = 4;
	?>
	<div class='boxes toolbar-group'>
		<?php echo $this->element('admin/widgets/lists/pagination', array('listKey' => 'WebPage')) ?>
	</div>

	<div class='table-responsive'>
		<table class='table table-hover table-condensed webpages'>
			<thead>
				<tr>
					<th class='locale-col' width='28'></th>

					<th>
						<?php echo Utility::translate('name', 'web_page', 'fields'); ?>
					</th>

					<th>
						<?php echo Utility::translate('key', 'web_page', 'fields'); ?>
					</th>

					<th width='100'>
						<?php echo Utility::translate('user-id', 'web_page', 'fields'); ?>
					</th>

					<th width='135'>
						<?php echo Utility::translate('created', 'web_page', 'fields'); ?>
					</th>

					<th width='<?php echo $actions * 45; ?>'></th>
				</tr>
			</thead>

			<tbody>
				<?php
				$pageLocales = Configure::read('App.webpages.locale.options');

				foreach ($pages as $key => $page):
					$index = 0;

					foreach ($pageLocales as $pageLocale):
						$pageLocaleModel = Inflector::camelize($pageLocale);

						if (!empty($page[$pageLocaleModel]['id'])):
							$class = 'webpage-translation';

							if ($index++ > 0) {
								$class .= ' webpage-secondary';
							}
							$class .= sprintf(
								' state-%sactive',
								$page['WebPage']['active'] ? '' : 'not-'
							);

				?>
				<tr
					class='<?php echo $class; ?>'
					data-model='WebPage'
					data-id='<?php echo $page['WebPage']['id']; ?>'
					data-name='<?php echo $page['WebPage']['name']; ?>'
					data-url='/admin/web_pages'
				>
					<td class='locale-col'>
						<span class='badge webpage-badge webpage-badge-<?php echo $pageLocale; ?>'><?php echo $pageLocale; ?></span>
					</td>

					<td>
						<?php
						echo $this->Html->link(
							$page[$pageLocaleModel]['name'],
							array(
								'action' => 'view',
								$page['WebPage']['id'],
								Utility::slug($page['WebPage']['name']),
								'?' => array('lang' => $pageLocale)
							)
						);
						?>
					</td>

					<td>
						<?php
						$link = Router::url(
							array(
								'controller' => 'web_pages',
								'action' => 'view',
								'admin' => false
							)
						);

						if (!$config['App']['webpages']['pretty-urls']) {
							$link .= '/';
						}

						$link .= $page['WebPage'][$pageLocale . '_key'];

						echo $this->Html->link(
							sprintf(
								"/%s <i class='fas fa-external-link'></i>",
								$page['WebPage'][$pageLocale . '_key']
							),
							$link,
							array(
								'escape' => false,
								'class' => 'webpage-key',
								'target' => '_blank'
							))
						;
						?>
					</td>

					<td>
						<?php
						if (!empty($page['User']['id'])) {
							$keywords = [];
							$name = explode(' ', trim($page['User']['name']));
							$name = $name[0];
							$lastName = trim($page['User']['last_name']);

							if (!empty($name)) {
								$keywords[] = $name;
							}
							if (!empty($lastName)) {
								$keywords[] = $lastName[0] . '.';
							}

							echo implode(' ', $keywords);
						}
						?>
					</td>

					<td>
						<?php echo $this->Time->format($page['WebPage']['created'], '%d/%b/%Y %H:%M'); ?>
					</td>

					<td>
						<div class='btn-toolbar pull-right'>
							<div class='btn-group'>
								<?php
								echo $this->Html->link(
									"<i class='far fa-copy'></i>",
									array('action' => 'duplicate', $page['WebPage']['id'], $page['WebPage']['es_key'], 'index'),
									array(
										'escape' => false,
										'class' => 'btn btn-info btn-sm'
									)
								);
								?>
							</div>

							<?php
							echo $this->element('admin/widgets/actions/toggle', array(
								'field' => 'active',
								'value' => $page['WebPage']['active'],
								'linkOnly' => true,
								'toggleModel' => 'WebPage'
							));
							?>

							<div class='btn-group'>
								<?php
								echo $this->Html->link(
									"<i class='fas fa-edit'></i>",
									array(
										'action' => 'edit',
										$page['WebPage']['id'],
										Utility::slug($page['WebPage']['name']),
										'?' => array('lang' => $pageLocale)
									),
									array(
										'class' => 'btn btn-info btn-sm',
										'title' => __('Editar'),
										'escape' => false
									)
								);
								?>
							</div>

							<div class='btn-group'>
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
										'title' => 'Borrar elemento'
									)
								);
								?>
							</div>
						</div>
					</td>
				</tr>
				<?php
						endif;
					endforeach;
				endforeach;
				?>
			</tbody>
		</table>
	</div>

	<div class='boxes toolbar-group'>
		<?php echo $this->element('admin/widgets/lists/pagination', array('listKey' => 'WebPage')) ?>
	</div>
</div>
