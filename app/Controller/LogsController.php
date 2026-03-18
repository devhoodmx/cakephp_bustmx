<?php
App::uses('AppController', 'Controller');

class LogsController extends AppController {

	public function admin_index() {
		$prosimians = [];
		$prosimiansIds = [];
		$conditions = [];
		$usersConditions = [];

		$this->Log->bindModel([
			'belongsTo' => [
				'User' => [
					'foreignKey' => 'user_id'
				]
			]
		]);

		// Hide prosimian activity from the rest
		if (!Utility::is('prosimian')) {
			$prosimians = $this->Log->User->find('list', [
				'conditions' => ['Role.key' => 'prosimian'],
				'contain' => ['Role']
			]);
			$prosimiansIds = array_keys($prosimians);
			$conditions = ['Log.user_id NOT IN' => $prosimiansIds];
			$usersConditions = ['User.id NOT IN' => $prosimiansIds];
		}

		// Current month activity
		$conditions['Log.created >='] = date('Y-m-01') . ' 00:00:00';
		$conditions['Log.created <='] = date('Y-m-t') . ' 23:59:59';

		// Use query params to filter the data
		if ($this->request->query('start')) {
			$conditions['Log.created >='] = $this->request->query('start') . ' 00:00:00';
		}
		if ($this->request->query('end')) {
			$conditions['Log.created <='] = $this->request->query('end') . ' 23:59:59';
		}
		if ($this->request->query('model')) {
			$conditions['Log.model'] = $this->request->query('model');
		}
		if ($this->request->query('user_id') &&
			(Utility::is('prosimian') || !isset($prosimians[$this->request->query('user_id')]))) {
			$conditions['Log.user_id'] = $this->request->query('user_id');
		}

		// Fetch activity
		$this->Paginator->settings = [
			'conditions' => $conditions,
			'limit' => 200
		];
		$logs = $this->Paginator->paginate();

		// Users
		$users = $this->Log->User->find('list', [
			'fields' => ['User.id', 'User.username'],
			'conditions' => $usersConditions
		]);

		// List of models
		$models = [];
		$files = scandir('../Model');
		$excludedModels = ['AppModel', 'Log', 'MediaTemplate'];

		foreach ($files as $file) {
			if (preg_match('/(.*)\.php$/', $file, $matches) && !in_array($matches[1], $excludedModels)) {
				$name = $matches[1];
				$models[$name] = $name;
			}
		}

		$this->set(compact('logs', 'users', 'models'));
	}
}
?>
