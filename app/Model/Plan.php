<?php
App::uses('AppModel', 'Model');
/**
 * Plan Model
 *
 */
class Plan extends AppModel {
	public $name = 'Plan';
	public $virtualFields = array(
		'display_created' => 'DATE_FORMAT(Plan.created, "%d/%m/%y %H:%i")',
		'formatted_price' => 'FORMAT(Plan.price, 2)'
	
	);
	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		),

        'list' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty'
            )

        ),
		'price' => [
			'notEmpty' => [
				'rule' => 'notEmpty'
			],
			'numeric' => [
				'rule' => 'numeric'
			]
		]
	);
}
