<?php
App::uses('AppController', 'Controller');

class ProjectsController extends AppController
{

	public function beforeFilter() {
		parent::beforeFilter();

		if (in_array($this->action, ['admin_add', 'admin_edit'])) {
			$this->loadModel('Category');
			$categories = $this->Category->find('list', [
				'conditions' => ['Category.core' => false],
				'order' => 'Category.name ASC'
			]);
			$this->set(compact('categories'));
		}
	}

	public function admin_edit($id = null, $name = null) {
		$result = parent::admin_edit($id, $name);

		if (!$this->request->is('post') && !$this->request->is('put')) {
			$project = $this->Project->find('first', [
				'conditions' => ['Project.id' => $id],
				'fields' => ['Project.category_id'],
				'contain' => false
			]);
			$this->request->data['Project']['category_id'] = !empty($project['Project']['category_id']) ? $project['Project']['category_id'] : null;
		}

		return $result;
	}

}
