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

}
