<?php
$title = 'Sección';

$this->assign('title', __d('admin', 'page-title', $title, $config['simian']['title'], $config['simian']['version']));

$this->set('menuItemKey', 'content');
$this->set('submenuItemKey', 'web_pages');
?>

<?php
echo $this->BootForm->create('WebPageSection', array(
	'data-model' => 'WebPageSection',
	'data-id' => $webPageSection['WebPageSection']['id'],
	'async' => false,
	'url' => array('controller' => 'web_page_sections', 'action' =>  'edit', $webPageSection['WebPageSection']['id'])
));
?>

<!-- Header -->
<div class='page-header boxes'>
	<!-- Title -->
	<h1 class='pull-left'><?php echo $title; ?></h1>

	<div class='btn-toolbar pull-right'>
		<?php
		// Cancel
		echo $this->Html->link(
			__('cancel'),
			array(
				'controller' => 'web_pages',
				'action' => 'view',
				$webPageSection['WebPageTranslation']['web_page_id'],
				'?' => array(
					'lang' => $webPageSection['WebPageTranslation']['language']
				)
			),
			array('class' => 'btn btn-link btn-sm text-danger')
		);

		// Save
		echo $this->BootForm->submit('Guardar', array(
			'buttonType' => 'success',
			'class' => 'btn-sm',
			'div' => false
		));
		?>
	</div>
</div>
<!-- End header -->

<!-- Columns -->
<div class='doc-body-row'>
	<!-- Main -->
	<div class='doc-body-main'>
		<?php
		$fields = array(
			'centered' => array(
				'type' => 'radio',
				'legend' => __d('web_page_section', 'centered'),
				'options' => array(
					1 => 'Sí',
					0 => 'No'
				)
			),
			'offset' => array(
				'type' => 'radio',
				'legend' => __d('web_page_section', 'offset'),
				'options' => array(
					1 => 'Sí',
					0 => 'No'
				)
			),
			'padded' => array(
				'type' => 'radio',
				'legend' => __d('web_page_section', 'padded'),
				'options' => array(
					1 => 'Sí',
					0 => 'No'
				)
			),
			'spaced' => array(
				'type' => 'radio',
				'legend' => __d('web_page_section', 'spaced'),
				'options' => array(
					1 => 'Sí',
					0 => 'No'
				)
			),
			'min_height' => array(
				'type' => 'text'
			),
			'background_color' => array(
				'type' => 'text',
				'placeholder' => '#35BDB2'
			),
			'background' => 'media',
			'styles' => array(
				'type' => 'textarea',
				'placeholder' => 'margin-bottom: 30px; padding: 0 20px;',
				'rows' => 4,
				'style' => 'font-family: courier',
				'after' => sprintf("<span class='help-block'>%s</span>", __d('web_page_section', 'styles-help'))
			),
			'class' => array(
				'type' => 'text',
				'placeholder' => 'webpage-section bg-light small',
				'after' => sprintf("<span class='help-block'>%s</span>", __d('web_page_section', 'class-help'))
			)
		);

		echo $this->element('admin/widgets/form/inputs', array('fields' => $fields, 'modelKey' => 'MenuItem'));
		?>
	</div>
</div>

<?php echo $this->BootForm->end(); ?>
