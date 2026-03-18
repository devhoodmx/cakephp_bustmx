<?php
App::uses('AppController', 'Controller');

class WebPageMapsController extends AppController {

	public function admin_add($webPageElementId = null) {
		$element = $this->WebPageMap->WebPageElement->find('first', array(
			'conditions' => array('WebPageElement.id' => $webPageElementId),
			'contain' => array('WebPageSection' => array('WebPageTranslation' => array('WebPage')))
		));

		if (empty($element)) {
			throw new NotFoundException();
		}

		if ($this->request->is('post') && !empty($this->request->data)) {
			$this->request->data['WebPageMap']['web_page_element_id'] = $element['WebPageElement']['id'];

			$this->WebPageMap->set($this->request->data);

			if ($this->WebPageMap->saveAll($this->request->data, array('validate' => 'first'))) {
				$map = $this->WebPageMap->find('first', array(
					'conditions' => array('WebPageMap.id' => $this->WebPageMap->id)
				));

				$this->Flash->success(Utility::translate('save-notification', 'menu_item', null, __('El mapa')));

				$this->redirect(array(
					'controller' => 'web_pages',
					'action' => 'view',
					$element['WebPageSection']['WebPageTranslation']['web_page_id'],
					Utility::slug($element['WebPageSection']['WebPageTranslation']['WebPage']['name']),
					'?' => array('lang' => $element['WebPageSection']['WebPageTranslation']['language'])
				));
			}
		}

		$this->set('referer', $this->referer());
	}

	public function admin_edit($id = null, $name = null) {
		$map = $this->WebPageMap->find('first', array(
			'conditions' => array('WebPageMap.id' => $id),
			'contain' => false
		));

		if (empty($map)) {
			throw new NotFoundException();
		}

		if ($this->request->is(array('post', 'put')) && !empty($this->request->data)) {
			$this->request->data['WebPageMap']['id'] = $id;

			if ($this->WebPageMap->saveAll($this->request->data, array('validate' => 'first'))) {
				$element = $this->WebPageMap->WebPageElement->find('first', array(
					'conditions' => array('WebPageElement.id' => $map['WebPageMap']['web_page_element_id']),
					'contain' => array('WebPageSection' => array('WebPageTranslation' => array('WebPage')))
				));

				$this->Flash->success(Utility::translate('save-notification', 'menu_item', null, __('El mapa')));

				$this->redirect(array(
					'controller' => 'web_pages',
					'action' => 'view',
					$element['WebPageSection']['WebPageTranslation']['web_page_id'],
					Utility::slug($element['WebPageSection']['WebPageTranslation']['WebPage']['name']),
					'?' => array('lang' => $element['WebPageSection']['WebPageTranslation']['language'])
				));
			}
		} else {
			$this->request->data = $map;
		}

		$this->set('webPageMap', $map);
		$this->set('referer', $this->referer());
	}
}
?>
