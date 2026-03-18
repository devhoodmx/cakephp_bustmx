<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
	public $useConsistentAfterFind = false;

	public function isEqualToField($check, $field) {
		if (!isset($this->data[$this->name][$field])) {
			return false;
		}

		$value = array_shift($check);

		return ($value == $this->data[$this->name][$field]);
	}

	public function onlyIf($check, $relatedField, $relatedFieldRule, $rule) {
		if (!isset($this->data[$this->alias][$relatedField])) {
			return false;
		}

		$validationRule = new CakeValidationRule(array('rule' => $relatedFieldRule));
		$methods = $this->validator()->getMethods();

		if ($validationRule->process($relatedField, $this->data[$this->alias], $methods) && $validationRule->isValid()) {
			$validationRule = new CakeValidationRule(array('rule' => $rule));
			reset($check);

			return $validationRule->process(key($check), $this->data[$this->alias], $methods) && $validationRule->isValid();
		}

		return true;
	}

	public function different($check, $against) {
		$return = false;

		$field = array_keys($check);
		$field = $field[0];

		if ($check[$field] != $this->data[$this->name][$against]) {
			$return = true;
		}

		return $return;
	}

	public function unique($check, $against) {
		$return = true;
		$field = array_keys($check);
		$field = $field[0];
		$fields = array('OR' => array(
			$field => $check[$field],
			$against => $check[$field])
		);

		if (!empty($this->id)) {
			$fields[$this->alias . '.' . $this->primaryKey . ' !='] = $this->id;
		}

		$count = $this->find('count', array('conditions' => $fields, 'recursive' => -1));

		if ($count) {
			$return = false;
		}

		return $return;
	}
}
