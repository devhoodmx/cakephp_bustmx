<?php
App::uses('AppController', 'Controller');
 
class VideosController extends AppController {
	
	public function admin_add($id = null, $model = null) {
		$this->loadModel($model);
		$mod = $this->{$model}->find('first', array(
			'conditions' => array($model . '.id' => $id), 
			'contain' => false
		));

		if ($mod) {
			$this->set('model', $model);
			$this->set('model_id', $id);
			
			$this->Video->create();
			$this->Video->set($this->request->data);
			
			if (!empty($this->request->data)) {
				$this->request->data['Video']['model'] = $model;
				$this->request->data['Video']['foreign_key'] = $id;
				
				if ($this->Video->save($this->request->data)){
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
		$text = $this->Video->find('first', array(
			'conditions' => array('Video.id' => $id), 
			'contain' => false
		));

		if ($text) {
			$this->set('model', $text['Video']['model']);
			$this->set('model_id', $text['Video']['foreign_key']);

			if (!empty($this->data)) {
				if ($this->Video->save($this->data)){
					$this->Flash->success(__('El texto ha sido editado', true));					
					$this->redirect(array('controller' => Inflector::tableize($text['Video']['model']), 'action' => 'view', $text['Video']['foreign_key']));	
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