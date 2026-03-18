<?php
App::uses('AppModel', 'Model');

class MenuItem extends AppModel {
	public $name = 'MenuItem';

	public $actsAs = array(
		'Tree',
		'Containable'
	);

	public $catalogues = array(
		'sections' => array(
			// 'articles/index' => 'Noticias/News'
		)
	);

	public $displayField = 'es_name';

	public $belongsTo = array(
		'ParentItem' => array(
			'className' 	=> 'MenuItem',
			'foreignKey' 	=> 'parent_id'
		),
		'WebPage' => array(
			'className'		=> 'WebPage',
			'foreignKey'	=> 'web_page_id'
		),
		'Website'
	);

	public function __construct($id = false, $table = null, $ds = null) {
		$positions = array('main', 'header', 'footer');
		$types = array('internal', 'external', 'header');

		parent::__construct($id, $table, $ds);

		foreach ($positions as $value) {
			$this->catalogues['positions'][$value] = __d('menu_item', 'position-' . Utility::slug($value));
		}
		foreach ($types as $value) {
			$this->catalogues['types'][$value] = __d('menu_item', 'type-' . Utility::slug($value));
		}

		$this->validator()
			->add(
				'type',
				array(
					'inList' => array(
						'rule' => array('inList', array_keys($this->catalogues['types']))
					)
				)
			);
	}

	public function isInternal($check) {
		$value = reset($check);
		$key = key($check);
		$valid = false;

		if (is_numeric($value)) {
			$page = $this->WebPage->find('first', array(
				'conditions' => array('WebPage.id' => $value),
				'contain' => false
			));

			$valid = !empty($page);
		} else {
			$valid = isset($this->catalogues['sections'][$value]);
		}

        return $valid;
    }

	public function beforeSave($options = []) {
		if (!empty($this->data)) {
			if (isset($this->data['MenuItem']['type'])) {
				$type = $this->data['MenuItem']['type'];
				$data = array(
					'es_url' => null,
					'controller' => null,
					'action' => null,
					'webpage_id' => null,
					'internal_id' => null
				);

				if ($type == 'internal') {
					if (is_numeric($this->data['MenuItem']['internal_id'])) {
						$this->WebPage->Behaviors->detach('Sortable');
						$page = $this->WebPage->find('first', array(
							'conditions' => array('WebPage.id' => $this->data['MenuItem']['internal_id']),
							'contain' => array(
								'Es' => array('fields' => array('Es.name')),
								'En' => array('fields' => array('En.name'))
							)
						));

						$data['es_name'] = $page['Es']['name'];
						$data['controller'] = 'web_pages';
						$data['action'] = 'view';
						$data['web_page_id'] = $this->data['MenuItem']['internal_id'];
					} else {
						// Parse URL
						$splited = explode('/', $this->data['MenuItem']['internal_id']);
						$splittedName = explode('/', $this->catalogues['sections'][$this->data['MenuItem']['internal_id']]);

						$data['es_name'] = $splittedName[0];
						$data['controller'] = $splited[0];
						$data['action'] = isset($splited[1]) ? $splited[1] : 'index';
					}

					$data['internal_id'] = $this->data['MenuItem']['internal_id'];
				} elseif ($type == 'external') {
					$data['es_url'] = $this->data['MenuItem']['es_url'];
				}

				$this->data['MenuItem'] = array_merge($this->data['MenuItem'], $data);
			}
			if (isset($this->data['MenuItem']['_target'])) {
				$this->data['MenuItem']['target'] = $this->data['MenuItem']['_target'] ? '_blank' : null;
			}

			if (empty($this->id)) {
				$order = 0;
				$last = $this->find('first', array(
					'conditions' => array(
						'MenuItem.parent_id' => $this->data['MenuItem']['parent_id'],
						'MenuItem.position' => $this->data['MenuItem']['position'],
						'MenuItem.website_id' => $this->data['MenuItem']['website_id']
					),
					'order' => array('MenuItem.order' => 'DESC'),
					'contain' => false
				));

				if (!empty($last)) {
					$order = $last['MenuItem']['order'] +  1;
				}

				$this->data['MenuItem']['order'] = $order;
			} else {
				if (isset($this->data['MenuItem']['order'])) {
					$menuItem = $this->find('first', array(
						'conditions' => array('MenuItem.id' => $this->id),
						'contain' => false
					));
					$conditions = array(
						'MenuItem.parent_id' => $menuItem['MenuItem']['parent_id'],
						'MenuItem.position' => $menuItem['MenuItem']['position'],
						'MenuItem.website_id' => $menuItem['MenuItem']['website_id']
					);
					$from = $menuItem['MenuItem']['order'];
					$to = $this->data['MenuItem']['order'];

					if ($from > $to) {
						// Move down
						$conditions['MenuItem.order >='] = $to;
						$this->updateAll(
							array('MenuItem.order' =>  'MenuItem.order + 1'),
							$conditions
						);
					} elseif ($to > $from) {
						// Move up
						$conditions['MenuItem.order <='] = $to;
						$this->updateAll(
							array('MenuItem.order' =>  'MenuItem.order - 1'),
							$conditions
						);
					}
				}
			}
		}

		return true;
	}

	public function beforeDelete($cascade = true) {
		$menuItem = $this->find('first', array(
			'conditions' => array($this->alias . '.id' => $this->id),
			'contain' => false
		));

		$this->updateAll(
			array($this->alias . '.order' =>  $this->alias . '.order - 1'),
			array(
				$this->alias . '.parent_id' => $menuItem[$this->alias]['parent_id'],
				$this->alias . '.position' => $menuItem[$this->alias]['position'],
				$this->alias . '.website_id' => $menuItem[$this->alias]['website_id'],
				$this->alias . '.order >' => $menuItem[$this->alias]['order']
			)
		);

		return true;
	}
}
?>
