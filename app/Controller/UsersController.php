<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 */
class UsersController extends AppController {
	public function beforeFilter() {
		parent::beforeFilter();

		if ($this->Auth->user()) {
			if (in_array($this->action, array('admin_edit', 'admin_delete'))) {
				if (!empty($this->request->params['pass'])) {
					$id = $this->request->params['pass'][0];
					$user = $this->User->find('first', array(
						'conditions' => array('User.id' => $id),
						'contain' => array('Role')
					));

					if (!empty($user) && $user['Role']['key'] == 'prosimian' && !Utility::is('prosimian')) {
						throw new UnauthorizedException();
					}
				}
			}

			if (in_array($this->action, array('admin_index', 'admin_add', 'admin_edit'))) {
				$conditions = array();

				if (!Utility::is('prosimian')) {
					$conditions['NOT'] = array('Role.key' => 'prosimian');

					if ($this->request->is(array('post', 'put')) &&
						!empty($this->request->data['User']['role_id'])) {
						$roleId = $this->User->Role->field('id', array(
							'Role.key' => 'prosimian'
						));

						if ($roleId == $this->request->data['User']['role_id']) {
							throw new UnauthorizedException();
						}
					}
				}

				$roles = $this->User->Role->find('list', array(
					'conditions' => $conditions,
					'contain' => false
				));

				$this->set('roles', $roles);
			}

			if ($this->action == 'admin_profile') {
				$this->Auth->allow();
			}
		}
	}

	public function admin_login() {
		$this->layout = 'Admin/login';

		if ($this->Auth->user() && $this->RequestHandler->ext != 'json') {
			return $this->redirect($this->Auth->redirectUrl());
		}

		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$authUser = $this->Auth->user();
				$this->User->id = $authUser['id'];
				$this->User->save(array(
					'last_login' => date('Y-m-d H:i:s'),
					'last_login_ip' => $this->request->clientIp()
				));

				$log = array(
					'model' => 'User',
					'foreign_key' => $authUser['id'],
					'user_model' => 'User',
					'user_id' => $authUser['id'],
					'name' => $authUser['name'] . ' ' . $authUser['last_name'],
					'action' => 'LOGIN'
				);
				$this->loadModel('Log');
				$this->Log->save($log);

				if ($this->RequestHandler->ext != 'json') {
					return $this->redirect($this->Auth->redirectUrl());
				}
			} else {
				if ($this->RequestHandler->ext == 'json') {
					$this->User->invalidate('password', 'invalid-access');
				} else {
					$this->Flash->danger(__('Usuario o contraseña incorrectos.', true), array('key' => 'auth'));
				}
			}
		}
	}

	public function admin_logout() {
		$authUser = $this->Auth->user();

		$this->Session->delete('Auth.System.menu_items');

		$log = array(
			'model' => 'User',
			'foreign_key' => $authUser['id'],
			'user_model' => 'User',
			'user_id' => $authUser['id'],
			'name' => $authUser['name'] . ' ' . $authUser['last_name'],
			'action' => 'LOGOUT'
		);
		$this->loadModel('Log');
		$this->Log->save($log);

		return $this->redirect($this->Auth->logout());
	}

	public function admin_index() {
		$configuration = $this->validateScaffold();
		$query = $configuration['findParams'];

		if ($this->request->query('role_id')) {
			$query['conditions']['User.role_id'] = $this->request->query('role_id');
		}
		if (!Utility::is('prosimian')) {
			$query['conditions']['NOT'] = array('Role.key' => 'prosimian');
		}

		// Search
		if ($this->request->query('q')) {
			$query['conditions']['OR'] = [
				'User.full_name LIKE' => '%' . $this->request->query('q') . '%',
				'User.username LIKE' => '%' . $this->request->query('q') . '%'
			];
		}

		$query['limit'] = isset($query['limit']) ? $query['limit'] : 25;
		if (!empty($this->params['named']['limit'])) {
			$query['limit'] = $this->params['named']['limit'];
		}

		$this->Paginator->settings = $query;
		$users = $this->Paginator->paginate();

		$this->view = 'admin_index';

		$this->set($configuration['setParams']);
		$this->set(compact('users'));
	}

	public function admin_profile() {
		$authUser = $this->Auth->user();
		$this->User->id = $authUser['id'];
		$query = array(
			'conditions' => array('User.id' => $this->User->id),
			'contain' => array('Media', 'Role')
		);

		if ($this->request->is('post') || $this->request->is('put')) {
			$this->User->validator()->add('_password', array(
				'requiredIfNotEmpty' => array(
					'rule'    => array('onlyIf', '_current_password', 'notBlank', 'notBlank'),
					'message' => 'not-blank',
					'on' => 'update'
				)
			));

			$fieldList = array('email', 'password', '_password', '_password_confirmation', '_current_password', 'bio');
			if ($this->User->save($this->request->data, true, $fieldList)) {
				$user = $this->User->find('first', $query);
				$session = $user['User'];
				$session['MediaProfile'] = $user['MediaProfile'];
				$session['Role'] = $user['Role'];
				SessionComponent::write(AuthComponent::$sessionKey, $session);

				$message = Utility::translate('save-notification', Inflector::underscore('User') , NULL, 'Su usuario');
				$this->set(compact('message'));
			}
		} else {
			$this->request->data = $this->User->find('first', $query);
			$this->set('user', $this->request->data);
		}

		$this->set('mediaConfig', $this->User->getMediaConfig('profile'));
	}
}
