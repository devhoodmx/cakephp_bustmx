<?php
App::uses('AppModel', 'Model');
/**
 * Review Quote
 *
 */
class Quote extends AppModel {
	public $name = 'Quote';
	
	public $validationDomain = 'error';
	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		),
        'email' => array(
			'notBlank' => array('rule' => 'notBlank'),
			'email' => [
				'rule' => 'email',
				'allowEmpty' => true
			]
		),
        'message' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty'
            )

        ),
        'phone' => [
			'notEmpty' => [
				'rule' => 'notEmpty'
			],
			'numeric' => [
				'rule' => 'numeric'
			]
            
        ],
        'budget' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty'
            )

        ),
	);
}