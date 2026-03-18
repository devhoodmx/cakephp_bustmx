<?php
/**
 * MediaLibraries Controller
 *
 * Static content controller
 *
 */
class MediaLibrariesController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();

		if (in_array($this->action, ['admin_add', 'admin_index'])) {
			$parents = $this->MediaLibrary->generateTreeList(
				[],
				null,
				null,
				'---- '
			);

			$this->set(compact('parents'));
		}
	}

	public function admin_index($id = null) {
		$conditions = [];

		if ($id) {
			$conditions = [
				'Media.foreign_key' => $id,
				'Media.model' => 'MediaLibrary',
				'Media.collection' => 'main'
			];

			$mediaLibrary = $this->MediaLibrary->find('first', array(
				'conditions' => array(
					'MediaLibrary.id' => $id
				),
				'contain' => false
			));

			if (empty($mediaLibrary)) {
				throw new NotFoundException();
			}

			$path = $this->MediaLibrary->getPath($id);

			$this->set(compact('mediaLibrary', 'path'));
		}

		$libraries = $this->MediaLibrary->find('all', array(
			'conditions' => array(
				'MediaLibrary.parent_id' => $id
			),
			'order' => ['MediaLibrary.order' => 'ASC'],
			'contain' => false
		));

		if (!empty($this->request->query['type'])) {
			$conditions['Media.type'] = $this->request->query['type'];
		}

		if (!empty($this->request->query['model'])) {
			if ($this->request->query['model'] == 'models') {
				$conditions['Media.model <>'] = 'MediaLibrary';
			} else {
				$conditions['Media.model'] = $this->request->query['model'];
			}
		}



		$mediaConfig = [
			'MediaLibrary' => $this->MediaLibrary->getMediaConfig()
		];

		$types = [];

		foreach ($mediaConfig['MediaLibrary']['main']['mediaTypes'] as $type) {
			$types[$type] = Utility::translate(Utility::slug($type), 'media');
		}

		$this->Paginator->settings = [
			'Media' => [
				'conditions' => $conditions,
				'limit' => 25
			]
		];

		$files = $this->Paginator->paginate('Media');
		$fileModels = [];

		foreach ($files as $file) {
			if (empty($mediaConfig[$file['Media']['model']])) {
				$this->loadModel($file['Media']['model']);
				$mediaConfig[$file['Media']['model']] = $this->{$file['Media']['model']}->getMediaConfig();

				$fileModels[$file['Media']['model']] = __d('modules', Utility::slug(Inflector::pluralize($file['Media']['model'])));
			}
		}

		if ($id === null) {
			$models = $this->MediaLibrary->Media->find('list', [
				'fields' => ['Media.model', 'Media.model'],
				'group' => ['Media.model'],
				'contain' => false
			]);

			foreach ($models as $key => $model) {
				$models[$key] = Utility::translate(Utility::slug($key), 'modules');
			}

			unset($models['MediaLibrary']);
			$models = [
				'models' => 'Solo modelos',
				'MediaLibrary' => 'Solo carpetas',
				'Modelos' => $models
			];

			$this->set(compact('models'));
		}

		$this->set(compact('files', 'mediaConfig', 'libraries', 'types'));
	}

	public function admin_add($id = null) {
		parent::admin_add();

		if (empty($this->request->data)) {
			$this->request->data['MediaLibrary']['parent_id'] = $id;
		}
	}

	public function admin_edit($id = null, $name = null) {
		$config = parent::admin_edit($id, $name);
		$library = $config['setParams']['mediaLibrary'];

		$parents = $this->MediaLibrary->generateTreeList(
			['OR' => [
				'MediaLibrary.lft <' => $library['MediaLibrary']['lft'],
				'MediaLibrary.rght >' => $library['MediaLibrary']['rght']
			]],
			null,
			null,
			'---- '
		);

		$this->set(compact('parents'));

	}
}
?>
