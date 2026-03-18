<?php
App::uses('AppController', 'Controller');

class WebPageElementsController extends AppController {

	public function admin_add($id = null, $column = null, $type = null, $before = null) {
		if ($id == null || $column == null || $type == null) {
			$this->redirect(array('controller' => 'web_pages', 'action' => 'index'));
		}

		$section = $this->WebPageElement->WebPageSection->find('first', array(
			'conditions' => array('WebPageSection.id' => $id),
			'contain' => array('WebPageTranslation')
		));

		if ($section &&
			$column <= $section['WebPageSection']['columns'] &&
			(isset($this->WebPageElement->hasOne[$type]) || in_array($type, array('Image', 'Archive', 'Contact', 'Login', 'Map')))
		) {
			$this->data = array(
				'WebPageElement' => array(
					'column' => $column,
					'web_page_section_id' => $id,
					'type' => $type
				)
			);

			if (!empty($before)) {
				$element = $this->WebPageElement->find('first', array(
					'conditions' => array('WebPageElement.id' => $before),
					'contain' => false
				));
				if(!$element) {
					$this->redirect(array(
						'controller' => 'web_pages',
						'action' => 'view',
						$section['WebPageSection']['web_page_id'],
						'#' => 'webpage-section-' . $id
					));
				}
			}

			$this->WebPageElement->id = null;
			if ($this->WebPageElement->save($this->data)){
				if (!empty($before)) {
					$this->WebPageElement->move($this->WebPageElement->id, $element['WebPageElement']['id']);
				}
				if (in_array($type, array('Contact', 'Login'))) {
					$this->redirect(array(
						'controller' => 'web_pages',
						'action' => 'view',
						$section['WebPageSection']['web_page_id'],
						'#' => 'webpage-element-' . $this->WebPageElement->id
					));
				} elseif (in_array($type, array('Map'))) {
					$this->redirect(array(
						'controller' => Inflector::tableize(sprintf('WebPage' . $type)),
						'action' => 'add',
						$this->WebPageElement->id
					));
				} else {
					$this->redirect(array(
						'controller' => Inflector::tableize($type),
						'action' => 'add',
						$this->WebPageElement->id,
						'WebPageElement'
					));
				}
			} else {
				$this->redirect(array(
					'controller' => 'web_pages',
					'action' => 'view',
					$section['WebPageSection']['web_page_id'],
					'#' => 'webpage-section-' . $id
				));
			}
		} else {
			$this->redirect(array('controller' => 'web_pages', 'action' => 'index'));
		}
	}

	public function admin_view($id) {
		$element = $this->WebPageElement->find('first', array(
			'conditions' => array('WebPageElement.id' => $id),
			'contain' => array('WebPageSection' => array('WebPageTranslation' => array('WebPage')), 'Text', 'Video', 'Code')
		));

		if ($element) {
			if (
				!in_array($element['WebPageElement']['type'], array('Contact', 'Login', 'Map', 'Image')) &&
				empty($element[$element['WebPageElement']['type']]['id'])
			) {
					$this->WebPageElement->delete($id);
			}

			$this->redirect(array(
				'controller' => 'web_pages',
				'action' => 'view',
				$element['WebPageSection']['WebPageTranslation']['web_page_id'],
				Utility::slug($element['WebPageSection']['WebPageTranslation']['WebPage']['name']),
				'?' => array('lang' => $element['WebPageSection']['WebPageTranslation']['language']),
				'#' => 'webpage-element-' . $element['WebPageElement']['id']
			));
		} else {
			$this->redirect(array('controller' => 'web_pages', 'action' => 'index'));
		}
	}

	public function admin_delete($id = null) {
		$element = $this->WebPageElement->find('first', array(
			'conditions' => array('WebPageElement.id' => $id),
			'contain' => array('WebPageSection' => array('WebPageTranslation' => array('WebPage')))
		));

		parent::admin_delete($id);

		if (!empty($element['WebPageSection']['WebPageTranslation']['WebPage'])) {
			$this->redirect(array(
				'controller' => 'web_pages',
				'action' => 'view',
				$element['WebPageSection']['WebPageTranslation']['web_page_id'],
				Utility::slug($element['WebPageSection']['WebPageTranslation']['WebPage']['name']),
				'?' => array('lang' => $element['WebPageSection']['WebPageTranslation']['language'])
			));
		}
	}
}
?>
