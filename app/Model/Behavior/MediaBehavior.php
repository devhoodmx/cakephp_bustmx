<?php

/**
 * Media behavior
 *
 * Enables a model object to contain media
 *
 */
App::uses('ModelBehavior', 'Model');

class MediaBehavior extends ModelBehavior {
/**
 * Defaults
 *
 * @var array
 */
	protected $_defaults = array(
		'configuration' => array(
			'max-size' => '2MB',
			'multiple' => true,
			'not-empty' => false,
			'label' => true,
			'private' => false,
			'files' => array(), // false: Not Supported
			'services' => array(), // false: Not Supported,
			'attributes' => [
				'whitelist' => ['name', 'title', 'subtitle', 'alt'],
				'default' => [
					'name' => 'text',
					'validation' => [
						'name' => 'notBlank'
					]
				],
				'image' => [
					'alt' => 'text',
					'title' => 'text'
				]
			],
		),
		'file-support' => array(
			'image' => array(
				'mediaType' => 'image',
				'vendor' => array(
					'location' => 'image/ImageFactory',
					'class' => 'ImageFactory'
				),
				'customizable' => true,
				'types' => array('jpg', 'jpeg', 'png', 'gif')
			),
			'svg' => array(
				'mediaType' => 'svg',
				'customizable' => false,
				'types' => array('svg')
			),
			'video' => array(
				'mediaType' => 'video',
				'customizable' => false,
				'types' => array('mp4')
			),
			'audio' => array(
				'mediaType' => 'audio',
				'customizable' => false,
				'types' => array('mp3')
			),
			'file' => array(
				'mediaType' => 'file',
				'customizable' => false,
				'types' => array()
			)
		),
		'service-support' => array(
			'youtube' => array(
				'mediaType' => 'video'
			),
			'vimeo' => array(
				'mediaType' => 'video'
			)
		)
	);

