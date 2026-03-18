<?php

/*
 * @(#)Text Model         22/06/09
 *
 * Copyright (c) 2008-2009 Affen Bits, Inc.
 * C. 38 Campestre, Mérida, Yucatán, 97120, México 
 * All rights reserved.
 *
 * This software is the confidential and proprietary information of 
 * Affen Bits, Inc. ('Confidential Information').  You shall not
 * disclose such Confidential Information and shall use it only in
 * accordance with the terms of the license agreement you entered into
 * with Affen Bits.
 */

class Text extends AppModel {
	var $name = 'Text';	
	var $useTable = 'default_texts';
	var $actsAs = array(
		'Containable'
	);
	
	var $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' 		=> 'notBlank'
			)
		),
		'text' => array(
			'notBlank' => array(
				'rule' 		=> 'notBlank'
			)
		)
	);
}

?>