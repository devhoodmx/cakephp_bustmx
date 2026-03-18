<?php $listKey = empty($listKey) ? NULL : $listKey ?>

<?php if (!empty($configView['filter'])) : ?>
	<div class='boxes columns-container'>
		<div class='boxes toolbar-group'>
			<?php 
			if (is_array($configView['filter'])) {
				echo $this->element('admin/filters/default', array('listKey' => $listKey, 'filters' => $configView['filter']));
			} else {
				$filterElement = is_string($configView['filter']) ? $configView['filter'] : Inflector::pluralize($model);
				echo $this->element('admin/filters/' . $filterElement, array('listKey' => $listKey));
			}
			?>
		</div>
	</div>
<?php endif ?>

<div class='boxes toolbar-group'>
	<?php echo $this->element('admin/widgets/lists/pagination', array('listKey' => $listKey)) ?>
</div>

<?php
echo $this->element('admin/widgets/lists/table', array('configList' => $configList, 'listData' => $listData, 'model' => $model, 'listKey' => empty($listKey) ? 'main' : $listKey));
?>

<div class='boxes toolbar-group'>
	<?php echo $this->element('admin/widgets/lists/pagination', array('listKey' => $listKey)) ?>
</div>
