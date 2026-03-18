<?php
App::uses('AppController', 'Controller');

class RequestVacanciesController extends AppController
{
    public function admin_add() {
        $this->loadModel('Category');

        $parentCategory = $this->Category->find('first',array('key' => 'vacancies'));
       
        $vacancies = $this->Category->find('list',array(
            'conditions' => ['parent_id' => $parentCategory['Category']['id']]
        ));

        $this->set(compact('vacancies'));
        parent::admin_add();
    }
	
    public function admin_edit($id = null, $name = null)
    {
        $config = parent::admin_edit($id, $name);
        $this->loadModel('Category');
        $parentCategory = $this->Category->find('first',array('key' => 'vacancies'));
       
        $vacancies = $this->Category->find('list',array(
            'conditions' => ['parent_id' => $parentCategory['Category']['id']]
        ));

        $this->set(compact('vacancies'));
    }

    
}