<?php
App::uses('AppController', 'Controller');
class ArchivesController extends AppController {

	public function admin_add($webPageElementId = null) {
		$this->loadModel('WebPageElement');
		$element = $this->WebPageElement->find('first', array(
			'conditions' => array('WebPageElement.id' => $webPageElementId),
			'contain' => array('MediaArchive', 'WebPageSection' => array('WebPageTranslation' => array('WebPage')))
		));

		if (!$element) {
			$this->redirect(array('controller' => 'web_pages', 'action' => 'index'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			$this->WebPageElement->save($this->request->data);
			$this->Flash->success(__('👍'));
			$this->redirect(array(
				'controller' => 'web_pages',
				'action' => 'view',
				$element['WebPageSection']['WebPageTranslation']['web_page_id'],
				Utility::slug($element['WebPageSection']['WebPageTranslation']['WebPage']['name']),
				'?' => array('lang' => $element['WebPageSection']['WebPageTranslation']['language'])
			));
		}
		if (!$this->request->data) {
			$this->request->data = $element;
		}

		$this->set(array(
			'webPageElement' => $element,
			'mediaConfig' => $this->WebPageElement->getMediaConfig(),
			'referer' => $this->referer()
		));
	}
}
?>
