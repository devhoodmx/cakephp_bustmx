<?php
App::uses('AppController', 'Controller');

class WebPageSectionsController extends AppController {

	public $uses = array('WebPageSection', 'WebPageTranslation');

	public function admin_add($id = null, $layout = null, $before = null) {
		$page = $this->WebPageTranslation->find('first', array(
			'conditions' => array('WebPageTranslation.id' => $id),
			'contain' => array('WebPage')
		));

		if ($page) {
			$layoutDescription = Configure::read('Layout');

			$this->data = array(
				'WebPageSection' => array(
					'layout' => $layout,
					'web_page_translation_id' => $id,
					'columns' => $layoutDescription['Columns'][$layout]['columns']
				)
			);

			if (!empty($before)) {
				$section = $this->WebPageSection->find('first', array(
					'conditions' => array('WebPageSection.id' => $before),
					'contain' => false
				));

				if(!$section) {
					$this->redirect(array(
						'controller' => 'web_pages',
						'action' => 'view',
						$id
					));
				}

				$count = $this->WebPageSection->find('count', array(
					'conditions' => array('WebPageSection.order >=' => $section['WebPageSection']['order']),
					'contain' => false
				));
			}

			$this->WebPageSection->id = null;
			if ($this->WebPageSection->save($this->data)) {
				$this->Flash->success(__('👍', true));

				if (!empty($before)) {
					$this->WebPageSection->move($this->WebPageSection->id, $section['WebPageSection']['id']);
				}
			}

			$this->redirect(array(
				'controller' => 'web_pages',
				'action' => 'view',
				$page['WebPage']['id'],
				Utility::slug($page['WebPage']['name']),
				'?' => array('lang' => $page['WebPageTranslation']['language']),
				'#' => 'webpage-section-' . $this->WebPageSection->id
			));

		} else {
			$this->redirect(array('controller' => 'web_pages', 'action' => 'index'));
		}
	}

	public function admin_edit($id = null, $name = null) {
		$section = $this->WebPageSection->find('first', array(
			'conditions' => array('WebPageSection.id' => $id),
			'contain' => array('Media', 'WebPageTranslation' => array('WebPage'))
		));

		if (empty($section)) {
			throw new NotFoundException();
		}

		if ($this->request->is(array('post', 'put')) && !empty($this->request->data)) {
			$this->request->data['WebPageSection']['id'] = $id;

			if ($this->WebPageSection->saveAll($this->request->data, array('validate' => 'first'))) {
				$this->Flash->success(__('👍'));

				$this->redirect(array(
					'controller' => 'web_pages',
					'action' => 'view',
					$section['WebPageTranslation']['web_page_id'],
					Utility::slug($section['WebPageTranslation']['WebPage']['name']),
					'?' => array('lang' => $section['WebPageTranslation']['language']),
					'#' => 'webpage-section-' . $section['WebPageSection']['id']
				));
			}
		} else {
			$this->request->data = $section;
		}

		$this->set(array(
			'mediaConfig' => $this->WebPageSection->getMediaConfig(),
			'webPageSection' => $section
		));
	}

	public function admin_delete($id = null) {
		$section = $this->WebPageSection->find('first', array(
			'conditions' => array('WebPageSection.id' => $id),
			'contain' => array('WebPageTranslation' => array('WebPage'))
		));
		parent::admin_delete($id);
		$this->redirect(array(
			'controller' => 'web_pages',
			'action' => 'view',
			$section['WebPageTranslation']['web_page_id'],
			Utility::slug($section['WebPageTranslation']['WebPage']['name']),
			'?' => array('lang' => $section['WebPageTranslation']['language'])
		));
	}
}
?>
