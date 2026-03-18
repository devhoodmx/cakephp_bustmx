<?php
App::uses('Controller', 'Controller');

class TemplatesAppController extends Controller {
	public $locale = null;

	public $components = array(
		'Cookie' => array(
			'name' => 'hc'
		),
		'RequestHandler',
		'Session',
		'Email'
	);

	public $helpers = array(
		'Form',
		'Html',
		'Js',
		'Text',
		'Time',
		'Session',
		'Package'
	);

	public $_mergeParent = 'Controller';

	public function beforeFilter() {
		$config = Configure::read();
		$clientIP = $this->request->clientIp();

		// Maintenance mode
		if ($config['App']['maintenance']['active'] &&
			!in_array($clientIP, $config['App']['maintenance']['allow']) &&
			$this->name != 'CakeError') {
			App::uses('MaintenanceException', 'Error/Exception');
			throw new MaintenanceException();
		}

		// Debug mode
		if (in_array($clientIP, $config['App']['debug']['allow'])) {
			Configure::write('debug', $config['App']['debug']['level']);
		}

		// Localization
		$this->locale = $config['App']['locale'];
		Configure::write('Config.language', $this->locale);
		
		$this->set(array(
			'config' => $config,
			'locale' => $this->locale,
			'assets' => array('stylesheets' => array(), 'scripts' => array())
		));
	}

	public function beforeRender() {
		if ($this->RequestHandler->ext == 'json') {
			$this->viewClass = 'ResponseJson';
		}
	}
}
