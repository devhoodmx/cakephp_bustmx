<?php
App::uses('AppController', 'Controller');

class SectionsController extends AppController {
	public function beforeFilter() {
		if (in_array($this->action, ['admin_add', 'admin_delete'])) {
			if (!Utility::is('prosimian')) {
				throw new ForbiddenException();
			}
		}

		parent::beforeFilter();
	}

	public function admin_index() {
		$sections = $this->Section->find('all', [
			'order' => ['Section.id' => 'ASC'],
			'contain' => false
		]);

		$tmp = [];
		foreach ($sections as $section) {
			$tmp[$section['Section']['page']][] = $section;
		}

		$this->set('menuItemKey', 'content');
		$this->set('submenuItemKey', 'sections');
		$this->set('sections', $tmp);
	}


	public function admin_add() {
		parent::admin_add();

		if (!empty($this->params->query['id'])) {
			$section = $this->Section->find('first', array(
				'conditions' => array('Section.id' => $this->params->query['id']),
				'contain' => false
			));

			$this->request->data = $section;

			unset($this->request->data['Section']['id']);
		}
	}

	public function admin_edit($id = null, $name = null) {
		$configuration = $this->validateScaffold();
		$model = $configuration['model'];

		$configuration['findParams']['conditions'][$model . '.id'] = $id;

		$modelData = $this->{$model}->find('first', $configuration['findParams']);
		$type = $modelData['Section']['type'];

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

		$redirect = [
			'controller' => 'sections',
			'action' => 'index'
		];

		if (($this->request->is('post') || $this->request->is('put'))) {
			$this->request->data[$model]['id'] = $id;

			if ($this->{$model}->saveAll($this->request->data, array('validate' => 'first'))) {
				$modelData = $this->{$model}->find('first', $configuration['findParams']);

				$this->redirect($redirect);
			}
		} else if ($this->RequestHandler->ext == 'json') {
			throw new BadRequestException();
		} else {
			$this->data = $modelData;
		}

		if (!Utility::is('prosimian')) {
			$configuration['setParams']['configView']['fields']['main'] = [];
		}

		if ($type == 'text' || $type == '') {
			$configuration['setParams']['configView']['fields']['main']['content'] = 'editor';
		}
		if ($type == 'image' || $type == '') {
			$configuration['setParams']['configView']['fields']['main']['gallery'] = 'media';
		}
		if ($type == 'code') {
			$configuration['setParams']['configView']['fields']['main']['content'] = 'textarea';
		}
		if ($type == 'archive') {
			$configuration['setParams']['configView']['fields']['main']['archive'] = 'media';
		}
		if ($type == 'simple-text' || $type == '') {
		   $configuration['setParams']['configView']['fields']['main']['content'] = 'text';
		}

		$configuration['setParams'][Inflector::variable($model)] = $modelData;

		$this->set($configuration['setParams']);
	}
}
?>
