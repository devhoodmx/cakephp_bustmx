<?php

/*
 * @(#)Web Page Element Model         22/06/09
 *
 * Copyright (c) 2008-2009 affenbits, Inc.
 * C. 38 Campestre, Mérida, Yucatán, 97120, México
 * All rights reserved.
 *
 * This software is the confidential and proprietary information of
 * affenbits, Inc. ("Confidential Information").  You shall not
 * disclose such Confidential Information and shall use it only in
 * accordance with the terms of the license agreement you entered into
 * with affenbits.
 */

class WebPageElement extends AppModel {
	public $name = 'WebPageElement';
	public $actsAs = array(
		'Containable',
		'Media' => array(
			'image' => array(
				'private' => TRUE,
				'multiple' => TRUE,
				'max-size' => '5MB',
				'files' => array(
					'image' => array(
						'custom' => array(
							'element' => array(
								'filters' => array(
									'resizeToMaxWidthHeight' => array(960, 720)
								)
							),
							'carousel' => array(
								'filters' => array(
									'resizeAndCrop' => array(1280, 720)
								)
							),
							'raw' => array()
						),
						'attributes' => [
							'subtitle' => 'text'
						]
					)
				),
				'services' => FALSE
			),
			'archive' => array(
				'private' => FALSE,
				'multiple' => TRUE,
				'max-size' => '300MB',
				'files' => array(
					'file' => array(
						//'types' => array('docx')
					)
				),
				'services' => FALSE
			),
		),
		'Sortable' => array(
			'foreignKey' => array(
				'web_page_section_id'
			)
		)
	);

	public $belongsTo = array(
		'WebPageSection' => array(
			'className'		=> 'WebPageSection',
			'foreignKey'	=> 'web_page_section_id'
		)
	);

	public $hasOne = array(
		'Text' => array(
			'className'     => 'Text',
			'foreignKey'    => 'foreign_key',
			'conditions' 	=> array('Text.model' => 'WebPageElement'),
			'dependent'		=> true
		),
		'Video' => array(
			'className'     => 'Video',
			'foreignKey'    => 'foreign_key',
			'conditions' 	=> array('Video.model' => 'WebPageElement'),
			'dependent'		=> true
		),
		'Code' => array(
			'className'     => 'Code',
			'foreignKey'    => 'foreign_key',
			'conditions' 	=> array('Code.model' => 'WebPageElement'),
			'dependent'		=> true
		),
		'Map' => array(
			'className'		=> 'WebPageMap',
			'dependent'		=> true
		)
		// 'Image' => array(
		// 	'className'     => 'Image',
		// 	'foreignKey'    => 'foreign_key',
		// 	'conditions' 	=> array('Image.model' => 'WebPageElement'),
		// 	'dependent'		=> true
		// ),
		// 'Archive' => array(
		// 	'className'     => 'Archive',
		// 	'foreignKey'    => 'foreign_key',
		// 	'conditions' 	=> array('Archive.model' => 'WebPageElement'),
		// 	'dependent'		=> true
		// )
	);
}
?>
