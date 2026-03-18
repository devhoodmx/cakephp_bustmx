<div class='webpage'>
	<div id='layout-title'>
		<div class='clean'>
		<?php
		// echo $this->Html->link(
		// 	'<i class="fas fa-times"></i>',
		// 	array(
		// 		'action' => 'clean',
		// 		$page['WebPage']['id'],
		// 		Utility::slug($page['WebPage']['name'])
		// 	),
		// 	array('class' => 'btn btn-warning', 'escape' => false)
		// );
		?>
		</div>
	</div>

	<div class='layout-content' data-sortable-container>
		<?php foreach($page['WebPageSection'] as $section) : ?>
		<?php echo $this->element('admin/web_pages/section',array('page' => $page, 'section' => $section)); ?>
		<?php endforeach; ?>

		<?php echo $this->element('admin/web_pages/section', array('page' => $page)); ?>
	</div>

	<?php
	/*
	// Shared Page
	if (!empty($page['SharedContent']['WebPageSection'])) :


	<div class='shared layout-content'>
		<?php
			foreach($page['SharedContent']['WebPageSection'] as $section) {
				echo $this->element('admin/web_pages/shared',array('page' => $page, 'section' => $section));
			}
		?>
	</div>

	<?php endif; ?>
	*/
	?>
</div>
