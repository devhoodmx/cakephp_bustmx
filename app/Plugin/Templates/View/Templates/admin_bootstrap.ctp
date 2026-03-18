<?php
$this->Package->assign('view', 'css', array(
	'templates.view.templates.admin-bootstrap'
));

$this->assign('title', __('Bootstrap') . ' | ' . __('Site'));

$types = array('primary', 'success', 'info', 'warning', 'danger');
$sizes = array(
	array('name' => 'Large', 'key' => 'lg'),
	array('name' => 'Default', 'key' => ''),
	array('name' => 'Small', 'key' => 'sm'),
	array('name' => 'Extra small', 'key' => 'xs')
);
?>

<!-- Container -->
<div class='boxes columns-container bs-example'>
	<div class='row doc-section'>
		<div class='col-md-3'>
			<?php for ($index = 1; $index < 7; $index++): ?>
			<h<?php echo $index; ?>>h<?php echo $index; ?>. Heading</h<?php echo $index; ?>>
			<?php endfor; ?>
		</div>

		<div class='col-md-3'>
			<?php
			$options = array_merge(array('muted'), $types);
			foreach ($options as $key => $option):
			?>
			<p class='text-<?php echo $option; ?>'>text-<?php echo $option; ?></p>
			<?php endforeach; ?>
		</div>

		<div class='col-md-3'>
			<?php
			$options = array_merge(array('default'), $types);
			foreach ($options as $key => $option):
			?>
			<p>
				<span class='label label-<?php echo $option; ?>'><?php echo ucfirst($option); ?></span>
			</p>
			<?php endforeach; ?>
		</div>

		<div class='col-md-3'>
			<?php
			$options = array_merge(array('default'), $types);
			foreach ($options as $key => $option):
			?>
			<p>
				<a href='#'>Inbox <span class='badge badge-<?php echo $option; ?>'>42</span></a>
			</p>
			<?php endforeach; ?>
		</div>
	</div>

	<div class='row doc-section'>
		<?php
		$options = array_merge(array('default'), $types);
		$colSize = 12 / sizeof($options);
		foreach ($options as $key => $option):
		?>
		<div class='col-md-<?php echo $colSize; ?>'>
			<?php
			foreach ($sizes as $key => $size):
				$class = 'btn btn-' . $option;
				if (!empty($size['key'])) {
					$class .= ' btn-' . $size['key'];
				}
			?>
			<p>
				<button type='button' class='<?php echo $class; ?>'><?php echo ucfirst($option) . ' ' . $size['name']; ?></button>
			</p>
			<?php endforeach; ?>

			<p>
				<button type='button' class='btn btn-<?php echo $option; ?> active'><?php echo ucfirst($option) ?> Active</button>
			</p>

			<p>
				<button type='button' class='btn btn-<?php echo $option; ?> disabled'><?php echo ucfirst($option) ?> Disabled</button>
			</p>
		</div>
		<?php endforeach; ?>
	</div>

	<div class='row doc-section'>
		<div class='col-md-3'>
			<p>
				<div class='btn-group' role='group' aria-label='Basic example'>
					<button type='button' class='btn btn-default'>Left</button>
					<button type='button' class='btn btn-default'>Middle</button>
					<button type='button' class='btn btn-default'>Right</button>
				</div>
			</p>

			<p>
				<div class='btn-group' role='group' aria-label='Basic example'>
					<button type='button' class='btn btn-default'>Left</button>
					<button type='button' class='btn btn-default active'>Middle</button>
					<button type='button' class='btn btn-default'>Right</button>
				</div>
			</p>

			<p>
				<div class='btn-group' role='group' aria-label='Basic example'>
					<button type='button' class='btn btn-default'>1</button>
					<button type='button' class='btn btn-success'>2</button>
					<button type='button' class='btn btn-danger'>3</button>
				</div>
			</p>
		</div>

		<div class='col-md-3'>
			<div class='dropdown'>
				<button class='btn btn-default dropdown-toggle' type='button' id='dropdown-menu-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='true'>
					Dropdown
					<span class='caret'></span>
				</button>

				<ul class='dropdown-menu' aria-labelledby='dropdown-menu-1'>
					<li><a href='#'>Action</a></li>
					<li><a href='#'>Another action</a></li>
					<li><a href='#'>Something else here</a></li>
					<li role='separator' class='divider'></li>
					<li><a href='#'>Separated link</a></li>
			  	</ul>
			</div>
		</div>

		<div class='col-md-3'>
			<div class='dropdown'>
				<button class='btn btn-default dropdown-toggle' type='button' id='dropdown-menu-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='true'>
					Dropdown
					<span class='caret'></span>
				</button>

				<ul class='dropdown-menu dropdown-arrow-skin' aria-labelledby='dropdown-menu-1'>
					<li><a href='#'>Action</a></li>
					<li><a href='#'>Another action</a></li>
					<li><a href='#'>Something else here</a></li>
					<li role='separator' class='divider'></li>
					<li><a href='#'>Separated link</a></li>
				</ul>
			</div>
		</div>
	</div>

	<div class='row doc-section'>
		<div class='col-md-6'>
			<ul class='nav nav-tabs'>
				<li role='presentation' class='active'><a href='#'>Home</a></li>
				<li role='presentation'><a href='#'>Profile</a></li>
				<li role='presentation'><a href='#'>Messages</a></li>
			</ul>
		</div>
	</div>

	<div class='row doc-section'>
		<div class='col-md-6'>
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
			</ul>
			<!-- Next / Last -->
			<ul class='pager'>
				<li><?php echo $this->Html->link("<i class='fas fa-angle-right'></i>", '#', array('escape' => false, 'title' => __('Siguiente'))); ?></li>
				<li><?php echo $this->Html->link("<i class='fas fa-angle-double-right'></i>", '#', array('escape' => false, 'title' => __('Último'))); ?></li>
			</ul>
		</div>
	</div>

	<div class='row doc-section'>
		<div class='col-md-12'>
			<div class='panel panel-default'>
				<div class='panel-body'>
					<strong>Basic panel</strong>. sit amet, consectetur adipiscing elit. Vivamus luctus urna sed urna ultricies ac tempor dui sagittis. In condimentum.
				</div>
			</div>
		</div>

		<?php
		$options = array_merge(array('default'), $types);
		$colSize = 4;
		foreach ($options as $key => $option):
		?>
		<div class='col-md-<?php echo $colSize; ?>'>
			<div class='panel panel-<?php echo $option; ?>'>
				<div class='panel-heading'>
					<h3 class='panel-title'><?php echo ucfirst($option); ?> panel title</h3>
				</div>

				<div class='panel-body'>
					Panel content
				</div>
			</div>
		</div>
		<?php endforeach; ?>
	</div>

	<div class='row doc-section'>
		<div class='col-md-12'>
			<div class='well'>
				<strong>Well</strong>. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus luctus urna sed urna ultricies ac tempor dui sagittis.
			</div>
		</div>
	</div>

	<div class='row doc-section'>
		<div class='col-md-6'>
			<?php
			echo $this->element('alert', array('message' => "<strong>Warning</strong> Duis aliquet egestas purus in blandit. <a href='#' class='alert-link'>Link vulputate.</a>"));
			echo $this->element('alert', array('message' => "<strong>Success</strong> Duis aliquet egestas purus in blandit. <a href='#' class='alert-link'>Link vulputate.</a>", 'type' => 'success'));
			echo $this->element('alert', array('message' => "<strong>Info</strong> Duis aliquet egestas purus in blandit. <a href='#' class='alert-link'>Link vulputate.</a>", 'type' => 'info'));
			echo $this->element('alert', array('message' => "<strong>Error</strong> Duis aliquet egestas purus in blandit. <a href='#' class='alert-link'>Link vulputate.</a>", 'type' => 'danger'));
			?>
		</div>
	</div>

	<div class='row doc-section'>
		<?php
		$options = array_merge(array('default'), $types);
		$colSize = 4;
		foreach ($options as $key => $option):
		?>
		<div class='col-md-<?php echo $colSize; ?>'>
			<div class='callout callout-<?php echo $option; ?>'>
				<h4><?php echo ucfirst($option); ?> callout</h4>

				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus luctus. Nunc eu ullamcorper orci. Quisque eget odio ac lectus vestibulum.
			</div>
		</div>
		<?php endforeach; ?>
	</div>

	<div class='row doc-section'>
		<div class='col-md-6'>
			<?php
			foreach ($types as $key => $type):
				$progress = rand(1, 10) * 10;
				$label = $type == 'primary' ? '' : ' (' . $type . ')';
				$class = $type == 'primary' ? '' : 'progress-bar-' . $type;
			?>
			<div class='progress'>
				<div class='progress-bar <?php echo $class; ?>' role='progressbar' aria-valuenow='<?php echo $progress; ?>' aria-valuemin='0' aria-valuemax='100' style='width: <?php echo $progress; ?>%'>
					<span class='sr-only'><?php echo $progress; ?>% Complete<?php echo $label; ?></span>
				</div>
			</div>
			<?php endforeach; ?>
		</div>

		<div class='col-md-6'>
			<?php
			foreach ($types as $key => $type):
				$progress = rand(1, 10) * 10;
				$label = $type == 'primary' ? '' : ' (' . $type . ')';
				$class = $type == 'primary' ? '' : 'progress-bar-' . $type;
			?>
			<div class='progress'>
				<div class='progress-bar <?php echo $class; ?> progress-bar-striped' role='progressbar' aria-valuenow='<?php echo $progress; ?>' aria-valuemin='0' aria-valuemax='100' style='width: <?php echo $progress; ?>%'>
					<span class='sr-only'><?php echo $progress; ?>% Complete<?php echo $label; ?></span>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>

	<div class='row doc-section'>
		<div class='col-md-12'>
			<div class='jumbotron'>
				<h1>Hello, world!</h1>
				<p>Etiam at risus et justo dignissim congue. Donec congue lacinia dui, a porttitor lectus.</p>
			</div>
		</div>
	</div>
</div>
