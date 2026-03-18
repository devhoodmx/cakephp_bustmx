<?php
App::uses('AppController', 'Controller');
 
class TextsController extends AppController {
	
	public function admin_add($id = null, $model = null) {
		$this->loadModel($model);
		$mod = $this->{$model}->find('first', array(
			'conditions' => array($model . '.id' => $id), 
			'contain' => false
		));

		if ($mod) {
			$this->set('model', $model);
			$this->set('model_id', $id);
			
			$this->Text->create();
			$this->Text->set($this->request->data);
			
			if (!empty($this->request->data)) {
				$this->request->data['Text']['model'] = $model;
				$this->request->data['Text']['foreign_key'] = $id;
				if ($this->Text->save($this->request->data)){
					$this->Flash->success(__('El texto ha sido creado', true));					
					$this->redirect(array('controller' => Inflector::tableize($model), 'action' => 'view', $id));	
				}
			}
		} else {
			$this->redirect(array('controller' => 'pages', 'action' => 'home'));				
		}

		$this->set('referer', $this->referer());
	}
	
	public function admin_edit($id = null, $name = null) {
		$text = $this->Text->find('first', array(
			'conditions' => array('Text.id' => $id), 
			'contain' => false
		));

		if ($text) {
			$this->set('model', $text['Text']['model']);
			$this->set('model_id', $text['Text']['foreign_key']);

			if (!empty($this->data)) {
				if ($this->Text->save($this->data)){
					$this->Flash->success(__('El texto ha sido editado', true));					
					$this->redirect(array('controller' => Inflector::tableize($text['Text']['model']), 'action' => 'view', $text['Text']['foreign_key']));	
				}
			} else {
				$this->data = $text;
			}
		} else {
			$this->redirect(array('controller' => 'pages', 'action' => 'home'));				
		}

		$this->set('referer', $this->referer());
	}	
}
?>