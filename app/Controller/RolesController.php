<?php
App::uses('AppController', 'Controller');

class RolesController extends AppController {
	public function admin_add() {
		if ($this->request->is('post')) {
			if ($this->Role->save($this->request->data)) {
				$aro = $this->Role->node();
				$aro = $aro[0];
				$acos = $this->Acl->Aco->find('all', [
					'recursive' => false
				]);

				// Asign permissions
				$this->assignPermissions($aro, $acos);

				$this->Flash->success(Utility::translate('save-notification', 'role', null, $this->request->data['Role']['name']));
				$this->redirect(array('controller' => 'roles', 'action' => 'index'));
			}
		}
	}

	public function admin_edit($id = null, $name = null) {
		$role = $this->Role->find('first', array(
			'conditions' => array('Role.id' => $id),
			'contain' => false
		));

		if (empty($role)) {
			throw new NotFoundException();
		}

		$this->loadModel('Module');

		$aro = $this->Acl->Aro->find('first', [
			'conditions' => ['Aro.foreign_key' => $role['Role']['id']],
			'recursive' => false
		]);
		$modules = [];

		if ($this->request->is(array('post', 'put')) && !empty($this->request->data)) {
			$this->request->data['Role']['id'] = $role['Role']['id'];

			if ($this->Role->save($this->request->data)) {
				// Assign permissions
				$acos = $this->Acl->Aco->find('all', [
					'recursive' => false
				]);
				$this->assignPermissions($aro, $acos, $this->request->data['Aco']);

				// Update authenticated user menu
				$menuItems = $this->Role->User->getMenuItems($this->Auth->user('id'));
				$this->Session->write('Auth.System.menu_items', $menuItems);

				$this->Flash->success(Utility::translate('save-notification', 'role', null, $this->request->data['Role']['name']));
				$this->redirect(array('controller' => 'roles', 'action' => 'index'));
			}
		}

		if (!$this->request->data) {
			$this->request->data = $role;

			$_modules = $this->Module->find('all', [
				'conditions' => [
					'Module.parent_id' => null
				],
				'contain' => ['Category']
			]);

			// Group modules by category
			foreach ($_modules as $key => $module) {
				$module['children'] = $this->Module->childCount($module['Module']['id']) > 0 ? $this->Module->children($module['Module']['id']) : null;
				$modules[$module['Category']['name']][] = $module;
			}

			// Permissions granted
			$permissions = $this->Acl->Aro->Permission->find('all', [
				'conditions' => [
					'Permission.aro_id' => $aro['Aro']['id']
				]
			]);
			$permissions = Hash::combine($permissions, '{n}.Permission.aco_id', '{n}');

			// Prepare data
			foreach ($modules as $group) {
				foreach ($group as $module) {
					$allow = false;

					if (isset($permissions[$module['Module']['id']]) && $permissions[$module['Module']['id']]['Permission']['_read'] == 1) {
						$allow = true;
					}

					$this->request->data['Aco'][$module['Module']['id']] = $allow;

					if (!empty($module['children'])) {
						foreach ($module['children'] as $child) {
							$allow = false;

							if (isset($permissions[$child['Module']['id']]) && $permissions[$child['Module']['id']]['Permission']['_read'] == 1) {
								$allow = true;
							}

							$this->request->data['Aco'][$child['Module']['id']] = $allow;
						}
					}
				}
			}
		}

		$this->set(compact('role', 'modules'));
	}

	private function assignPermissions($aro = null, $acos = [], $_acos = []) {
		$permissions = [];

		foreach ($acos as $key => $aco) {
			$allow = -1;

			if (!empty($_acos[$aco['Aco']['id']])) {
				$allow = 1;
			}

			$permissions[] = [
				'aro_id' => $aro['Aro']['id'],
				'aco_id' => $aco['Aco']['id'],
				'_create' => $allow,
				'_read' => $allow,
				'_update' => $allow,
				'_delete' => $allow
			];
		}

		if (!empty($permissions)) {
			$this->Acl->Aro->Permission->deleteAll(
				['Permission.aro_id' => $aro['Aro']['id']],
				false
			);

			$this->Acl->Aro->Permission->saveAll($permissions);
		}
	}
}
