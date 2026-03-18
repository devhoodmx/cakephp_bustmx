<?php
App::uses('AppModel', 'Model');

class WebPage extends AppModel {
	public $name = 'WebPage';

	public $actsAs = array(
		'Containable',
		'Loggable'
	);

	public $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' 		=> 'notBlank'
			)
		)
	);

	public $belongsTo = array(
		'SharedContent' => array(
			'className'		=> 'WebPage',
			'foreignKey' 	=> 'shared_page_id'
		),
		'User'
	);

	public $hasMany = array(
		'WebPageTranslation' => array(
			'className' => 'WebPageTranslation',
			'foreignKey' => 'web_page_id',
			'dependent' => true
		),
		'MenuItem' => array(
			'className' => 'MenuItem',
			'foreignKey' => 'web_page_id',
			'dependent' => true
		)
	);

	public $hasOne = array(
		'Es' => array(
			'className' => 'WebPageTranslation',
			'foreignKey' => 'web_page_id',
			'conditions' => array('Es.language' => 'es'),
			'dependent' => true
		),
		'En' => array(
			'className' => 'WebPageTranslation',
			'foreignKey' => 'web_page_id',
			'conditions' => array('En.language' => 'en'),
			'dependent' => true
		)
	);

    public function uniqueKey($check) {
		$value = reset($check);
		$key = key($check);
		$conditions = array(
			'OR' => array(
				$this->alias . '.es_key' => $value,
				$this->alias . '.en_key' => $value
			)
		);

		$page = $this->find('first', array(
            'conditions' => $conditions,
            'contain' => false
		));
		if (empty($page)) {
			return true;
		}

		if ($this->id && $page['WebPage']['id'] == $this->id && $page['WebPage'][$key] == $value) {
			return true;
		}

        return false;
    }

	public function beforeSave($options = []) {
		if (!empty($this->data)) {
			$menu = array();
			$locales = Configure::read('App.webpages.locale.options');

			if (!empty($this->data['WebPage']['es_name'])) {
				$this->data['WebPage']['name'] = $this->data['WebPage']['es_name'];
			}

			foreach ($locales as $locale) {
				if (!empty($this->data['WebPage'][$locale . '_name'])) {
					$menu[sprintf('MenuItem.%s_name', $locale)] = sprintf('"%s"', $this->data['WebPage'][$locale . '_name']);
				}
			}

			if (empty($this->id)) {
				$this->data['WebPage']['user_id'] = AuthComponent::user('id');;
			} else {
				if (!empty($menu)) {
					$this->MenuItem->updateAll(
						$menu,
						array('MenuItem.web_page_id' => $this->id)
					);
				}
			}
		}

		return true;
	}

	public function afterSave($created, $options = []) {
		if (!empty($this->id)) {
			// Saving webpage translations
			$data = array();
			$locales = Configure::read('App.webpages.locale.options');
			$translations = $this->WebPageTranslation->find('all', array(
				'conditions' => array('WebPageTranslation.web_page_id' => $this->id),
				'contain' => false
			));

			foreach ($locales as $locale) {
				if (!empty($this->data['WebPage'][$locale . '_name'])) {
					$data[$locale] = array(
						'WebPageTranslation' => array(
							'name' => $this->data['WebPage'][$locale . '_name'],
							'language' => $locale,
							'web_page_id' => $this->id
						)
					);
				}
			}

			if ($translations) {
				foreach ($translations as $key => $translation) {
					$data[$translation['WebPageTranslation']['language']]['WebPageTranslation']['id'] = $translation['WebPageTranslation']['id'];
				}
			}

			if (!empty($data)) {
				$this->WebPageTranslation->saveMany($data);
			}
		}

		return true;
	}
}
?>
