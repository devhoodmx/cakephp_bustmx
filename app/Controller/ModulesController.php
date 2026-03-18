<?php
App::uses('AppController', 'Controller');

class ModulesController extends AppController {

	public function admin_index($id = null) {
		$parent = null;
		$categories = array();
		$data = array();

		if ($id) {
			$parent = $this->Module->find('first', array(
				'conditions' => array('Module.id' => $id),
				'contain' => array('Category')
			));

			if (empty($parent)) {
				throw new NotFoundException();
			}
		}

		if ($parent) {
			$categories[] = array('Category' => $parent['Category']);
		} else {
			$categories = $this->Module->Category->find('all', array(
				'conditions' => array('ParentCategory.key' => 'modules'),
				'order' => array('Category.order' => 'ASC'),
				'contain' => array('ParentCategory')
			));
		}

		$modules = $this->Module->find('all', array(
			'conditions' => array(
				'Module.parent_id' => $id
			),
			'order' => array(
				'Module.order' => 'ASC'
			),
			'contain' => false
		));

		foreach ($categories as $key => $category) {
			$buffer = $category;
			$buffer['children'] = array();

			$data[$category['Category']['id']] = $buffer;
		}

		foreach ($modules as $key => $module) {
			$module['Module']['children'] = $this->Module->childCount($module['Module']['id']);

			$data[$module['Module']['category_id']]['children'][] = $module;
		}

		$this->set(compact('parent'));
		$this->set('modules', $data);
	}

	public function admin_add($id = null) {
		$parent = null;

		if ($id) {
			$parent = $this->Module->find('first', [
				'conditions' => ['Module.id' => $id],
				'contain' => ['Category']
			]);

			if (empty($parent)) {
				throw new NotFoundException();
			}
		}

		// All Aros
		$this->Acl->Aro->bindModel([
			'belongsTo' => [
				'Role' => [
					'foreignKey' => 'foreign_key'
				]
			]
		]);
		$aros = $this->Acl->Aro->find('all');

		// Categories
		$categories = $this->Module->Category->find('list', [
			'conditions' => ['Category.parent_id' => 1]
		]);

		if ($this->request->is('post') && !empty($this->request->data)) {
			$this->request->data['Module']['parent_id'] = $id;

			if ($this->Module->save($this->request->data)) {
				$module = $this->Module->read();
				$url = ['controller' => 'modules', 'action' => 'index'];

				if (!empty($parent)) {
					$url[] = $parent['Module']['id'];
					$url[] = Utility::slug($parent['Module']['name']);
				}

				// Assign permissions
				$this->assignPermissions($module, $aros, $this->request->data['Aro']);

				// Update authenticated user menu
				$this->loadModel('User');
				$menuItems = $this->User->getMenuItems($this->Auth->user('id'));
				$this->Session->write('Auth.System.menu_items', $menuItems);

				$this->Flash->success(Utility::translate('save-notification', 'module', null, $module['Module']['name']));

				$this->redirect($url);
			}
		}

		if (!$this->request->data) {
			if ($this->request->query('category_id')) {
				$this->request->data['Module']['category_id'] = $this->request->query('category_id');
			}
		}

		$this->set(compact('parent', 'categories', 'aros'));
	}

	public function admin_delete($id = null, $name = null) {
		$model = 'Module';

		if (!$this->request->is(['post', 'delete'])) {
			throw new BadRequestException();
		}

		if (!$id) {
			throw new BadRequestException();
		}

		$module = $this->Module->find('first', [
			'conditions' => ['Module.id' => $id],
			'contain' => false
		]);
		if (!$module) {
			throw new NotFoundException();
		}

		if ($this->Module->delete($id)) {
			$message = Utility::translate('delete-notification', Inflector::underscore($model), null, $module[$model]['name']);

			$this->Acl->Aro->Permission->deleteAll(
				['Permission.aco_id' => $id],
				false
			);

			// Update authenticated user menu
			$this->loadModel('User');
			$menuItems = $this->User->getMenuItems($this->Auth->user('id'));
			$this->Session->write('Auth.System.menu_items', $menuItems);

			$this->set(compact('id', 'model', 'message'));
		}
	}

	public function admin_edit($id = null, $name = null) {
		$module = $this->Module->find('first', [
			'conditions' => ['Module.id' => $id]
		]);
		if (!$module) {
			throw new NotFoundException();
		}

		// Aco & permissions
		$aco = $this->Acl->Aco->find('first', [
			'conditions' => ['Aco.id' => $id]
		]);
		$acoAros = Hash::combine($aco['Aro'], '{n}.id', '{n}');

		// All Aros
		$this->Acl->Aro->bindModel([
			'belongsTo' => [
				'Role' => [
					'foreignKey' => 'foreign_key'
				]
			]
		]);
		$aros = $this->Acl->Aro->find('all');

		// Categories
		$categories = $this->Module->Category->find('list', [
			'conditions' => ['Category.parent_id' => 1]
		]);

		if ($this->request->is(['post', 'put']) && !empty($this->request->data)) {
			$this->request->data['Module']['id'] = $id;

			if ($this->Module->save($this->request->data)) {
				$module = $this->Module->find('first', [
					'conditions' => ['Module.id' => $id],
					'contain' => ['Parent']
				]);
				$url = ['controller' => 'modules', 'action' => 'index'];

				if (!empty($module['Parent']['id'])) {
					$url[] = $module['Parent']['id'];
					$url[] = Utility::slug($module['Parent']['name']);
				}

				// Assign permissions
				$this->assignPermissions($module, $aros, $this->request->data['Aro']);

				// Update authenticated user menu
				$this->loadModel('User');
				$menuItems = $this->User->getMenuItems($this->Auth->user('id'));
				$this->Session->write('Auth.System.menu_items', $menuItems);

				$this->Flash->success(Utility::translate('save-notification', 'module', null, $module['Module']['name']));

				$this->redirect($url);
			}
		}

		if (!$this->request->data) {
			$this->request->data = $module;

			foreach ($aros as $key => $aro) {
				$allow = false;

				if (isset($acoAros[$aro['Aro']['id']]) && $acoAros[$aro['Aro']['id']]['Permission']['_read'] == 1) {
					$allow = true;
				}

				$this->request->data['Aro'][$aro['Aro']['id']] = $allow;
			}
		}

		$this->set(compact('module', 'categories', 'aros'));
	}

	private function assignPermissions($aco = null, $aros = [], $_aros = []) {
		$permissions = [];

		foreach ($aros as $key => $aro) {
			$allow = -1;

			if (!empty($_aros[$aro['Aro']['id']]) || $aro['Role']['key'] == 'prosimian') {
				$allow = 1;
			}

			$permissions[] = [
				'aro_id' => $aro['Aro']['id'],
				'aco_id' => $aco['Module']['id'],
				'_create' => $allow,
				'_read' => $allow,
				'_update' => $allow,
				'_delete' => $allow
			];
		}

		if (!empty($permissions)) {
			$this->Acl->Aro->Permission->deleteAll(
				['Permission.aco_id' => $aco['Module']['id']],
				false
			);

			$this->Acl->Aro->Permission->saveAll($permissions);
		}
	}
}
