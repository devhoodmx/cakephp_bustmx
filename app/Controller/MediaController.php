<?php
/**
 * Media Controller
 *
 * Static content controller
 *
 */
class MediaController extends AppController {
/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Media';
/**
 * Default components
 *
 * @var array
 */
	// public $components = array('Recaptcha');
/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

	public function admin_add() {
		if (empty($this->data)) {
			throw new BadRequestException();
		} else {
			if ($this->Media->save($this->data)) {
				$media = $this->Media->find('first', array(
					'conditions' => array('Media.id' => $this->Media->id),
					'contain' => FALSE
				));

				$model = $media['Media']['model'];
				if (empty($this->{$model})) {
					$this->loadModel($model);
				}

				$config = $this->{$model}->getMediaConfig($media['Media']['collection']);
				$config['mediaItem'] = $media['Media'];

				$mediaItem = array(
					'viewElement' => array(
						'url' => 'admin/widgets/media/item',
						'params' => $config
					)
				);

				if (!empty($this->data['Media']['previous_id'])) {
					$this->set('previousId', $this->data['Media']['previous_id']);
				}

				$this->set(compact('media', 'mediaItem'));
			}
		}
	}

	public function admin_attribute($id = null, $name = null) {
		$media = $this->Media->find('first', array(
			'conditions' => array('Media.id' => $id),
			'contain' => false
		));

		if (empty($media)) {
			throw new NotFoundException();
		} else {
			$this->loadModel($media['Media']['model']);

			$mediaConfig = $this->{$media['Media']['model']}->getMediaConfig($media['Media']['collection']);
			$media = $media['Media'];
			$mediaContent = true;
			$mediaAttributes = !empty($mediaConfig['mediaAttributes'][$media['type']]) ? $mediaConfig['mediaAttributes'][$media['type']] : [];
			$mediaFields = !empty($mediaAttributes['fields']) ? $mediaAttributes['fields'] : [];

			if (empty($this->request->data)) {
				$this->request->data['Media'] = $media;

				$view = new View($this, false);
				$modal = $view->element('admin/widgets/media/attribute', compact('media', 'mediaFields', 'mediaContent'));
				$this->set(compact('modal', 'media'));
			} else {
				$this->request->data['Media']['id'] = $id;
				$extraFields = [];

				$this->Media->set($this->request->data);

				foreach ($mediaAttributes['validation'] as $attribute => $rule) {
					$this->Media->validator()->add($attribute, is_array($rule) ? $rule : ['rule' => $rule]);
				}

				foreach ($this->request->data['Media'] as $field => $value) {
					if (!$this->Media->hasField($field)) {
						$extraFields[$field] = $this->request->data['Media'][$field];
					} else if (in_array($field, $mediaAttributes['whitelist'])) {
						$this->request->data['Media'][$field] = $this->request->data['Media'][$field];
					} else {
						unset($this->request->data['Media'][$field]);
					}
				}

				$this->request->data['Media']['extra'] = json_encode($extraFields);

				if ($this->Media->validates() && $this->Media->save($this->request->data)) {
					$name = empty($this->request->data['Media']['name']) ? 'elemento' : $this->request->data['Media']['name'];
					$message = Utility::translate('save-notification', Inflector::underscore('Media') , NULL, $name);

					$this->set(compact('message', 'id', 'name'));
				}
			}
		}
	}

	public function admin_change_name($id = NULL) {
		if (($this->request->is('post') || $this->request->is('put')) && !empty($this->request->data['Media']['name'])) {
			$media = $this->Media->find('first', array('conditions' => array('Media.id' => $id), 'contain' => false));

			if (!empty($media)) {
				$name = $this->request->data['Media']['name'];
				$this->Media->id = $id;

				if ($this->Media->saveField('name', $name)) {
					$message = Utility::translate('save-notification', Inflector::underscore('Media') , NULL, $name);

					$this->set(compact('message', 'name'));
				} else {
					throw new BadRequestException();
				}
			} else {
				throw new NotFoundException();
			}
		} else {
			throw new BadRequestException();
		}
	}

	public function admin_change_share_key($id = NULL) {
		if (($this->request->is('post') || $this->request->is('put')) && isset($this->request->data['Media']['share_key'])) {
			$media = $this->Media->find('first', array('conditions' => array('Media.id' => $id), 'contain' => false));

			if (!empty($media)) {
				$name = $media['Media']['name'];
				$shareKey = Utility::slug($this->request->data['Media']['share_key']);

				if ($this->Media->save(['id' => $id, 'share_key' => $shareKey])) {
					$message = Utility::translate('save-notification', Inflector::underscore('Media') , NULL, 'El identificador <strong>' . $shareKey . '</strong>');

					$this->set(compact('message', 'name'));

					$this->admin_share($id);
				}
			} else {
				throw new NotFoundException();
			}
		} else {
			throw new BadRequestException();
		}
	}

