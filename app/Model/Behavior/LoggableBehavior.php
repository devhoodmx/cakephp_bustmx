<?php
App::uses('ModelBehavior', 'Model');
App::uses('Log', 'Model');
App::uses('CakeSession', 'Model/Datasource');

class LoggableBehavior extends ModelBehavior {

	protected $_defaults = array(
		'name' => 'name'
	);

	protected $old = null;

	public function setup(Model $Model, $settings = []) {
		$settings = array_merge($this->_defaults, $settings);

		$this->settings[$Model->alias] = $settings;
	}

	private function _getUser() {
		$user = [
			'id' => 0,
			'username' => '',
			'full_name' => '',
			'model' => 'PublicUser'
		];
		$models = ['User', 'Account'];

		foreach ($models as $key => $model) {
			$data = CakeSession::read(sprintf('Auth.%s', $model));

			if ($data) {
				$user = [
					'id' => $data['id'],
					'username' => $data['username'],
					'full_name' => $data['full_name'],
					'model' => $model
				];

				break;
			}
		}

		return $user;
	}

	public function beforeSave(Model $Model, $options = []) {
		$this->old = $Model->find('first', [
			'conditions' => [$Model->primaryKey => $Model->id],
			'recursive' => -1
		]);

		return true;
	}

	public function afterSave(Model $Model, $created, $options = []) {
		$user = $this->_getUser();

		if ($user) {
			$data = $Model->find('first', array(
				'conditions' => array($Model->alias . '.' . $Model->primaryKey => $Model->id)
			));

			$nameValue = __('Sin nombre');
			if (!empty($Model->displayField)) {
				$nameValue = $data[$Model->alias][$Model->displayField];
			} else if (!empty($data[$Model->alias][$this->settings[$Model->alias]['name']])) {
				$nameValue = $data[$Model->alias][$this->settings[$Model->alias]['name']];
			} else {
				$nameValue = $Model->alias;
			}

			$Log = new Log();
			$name = CakeText::truncate($nameValue, 252);
			$log = array(
				'model' => $Model->alias,
				'foreign_key' => $Model->id,
				'user_model' => $user['model'],
				'user_id' => $user['id'],
				'user_username' => $user['username'],
				'user_fullname' => $user['full_name'],
				'name' => $name,
				'action' => $created ? 'CREATE' : 'UPDATE',
				'change' => ''
			);

			$unallowedKeys = array(
				'password',
				'api_token',
				'api_key'
			);
			$dbFields = array_keys($Model->schema());
			$changedFields = array();

			foreach ($data[$Model->alias] as $key => $value) {
				if (isset($data[$Model->alias][$Model->primaryKey]) && !empty($this->old) && isset($this->old[$Model->alias][$key])) {
					$old = $this->old[$Model->alias][$key];
				} else {
					$old = '';
				}

				if (!in_array($key, $unallowedKeys) && $value != $old && in_array($key, $dbFields)) {
					$change = $value;

					if ($old != '') {
						$change = array(
							'from' => $old,
							'to' => $value
						);
					}

					$changedFields[$key] = $change;
				}
			}

			$log['change'] = json_encode($changedFields);

			return $Log->save($log);
		}

		return true;
	}

	public function beforeDelete(Model $Model, $cascade = true) {
		$user = $this->_getUser();

		if ($user) {
			$data = $Model->find('first', array(
				'conditions' => array($Model->alias . '.' . $Model->primaryKey => $Model->id)
			));

			if ($data) {
				$nameValue = __('Sin nombre');
				if (!empty($Model->displayField)) {
					$nameValue = $data[$Model->alias][$Model->displayField];
				} else if (!empty($data[$Model->alias][$this->settings[$Model->alias]['name']])) {
					$nameValue = $data[$Model->alias][$this->settings[$Model->alias]['name']];
				} else {
					$nameValue = $Model->alias;
				}

				$Log = new Log();
				$name = $nameValue;
				$log = array(
					'model' => $Model->alias,
					'foreign_key' => $Model->id,
					'user_model' => $user['model'],
					'user_id' => $user['id'],
					'user_username' => $user['username'],
					'user_fullname' => $user['full_name'],
					'name' => $name,
					'action' => 'DELETE',
					'change' => ''
				);

				$unallowedKeys = array(
					'password',
					'api_token',
					'api_key'
				);
				$dbFields = array_keys($Model->schema());
				$changedFields = array();

				foreach ($data[$Model->alias] as $key => $value) {
					if (isset($data[$Model->alias][$Model->primaryKey]) && !empty($this->old) && isset($this->old[$Model->alias][$key])) {
						$old = $this->old[$Model->alias][$key];
					} else {
						$old = '';
					}

					if (!in_array($key, $unallowedKeys) && $value != $old && in_array($key, $dbFields)) {
						$change = $value;

						if ($old != '') {
							$change = array(
								'from' => $old,
								'to' => $value
							);
						}

						$changedFields[$key] = $change;
					}
				}

				$log['change'] = json_encode($changedFields);

				return $Log->save($log);
			}
		}

		return true;
	}
}
