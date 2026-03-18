<?php
App::uses('AppController', 'Controller');

class CategoriesController extends AppController {

	public function admin_index($id = null) {
		$conditions = array(
			'Category.parent_id' => null,
			'Category.core' => false
		);
		$current = null;
		$parents = array();

		if (Utility::is('prosimian')) {
			unset($conditions['Category.core']);
		}

		if ($id) {
			$conditions['Category.parent_id'] = $id;
			$current = $this->Category->find('first', array(
				'conditions' => array(
					'Category.id' => $id
				),
				'contain' => array('ParentCategory')
			));

			if (empty($current)) {
				throw new NotFoundException();
			}

			$parents = $this->Category->getPath($id);
			array_pop($parents);
		}

		$this->Paginator->settings = [
			'limit' => 25,
			'conditions' => $conditions
		];

		$categories = $this->Paginator->paginate();

		$this->set(compact('categories', 'current', 'parents'));
	}

	public function admin_add($id = null) {
		$parent = null;

		if ($id) {
			$parent = $this->Category->find('first', array(
				'conditions' => array('Category.id' => $id),
				'contain' => false
			));
		}

		if (!empty($parent) && $parent['Category']['core'] && !Utility::is('prosimian')) {
			throw new ForbiddenException();
		}

		if ($this->request->is('post')) {
			$this->Category->create();
			$this->request->data['Category']['parent_id'] = $id;

			if (!empty($parent)) {
				$this->request->data['Category']['core'] = $parent['Category']['core'];
			}

			if ($this->Category->save($this->request->data)) {
				$message = __('save-notification', sprintf('La categoría %s', $this->request->data['Category']['name']));
				$redirectURL = array('controller' => 'categories', 'action' => 'index');

				if (!empty($parent)) {
					 $redirectURL += array($parent['Category']['id'], Utility::slug($parent['Category']['name']));
				}

				$this->Flash->success($message);
				return $this->redirect($redirectURL);
			}
		}

		$this->set(compact('parent'));
	}

	public function admin_edit($id = null, $name = null) {
		if (empty($id)) {
			throw new NotFoundException();
		}

		$category = $this->Category->find('first', array(
			'conditions' => array(
				'Category.id' => $id
			),
			'contain' => array('ParentCategory')
		));
		if (empty($category)) {
			throw new NotFoundException();
		}
		if (!empty($category) && $category['Category']['core'] && !Utility::is('prosimian')) {
			throw new ForbiddenException();
		}

		$conditions = array(
			'NOT' => array(
				'OR' => array(
					'Category.core' => true,
					'AND' => array(
						'Category.lft >=' => $category['Category']['lft'],
						'Category.rght <=' => $category['Category']['rght']
					)
				)
			)
		);
		if (Utility::is('prosimian')) {
			$conditions['NOT'] = array(
				'AND' => array(
					'Category.lft >=' => $category['Category']['lft'],
					'Category.rght <=' => $category['Category']['rght']
				)
			);
		}
		$categories = $this->Category->generateTreeList(
			$conditions,
			null,
			null,
			' -- '
		);

		if ($this->request->is(array('post', 'put'))) {
			$parent = $this->Category->find('first', array(
				'conditions' => array('Category.id' => $this->request->data['Category']['parent_id']),
				'contain' => false
			));
			if (!empty($parent) && $parent['Category']['core'] && !Utility::is('prosimian')) {
				throw new ForbiddenException();
			}
			$this->request->data['Category']['core'] = empty($parent) ? 0 : $parent['Category']['core'];

			if ($this->Category->save($this->request->data)) {
				$message = __('save-notification', sprintf('La categoría %s', $this->request->data['Category']['name']));
				$redirectURL = array('controller' => 'categories', 'action' => 'index');

				if (!empty($category['Category']['parent_id'])) {
					 $redirectURL += array($category['ParentCategory']['id'], Utility::slug($category['ParentCategory']['name']));
				}

				$this->Flash->success($message);
				return $this->redirect($redirectURL);
			}
		}
		if (!$this->request->data) {
			$this->request->data = $category;
		}

		$this->set(compact('category', 'categories'));
	}

	public function admin_delete($id = null) {
		$category = $this->Category->find('first', array(
			'conditions' => array(
				'Category.id' => $id
			),
			'contain' => false
		));
		if (!empty($category) && $category['Category']['core'] && !Utility::is('prosimian')) {
			throw new ForbiddenException();
		}

		parent::admin_delete($id);
	}
}
