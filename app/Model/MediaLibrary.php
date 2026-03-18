<?php
App::uses('AppModel', 'Model');

class MediaLibrary extends AppModel {
	public $name = 'MediaLibrary';

	public $actsAs = array(
		'Tree',
		'Sortable' => array(
			'foreignKey' => array(
				'parent_id'
			)
		),
		'Media' => array(
			'model-url' => [
				'action' => 'index'
			]
		),
		'Containable',
		'Loggable'
	);

	public $order = array();

	public $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' => 'notBlank'
			)
		)
	);

	public $hasMany = array(
		'MediaLibraryLink' => array(
			'dependent' => true,
			'counterCache' => 'links'
		)
	);

	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->order[$this->alias . '.order'] = 'ASC';
	}

	public function beforeSave($options = []) {
		if (!empty($this->data[$this->alias]['name']) && empty($this->data[$this->alias]['slug'])) {
			$this->data[$this->alias]['slug'] = Utility::slug($this->data[$this->alias]['name']);
		}

		if (!empty($this->data[$this->alias]['slug'])) {
			$this->data[$this->alias]['slug'] = Utility::slug($this->data[$this->alias]['slug']);
		}

		return true;
	}
}