	public function download($id = null, $key = null) {
		$conditions = array('Media.id' => $id);
		$preview = false;
		$path = '';

		if (empty($key)) {
			$conditions['Media.public'] = true;
		} else {
			$conditions['Media.key'] = $key;
		}

		if ($this->request->query('preview')) {
			$preview = true;
		}

		$media = $this->Media->find('first', array(
			'conditions' => $conditions
		));

		if ($media) {
			$this->loadModel($media['Media']['model']);

			$config = $this->{$media['Media']['model']}->getMediaConfig($media['Media']['collection']);
			$path = $config['mediaPath'][0] == '/' ? $config['mediaPath'] : (WWW_ROOT . 'files' . DS . $config['mediaPath']);

			$path = sprintf(
				$path . '/%s/%s_%s.%s',
				$media['Media']['type'],
				$media['Media']['type'] == 'image' ? 'raw' : 'file',
				$media['Media']['key'],
				$media['Media']['format']
			);

			$this->response->file(
				$path,
				array(
					'download' => true,
					'name' => $media['Media']['source']
				)
			);

			return $this->response;
		} else {
			throw new NotFoundException();
		}
	}

	public function admin_download($id = null, $key = null) {
		return $this->download($id, $key);
	}

	public function admin_video($id = null, $key = null) {
		$conditions = array('Media.id' => $id, 'Media.type' => 'video');

		if (empty($key)) {
			$conditions['Media.public'] = true;
		} else {
			$conditions['Media.key'] = $key;
		}

		$media = $this->Media->find('first', array(
			'conditions' => $conditions
		));

		if ($media) {
			$this->loadModel($media['Media']['model']);

			$config = $this->{$media['Media']['model']}->getMediaConfig($media['Media']['collection']);
			$path = $config['mediaPath'][0] == '/' ? $config['mediaPath'] : (WWW_ROOT . 'files' . DS . $config['mediaPath']);

			$this->response->file(
				$path . '/video/file_' . $media['Media']['key'] . '.' . $media['Media']['format'],
				array(
					'download' => false,
					'name' => $media['Media']['source']
				)
			);

			return $this->response;
		} else {
			throw new NotFoundException();
		}
	}

	public function admin_toggle_field($id = null) {
		parent::admin_toggle_field($id);

		if (!empty($this->request->data['Media']['field']) && $this->request->data['Media']['field'] == 'shared') {
			$media = $this->Media->find('first', [
				'conditions' => ['Media.id' => $id],
				'contain' => ['MediaLink']
			]);

			if (!empty($this->request->data['Media']['value'])) {
				if (empty($media['MediaLink']['id'])) {
					$this->Media->MediaLink->save(['name' => $media['Media']['name'], 'media_id' => $id]);
				}
			} else {
				if (!empty($media['MediaLink']['id'])) {
					$this->Media->MediaLink->delete($media['MediaLink']['id']);
				}
			}

			$this->admin_share($id);
		}
	}

	public function admin_share($id = null) {
		$media = $this->Media->find('first', [
			'conditions' => ['Media.id' => $id],
			'contain' => ['MediaLink']
		]);

		if (empty($media)) {
			throw new NotFoundException();
		} else {
			$this->loadModel($media['Media']['model']);

			$mediaConfig = $this->{$media['Media']['model']}->getMediaConfig($media['Media']['collection']);

			$mediaLink = empty($media['MediaLink']['id']) ? null : $media['MediaLink'];
			$media = $media['Media'];

			$path = $mediaConfig['mediaPath'][0] == '/' ? $mediaConfig['mediaPath'] : (WWW_ROOT . 'files' . DS . $mediaConfig['mediaPath']);
			$mediaContent = true;

			$view = new View($this, false);
			$modal = $view->element('admin/widgets/media/share', compact('media', 'mediaLink', 'mediaConfig', 'path', 'mediaContent'));
			$this->set(compact('modal', 'media', 'mediaLink'));
		}
	}

	public function share($hash = null) {
		$hash = explode('.', $hash);

		if (sizeof($hash) > 1) {
			unset($hash[sizeof($hash) - 1]);
			$hash = implode($hash);
		}

		$link = $this->Media->MediaLink->find('first', [
			'conditions' => [
				'OR' => [
					'Media.share_key' => $hash,
					'MediaLink.hash' => $hash
				],
				'Media.shared' => true
			],
			'contain' => ['Media']
		]);

		if ($link) {
			$this->loadModel($link['Media']['model']);

			$config = $this->{$link['Media']['model']}->getMediaConfig($link['Media']['collection']);
			$path = $config['mediaPath'][0] == '/' ? $config['mediaPath'] : (WWW_ROOT . 'files' . DS . $config['mediaPath']);

			$path = sprintf(
				$path . '/%s/%s_%s.%s',
				$link['Media']['type'],
				!empty($this->request->params['version']) ? $this->request->params['version'] : ($link['Media']['type'] == 'image' ? 'raw' : 'file'),
				$link['Media']['key'],
				$link['Media']['format']
			);

			$this->response->file(
				$path,
				array(
					'download' => !empty($this->request->params['download']),
					'name' => $link['Media']['source']
				)
			);

			return $this->response;
		} else {
			throw new NotFoundException();
		}
	}

}
?>
