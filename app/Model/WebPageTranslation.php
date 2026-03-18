<?php
App::uses('AppModel', 'Model');

class WebPageTranslation extends AppModel {
	public $name = 'WebPageTranslation';

	public $actsAs = array(
		'Containable',
		'Loggable'
	);

	public $validate = array(
		'name' => array(
			'notBlank' => array('rule' => 'notBlank')
		)
	);

	public $belongsTo = array(
		'WebPage' => array(
			'className' => 'WebPage',
			'foreignKey' => 'web_page_id'
 		)
	);

	public $hasMany = array(
		'WebPageSection' => array(
			'className' => 'WebPageSection',
			'foreignKey' => 'web_page_translation_id',
			'order' => array('WebPageSection.order' => 'ASC'),
			'dependent' => true
		)
	);
}
?>
