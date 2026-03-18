<?php
class MediaLink extends AppModel {
	public $name = 'MediaLink';

	public $actsAs = array(
		'Containable'
	);

	public $validate = array(
		'hash' => array(
			'notBlank' => array(
				'rule' => 'notBlank'
			)
		)
	);

	public $belongsTo = array(
		'Media' => array(
			'dependent' => true
		)
	);

	public function beforeValidate($options = []) {
		if (!isset($this->data[$this->alias]['hash'])) {
			$this->data[$this->alias]['hash'] = CakeText::uuid();
		}
	}
}
?>
