<?php
App::uses('AppController', 'Controller');

class CodesController extends AppController {

	public function admin_add($id = null, $model = null) {
		$this->loadModel($model);
		$mod = $this->{$model}->find('first', array(
			'conditions' => array($model . '.id' => $id),
			'contain' => false
		));

		if ($mod) {
			$this->set('model', $model);
			$this->set('model_id', $id);

			$this->Code->create();
			$this->Code->set($this->request->data);

			if (!empty($this->request->data)) {
				$this->request->data['Code']['model'] = $model;
				$this->request->data['Code']['foreign_key'] = $id;
				if ($this->Code->save($this->request->data)){
					$this->Flash->success(__('El código ha sido creado', true));
					$this->redirect(array('controller' => Inflector::tableize($model), 'action' => 'view', $id));
				}
			}
		} else {
			$this->redirect(array('controller' => 'pages', 'action' => 'home'));
		}

		$this->set('referer', $this->referer());
	}

	public function admin_edit($id = null, $name = null) {
		$code = $this->Code->find('first', array(
			'conditions' => array('Code.id' => $id),
			'contain' => false
		));

		if ($code) {
			$this->set('model', $code['Code']['model']);
			$this->set('model_id', $code['Code']['foreign_key']);

			if (!empty($this->data)) {
				if ($this->Code->save($this->data)){
					$this->Flash->success(__('El código ha sido editado', true));
					$this->redirect(array('controller' => Inflector::tableize($code['Code']['model']), 'action' => 'view', $code['Code']['foreign_key']));
				}
			} else {
				$this->data = $code;
			}
		} else {
			$this->redirect(array('controller' => 'pages', 'action' => 'home'));
		}

		$this->set('referer', $this->referer());
	}
}
?>
