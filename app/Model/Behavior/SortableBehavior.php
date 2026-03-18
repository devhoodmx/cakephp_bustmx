<?php

App::uses('ModelBehavior', 'Model');

class SortableBehavior extends ModelBehavior {

	protected $_defaults = array(
		'column' => 'order',
		'conditions' => array(),
		'foreignKey' => array()
	);


	public function setup(Model $Model, $config = array()) {
		$settings = Set::merge($this->_defaults, $config);

		$this->settings[$Model->alias] = $settings;
	}

	public function afterSave(Model $Model, $created, $options = []) {
		extract($this->settings[$Model->alias]);
		if($created && empty($Model->data[$Model->alias][$column])) {
			$Model->updateAll(
				array(
					$Model->alias . '.' . $column => $Model->id
				),
				array(
					$Model->alias . '.id' => $Model->id
				)
			);
		}
	}

	public function move(Model $Model, $id = NULL, $replaceId) {
		extract($this->settings[$Model->alias]);

		if (empty($id) && !empty($Model->id)) {
			$id = $Model->id;
		}

		if (!empty($id)) {
			$movingObject = $Model->find('first', array(
				'conditions' => Set::merge(
					$conditions,
					array($Model->alias . '.id' => $id)
				),
				'contain' => FALSE
			));

			if (!empty($movingObject)) {
				$movingConditions = array($Model->alias . '.id <>' => $id);

				if (!empty($foreignKey)) {
					if (!is_array($foreignKey)) {
						$foreignKey = array($foreignKey);
					}

					foreach ($foreignKey as $key) {
						$keyValue = $movingObject[$Model->alias][$key];
						$movingConditions[$Model->alias . '.' . $key] = $keyValue;
					}
				}

				$relatedObject = $Model->find('first', array(
					'conditions' => Set::merge(
						$conditions,
						$movingConditions,
						array($Model->alias . '.id' => $replaceId)
					),
					'contain' => FALSE
				));
			}

			if (!empty($movingObject) && !empty($relatedObject)) {
				if ($movingObject[$Model->alias][$column] != $relatedObject[$Model->alias][$column]) {
					if ($movingObject[$Model->alias][$column] > $relatedObject[$Model->alias][$column]) {
						$increment = 1;
					} else {
						$increment = -1;
					}

					if ($increment > 0) {
						$movingValue = array($Model->alias . '.' . $column =>  $Model->alias . '.' . $column . ' + 1');
						$movingConditions[$Model->alias . '.' . $column . ' <'] = $movingObject[$Model->alias][$column];
						$movingConditions[$Model->alias . '.' . $column . ' >='] = $relatedObject[$Model->alias][$column];
					} else {
						$movingValue = array($Model->alias . '.' . $column =>  $Model->alias . '.' . $column . ' - 1');
						$movingConditions[$Model->alias . '.' . $column . ' >'] = $movingObject[$Model->alias][$column];
						$movingConditions[$Model->alias . '.' . $column . ' <='] = $relatedObject[$Model->alias][$column];
					}

					$Model->id = $id;
					$Model->saveField($column, $relatedObject[$Model->alias][$column]);

					$Model->updateAll(
						$movingValue,
						$movingConditions
					);
				}

				return TRUE;
			}
		}

		return FALSE;
	}
}
