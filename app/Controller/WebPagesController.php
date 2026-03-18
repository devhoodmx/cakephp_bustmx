<?php
App::uses('AppController', 'Controller');

class WebPagesController extends AppController {

	protected $elements = array('Text', 'MediaImage', 'MediaArchive', 'Video', 'Code', 'Map');

	public function beforeFilter() {
		parent::beforeFilter();

		$this->currentLocale = Configure::read('App.webpages.locale.default');

		if (!empty($this->request->query['lang'])) {
			if (!in_array($this->request->query['lang'], Configure::read('App.webpages.locale.options'))) {
				throw new BadRequestException();
			}

			$this->currentLocale = $this->request->query['lang'];
		}

		$this->currentLocaleModel = Inflector::camelize($this->currentLocale);

		// Add model validations
		if (in_array($this->action, array('admin_add', 'admin_edit')) && $this->request->is(array('post', 'put'))) {
			$this->WebPage->validator()
				->add(
					$this->currentLocale . '_name',
					array(
						'notBlank' => array(
							'rule' 		=> 'notBlank'
						)
					)
				)
				->add(
					$this->currentLocale . '_key',
					array(
						'uniqueRoute' => array(
							'rule' => array('uniqueKey')
						),
						'routeChars' => array(
							'rule' => array('custom', '#^[/\-a-z0-9]*$#')
						)
					)
				);
		}

		$this->set(array(
			'currentLocale' => $this->currentLocale,
			'currentLocaleModel' => $this->currentLocaleModel,
			'components' => array(
				'search' => true
			)
		));
	}

	public function admin_index() {
		$conditions = array();

		if (!empty($this->params->query['q'])) {
			$q = trim($this->params->query['q']);
			$conditions = array(
				'OR' => array(
					'Es.name LIKE' => '%' . $q . '%',
					'En.name LIKE' => '%' . $q . '%',
					'WebPage.es_key LIKE' => '%' . $q . '%',
					'WebPage.en_key LIKE' => '%' . $q . '%'
				)
			);
		}

		$this->Paginator->settings = [
			'conditions' => $conditions,
			'contain' => ['User', 'Es', 'En'],
			'order' => ['WebPage.name' => 'ASC'],
			'limit' => 50
		];

		$pages = $this->Paginator->paginate();

		$this->set(compact('pages'));
	}

	public function admin_add() {
		parent::admin_add();

		$this->view = 'admin_add';
	}

	public function admin_edit($id = null, $name = null) {
		$query = array(
			'conditions' => array('WebPage.id' => $id),
			'contain' => array('Es', 'En')
		);
		$webPage = $this->WebPage->find('first', $query);

		if (empty($webPage)) {
			throw new NotFoundException();
		}

		if ($this->request->is(array('post', 'put')) && !empty($this->request->data)) {
			$this->request->data['WebPage']['id'] = $id;

			if ($this->WebPage->saveAll($this->request->data, array('validate' => 'first'))) {
				$webPage = $this->WebPage->find('first', $query);

				$this->Flash->success(Utility::translate('save-notification', 'web_page', null, $webPage[$this->currentLocaleModel]['name']));

				$this->redirect(array(
					'action' => 'view',
					$id,
					Utility::slug($webPage['WebPage']['name']),
					'?' => array('lang' => $this->currentLocale)
				));
			}
		} else {
			$this->request->data = $webPage;
			$this->request->data['WebPage'][$this->currentLocale . '_name'] = $webPage[$this->currentLocaleModel]['name'];
		}

		$this->set(compact('webPage'));
		$this->set(Utility::config('web_pages', 'vars'));
	}

	public function admin_view($id = null, $name = null) {
		$page = $this->WebPage->find('first', array(
			'conditions' => array('WebPage.id' => $id),
			'contain' => array(
				'Es' => array(
					'WebPageSection' => array(
						'MediaBackground',
						'Column1' => $this->elements,
						'Column2' => $this->elements,
						'Column3' => $this->elements,
						'Column4' => $this->elements
					)
				),
				'En' => array(
					'WebPageSection' => array(
						'MediaBackground',
						'Column1' => $this->elements,
						'Column2' => $this->elements,
						'Column3' => $this->elements,
						'Column4' => $this->elements
					)
				)
			)
		));

		if (empty($page)) {
			throw new NotFoundException();
		}

		if (empty($page[Inflector::camelize($this->currentLocale)]['id'])) {
			return $this->redirect(
				array(
					'action' => 'edit',
					$page['WebPage']['id'],
					Utility::slug($page['WebPage']['name']),
					'?' => array('lang' => $this->currentLocale)
				)
			);
		}

		$this->set(compact('page'));
	}

