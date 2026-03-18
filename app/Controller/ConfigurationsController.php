<?php
App::uses('AppController', 'Controller');

class ConfigurationsController extends AppController {

	public function admin_index() {
		$categoriesIds = array();
		$conditions = ['Configuration.hidden' => 0];
		$configurations = null;

		if (Utility::is('prosimian')) {
			unset($conditions['Configuration.hidden']);
		}

		$configurations = $this->Configuration->find('all', array(
			'conditions' => $conditions,
			'order' => array('Category.order' => 'ASC', 'Configuration.id' => 'ASC'),
			'contain' => array('Category', 'Media')
		));

		foreach ($configurations as $key => $configuration) {
			$categoriesIds[] = $configuration['Category']['id'];
			$data[$configuration['Category']['name']][] = array(
				'Configuration' => $configuration['Configuration'],
				'MediaDocument' => $configuration['MediaDocument'],
				'MediaImage' => $configuration['MediaImage']
			);
		}
		$configurations = $data;

		$categories = $this->Configuration->Category->find('all', array(
			'conditions' => array('Category.id' => $categoriesIds, 'Category.parent_id' => 3)
		));

		$this->set(compact('configurations', 'categories'));
	}

	public function admin_edit($id = null, $name = null) {
		$configuration = $this->Configuration->find('first', array(
			'conditions' => array(
				'Configuration.id' => $id
			)
		));
		$key = $configuration['Configuration']['key'];

		if ($configuration['Configuration']['type'] == 'code') {
			if (!empty($configuration['Configuration']['attributes_map'])) {
				$attrs = $configuration['Configuration']['attributes_map'];
				$configuration['Configuration']['language'] = !empty($attrs['language']) ? $attrs['language'] : '';
			} else {
				$configuration['Configuration']['language'] = '';
			}
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			// Image, video & file
			if (in_array($configuration['Configuration']['type'], ['image', 'video', 'file'])) {
				$models = [
					'image' => 'MediaImage',
					'video' => 'MediaVideo',
					'file' => 'MediaDocument'
				];
				$modelKey = $models[$configuration['Configuration']['type']];
				$value = null;

				if (!empty($configuration[$modelKey]['id'])) {
					$value = sprintf('%s.%s', $configuration[$modelKey]['key'], $configuration[$modelKey]['format']);
				}

				$this->request->data['Configuration']['value'] = $value;
			}

			if ($this->Configuration->saveAll($this->request->data)) {
				$this->Flash->success(__('<strong>%s</strong> ha sido actualizado.', $configuration['Configuration']['name']));
				$this->redirect(array('controller' => 'configurations', 'action' => 'index', '?' => array(
					'category_id' => $configuration['Configuration']['category_id']
				)));
			}
		} else {
			$this->request->data = $configuration;
		}

		$mediaConfig = $this->Configuration->getMediaConfig();
		$this->set(compact('configuration', 'mediaConfig'));
	}
}
