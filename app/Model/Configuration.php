<?php
App::uses('AppModel', 'Model');

class Configuration extends AppModel {
	public $name = 'Configuration';

	public $useConsistentAfterFind = true;

	public $actsAs = array(
		'Containable',
		'Loggable',
		'Media' => array(
			'image' => array(
				'private' => false,
				'not-empty' => false,
				'multiple' => false,
				'max-size' => '10MB',
				'files' => array(
					'image' => array(
						'custom' => array(
							'small' => array(
								'filters' => array(
									'resizeToMaxWidthHeight' => [400, 400]
								)
							)
						)
					),
					'svg' => [],
					'video' => []
				),
				'services' => false
			),
			'video' => [
				'private' => false,
				'not-empty' => false,
				'multiple' => false,
				'max-size' => '300MB',
				'files' => [
					'video' => []
				],
				'services' => false
			],
			'document' => array(
				'private' => false,
				'multiple' => false,
				'max-size' => '300MB',
				'files' => array(
					'file' => array(
						'types' => array('pdf')
					)
				),
				'services' => false
			)
		)
	);

	public $belongsTo = array(
		'Category'
	);

	public function afterFind($results, $primary = false) {
		foreach ($results as $key => $val) {
			if (array_key_exists('attributes', $val[$this->alias])) {
				$attributes = json_decode($val[$this->alias]['attributes'], true);
				$attributes = empty($attributes) ? array() : $attributes;

				$results[$key][$this->alias]['attributes_map'] = $attributes;
			}
		}

		return $results;
	}

	public function beforeValidate($options = array()) {
		if ($this->id) {
			$configuration = $this->find('first', array(
				'conditions' => array($this->alias . '.' . $this->primaryKey => $this->id),
				'contain' => false
			));

			if (!empty($configuration)) {
				$allowEmpty = $configuration[$this->alias]['allow_empty'] ? true : false;

				if ($configuration[$this->alias]['type'] == 'email') {
					$this->validator()->add('value', array(
						'email' => array(
							'rule' => 'email',
							'allowEmpty' => $allowEmpty
						)
					));
				}
				if ($configuration[$this->alias]['type'] == 'url') {
					$this->validator()->add('value', array(
						'url' => array(
							'rule' => array('url', true),
							'allowEmpty' => $allowEmpty
						)
					));
				}
				if (!$allowEmpty) {
					$this->validator()->add('value', array(
						'notBlank' => array(
							'rule' => 'notBlank'
						)
					));
				}
			}
		}

		return true;
	}

	public function beforeSave($options = []) {
		if (!empty($this->data)) {
			if ($this->id) {
				$configuration = $this->find('first', [
					'conditions' => [$this->alias . '.' . $this->primaryKey => $this->id],
					'contain' => false
				]);

				if ($configuration && !empty($this->data['Configuration']['value'])) {
					$value = $this->data['Configuration']['value'];
					$type = $configuration['Configuration']['type'];

					if ($type == 'checkbox') {
						// Multiple
						if (!empty($configuration['Configuration']['attributes_map']['options'])) {
							if (empty($value)) {
								$value = [];
							}

							$value = json_encode($value);
							$this->data['Configuration']['value'] = $value;
						}
					}
				}
			}
		}

		return true;
	}
}
?>
