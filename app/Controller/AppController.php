<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $locale = null;

	public $localePrefix = '';

	public $components = array(
		'Auth',
		'Cookie' => array(
			'name' => 'hc'
		),
		'Paginator',
		'RequestHandler',
		'Session',
		'Flash',
		'Acl',
		'Email'
	);

	public $helpers = array(
		'Form',
		'Html',
		'Js',
		'Text',
		'Time',
		'Session',
		'Package'
	);

	public function beforeFilter() {
		$config = Configure::read();
		$isAdmin = $this->request->param('prefix') == 'admin';
		$isAPI = $this->request->param('prefix') == 'api';
		$clientIP = $this->request->clientIp();

		// Debug mode
		if (in_array($clientIP, $config['App']['debug']['allow'])) {
			Configure::write('debug', $config['App']['debug']['level']);
		}

		// Maintenance mode
		if ($config['App']['maintenance']['active'] &&
			!in_array($clientIP, $config['App']['maintenance']['allow']) &&
			$this->name != 'CakeError') {
			App::uses('MaintenanceException', 'Error/Exception');
			throw new MaintenanceException();
		}

		// Configuration
		$this->loadModel('Configuration');
		$config['App']['configurations'] = $this->Configuration->find('list', array(
			'fields' => array('Configuration.key', 'Configuration.value')
		));
		Configure::write('App.configurations', $config['App']['configurations']);

		// Password protection
		$isPasswordProtected = !empty($config['App']['configurations']['general-password-protection']);

		if ($isPasswordProtected && !$this->Session->read('App.password_protection.authorized') && $this->getActionKey() != 'pages.password_protection') {
			$this->redirect(['controller' => 'pages', 'action' => 'password_protection', 'admin' => false, '?' => ['redirectURL' => $this->request->here()]]);
		}

		// Auth
		$this->Auth->allow();

		// Localization
		$this->locale = $config['App']['locale'];

		if (!empty($this->request->params['locale'])) {
			$this->locale = $this->request->params['locale'];
		} elseif (!empty($config['App']['configurations']['default-locale'])) {
			$this->locale = $config['App']['configurations']['default-locale'];
		}

		if ($this->locale != 'es' && sizeof(Configure::read('App.i18n.locales')) > 1) {
			$this->localePrefix = $this->locale . '_';
		}

		if ($isAdmin) {
			$this->layout = 'Admin/main';
			$this->locale = 'es';

			// Auth settings
			$this->Auth->deny($this->params['action']);
			$this->Auth->loginRedirect = array('controller' => 'pages', 'action' => 'home', 'admin' => true);
			$this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login', 'admin' => true);
			$this->Auth->authError = false;
			$this->Auth->authorize = 'Controller';
			$this->Auth->authenticate = array(
				'Form' => array(
					'scope' => array('User.active' => true),
					'contain' => ['Role', 'Media'],
					'passwordHasher' => Configure::read('simian.auth.passwordHasher')
				)
			);
			$this->Auth->ajaxLogin = 'login';

			$this->getEventManager()->attach(function($event) {
				App::uses('User', 'Model');
				$User = new User();

				$menuItems = $User->getMenuItems($this->Auth->user('id'));

				$this->Session->write('Auth.System.menu_items', $menuItems);
			}, 'Auth.afterIdentify');

			if ($this->Auth->user()) {
				$this->set('currentUser', $this->Auth->user());
				$this->set('menu', $this->Session->read('Auth.System.menu_items'));
			}
		} elseif ($isAPI) {
			$token = '';
			$header = $this->request->header('Authorization');

			if (strlen($header) > 0 && strpos($header, 'Bearer') !== false) {
				$token = substr($header, 7);
			}

			if ($token != Configure::read('API.auth.token')) {
				throw new UnauthorizedException('Invalid token');
			}
		} else {
			$this->layout = 'Site/main';
			$this->loadModel('MenuItem');

			// Load menus
			$menus = array();
			$positions = $this->MenuItem->catalogues['positions'];
			$website = $this->MenuItem->Website->find('first', array(
				'conditions' => array('Website.main' => true),
				'contain' => false
			));

			foreach ($positions as $key => $value) {
				$menus[$key] = $this->MenuItem->find('threaded', array(
					'order' => array('MenuItem.order' => 'ASC'),
					'conditions' => array(
						'MenuItem.position' => $key,
						'MenuItem.website_id' => empty($website['Website']['id']) ? null : $website['Website']['id']
					),
					'contain' => array('WebPage', 'ParentItem')
				));
				$menus[$key]= $this->formatMenuItems($menus[$key]);
			}

			$this->menus = $menus;

			$this->set(compact('menus'));
		}

		// Set language
		Configure::write('Config.language', $this->locale);

		$this->set(array(
			'config' => $config,
			'locale' => $this->locale,
			'localePrefix' => $this->localePrefix,
			'assets' => array('stylesheets' => array(), 'scripts' => array())
		));
	}

	public function beforeRender() {
		if ($this->RequestHandler->ext == 'json' &&
			$this->request->param('prefix') != 'api') {
			$this->viewClass = 'ResponseJson';
		}
	}

	public function redirect($url, $status = null, $exit = true) {
		if (!empty($this->request->query['redirectURL'])) {
			$url = $this->request->query['redirectURL'];
		}

		if ($this->RequestHandler->ext == 'json' ) {

			if (!$this->Auth->isAuthorized() && $this->request->param('prefix') == 'admin') {
				throw new UnauthorizedException();
			}

			$this->set('redirect', Router::url($url, true));
			return false;
		} else {
			parent::redirect($url, $status, $exit);
		}
	}

	public function setRedirect($redirect, $modelData = NULL, $defaultRedirect = array('action' => 'index')) {
		if (!is_array($redirect) && $redirect === TRUE) {
			$redirect = $defaultRedirect;
		} else {
			$redirect = Utility::redirect($redirect, $modelData);
		}
		$this->redirect($redirect);
	}

	public function validateScaffold() {
		$configuration = Utility::config($this->params['controller']);
		$model = Inflector::classify($this->name);

		if (empty($configuration['views']) || !isset($configuration['views'][$this->params['action']])) {
			throw new NotFoundException();
		} else {
			$defaultFindParams = array('conditions' => array(), 'contain' => FALSE);
			$configuration['model'] = $model;
			$configuration['setParams'] = array();
			$configuration['findParams'] = empty($configuration['findParams']) ? $defaultFindParams : Set::merge($defaultFindParams, $configuration['findParams']);
			$viewConfiguration = $configuration['views'][$this->params['action']];

			$configuration['configView'] = $viewConfiguration;

			if (!empty($viewConfiguration['findParams'])) {
				$configuration['findParams'] = Set::merge($configuration['findParams'], $viewConfiguration['findParams']);
			}

			if ($this->RequestHandler->ext != 'json' ) {

				$this->view = '/Scaffolds/' . $this->params['action'];

				if ($this->{$model}->Behaviors->loaded('Media')) {
					$configuration['setParams']['mediaConfig'] = $this->{$model}->getMediaConfig();
				}

				if ($this->{$model}->Behaviors->loaded('Sortable')) {
					$configuration['setParams']['sortableModels'] = array($model);
				}

				if ($this->{$model}->Behaviors->loaded('Date')) {
					$configuration['setParams']['dateConfig'] = $this->{$model}->getDateConfig();
				}

				if (!empty($configuration['vars'])) {
					$configuration['setParams'] = Set::merge($configuration['setParams'], $configuration['vars']);
				}

				if (!empty($configuration['form']) && $this->params['action'] != 'admin_index') {
					$viewConfiguration = Set::merge($configuration['form'], $viewConfiguration);
				}

				$configuration['setParams']['configView'] = $viewConfiguration;
			}
		}

		return $configuration;
	}

	public function isAuthorized($user = null) {
		// Any signed in user can access public function
		if (empty($this->request->param('prefix')) && !$this->request->param('plugin')) {
			return true;
		}

		// Only admins can access admin functions
		if ($this->request->param('prefix') == 'admin' || $this->request->param('plugin')) {
			$controller = $this->request->controller;
			$action = $this->request->action;
			$key = sprintf('%s.%s', $controller, $action);
			$allowed = [
				'pages.admin_home',
				'pages.admin_oembed',
				'users.admin_logout',
				'images.admin_upload'
			];

			// Allowed actions
			foreach ($allowed as $value) {
				if ($key == $value) {
					return true;
				}
			}

			// Media asynchronous requests
			if ($controller === 'media' && ($this->request->is('ajax') || in_array($this->action, ['admin_video', 'admin_download', 'admin_toggle_field', 'admin_share']))) {
				return true;
			}

			// Modules
			$aro = $this->Acl->Aro->find('first', [
				'conditions' => ['model' => 'Role', 'foreign_key' => $user['role_id']],
				'recursive' => -1
			]);

			if (!$aro) {
				return false;
			}

			$aco = $this->Acl->Aco->find('first', [
				'joins' => [
					[
						'table' => 'aros_acos',
						'alias' => 'Permission',
						'type' => 'INNER',
						'conditions' => [
							'Permission.aco_id = Aco.id',
							'Permission.aro_id' => $aro['Aro']['id']
						]
					]
				],
				'conditions' => [
					'Aco.model' => Inflector::classify($controller),
					'Permission._read' => 1
				],
				'recursive' => -1
			]);

			if ($aco) {
				return true;
			}
		}

		// Default deny
		return false;
	}

	public function admin_index() {
		$configuration = $this->validateScaffold();
		$model = $configuration['model'];

		$configuration['findParams']['limit'] = isset($configuration['findParams']['limit']) ? $configuration['findParams']['limit'] : 25;

		if (!empty($this->params['named']['limit'])) {
			$configuration['findParams']['limit'] = $this->params['named']['limit'];
		}

		if (!empty($this->request->query['q']) && !empty($configuration['vars']['components']['search']['fields'])) {
			$searchConditions = array('OR' => array());

			foreach ($configuration['vars']['components']['search']['fields'] as $field) {
				$searchConditions['OR'][$field . ' LIKE'] = '%' . $this->request->query['q'] . '%';
			}

			$configuration['findParams']['conditions'][] = $searchConditions;
		}

		$this->Paginator->settings = [
			$model => $configuration['findParams']
		];

		$modelData = $this->Paginator->paginate($model);

		$configuration['setParams'][Inflector::variable($model)] = $modelData;
		$this->set($configuration['setParams']);

		return $configuration;
	}

	public function admin_add() {
		$configuration = $this->validateScaffold();
		$model = $configuration['model'];

		if ($this->request->is('post') && !empty($this->request->data)) {
			$this->{$model}->set($this->request->data);

			if ($this->{$model}->saveAll($this->request->data, array('validate' => 'first'))) {
				$configuration['findParams']['conditions'][$model . '.id'] = $this->{$model}->id;
				$modelData = $this->{$model}->find('first', $configuration['findParams']);
				$configuration['setParams'][Inflector::variable($model)] = $modelData;

				if (!empty($configuration['configView']['redirect'])) {
					$redirect = $configuration['configView']['redirect'];
					$defaultRedirect = array('action' => 'edit', $this->{$model}->id);

					if ($this->request->query('from')) {
						$redirect = $this->request->query('from');
					}

					$this->setRedirect($redirect, $modelData, $defaultRedirect);
				} else {
					$message = Utility::translate('save-notification', Inflector::underscore($model) , NULL, $modelData[$model][$this->{$model}->displayField]);
					$this->set(compact('message', 'modelData'));
				}

				return true;
			}
		} else if ($this->RequestHandler->ext == 'json') {
			throw new BadRequestException();
		}

		$this->set($configuration['setParams']);

		return $configuration;
	}

	public function admin_edit($id = null, $name = null) {
		$configuration = $this->validateScaffold();
		$model = $configuration['model'];

		$configuration['findParams']['conditions'][$model . '.id'] = $id;
		$modelData = $this->{$model}->find('first', $configuration['findParams']);

		if (empty($modelData)) {
			throw new NotFoundException();
		} else {
			$slugName = Utility::slug($modelData[$model][$this->{$model}->displayField]);

			if ($this->RequestHandler->ext != 'json' && $name != $slugName) {
				$this->redirect(array(
					$id,
					$slugName
				));
			}
		}

		if (($this->request->is('post') || $this->request->is('put')) && !empty($this->request->data)) {
			$this->request->data[$model]['id'] = $id;

			if ($this->{$model}->saveAll($this->request->data, array('validate' => 'first'))) {
				$modelData = $this->{$model}->find('first', $configuration['findParams']);

				if (!empty($configuration['configView']['redirect'])) {
					$redirect = $configuration['configView']['redirect'];
					$defaultRedirect = array('action' => 'index');

					if ($this->request->query('from')) {
						$redirect = $this->request->query('from');
					}

					$this->setRedirect($redirect, $modelData, $defaultRedirect);
				} else {
					$message = Utility::translate('save-notification', Inflector::underscore($model) , NULL, $modelData[$model][$this->{$model}->displayField]);
					$this->set(compact('message', 'modelData'));
				}
			}
		} else if ($this->RequestHandler->ext == 'json') {
			throw new BadRequestException();
		} else {
			$this->data = $modelData;
		}

		$configuration['setParams'][Inflector::variable($model)] = $modelData;
		$this->set($configuration['setParams']);
		return $configuration;
	}

	public function admin_delete($id = NULL) {
		$configuration = $this->validateScaffold();
		$model = $configuration['model'];

		$configuration['findParams']['conditions'][$model . '.id'] = $id;

		if ($this->request->is('post') || $this->request->is('delete')) {
			$modelData = $this->{$model}->find('first', $configuration['findParams']);

			if (empty($modelData)) {
				throw new NotFoundException();
			}

			if (isset($modelData[$model]['deletable']) && !$modelData[$model]['deletable']) {
				throw new ForbiddenException();
			}

			if ($this->{$model}->delete($id)) {
				$message = Utility::translate('delete-notification', Inflector::underscore($model) , NULL, $modelData[$model][$this->{$model}->displayField]);
				$this->set(compact('id', 'model', 'message'));
			} else {
				throw new NotFoundException();
			}
		} else {
			throw new BadRequestException();
		}
	}

	public function admin_move($id = NULL) {
		$model = Inflector::classify($this->name);
		if (($this->request->is('post') || $this->request->is('put')) && !empty($this->request->data[$model]['replace_id'])) {
			$replaceId = $this->request->data[$model]['replace_id'];
			if ($this->{$model}->Behaviors->loaded('Sortable') && $this->{$model}->move($id, $replaceId)) {
				$model = $model;
				$this->set(compact('id', 'model', 'replaceId'));
			} else {
				throw new NotFoundException();
			}
		} else {
			throw new BadRequestException();
		}
	}

	public function admin_toggle_field($id = NULL) {
		$configuration = $this->validateScaffold();
		$model = $configuration['model'];
		$configView = $configuration['configView'];

		if (($this->request->is('post') || $this->request->is('put')) && !empty($this->request->data[$model]['field']) && isset($this->request->data[$model]['value'])) {
			$field = $this->request->data[$model]['field'];
			$value = empty($this->request->data[$model]['value']) ? 0 : 1;

			if (isset($configuration['configView'][$field]) || in_array($field, $configuration['configView'])) {
				$configAction = isset($configuration['configView'][$field]) ? $configuration['configView'][$field] : NULL;

				$conditions = Set::merge(empty($configAction['conditions']) ? array() : $configAction['conditions'], array($model . '.id' => $id));
				$modelData = $this->{$model}->find('first', array('conditions' => $conditions, 'contain' => FALSE));

				if (!empty($modelData)) {

					if (!empty($value) && !empty($configAction['limit'])) {
						$limitConditions = empty($configAction['conditions']) ? array() : $configAction['conditions'];

						$limitConditions[$model . '.' . $field ] = $value;

						if (!empty($configAction['foreignKey'])) {
							$foreignKeys = is_array($configAction['foreignKey']) ? $configAction['foreignKey'] : array($configAction['foreignKey']);

							foreach ($foreignKeys as $key) {
								$keyValue = $modelData[$model][$key];
								$limitConditions[$model . '.' . $key] = $keyValue;
							}
						}

						$count = $this->{$model}->find('count', array(
							'conditions' => $limitConditions,
							'limit' => $configAction['limit'],
							'contain' => FALSE
						));

						if ($count >= $configAction['limit']) {
							throw new MethodNotAllowedException();
						}
					}

					$this->{$model}->id = $id;

					if ($this->{$model}->hasField($field) && $this->{$model}->saveField($field, $value)) {
						$fieldKey =  Utility::slug($field);
						$dialog = Utility::translate((empty($value) ? '' : 'not-') . $fieldKey . '-dialog', Inflector::underscore($model));
						$message = Utility::translate((empty($value) ? 'not-' : '') . $fieldKey . '-notification', Inflector::underscore($model) , NULL, $modelData[$model][$this->{$model}->displayField]);

						if (!empty($value)) {
							$title = Utility::translate('not-' . $fieldKey . '-dialog-title', $model);
						}

						if (empty($value) || $title == 'not-' . $fieldKey  . '-dialog-title') {
							$title = Utility::translate($fieldKey . '-dialog-title', $model);
						}

						if ($title == $fieldKey . '-dialog-title') {
							$title = '';
						}

						$this->set(compact('id', 'model', 'field', 'value', 'title', 'dialog', 'message'));

						if (!empty($value) && !empty($configAction['unique'])) {
							$updateConditions = empty($configAction['conditions']) ? array() : $configAction['conditions'];

							$updateConditions[$model . '.id <>'] = $id;

							if (!empty($configAction['foreignKey'])) {
								$foreignKeys = is_array($configAction['foreignKey']) ? $configAction['foreignKey'] : array($configAction['foreignKey']);

								foreach ($foreignKeys as $key) {
									$keyValue = $modelData[$model][$key];
									$updateConditions[$model . '.' . $key] = $keyValue;
								}
							}

							$this->{$model}->updateAll(
								array($model . '.' . $field => 0),
								$updateConditions
							);

							$title = Utility::translate($fieldKey . '-dialog-title', Inflector::underscore($model));

							$siblings = array(
								'value' => 0,
								'title' => $title == $fieldKey . '-dialog-title' ? '' : $title,
								'dialog' => Utility::translate($fieldKey . '-dialog', Inflector::underscore($model))
							);

							$this->set(compact('siblings'));
						}
					} else {
						throw new BadRequestException();
					}
				} else {
					throw new NotFoundException();
				}
			} else {
				throw new NotFoundException();
			}
		} else {
			throw new BadRequestException();
		}
	}

	private function formatMenuItems($items = array()) {
		$_items = array();
		$pretty = Configure::read('App.webpages.pretty-urls');

		foreach ($items as $item) {
			$url = '';
			$type = $item['MenuItem']['type'];

			if ($type == 'internal') {
				if ($item['MenuItem']['web_page_id']) {
					$url = Router::url(array('controller' => 'web_pages', 'action' => 'view', 'admin' => false), true);

					if (!$pretty) {
						$url .= '/';
					}

					$url .= $item['WebPage']['es_key'];
				} else {
					$url = Router::url(array('controller' => $item['MenuItem']['controller'], 'action' => $item['MenuItem']['action']));
				}
			} elseif ($type == 'external') {
				$url = $item['MenuItem']['es_url'];

				if (!preg_match('#^(mailto:|tel:|https?://|/)#', $url)) {
					$url = 'https://' . $url;
				}
			} elseif ($type == 'header') {
				$url = '#';
			}

			$_item = array(
				'name' => $item['MenuItem']['es_name'],
				'url' => $url
			);

			if (!empty($item['MenuItem']['target'])) {
				$_item['target'] = '_blank';
			}
			if (!empty($item['children'])) {
				$_item['children'] = $this->formatMenuItems($item['children']);
			}

			$_items[$item['MenuItem']['id']] = $_item;
		}

		return $_items;
	}

	protected function getActionKey() {
		return sprintf('%s.%s', $this->request->controller, $this->request->action);
	}

	private function getSeo() {
		$this->loadModel('WebPageSeo');

		$seo = [];
		$results = $this->WebPageSeo->find('all', [
			'contain' => ['Media']
		]);

		if (!empty($results)) {
			foreach ($results as $key => $result) {
				$seo[$result['WebPageSeo']['key']] = [
					'title' => $result['WebPageSeo'][$this->locale . '_title'],
					'description' => $result['WebPageSeo'][$this->locale . '_description'],
					'meta' => $result['WebPageSeo'][$this->locale . '_meta'],
					'image' => empty($result['MediaImage']['key']) ? null : ($result['MediaImage']['key'] . '.' . $result['MediaImage']['format']),
					'header_code' => $result['WebPageSeo'][$this->locale . '_header_code'],
					'footer_code' => $result['WebPageSeo'][$this->locale . '_footer_code']
				];
			}
		}

		return $seo;
	}
}