	protected $singleMedia = array();

/**
 * Initiate Media behavior
 *
 * @param Model $Model instance of model
 * @param array $config array of configuration settings.
 * @return void
 */
	public function setup(Model $Model, $config = array()) {
		$settings = array();
		$mediaUrl = array();
		$this->_defaults['configuration'] = Set::merge(Utility::config('media', 'behavior'), $this->_defaults['configuration']);

		if (!empty($config['model-url'])) {
			$mediaUrl = $config['model-url'];
			unset($config['model-url']);
		}

		if (empty($config)) {
			unset($config);
			$config['main'] = array();
		}

		if ($Model->name != 'Media' && empty($Model->Media)) {
			$Model->bindModel(
				array(
					'hasMany' => array(
		               'Media' => array(
		                    'className' => 'Media',
							'foreignKey' => 'foreign_key',
							'order' => array('Media.order' => 'DESC'),
							'conditions' => array('Media.model' => $Model->name),
							'dependent' => true
		                )
			    	)
				),
				false
			);

			App::import('Model', array('Media'));
			$MediaModel = new Media();
		} else {
			$MediaModel = $Model;
		}

		if ($Model->Behaviors->loaded('Containable')) {
			$Model->Behaviors->setPriority(array('Media' => 1, 'Containable' => 2));
		}

		foreach ($config as $key => $collection) {
			$settings[$key] = Set::merge($this->_defaults['configuration'], $collection);
			$relationName = 'Media' . Inflector::camelize(Inflector::slug($key));
			$supports = array();

			$path = empty($collection['path']) ? 'media' : $collection['path'];

			if ($path[0] == '/' || preg_match('~\A[A-Z]:(?![^/\\\\])~i', $path)){
				$settings[$key]['path']  = $path;
			} else {
				$settings[$key]['path']  = (WWW_ROOT . 'files' . DS . $path);
			}

			$settings[$key]['rawPath'] = $path;
			$settings[$key]['mediaUrl'] = $mediaUrl;

			if (!is_dir($settings[$key]['path'])) {
				mkdir($settings[$key]['path'], 0755, true);
			}

			$settings[$key]['maxSize'] = CakeNumber::fromReadableSize($settings[$key]['max-size']);

			unset($settings[$key]['max-size']);

			if ($settings[$key]['multiple']) {
				unset($settings[$key]['not-empty']);
				$relationType = 'hasMany';
			} else {
				$settings[$key]['notEmpty'] = !empty($settings[$key]['not-empty']);
				$relationType = 'hasOne';

				if (empty($this->singleMedia[$Model->alias])) {
					$this->singleMedia[$Model->alias] = array();
				}

				$this->singleMedia[$Model->alias][] = $key;
			}

			if ($Model->name != 'Media' && empty($Model->{$relationName})) {
				$Model->bindModel(
					array(
						$relationType => array(
			                $relationName => array(
			                    'className' => 'Media',
								'foreignKey' => 'foreign_key',
								'order' => empty($settings[$key]['multiple']) ? null : array($relationName . '.order' => 'DESC'),
								'conditions' => array(
									$relationName . '.model' => $Model->name,
									$relationName . '.collection' => $key
								),
								'dependent' => false
			                )
				    	)
					),
					false
				);
			}

			$supports = array(
				'files' => array(),
				'services' => array(),
				'types' => array()
			);

			$attributesFields = [];

			if ($settings[$key]['files'] !== false) {
				/*pr($key);
				pr($collection['attributes']);*/
				$generalAttributes = Set::merge(empty($this->_defaults['configuration']['attributes']['default']) ? [] : $this->_defaults['configuration']['attributes']['default'], empty($collection['attributes']) ? [] : $collection['attributes']);

				foreach ($this->_defaults['file-support'] as $type => $fileSupport) {
					if (empty($settings[$key]['files']) || isset($settings[$key]['files'][$type]) || in_array($type, $settings[$key]['files'])) {

						if (empty($fileSupport['types']) && (empty($settings[$key]['files'][$type]) || empty($settings[$key]['files'][$type]['types']))) {
							$supports['files']['*'] = $type;
						} else {
							if (empty($fileSupport['types']) && !empty($settings[$key]['files'][$type]['types'])) {
								$fileSupport['types'] = $settings[$key]['files'][$type]['types'];
							}

							foreach ($fileSupport['types'] as $file) {
								if (empty($settings[$key]['files'][$type]['types']) || in_array(mb_strtolower($file), $settings[$key]['files'][$type]['types'])) {
									$supports['files'][mb_strtolower($file)] = mb_strtolower($type);
								}
							}
						}

						if (!empty($fileSupport['vendor'])) {
							App::import('Vendor', $fileSupport['vendor']['location']);
						}

						if (!in_array($fileSupport['mediaType'], $supports['types'])) {
							$supports['types'][] = $fileSupport['mediaType'];
						}

						if (!empty($fileSupport['customizable'])) {
							$supports[$type] = array();

							if (!isset($settings[$key]['files'][$type]['default']) || $settings[$key]['files'][$type]['default'] !== false) {
								$supports[$type] = 	Utility::config('media', 'files.' . $type);
							}

							if (!empty($settings[$key]['files'][$type]['custom'])) {
								$supports[$type] = Set::merge($supports[$type], $settings[$key]['files'][$type]['custom']);
							}
						}

						if (!is_dir($settings[$key]['path']  . DS . $type)) {
							mkdir($settings[$key]['path']  . DS . $type, 0755, true);
						}


						if (isset($collection['files'][$type]['attributes']['default']) && $collection['files'][$type]['attributes']['default'] === false ) {
							$typeAttributes = empty($collection['files'][$type]['attributes']) ? [] : $collection['files'][$type]['attributes'];
						} else {
							$typeAttributes = Set::merge(empty($this->_defaults['configuration']['attributes'][$type]) ? [] : $this->_defaults['configuration']['attributes'][$type], empty($collection['files'][$type]['attributes']) ? [] : $collection['files'][$type]['attributes']);
						}

						$attributes = Set::merge($generalAttributes, $typeAttributes);

						$attributesFields[$type] = [
							'validation' => !empty($attributes['validation']) ? $attributes['validation'] : [],
							'whitelist' => $this->_defaults['configuration']['attributes']['whitelist']
						];
						unset($attributes['default']);
						unset($attributes['validation']);
						$attributesFields[$type]['fields'] = $attributes;
						$attributesFields[$type]['fields'] = $attributes;
					}
				}

				if (!isset($settings[$key]['preview'])) {
					if (!empty($supports['image']['img'])) {
						$settings[$key]['preview'] = 'img';
					} else if (!empty($supports['image']['thn'])) {
						$settings[$key]['preview'] = 'thn';
					}
				}
			}

			if ($settings[$key]['services'] !== false) {
				foreach ($this->_defaults['service-support'] as $type => $serviceSupport) {
					if (empty($settings[$key]['services']) || !empty($settings[$key]['services'][$type]) || in_array($type, $settings[$key]['services'])) {

						if (!in_array($type, $supports['services'])) {
							$supports['services'][] = $type;
						}

						if (!in_array($serviceSupport['mediaType'], $supports['types'])) {
							$supports['types'][] = $serviceSupport['mediaType'];
						}
					}
				}
			}

			$settings[$key]['supports'] = $supports;
			$settings[$key]['attributes'] = $attributesFields;

			unset($settings[$key]['services']);
			unset($settings[$key]['files']);
		}

		$this->settings[$Model->alias] = $settings;
	}
/**
 * Get the media manager configuration
 *
 * If collection is null returns all collections configuration
 *
 * @param Model $Model Model instance
 * @param string $collection collection configuration to retrieve
 * @return array configuration
 */
	public function getMediaConfig(Model $Model, $collection = NULL) {
		$settings = $this->settings[$Model->alias];
		$configuration = array();

		if (!empty($collection)) {
			$settings = array($collection => $settings[$collection]);
		}

		foreach ($settings as $key => $setting) {
			$configuration[$key] = array(
				'mediaPath' => $setting['rawPath'],
				'mediaModel' => $Model->name,
				'mediaCollection' => $key,
				'mediaField' => 'Media' . Inflector::camelize(Inflector::slug($key)),
				'mediaName' => Utility::slug(Inflector::underscore($Model->alias) . ' ' . $key),
				'mediaLabel' => $setting['label'],
				'mediaPrivate' => $setting['private'],
				'mediaMultiple' => $setting['multiple'],
				'mediaTypes' => $setting['supports']['types'],
				'mediaVersions' => !empty($setting['supports']['image']) ? array_keys($setting['supports']['image']) : [],
				'mediaMaxSize' => $setting['maxSize'] / (1024 * 1024),
				'mediaExtensions' => empty($setting['supports']['files']) ? false : (isset($setting['supports']['files']['*']) ? array() : array_keys($setting['supports']['files'])),
				'mediaServices' => empty($setting['supports']['services']) ? false : $setting['supports']['services'],
				'mediaFormats' => empty($setting['supports']['files']) ? NULL : $setting['supports']['files'],
				'mediaPreview' => empty($setting['preview']) ? false : $setting['preview'],
				'mediaAttributes' => empty($setting['attributes']) ? [] : $setting['attributes'],
				'mediaUrl' => empty($setting['mediaUrl']) ? [] : $setting['mediaUrl'],
			);

			if (!$setting['multiple']) {
				$configuration[$key]['mediaNotEmpty'] = $setting['notEmpty'];
			}
		}

		return empty($collection) ? $configuration : $configuration[$collection];
	}
/**
 * Get the media manager setting
 *
 * If collection is null returns all collections configuration
 *
 * @param Model $Model Model instance
 * @param string $collection collection configuration to retrieve
 * @return array configuration
 */
	public function getMediaSettings(Model $Model, $collection = NULL) {
		$settings = $this->settings[$Model->alias];

		return empty($collection) ? $settings : $settings[$collection];
	}
/**
 * Add the media to its respective structures
 *
 * @param Model $Model Model instance
 * @param array $data Request data
 * @return array file
 */
	public function addMedia(Model $Model, $data) {
		$media = array();
		$error = NULL;

		if ($Model->name != 'Media') {
			App::import('Model', array('Media'));
			$MediaModel = new Media();
		} else {
			$MediaModel = $Model;
		}

		if ($data['model'] != 'Media') {
			App::import('Model', array($data['model']));
			$RelatedModel = new $data['model']();
		} else {
			$RelatedModel = $MediaModel;
		}

		$settings = $RelatedModel->getMediaSettings($data['collection']);

		if ($file = $this->__isFile($data['media'])) {
			if (!(empty($file['tmp_name']) && $file['error'] == 4) && $file['error'] == 0) {
				if (is_uploaded_file($file['tmp_name'])) {
					$extension = $this->__getFileExtension($file);
					$fileSize = $this->__getFileSize($file);

					if ($fileSize <= $settings['maxSize']) {
						if (!empty($settings['supports']['files']['*']) || !empty($settings['supports']['files'][$extension])) {
							$extensionType = !empty($settings['supports']['files'][$extension]) ? $settings['supports']['files'][$extension] : $settings['supports']['files']['*'];
							$dir = $settings['path']  . DS . $extensionType;

							$fileName = md5(date('Ymdhis') . $file['tmp_name'] . (mt_rand() * 100000));

							try {
								if (!empty($this->_defaults['file-support'][$extensionType]['vendor'])) {
									$methodClass = $this->_defaults['file-support'][$extensionType]['vendor']['class'];
									$methodConfig = empty($settings['supports'][$extensionType]) ? array() : $settings['supports'][$extensionType];
									$media = call_user_func(array($methodClass, 'create'), $file, $methodConfig, $fileName, $dir);
								} else {
									$media = $this->saveFile($file, $fileName, $dir);
								}

								$media['type'] = $extensionType;
								$media['size'] = $fileSize;
								$media['is_file'] = true;
							} catch (Exception $e) {
								$error = 'processError';
							}
						} else {
							$error = 'invalidExtension';
						}
					} else {
						$error = 'fileSize';
					}
				} else {
					$error = 'maliciousUpload';
				}
			} else {
				$error = 'uploadError';
			}
		} else if (true /*VALID SERVICE*/) {
			// SERVICE LOGIC
		} else {
			$error = 'invalid';
		}

		if (empty($error)) {
			$media['public'] = empty($setting['private']);
			$media['model'] = $data['model'];
			$media['collection'] = $data['collection'];
			if (!empty($data['foreign_key'])) {
				$media['foreign_key'] = $data['foreign_key'];
			}
		} else {
			if (!empty($media['is_file'])) {
				$this->deleteMediaFile($media);
			}
			$media = false;
			$MediaModel->invalidate('media', $error);
		}

		return $media;
	}
/**
 * Pulic Method Deletes the media file
 *
 * @param array $data Media data
 */
	public function deleteMedia(Model $Model, $media) {
		$this->deleteMediaFile($media);
	}
/**
 * Deletes the media file
 *
 * @param Model $Model Model instance
 * @param array $data Media data
 */
	private function deleteMediaFile($media) {
		App::import('Model', array($media['model']));
		$model = new $media['model']();

		$settings = $model->getMediaSettings($media['collection']);

		$dir = $settings['path'] . DS . $media['type'];

		$fileName = $media['key'];
		$files = $dir . DS . '*_' . $fileName . '.*';
		array_map('unlink', glob($files));
	}
/**
 * Uploads and saves file
 *
 * @param array $data File data
 * @return integer size in bytes
 */
	private function saveFile($file, $fileName, $dir) {
		$extension = $this->__getFileExtension($file);
		$info = array(
			'name' => $file['name'],
			'key' => $fileName,
			'source' => $file['name'],
			'format' => $extension
		);

		try {
			if (!copy($file['tmp_name'], $dir . DS . 'file_' . $fileName . '.' . $extension)) {
				throw new Exception('processError');
			} else {
				return $info;
			}
		} catch (Exception $e) {
			throw $e;
		}
	}
/**
 * Returns if data is a file
 *
 * @param array $data File data
 * @return array false if is not file
 */
	private function __isFile($data) {
		$file = isset($data[0]) ? $data[0] : $data;
		if (is_file($file['tmp_name'])) {
			return $file;
		}
		return false;
	}
/**
 * Returns the file extension
 *
 * @param array $data File data
 * @return string extension
 */
	private function __getFileExtension($data) {
		$info = pathinfo($data['name']);
		return mb_strtolower($info['extension']);
	}

/**
 * Returns the file sieze
 *
 * @param array $data File data
 * @return integer size in bytes
 */
	private function __getFileSize($data) {
		return filesize($data['tmp_name']);
	}
/**
 * CALLBACKS
 */
/**
 * Runs before a find() operation
 *
 * @param Model $Model	Model using the behavior
 * @param array $query Query parameters as set by cake
 * @return array
 */
	public function beforeFind(Model $Model, $query) {
		if ($Model->alias != 'Media') {
			if ($Model->Behaviors->loaded('Containable') && !empty($query['contain']) &&
				(
					(is_array($query['contain']) && (in_array('Media', $query['contain']) || isset($query['contain']['Media']))) ||
					(is_string($query['contain']) && $query['contain'] == 'Media')
				)
			) {
				$settings = $this->settings[$Model->alias];
				$contain = is_string($query['contain']) ? array() : $query['contain'];
				unset($contain['Media']);
				unset($contain[array_search('Media', $contain)]);

				if (!empty($query['contain']['Media']) && is_array($query['contain'])) {
					foreach ($query['contain']['Media'] as $key => $collection) {
						if (!is_string($key)) {
							if (!empty($settings[$collection])) {
								$contain[] = 'Media' . Inflector::camelize(Inflector::slug($collection));
							}
						} else {
							if (!empty($settings[$key])) {
								$collection['Media'] = array();
								$contain['Media' . Inflector::camelize(Inflector::slug($key))] = $collection;
							}
						}
					}

				} else {
					foreach ($settings as $collection => $setting) {
						$contain[] = 'Media' . Inflector::camelize(Inflector::slug($collection));
					}
				}

				$query['contain'] = $contain;
			}
		}

		return $query;
	}
/**
 * Runs before a validates() operation
 *
 * @param Model $Model	Model using the behavior
 * @param array $options Options parameters as set by cake
 * @return boolean True if the operation should continue, false if it should abort
 */
	public function beforeValidate(Model $Model, $options = array()) {
		if ($Model->name == 'Media') {
			if (empty($Model->id) && empty($Model->data[$Model->alias]['id'])) {
				if (empty($Model->data[$Model->alias]['media'])) {
					$Model->invalidate('media', 'notBlank');
				}

				if ($Model->alias == $Model->name && empty($Model->data[$Model->alias]['foreign_key'])) {
					$Model->invalidate('foreign_key', 'notBlank');
				}
			}
		} else {
			if (empty($Model->id) && empty($Model->data[$Model->alias]['id'])) {
				if (!empty($this->singleMedia[$Model->alias])) {

					foreach ($this->singleMedia[$Model->alias] as $collection) {
						$settings = $Model->getMediaSettings($collection);
						$mediaModel = 'Media' . Inflector::camelize(Inflector::slug($collection));

						if (!empty($settings['not-empty']) && empty($Model->data[$mediaModel])) {
							$Model->{$mediaModel}->invalidate('media', 'notBlank');
							$Model->invalidate('media', 'notBlank');
						}
					}
				}
			}
		}

		return true;
	}
/**
 * Runs before a save() operation
 *
 * @param Model $Model	Model using the behavior
 * @param array $options Options parameters as set by cake
 * @return boolean True if the operation should continue, false if it should abort
 */
	public function beforeSave(Model $Model, $options = array()) {
		if ($Model->name == 'Media') {
			if (!empty($Model->data[$Model->alias]['media'])) {
				$media = $Model->addMedia($Model->data[$Model->alias]);

				if (!empty($media)) {
					App::import('Model', array($media['model']));
					$RelatedModel = new $media['model']();
					$settings = $RelatedModel->getMediaSettings($media['collection']);

					if(!empty($Model->data[$Model->alias]['created'])) {
						$media['created'] = $Model->data[$Model->alias]['created'];
					}

					if(!empty($Model->data[$Model->alias]['modified'])) {
						$media['modified'] = $Model->data[$Model->alias]['modified'];
					}

					if (!empty($Model->data[$Model->alias]['previous_id'])) {
						$previousMedia = $Model->find('first', [
							'contain' => false,
							'conditions' => [$Model->alias . '.id' => $Model->data[$Model->alias]['previous_id']]
						]);
					} else if (empty($settings['multiple']) && !empty($media['foreign_key'])) {
						$previousMedia = $Model->find('first', [
							'contain' => false,
							'conditions' => [
								$Model->alias . '.model' => $media['model'],
								$Model->alias . '.collection' => $media['collection'],
								$Model->alias . '.foreign_key' => $media['foreign_key']
							]
						]);
					}

					$Model->data[$Model->alias] = $media;

					if (!empty($previousMedia)) {
						if ($previousMedia[$Model->alias]['name'] != $previousMedia[$Model->alias]['source']) {
							$Model->data[$Model->alias]['name'] = $previousMedia[$Model->alias]['name'];
						}

						$Model->data[$Model->alias]['title'] = $previousMedia[$Model->alias]['title'];
						$Model->data[$Model->alias]['subtitle'] = $previousMedia[$Model->alias]['subtitle'];
						$Model->data[$Model->alias]['alt'] = $previousMedia[$Model->alias]['alt'];
						$Model->data[$Model->alias]['extra'] = $previousMedia[$Model->alias]['extra'];
						$Model->data[$Model->alias]['order'] = $previousMedia[$Model->alias]['order'];
						$Model->data[$Model->alias]['main'] = $previousMedia[$Model->alias]['main'];
						$Model->data[$Model->alias]['shared'] = $previousMedia[$Model->alias]['shared'];
						$Model->data[$Model->alias]['share_key'] = $previousMedia[$Model->alias]['share_key'];

						$Model->previousId = $previousMedia[$Model->alias]['id'];
					}
				} else {
					return false;
				}
			}
		}

		return true;
	}
/**
 * Runs after a save() operation
 *
 * @param Model $Model	Model using the behavior
 * @param boolean $cascade If true records that depend on this record will also be deleted
 * @param array $options Options parameters as set by cake
 * @return boolean True if the operation should continue, false if it should abort
 */
	public function afterSave(Model $Model, $created, $options = []) {
		if ($Model->name == 'Media') {
			if ($created) {
				$media = $Model->data;

				App::import('Model', array($media[$Model->alias]['model']));
				$RelatedModel = new $media[$Model->alias]['model']();

				$settings = $RelatedModel->getMediaSettings($media[$Model->alias]['collection']);

				$newModelId = $Model->id;

				if (!empty($Model->previousId)) {
					$Model->MediaLink->updateAll(
						['MediaLink.media_id' => $newModelId],
						['MediaLink.media_id' => $Model->previousId]
					);
				}

				if (empty($settings['multiple'])) {
					$Model->deleteAll(
						array(
							$Model->alias . '.id <>' => $newModelId,
							$Model->alias . '.model' => $media[$Model->alias]['model'],
							$Model->alias . '.collection' => $media[$Model->alias]['collection'],
							$Model->alias . '.foreign_key' => $media[$Model->alias]['foreign_key']
						),
						true,
						true
					);
				} else if (!empty($Model->previousId)) {
					$Model->delete($Model->previousId);
				}

				$Model->id = $newModelId;
			}
		}
	}
/**
 * Runs before a delete() operation
 *
 * @param Model $Model	Model using the behavior
 * @param boolean $cascade If true records that depend on this record will also be deleted
 * @return boolean True if the operation should continue, false if it should abort
 */
	public function beforeDelete(Model $Model, $cascade = true) {
		if ($Model->name == 'Media') {
			$media = $Model->find('first', array(
				'contain' => false,
				'conditions' => array($Model->alias . '.id' => $Model->id)
			));

			if (!empty($media[$Model->alias]['is_file'])) {
				$this->deleteMediaFile($media[$Model->alias]);
			}
		}

		return true;
	}
/**
 * Runs after a find() operation
 *
 * @param Model $Model	Model using the behavior
 * @param mixed $results The results of the find operation
 * @param bool $primary Whether this model is being queried directly (vs. being queried as an association)
 * @return mixed Result of the find operation
 */
	public function afterFind(Model $Model, $results, $primary = false) {
		if ($Model->name == 'Media') {
			$settings = [];

			foreach ($results as $key => $result) {
				if (!empty($result[$Model->alias])) {
					if (!empty($result[$Model->alias]['model']) && empty($settings[$result[$Model->alias]['model']])) {
						App::import('Model', array($result[$Model->alias]['model']));
						$RelatedModel = new $result[$Model->alias]['model']();

						$settings[$result[$Model->alias]['model']] = $RelatedModel->getMediaConfig();
					}

					if (!empty($result[$Model->alias]['collection']) && !empty($settings[$result[$Model->alias]['model']][$result[$Model->alias]['collection']])) {
						$extras = empty($result[$Model->alias]['extra']) ? [] : json_decode($result[$Model->alias]['extra'], true);

						if (!empty($extras)) {
							foreach ($extras as $attributeKey => $value) {
								$results[$key][$Model->alias][$attributeKey] = $value;
							}
						}
					}
				}
			}
		} else {
			$settings = [];

			foreach ($results as $key => $result) {
				if (empty($settings[$Model->alias])) {
					$settings[$Model->alias] = $Model->getMediaConfig();
				}

				if (!empty($settings[$Model->alias])) {
					foreach ($settings[$Model->alias] as $collection) {
						if (!empty($result[$collection['mediaField']]) && !empty($settings[$Model->alias][$collection['mediaCollection']])) {

							$isArray = !is_string(key($result[$collection['mediaField']]));

							$setResults = $isArray ? $result[$collection['mediaField']] : [$result[$collection['mediaField']]];


							foreach ($setResults as $resultKey => $setResult) {
								// Spread all extra JSON fields unconditionally
								if (!empty($setResult['extra'])) {
									$allExtras = json_decode($setResult['extra'], true);
									if (is_array($allExtras)) {
										foreach ($allExtras as $extraKey => $extraValue) {
											if ($isArray) {
												$results[$key][$collection['mediaField']][$resultKey][$extraKey] = $extraValue;
											} else {
												$results[$key][$collection['mediaField']][$extraKey] = $extraValue;
											}
										}
									}
								}

								if (!empty($settings[$Model->alias][$collection['mediaCollection']]['mediaAttributes'][$setResult['type']]['fields'])) {
									$attributes = $settings[$Model->alias][$collection['mediaCollection']]['mediaAttributes'][$setResult['type']]['fields'];

									$extras = empty($setResult['extra']) ? [] : json_decode($setResult['extra'], true);

									foreach ($attributes as $attribute => $attributeDesc) {
										if (!isset($setResult[$attribute])) {
											$attributeValue = !empty($extras[$attribute]) ? $extras[$attribute] : null;
											if ($isArray) {
												$results[$key][$collection['mediaField']][$resultKey][$attribute] = $attributeValue;
											} else {
												$results[$key][$collection['mediaField']][$attribute] = $attributeValue;
											}
										}
									}

								}
							}
						}

					}
				}
			}
		}

		return $results;
	}
}
?>
