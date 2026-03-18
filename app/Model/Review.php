<?php
App::uses('AppModel', 'Model');
/**
 * Review Model
 *
 */
class Review extends AppModel {
	public $name = 'Review';
	public $virtualFields = array(
		'display_created' => 'DATE_FORMAT(Review.created, "%d/%m/%y %H:%i")',
	
	);
	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		),

        'description' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty'
            )

        ),
	);
}