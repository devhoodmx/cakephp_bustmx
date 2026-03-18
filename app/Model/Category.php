<?php
App::uses('AppModel', 'Model');

class Category extends AppModel {
	public $name = 'Category';

	public $actsAs = array(
		'Tree' => array(
			'level' => 'level'
		),
		'Sortable' => array(
			'foreignKey' => array(
				'parent_id'
			)
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

	public $belongsTo = array(
        'ParentCategory' => array(
            'className' => 'Category',
            'foreignKey' => 'parent_id'
        )
	);

	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->order[$this->alias . '.order'] = 'ASC';
	}

	public function beforeSave($options = []) {
		if (!empty($this->data[$this->alias]['key']) && !Utility::isProsimian()) {
			unset($this->data[$this->alias]['key']);
		}

		return true;
	}

	public function afterSave($created, $options = []) {
		$parents = $this->getPath($this->id);

		if (!empty($parents)) {
			$path = '';
			$names = array();
			$size = sizeof($parents);

			for ($index = 0; $index < $size - 1; $index++) {
				$names[] = $parents[$index][$this->alias]['name'];
			}

			$path = implode(' » ', $names);

			$this->saveField('path', $path, array('callbacks' => false));
		}
	}

	public $hasMany = array(
        'RequestVacancy' => array(
            'className' => 'RequestVacancy',
            'foreignKey' => 'vacancy_id',
        )
    );
}
