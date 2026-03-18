<?php
App::uses('AppController', 'Controller');

class MenuItemsController extends AppController {
	public function beforeFilter() {
		$isAdmin = isset($this->request->params['prefix'])  && $this->request->params['prefix'] == 'admin';

		parent::beforeFilter();

		if ($isAdmin) {
			$this->currentWebsite = null;
			$this->currentWebsiteId = null;

			$websites = Hash::combine(
				$this->MenuItem->Website->find('all', array(
					'order' => array('Website.main' => 'DESC'),
					'contain' => false
				)),
				'{n}.Website.id',
				'{n}'
			);

			// Identify current website
			if (!empty($websites)) {
				$this->currentWebsite = reset($websites);
			}
			if (!empty($this->request->query['website_id'])) {
				if (!isset($websites[$this->request->query['website_id']])) {
					throw new BadRequestException();
				}

				$this->currentWebsite = $websites[$this->request->query['website_id']];
			}

			if (!empty($this->currentWebsite)) {
				$this->currentWebsiteId = $this->currentWebsite['Website']['id'];
			}

			if (in_array($this->action, array('admin_add', 'admin_edit'))) {
				$internals = array();

				// Load internal pages/sections
				$pages = $this->MenuItem->WebPage->find('all', array(
					'contain' => false,
					'conditions' => array('WebPage.active' => true)
				));

				$internals[__d('menu_item', 'internal-pages')] = Hash::combine($pages, '{n}.WebPage.id', array('%s (/%s)', '{n}.WebPage.name', '{n}.WebPage.es_key'));

				if (!empty($this->MenuItem->catalogues['sections'])) {
					$internals[__d('menu_item', 'internal-sections')] = $this->MenuItem->catalogues['sections'];
				}

				if ($this->request->is(array('post', 'put')) && !empty($this->request->data)) {
					$type = $this->request->data['MenuItem']['type'];

					// Add validations
					if ($type == 'internal') {
						$this->MenuItem->validator()
							->add(
								'internal_id',
								array(
									'notBlank' => array(
										'rule' => 'notBlank'
									),
									'isInternal' => array(
										'rule' => 'isInternal'
									)
								)
							);
					} elseif ($type == 'external') {
						$this->MenuItem->validator()
							->add(
								'es_name',
								array(
									'notBlank' => array(
										'rule' => 'notBlank'
									)
								)
							)
							->add(
								'es_url',
								array(
									'notBlank' => array(
										'rule' => 'notBlank'
									)
								)
							);
					} elseif ($type == 'header') {
						$this->MenuItem->validator()
							->add(
								'es_name',
								array(
									'notBlank' => array(
										'rule' => 'notBlank'
									)
								)
							);
					}
				}

				$this->set('internals', $internals);
				$this->set(Utility::config('menu_items', 'vars'));
			}

			$this->set($this->MenuItem->catalogues);
			$this->set(array(
				'currentWebsite' => $this->currentWebsite,
				'websites' => $websites
			));
		}
	}

	public function admin_index() {
		$menus = array();
		$positions = $this->MenuItem->catalogues['positions'];

		foreach ($positions as $key => $value) {
			$menus[$key] = $this->MenuItem->find('threaded', array(
				'order' => array('MenuItem.order' => 'ASC'),
				'conditions' => array(
					'MenuItem.position' => $key,
					'MenuItem.website_id' => $this->currentWebsiteId
				),
				'contain' => array('WebPage', 'ParentItem')
			));
		}

		$this->set(compact('menus'));
	}

	public function admin_add($position = null, $parentId = null) {
		$parent = null;
		$positions = $this->MenuItem->catalogues['positions'];
		$websiteId = $this->currentWebsiteId;

		if (empty($position) || !isset($positions[$position])) {
			throw new BadRequestException();
		}

		if (!empty($parentId)) {
			$parent = $this->MenuItem->find('first', array(
				'conditions' => array('MenuItem.id' => $parentId)
			));

			if (empty($parent)) {
				throw new BadRequestException('Parent not found');
			}
			$websiteId = $parent['MenuItem']['website_id'];
		}

		if ($this->request->is('post') && !empty($this->request->data)) {
			$this->request->data['MenuItem']['position'] = $position;
			$this->request->data['MenuItem']['parent_id'] = $parentId;
			$this->request->data['MenuItem']['website_id'] = $websiteId;

			$this->MenuItem->set($this->request->data);

			if ($this->MenuItem->saveAll($this->request->data, array('validate' => 'first'))) {
				$menuItem = $this->MenuItem->find('first', array(
					'conditions' => array('MenuItem.id' => $this->MenuItem->id)
				));
				$url = array('action' => 'index');

				if ($websiteId) {
					$url['?'] = array('website_id' => $websiteId);
				}

				$this->Flash->success(Utility::translate('save-notification', 'menu_item', null, $menuItem['MenuItem']['es_name']));

				$this->redirect($url);
			}
		}
	}

	public function admin_edit($id = null, $name = null) {
		$query = array(
			'conditions' => array('MenuItem.id' => $id),
			'contain' => array('WebPage')
		);

		$menuItem = $this->MenuItem->find('first', $query);
		if (empty($menuItem)) {
			throw new NotFoundException();
		}

		$conditions = array(
			'MenuItem.position' => $menuItem['MenuItem']['position'],
			'NOT' => array(
				'AND' => array(
					'MenuItem.lft >=' => $menuItem['MenuItem']['lft'],
					'MenuItem.rght <=' => $menuItem['MenuItem']['rght']
				)
			)
		);
		$parents = $this->MenuItem->generateTreeList(
			$conditions,
			null,
			null,
			' »» '
		);

		if ($this->request->is(array('post', 'put')) && !empty($this->request->data)) {
			$this->request->data['MenuItem']['id'] = $id;

			if ($this->MenuItem->saveAll($this->request->data, array('validate' => 'first'))) {
				$menuItem = $this->MenuItem->find('first', $query);
				$url = array('action' => 'index');

				if ($menuItem['MenuItem']['website_id']) {
					$url['?'] = array('website_id' => $menuItem['MenuItem']['website_id']);
				}

				$this->Flash->success(Utility::translate('save-notification', 'menu_item', null, $menuItem['MenuItem']['es_name']));

				$this->redirect($url);
			}
		} else {
			$menuItem['MenuItem']['_target'] = $menuItem['MenuItem']['target'] == '_blank' ? true : false;

			$this->request->data = $menuItem;
		}

		$this->set(compact('menuItem', 'parents'));
	}

	public function admin_move($id = null, $position = 0) {
		$menuItem = $this->MenuItem->find('first', array(
			'conditions' => array('MenuItem.id' => $id),
			'contain' => false
		));

		if (empty($menuItem)) {
			throw new NotFoundException();
		}

		$this->MenuItem->id = $id;
		$this->MenuItem->saveField('order', $position);
	}
}
?>
