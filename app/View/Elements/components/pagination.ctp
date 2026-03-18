<?php
$attrs = [
	'data-component' => 'pagination',
	'aria-label' => __('pagination')
];
$class = sprintf('pagination-component%s', (empty($class) ?  '' : ' ' . $class));
$options = isset($options) ? $options : [];
$numbers = isset($numbers) ? $numbers : [];
$prev = isset($prev) ? $prev : true;
$next = isset($next) ? $next : true;

// Options
if (is_array($options)) {
	$options = array_merge(
		$options,
		[
			'class' => 'page-link'
		]
	);
}
// Numbers
$numbers = array_merge(
	$numbers,
	[
		'tag' => 'li',
		'class' => 'page-item',
		'separator' => false,
		'currentTag' => 'span',
		'currentClass' => 'active',
		'ellipsis' => "<li class='page-item disabled'><span class='page-link'>...</span></li>"
	]
);

// Attributes
$attrs['class'] = $class;

$this->Package->append('component', 'css', array(
	'component.pagination'
));

$this->Paginator->options($options);
?>
<?php echo $this->Html->tag('nav', null, $attrs); ?>
	<ul class='pagination'>
		<?php if ($prev): ?>
		<!-- Prev -->
		<?php
		$_title = __('pagination-prev');

		if (is_string($prev)) {
			$_title = $prev;
		}

		echo $this->Paginator->prev(
			$_title,
			[
				'tag' => 'li',
				'escape' => false,
				'class' => 'page-item page-prev'
			],
			"<span class='page-link'>" . $_title . '</span>',
			[
				'class' => 'page-item page-prev disabled'
			]
		);
		?>
		<?php endif; ?>

		<?php if ($numbers): ?>
		<!-- Numbers -->
		<?php
		$buffer = $this->Paginator->numbers($numbers);

		// Hack to transform current item into a link
		$current = $this->Paginator->current();
		$currentLink = $this->Html->link(
			$current,
			$this->request->here(),
			[
				'class' => 'page-link'
			]
		);
		$buffer = str_replace(
			'"active page-item"><span>' . $current . '</span>',
			'"active page-item" aria-current="page">' . $currentLink,
			$buffer
		);

		echo $buffer;
		?>
		<?php endif; ?>

		<?php if ($next): ?>
		<!-- Next -->
		<?php
		$_title = __('pagination-next');

		if (is_string($next)) {
			$_title = $next;
		}

		echo $this->Paginator->next(
			$_title,
			[
				'tag' => 'li',
				'escape' => false,
				'class' => 'page-item page-next'
			],
			"<span class='page-link'>" . $_title . '</span>',
			[
				'class' => 'page-item page-next disabled'
			]
		);
		?>
		<?php endif; ?>
	</ul>
</nav>
