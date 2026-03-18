<?php

/*
 * @(#)Web Page Section Model         22/06/09
 *
 * Copyright (c) 2008-2009 affenbits, Inc.
 * C. 38 Campestre, Mérida, Yucatán, 97120, México
 * All rights reserved.
 *
 * This software is the confidential and proprietary information of
 * affenbits, Inc. ('Confidential Information').  You shall not
 * disclose such Confidential Information and shall use it only in
 * accordance with the terms of the license agreement you entered into
 * with affenbits.
 */
class WebPageSection extends AppModel {
	public $name = 'WebPageSection';

	public $actsAs = array(
		'Containable',
		'Sortable' => array(
			'foreignKey' => array(
				'web_page_translation_id'
			)
		),
		'Media' => array(
			'background' => array(
				'private' => true,
				'multiple' => false,
				'max-size' => '10MB',
				'files' => array(
					'image' => array(
						'custom' => array(
							'background' => array(
								'filters' => array(
									'resizeToMaxWidthHeight' => array(1280, 548)
								)
							)
						)
					)
				),
				'services' => FALSE
			)
		)
	);

	public $belongsTo = array(
		'WebPageTranslation' => array(
			'className'		=> 'WebPageTranslation',
			'foreignKey'	=> 'web_page_translation_id'
		)
	);

	public $hasMany = array(
		'Column1' => array(
			'className'     => 'WebPageElement',
			'foreignKey'    => 'web_page_section_id',
			'conditions' 	=> array('Column1.column' => 1),
			'order'    		=> array('Column1.order' => 'ASC'),
			'dependent'		=> false
		),
		'Column2' => array(
			'className'     => 'WebPageElement',
			'foreignKey'    => 'web_page_section_id',
			'conditions' 	=> array('Column2.column' => 2),
			'order'    		=> array('Column2.order' => 'ASC'),
			'dependent'		=> false
		),
		'Column3' => array(
			'className'     => 'WebPageElement',
			'foreignKey'    => 'web_page_section_id',
			'conditions' 	=> array('Column3.column' => 3),
			'order'    		=> array('Column3.order' => 'ASC'),
			'dependent'		=> false
		),
		'Column4' => array(
			'className'     => 'WebPageElement',
			'foreignKey'    => 'web_page_section_id',
			'conditions' 	=> array('Column4.column' => 4),
			'order'    		=> array('Column4.order' => 'ASC'),
			'dependent'		=> false
		),
		'Element' => array(
			'className'     => 'WebPageElement',
			'foreignKey'    => 'web_page_section_id',
			'order' => array(
				'Element.column' => 'ASC',
				'Element.lft' => 'ASC'
			),
			'dependent'		=> true
		)
	);
}
?>
