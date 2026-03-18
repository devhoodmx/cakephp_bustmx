<?php
class Media extends AppModel {
	public $name = 'Media';

	public $order = array('order' => 'DESC');

	public $displayField = 'name';

	public $actsAs = array(
		'Media' => array(),
		'Containable',
		'Sortable' => array(
			'foreignKey' => array('model', 'foreign_key', 'collection')
		)
	);

	public $validate = array(
		'model' => array(
			'notBlank' => array(
				'rule' => 'notBlank',
				'required' => 'create'
			)
		),
		'collection' => array(
			'notBlank' => array(
				'rule' => 'notBlank',
				'required' => 'create'
			)
		),
		'share_key' => array(
			'unique' => array(
				'rule' => 'isUnique',
				'allowEmpty' => true
			),
		)
	);

	public $hasOne = array(
		'MediaLink' => array(
			'dependent' => true
		)
	);
}
?>
