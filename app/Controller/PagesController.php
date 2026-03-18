<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link https://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

	public $blockEmails = [
		'ericjonesmyemail@gmail.com'
	];
	
	public function getPlanIfo()
	{
		$times = '<i class="fas fa-times-circle fa-lg text-muted"></i>';
		$check = '<i class="fas fa-check-circle fa-lg text-success"></i>';


		$plans = [
			[
				'name' => 'Bust X Food',
				'price' => '$22,000 + IVA',
				'features' => [
					'Dashboard' => 'SECTION',
						'Personalizado' => $check,
						'Fuentes' => 2,
					'Campañas de Meta' => 'SECTION',
						'Monto máximo' => '$10,000',
						'Inversión para la agencia' => '20%',
					'Prima de diseño' => 'SECTION',
						'Diseños' => '10',
					'Chatbot' => 'SECTION',
						'AI' => $check,
						'Flows' => '2',
					'Social Media Management' => 'SECTION',
						'Canales de contenido' => '3 canales',
						'Total de publicaciones' => '15',
						'Producción audiovisual' => 'Profesional',
						'Calendario de contenido' => $check,
						'Programación de contenido' => $check,
						'Tendencias de contenido' => '3 Contenidos',
						'Campañas de interacción' => '1',
					'Campaña de Google Ads' => 'SECTION',
						'Monto Máximo' => $times,
						'Inversión para la agencia' => $times,
					'Campaña de Email Marketing' => 'SECTION',
						'Correos' => $times,
					'Landing Page' => 'SECTION',
						'Soporte' => $times,
					'CRM' => 'SECTION',
						'Soporte en WhatsApp' => $times,
						'Automatizaciones' => $times,
						'Embudo de ventas' => $times,
						'Capacitación a ventas' => $times,
					'SEO' => 'SECTION',
						'Contenido' => $times,
						'Enlaces' => $times,
						'Optimización de Categorías' => $times,
						'Optimización de Semántica' => $times,
						'Posicionar Keywords' => $times
				],
			],
			[
				'name' => 'Bust X Sales',
				'price' => '$27,000 + IVA',
				'features' => [
					'Dashboard' => 'SECTION',
						'Personalizado' => $check,
						'Fuentes' => 'Ilimitadas',
					'Campañas de Meta' => 'SECTION',
						'Monto máximo' => '$20,000',
						'Inversión para la agencia' => '20%',
					'Prima de diseño' => 'SECTION',
						'Diseños' => '10',
					'Chatbot' => 'SECTION',
						'AI' => $times,
						'Flows' => $times,
					'Social Media Management' => 'SECTION',
						'Canales de contenido' => $check,
						'Total de publicaciones' => $check,
						'Producción audiovisual' => $check,
						'Calendario de contenido' => $check,
						'Programación de contenido' => $check,
						'Tendencias de contenido' => $check,
						'Campañas de interacción' => $check,
					'Campaña de Google Ads' => 'SECTION',
						'Monto Máximo' => '$20,000',
						'Inversión para la agencia' => '20%',
					'Campaña de Email Marketing' => 'SECTION',
						'Correos' => '3',
					'Landing Page' => 'SECTION',
						'Soporte' => $check,
					'CRM' =>  'SECTION',
						'Soporte en WhatsApp' => $check,
						'Automatizaciones' => '3',
						'Embudo de ventas' => '1',
						'Capacitación a ventas' => $check,
					'SEO' =>  'SECTION',
						'Contenido' => $times,
						'Enlaces' => $times,
						'Optimización de Categorías' => $times,
						'Optimización de Semántica' => $times,
						'Posicionar Keywords' => $times
				],
			],
			[
				'name' => 'Bust X Enterprise',
				'price' => '$46,900 + IVA',
				'features' => [
					'Dashboard' => 'SECTION',
						'Personalizado' => $check,
						'Fuentes' => 2,
					'Campañas de Meta' => 'SECTION',
						'Monto máximo' => '$10,000',
						'Inversión para la agencia' => '20%',
					'Prima de diseño' => 'SECTION',
						'Diseños' => '10',
					'Chatbot' => 'SECTION',
						'AI' => $check,
						'Flows' => '2',
					'Social Media Management' => 'SECTION',
						'Canales de contenido' => '3 canales',
						'Total de publicaciones' => '15',
						'Producción audiovisual' => 'Profesional',
						'Calendario de contenido' => $check,
						'Programación de contenido' => $check,
						'Tendencias de contenido' => '3 Contenidos',
						'Campañas de interacción' => '1',
					'Campaña de Google Ads' => 'SECTION',
						'Monto Máximo' => $times,
						'Inversión para la agencia' => $times,
					'Campaña de Email Marketing' => 'SECTION',
						'Correos' => $times,
					'Landing Page' => 'SECTION',
						'Soporte' => $times,
					'CRM' => 'SECTION',
						'Soporte en WhatsApp' => $times,
						'Automatizaciones' => $times,
						'Embudo de ventas' => $times,
						'Capacitación a ventas' => $times,
					'SEO' => 'SECTION',
						'Contenido' => '3',
						'Enlaces' => '5',
						'Optimización de Categorías' => '50 categorías',
						'Optimización de Semántica' => $check,
						'Posicionar Keywords' => '10'
				],
			],
		];

		return $plans;
	}

	public function home() {
		$this->loadModel('Project');
		$this->loadModel('Review');
		$this->loadModel('Plan');
		$projects = $this->Project->find(
			'all',
			array(
				'conditions' => array(
					'Project.active' => true,
					'Project.main' => true
				),
				'order' => 'Project.id ASC',
			)
		);
		$reviews = $this->Review->find('all',array(
			'order' => 'RAND()',
			'limit' => 3,
			'conditions' => array(
				'active' => true,
			)
		));
		$plans = $this->Plan->find('all');
		
		$plansTable = $this->getPlanIfo();

		$this->set(compact(['projects', 'reviews','plans', 'plansTable']));
	}

	public function projects(){
		$this->loadModel('Project');
		$projects = $this->Project->find(
			'all',
			array(
				'conditions' => array(
					'Project.active' => true,
				),
				'order' => 'Project.id ASC',
			)
		);
		$this->set(compact(['projects']));
	}
	public function project($id = null, $name = null){
		$this->loadModel('Project');
		$project = $this->Project->find(
			'first',
			array(
				'conditions' => [
					'Project.id' => $id,
					'Project.active' => true
				]
			)
		);
		$this->set(compact(['project']));

	}
	public function save_vacant(){

		$this->loadModel('RequestVacancy');


		/*$redirectURL = ['action' => 'contact', '#' => __('contacto')];*/
		$redirectURL = ['controller' => 'pages', 'action' => 'thanks'];
		$this->Recaptcha = $this->Components->load('Recaptcha');

		if($this->request->is('post')){

			$data = $this->request->data;
			$this->RequestVacancy->set($data);

			$isHuman = $this->Recaptcha->checkAnswer(
				$_SERVER['REMOTE_ADDR'],
				$_POST['g-recaptcha-response']
			);

			if (empty($isHuman)) {
				$this->RequestVacancy->invalidate('recaptcha', 'recaptcha');
			}

			if($this->RequestVacancy->validates() && $isHuman){

				$this->request->data['RequestVacancy']['email'] = trim($this->request->data['RequestVacancy']['email']);

				if (!in_array(mb_strtolower($this->request->data['RequestVacancy']['email']), $this->blockEmails)) {
					$this->RequestVacancy->saveAll($data);
				}
			
				// $this->Flash->success(__d('contact', 'success'));
				$this->redirect($redirectURL);

			}else{
				$validationErrors = $this->RequestVacancy->validationErrors;
				$this->Session->write('validationErrorsRequestVacancy', $validationErrors);
				//URL validations
				$this->redirect(['action' => 'contact', '#' => __('contacto')]);
			}
		}
		$this->set('recaptchaError', $this->Recaptcha->error());
    }
	public function send_quote(){

		$this->loadModel('Quote');

		$config = $this->viewVars['config'];
		/*$redirectURL = ['action' => 'contact','#' => __('contacto')];*/
		$redirectURL = ['controller' => 'pages', 'action' => 'thanks'];
		$this->Recaptcha = $this->Components->load('Recaptcha');

		if ($this->request->is('post')) {
			$data = $this->request->data;
			$this->Quote->set($data);

			$isHuman = $this->Recaptcha->checkAnswer(
				$_SERVER['REMOTE_ADDR'],
				$_POST['g-recaptcha-response']
			);

			if (empty($isHuman)) {
				$this->Quote->invalidate('recaptcha', 'recaptcha');
			}
			
			if ($this->Quote->validates() && $isHuman) {
				//email contact
				$to = $config['App']['configurations']['contact-email'];

				if (empty($to)) {
					throw new Exception('Invalid recipient email.');
				}

				$this->request->data['Quote']['email'] = trim($this->request->data['Quote']['email']);

				if (!in_array(mb_strtolower($this->request->data['Quote']['email']), $this->blockEmails)) {
					$this->Email->send(
						array(
							'template' => 'quote',
							'to' => $to,
							'subject' => __d('contact', 'quote-email-title', $config['App']['configurations']['website-title']),
							'replyTo' => $this->request->data['Quote']['email']
						),
						array(
							'data' => $this->request->data
						)
					);

					$this->Quote->save($data);		
				}		
				
				$this->redirect($redirectURL);
			}else{
				$validationErrors = $this->Quote->validationErrors;
				$this->Session->write('validationErrorsQuote', $validationErrors);
				//URL validation
				$this->redirect(['action' => 'contact', '#' => __('contacto')]);
			}
		}

		$this->set('recaptchaError', $this->Recaptcha->error());


	}
	public function about(){

	}
	public function thanks(){
		
	}
	public function contact() {

		// send the quote validation to the contact view
		$this->loadModel('Quote');
		$validationErrorsQuote = $this->Session->read('validationErrorsQuote');
		$this->set('validationErrorsQuote', $validationErrorsQuote);
		$this->Session->delete("validationErrorsQuote");
		//end code 

		// send the vacancy validation to the contact view
		$this->loadModel('RequestVacancy');
		$validationErrorsRequestVacancy = $this->Session->read('validationErrorsRequestVacancy');
		$this->set('validationErrorsRequestVacancy', $validationErrorsRequestVacancy);
		$this->Session->delete("validationErrorsRequestVacancy");
		//end code 

		$this->loadModel('Category');

		$parentCategory = $this->Category->find('first',[
			'conditions' => ['Category.key' => 'vacancies'],
			'fields' => ['id','name','key','parent_id']
		]);
		$vacancies = $this->Category->find('list',[
			'conditions' =>[
				'parent_id' => $parentCategory['Category']['id']
			]
		]);

		//media config vacancies
		$this->loadModel('RequestVacancy');
		$mediaConfig = $this->RequestVacancy->getMediaConfig();

		$this->set(compact('vacancies','mediaConfig'));

		$config = $this->viewVars['config'];
		/*$redirectURL = ['action' => 'contact', '#' => __('contacto')];*/
		$redirectURL = ['controller' => 'pages', 'action' => 'thanks'];

		$this->Recaptcha = $this->Components->load('Recaptcha');

		if ($this->request->is('post')) {
			$this->loadModel('ContactEmail');
			$this->ContactEmail->set($this->request->data);

			$isHuman = $this->Recaptcha->checkAnswer(
				$_SERVER['REMOTE_ADDR'],
				$_POST['g-recaptcha-response']
			);

			if (empty($isHuman)) {
				$this->ContactEmail->invalidate('recaptcha', 'recaptcha');
			}

			if ($this->ContactEmail->validates() && $isHuman) {
				$to = $config['App']['configurations']['contact-email'];

				if (empty($to)) {
					throw new Exception('Invalid recipient email.');
				}

				$this->request->data['ContactEmail']['email'] = trim($this->request->data['ContactEmail']['email']);

				if (!in_array(mb_strtolower($this->request->data['ContactEmail']['email']), $this->blockEmails)) {
					$this->Email->send(
						array(
							'template' => 'contact',
							'to' => $to,
							'subject' => __d('contact', 'email-title', $config['App']['configurations']['website-title']),
							'replyTo' => $this->request->data['ContactEmail']['email']
						),
						array(
							'config' => $config,
							'data' => $this->request->data
						)
					);
				}

				$this->Flash->success(__d('contact', 'success'));
				$this->redirect($redirectURL);
				
			}
		}

		$this->set('recaptchaError', $this->Recaptcha->error());
	}

	public function privacy() {
	}

	private function tos() {
	}

	public function sitemap() {
		if ($this->RequestHandler->isXml()) {
			$webpages = [];

			Configure::write('debug', 0);

			$this->cacheAction = true;

			$this->RequestHandler->renderAs($this, 'xml');

			if (Configure::read('App.webpages.active')) {
				$this->loadModel('WebPage');

				$webpages = $this->WebPage->find('all', array(
					'conditions' => array('WebPage.active' => true),
					'contain' => false
				));
			}

			$this->set(compact('webpages'));
		}
	}

	public function admin_home() {
	}

	public function admin_oembed() {
		$url = '';
		$service = null;
		$services = [
			'youtube' => [
				'key' => 'youtube',
				'pattern' => 'youtube.com',
				'endpoint' => 'https://www.youtube.com/oembed?url=%s&maxwidth=1280'
			],
			'vimeo' => [
				'key' => 'vimeo',
				'pattern' => 'vimeo.com',
				'endpoint' => 'https://vimeo.com/api/oembed.json?url=%s&maxwidth=1280'
			]
		];
		$response = [];

		$this->viewClass = 'Json';

		// URL
		if (!$this->request->query('url')) {
			throw new BadRequestException('url required');
		}
		$url = $this->request->query('url');

		// Service
		foreach ($services as $key => $_service) {
			if (strpos($url, $_service['pattern']) !== false) {
				$service = $_service;

				break;
			}
		}
		if (!$service) {
			throw new BadRequestException('Unsupported service');
		}

		// Request embeded representation
		// See https://oembed.com/
		$client = new GuzzleHttp\Client();
		$_response = $client->request(
			'GET',
			sprintf($service['endpoint'], $url)
		);
		$response = json_decode($_response->getBody(), true);

		if (!empty($response['html'])) {
			// Wrap iframe with .embed-responsive to create a responsive video
			$response['html'] = str_replace('<iframe ', "<iframe class='embed-responsive-item' ", $response['html']);
			$response['html'] = sprintf(
				"<div class='embed-responsive embed-responsive-16by9'>%s</div>",
				$response['html']
			);
		}

		// Enable JSONP
		if ($this->request->query('callback')) {
			$this->set('_jsonp', true);
		}

		$this->set($response);
		$this->set('_serialize', array_keys($response));
	}

	public function password_protection() {
		$this->layout = 'Admin/password';

		$setPassword = Configure::read('App.configurations.general-password-protection');
		$access = $this->Session->read('App.password_protection.authorized');

		if (empty($setPassword) || !empty($access)) {
			$this->redirect(['action' => 'home', 'admin' => false]);
		} else {
			if (isset($this->request->data['User']['password'])) {
				$password = trim($this->request->data['User']['password']);

				if ($password != $setPassword) {
					$this->loadModel('User');
					$this->User->invalidate('password', empty($password) ? 'notBlank' : 'password-incorrect');
				} else {
					$this->Session->write('App.password_protection.authorized', true);

					$this->redirect(!empty($this->request->query['redirectURL']) ? $this->request->query['redirectURL'] : ['action' => 'home']);
				}
			}
		}
	}
}
