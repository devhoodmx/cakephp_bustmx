<?php
$id = empty($id) ? null : $id;
$class = sprintf('filters-component%s', (empty($class) ?  '' : ' ' . $class));
$filters =  !empty($filters) ? $filters : [];
$_actions =  !empty($actions) ? $actions : [];

// Default actions
$actions = [
	'filter' => [
		'active' => true
	],
	'clear' => [
		'active' => false,
		'action' => $this->request->action
	],
	'advanced' => [
		'active' => false
	]
];

// Merge default & user defined actions
foreach ($actions as $_key => $action) {
	if (isset($_actions[$_key])) {
		if (is_bool($_actions[$_key])) {
			$actions[$_key]['active'] = $_actions[$_key];
		} elseif (is_array($_actions[$_key])) {
			$actions[$_key] = array_merge($actions[$_key], $_actions[$_key]);
		}
	}
}

$filterUrl = Router::reverseToArray($this->request);
unset($filterUrl['page']);

$this->Package->append('component', 'css', [
	'admin.component.filters'
]);
?>
<div <?php $id ? printf("id='%s'", $id) : ''; ?> class='<?php echo $class; ?>' data-component='filters'>
	<?php
	$modalId = null;
	$filterType = null;

	foreach ($filters as $key => $filter) {
		$filterType = isset($filter['type']) ? $filter['type'] : null;

		// Actions
		if ($filterType != 'hidden') {
			// Clear
			if ($this->request->query($key)) {
				$actions['clear']['active'] = true;
			}
			// Advanced
			if (!empty($filter['advanced'])) {
				$actions['advanced']['active'] = true;
			}
		}
	}
	?>

	<?php
	// Modal
	if ($actions['advanced']['active']) {
		$modalId = sprintf('filters-modal-%s', mt_rand(0, 1000));

		echo $this->element('admin/components/filters/modal', [
			'id' => $modalId,
			'inputs' => $this->element('admin/components/filters/inputs', [
				'filters' => $filters,
				'labels' => true,
				'advanced' => true
			])
		]);
	}
	?>

	<?php
	echo $this->BootForm->create(false, [
		'id' => false,
		'type' => 'get',
		'async' => false,
		'class' => 'filters-form',
		'url' => $filterUrl
	]);
	?>
		<?php
		echo $this->element('admin/components/filters/inputs', [
			'filters' => $filters,
			'labels' => false,
			'advanced' => false
		]);
		?>

		<!-- Actions -->
		<div class='actions'>
			<?php
			if ($actions['advanced']['active']) {
				echo $this->BootForm->button(
					sprintf(
						'<i class="fas fa-filter"><span class="sr-only">%s</span></i>',
						__('Abrir filtros avanzados')
					),
					[
						'type' => 'button',
						'class' => 'btn btn-sm btn-info',
						'title' => __('Mostrar filtros avanzados'),
						'data-toggle' => 'modal',
						'data-target' => sprintf('#%s', $modalId)
					]
				);
			}

			if ($actions['filter']['active']) {
				echo $this->BootForm->button(
					sprintf(
						'<i class="fas fa-check"><span class="sr-only">%s</span></i>',
						__('Filtrar')
					),
					[
						'type' => 'submit',
						'class' => 'btn btn-sm btn-primary',
						'title' => __('Filtrar')
					]
				);
			}

			if ($actions['clear']['active']) {
				echo $this->Html->link(
					sprintf(
						'<i class="fas fa-eraser"><span class="sr-only">%s</span></i>',
						__('Limpiar')
					),
					$actions['clear'],
					['class' => 'btn btn-sm btn-default', 'escape' => false]
				);
			}
			?>
		</div>
	<?php echo $this->BootForm->end(); ?>
</div>