	public function admin_duplicate($id = null, $name = null, $from = null) {
		$page = $this->WebPage->find('first', array(
			'conditions' => array('WebPage.id' => $id),
			'contain' => array(
				'Es' => array(
					'WebPageSection'
				),
				'En' => array(
					'WebPageSection'
				)
			)
		));
		$pageLocales = Configure::read('App.webpages.locale.options');

		if (empty($page)) {
			throw new NotFoundException();
		}

		$start = time();
		$newPage = array(
			'WebPage' => array(
				'es_name' => sprintf('%s (%s)', $page['Es']['name'], date('Y-m-d H:i:s', $start)),
				'es_key' => sprintf('%s-%s', $page['WebPage']['es_key'], date('Ymd-His', $start)),
				'es_meta_tags' => $page['WebPage']['es_meta_tags'],
				'shared_page_id' => $page['WebPage']['shared_page_id'],
				'active' => $page['WebPage']['active'],
			)
		);
		if (!empty($page['En']['id'])) {
			$newPage['WebPage']['en_name'] = sprintf('%s (%s)', $page['En']['name'], date('Y-m-d H:i:s', $start));
			$newPage['WebPage']['en_key'] = sprintf('%s-%s', $page['WebPage']['en_key'], date('Ymd-His', $start));
			$newPage['WebPage']['en_meta_tags'] = $page['WebPage']['en_meta_tags'];
		}

		if ($this->WebPage->save($newPage)) {
			$newPage = $this->WebPage->find('first', array(
				'conditions' => array('WebPage.id' => $this->WebPage->id),
				'contain' => array('Es', 'En')
			));

			$sections = array();

			foreach ($pageLocales as $pageLocale) {
				$pageLocaleModel = Inflector::camelize($pageLocale);

				if (!empty($page[$pageLocaleModel]['WebPageSection'])) {
					foreach ($page[$pageLocaleModel]['WebPageSection'] as $key => $value) {
						$sections[] = array(
							'WebPageSection' => array(
								'name' => $value['name'],
								'layout' => $value['layout'],
								'columns' => $value['columns'],
								'wrap' => $value['wrap'],
								'styles' => $value['styles'],
								'web_page_translation_id' => $newPage[$pageLocaleModel]['id']
							)
						);
					}
				}
			}

			if (!empty($sections)) {
				if ($this->WebPage->WebPageTranslation->WebPageSection->saveMany($sections)) {
					$this->Flash->success('Duplicado generado como <strong>' . $newPage['WebPage']['name'] . '</strong>');
				} else {
					$this->Flash->danger('Ocurrió un error al guardar las secciones de la página duplicada');
				}
			}
		} else {
			$this->Flash->danger('Ocurrió un error al duplicar la página');
		}

		if ($from != 'view') {
			$this->redirect(array('action' => 'index'));
		} else {
			$this->redirect(array('action' => 'view', $newPage['WebPage']['id']));
		}
	}

	public function view($id = '') {
		$args = $this->passedArgs;
		$navItemKey = null;
		$conditions = array('WebPage.active' => true);

		// Normalize id
		if (sizeof($args) > 1) {
			if ($args[0] == 'web_pages') {
				unset($args[0]);
				unset($args[1]);
			}
			$id = implode('/', $args);
		}

		// Admin users can see nonpublic pages
		if ($this->Auth->user()) {
			$conditions = array();
		}

		if (is_numeric($id)) {
			$conditions['WebPage.id'] = $id;
		} else {
			// A web page path/route sets the locale
			$conditions['OR'] = array('WebPage.es_key' => $id, 'WebPage.en_key' => $id);
			$page = $this->WebPage->find('first', array('conditions' => $conditions, 'contain' => false));
			$locales = Configure::read('App.webpages.locale.options');

			if (!$page) {
				throw new NotFoundException(__('La página que estás buscando no existe.'));
			}

			foreach ($locales as $key => $locale) {
				if (isset($page['WebPage'][$locale . '_key']) && $page['WebPage'][$locale . '_key'] === $id) {
					$this->locale = $locale;
					Configure::write('Config.language', $this->locale);

					break;
				}
			}
		}

		// Find localized page
		$localeModel = Inflector::camelize($this->locale);
		$page = $this->WebPage->find('first', array(
			'conditions' => $conditions,
			'contain' => array(
				$localeModel => array(
					'WebPageSection' => array(
						'MediaBackground',
						'Column1' => $this->elements,
						'Column2' => $this->elements,
						'Column3' => $this->elements,
						'Column4' => $this->elements
					)
				)
			)
		));

		// Translations
		$pretty = Configure::read('App.webpages.pretty-urls');
		$pageLocales = [];

		foreach ($locales as $key => $locale) {
			if (!empty($page['WebPage'][$locale . '_key'])) {
				$url = Router::url(array('controller' => 'web_pages', 'action' => 'view', 'client' => false, 'admin' => false), true);

				if (!$pretty) {
					$url .= '/';
				}

				$url .= $page['WebPage'][$locale . '_key'];

				$pageLocales[$locale] = [
					'url' => $url
				];
			}
		}

		if (!$page || empty($page[$localeModel]['id'])) {
			throw new NotFoundException(__('La página que estás buscando no existe.'));
		}

		$this->loadModel('MenuItem');
		$navItemKey = $this->MenuItem->field('id', array('MenuItem.web_page_id' => $page['WebPage']['id']));

		$this->set(compact('page', 'pageLocales', 'localeModel', 'navItemKey'));
		$this->set('locale', $this->locale);
	}
}
?>
