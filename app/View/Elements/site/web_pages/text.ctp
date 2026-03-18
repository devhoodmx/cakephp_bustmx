<div class='webpage-element webpage-text <?php echo $element['Text']['is_well'] ? 'card bg-light' : ''; ?>'>
	<?php if ($element['Text']['is_well']): ?>
	<div class='card-body'>
		<?php echo $element['Text']['text']; ?>
	</div>
	<?php else: ?>
	<?php echo $element['Text']['text']; ?>
	<?php endif; ?>
</div>
