<?php
App::uses('AppModel', 'Model');

class Module extends AppModel {
	public $name = 'Module';

	public $useTable = 'acos';

	public $actsAs = array(
		'Tree',
		'Sortable' => array(
			'foreignKey' => array(
				'parent_id',
				'category_id'
			)
		),
		'Containable',
		'Loggable'
	);

	public $order = array(
		'Module.order' => 'ASC'
	);

	public $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' => 'notBlank'
			)
		),
		'model' => array(
			'notBlank' => array(
				'rule' => 'notBlank'
			)
		),
		'category_id' => array(
			'notBlank' => array(
				'rule' => 'notBlank'
			)
		)
	);

	public $belongsTo = array(
		'Category',
		'Parent' => array(
			'className' => 'Module',
			'foreignKey' => 'parent_id'
		)
	);

	public function beforeSave($options = []) {
		if (isset($this->data[$this->alias]['model'])) {
			$key = Inflector::tableize($this->data[$this->alias]['model']);
			$url = sprintf('/admin/%s', $key);

			$this->data[$this->alias]['alias'] = str_replace('/', '.', $url);

			if (empty($this->data[$this->alias]['key'])) {
				$this->data[$this->alias]['key'] = $key;
			}
		}

		return true;
	}
}
