<?php
$paginateUrl = Router::reverseToArray($this->request);
unset($paginateUrl['page']);

$listKey = empty($listKey) ? NULL : $listKey;
$paginatorParams = $this->Paginator->params();
echo $this->Paginator->options(array(
	'class' => 'btn btn-default',
	'model' => $listKey
));
?>
<?php if (!empty($paginatorParams['count']) && !empty($paginatorParams['limit'])) : ?>
<div class='pull-right pagination-info' data-paginate='<?php echo empty($listKey) ? 'main' : $listKey ?>'>

	<span class='pagination-resume'><?php echo $this->Paginator->counter(__('paginate-counter')); ?></span>

	<div class='btn-group'>
		<?php
		echo $this->Paginator->prev(
			"<i class='fas fa-chevron-left'></i>",
			array(
				'tag' => FALSE,
				'title' => __('previous'),
				'escape' => FALSE,
				'class' => 'btn btn-default'
			),
			null,
			array(
				'tag' => FALSE,
				'title' => __('previous'),
				'escape' => FALSE,
				'class' => 'btn btn-default disabled'
			)
		);

		echo $this->Paginator->numbers(array(
			'tag' => FALSE,
			'currentTag' => 'span',
			'separator' => FALSE,
			'modulus' => 2
		));


		echo $this->Paginator->next(
			"<i class='fas fa-chevron-right'></i>",
			array(
				'tag' => FALSE,
				'title' => __('next'),
				'escape' => FALSE,
				'class' => 'btn btn-default'
			),
			null,
			array(
				'tag' => FALSE,
				'title' => __('next'),
				'escape' => FALSE,
				'class' => 'btn btn-default disabled'
			)
		);
		?>
	</div>

	<div class='btn-group'>
		<?php
		echo $this->Html->link(
			"<i class='fas fa-cog'></i>",
			'#',
			array('escape' => false, 'class' => 'btn btn-default dropdown-toggle', 'data-toggle' => 'dropdown')
		);
		?>
		<div class='dropdown-menu dropdown-arrow-skin dropdown-menu-right' role='menu'>
			<?php if ($this->Paginator->hasNext($listKey) || $this->Paginator->hasPrev($listKey)) : ?>
				<?php echo $this->Paginator->options(array('class' => FALSE)); ?>
				<li class='dropdown-header' role='presentation'>
					<?php echo __('go-to'); ?>
				</li>
				<?php if ($this->Paginator->hasPrev($listKey)) : ?>
				<li role='presentation'>
					<?php echo $this->Paginator->first(__('first-page'), array('tag' => FALSE)); ?>
				</li>
				<?php endif ?>

				<?php if ($this->Paginator->hasNext($listKey)) : ?>
				<li role='presentation'>
					<?php echo $this->Paginator->last(__('last-page'), array('tag' => FALSE)); ?>
				</li>
				<?php endif ?>
			<?php endif ?>

			<li class='dropdown-header' role='presentation'>
				<?php echo __('items-per-page'); ?>
			</li>
			<li role='presentation'>
				<?php
				echo $this->Html->link(
					'10',
					array_merge($paginateUrl, array('limit' => 10)),
					array('escape' => false, 'role' => 'menuitem')
				);
				?>
			</li>
			<li role='presentation'>
				<?php
				echo $this->Html->link(
					'25',
					array_merge($paginateUrl, array('limit' => 25)),
					array('escape' => false, 'role' => 'menuitem')
				);
				?>
			</li>
			<li role='presentation'>
				<?php
				echo $this->Html->link(
					'50',
					array_merge($paginateUrl, array('limit' => 50)),
					array('escape' => false, 'role' => 'menuitem')
				);
				?>
			</li>
			<li role='presentation'>
				<?php
				echo $this->Html->link(
					'100',
					array_merge($paginateUrl, array('limit' => 100)),
					array('escape' => false, 'role' => 'menuitem')
				);
				?>
			</li>
		</div>
	</div>
</div>
<?php endif; ?>
