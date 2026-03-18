<?php
App::uses('AppController', 'Controller');

class WebPageSeosController extends AppController {

	public function admin_index() {
		parent::admin_index();

		$this->view = 'admin_index';
	}

	public function admin_edit($id = null, $name = null) {
		$config = parent::admin_edit($id, $name);
		$available = [
			'title' => [
				'type' => 'text'
			],
			'description' => [
				'type' => 'textarea'
			],
			'meta' => [
				'type' => 'textarea'
			],
			'header_code' => [
				'type' => 'textarea'
			],
			'footer_code' => [
				'type' => 'textarea'
			]
		];
		$fields = $config['form']['fields']['main'];
		$locales = Configure::read('App.i18n.locales');
		$localesLength = sizeof($locales);

		$this->view = 'admin_edit';

		// Build localized fields
		foreach ($available as $fieldKey => $field) {
			foreach ($locales as $_locale) {
				$key = $_locale . '_' . $fieldKey;

				$fields[$key] = $field;

				// Label
				$fields[$key]['label'] = Utility::translate(
					str_replace('_', '-', $fieldKey),
					'web_page_seo',
					'fields'
				);

				// Append locale to label
				if ($localesLength > 1) {
					$fields[$key]['label'] .= sprintf(
						' en %s',
						mb_strtolower(__('locale-' . $_locale))
					);
				}
			}
		}

		// Set fields
		$config['setParams']['configView']['fields']['main'] = $fields;
		$config['setParams']['configView']['fields']['aside'] = ['Imagen' => ['image' => 'media']];

		$this->set($config['setParams']);
	}
}
?>
