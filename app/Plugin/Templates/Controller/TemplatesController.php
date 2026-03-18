<?php
App::uses('TemplatesAppController', 'Templates.Controller');
/**
 * Templates Controller
 *
 */
class TemplatesController extends TemplatesAppController {
	public $uses = array();

	public $prefixes = array();

	public function beforeFilter() {
		$path = '';

		parent::beforeFilter();

		if (!Configure::read('debug') && $this->name != 'CakeError') {
			throw new NotFoundException();
		}

		$this->prefixes = Configure::read('Templates.prefixes');

		// Layout
		$this->layout = 'main';
		if (preg_match('/^(' . implode($this->prefixes, '|') . ')_/', $this->request->action, $matches)) {
			$path = ucwords($matches[1]) . '/';
			$this->layout =   $path . 'main';

			// Mobile
			if (isset($this->request->query['mobile']) &&
				$this->request->query['mobile'] == 1) {

				$this->layout = $path . 'mobile';
				$this->viewPath = $this->viewPath . '/' . 'Mobile';
			}
		}
	}

	public function index() {
		$templates = array();

		foreach ($this->prefixes as $prefix) {
			$templates[$prefix] = $this->_getTemplates($prefix);
		}

		$this->set('templates', $templates);
	}

	public function site_index() {
		$this->set('templates', $this->_getTemplates('site'));
	}

	public function site_template() {
		return false;
	}

	public function site_webpage() {
		return false;
	}

	public function site_home() {
		return false;
	}

	public function site_search() {
		return false;
	}

	public function site_contact() {
		if ($this->request->action != __FUNCTION__) {
			return false;
		}

		$this->loadModel('ContactEmail');
		// $this->Recaptcha = $this->Components->load('Recaptcha');

		if (!empty($this->data)) {
			/*
			$isHuman = $this->Recaptcha->checkAnswer(
				$_SERVER["REMOTE_ADDR"],
				$_POST["g-recaptcha-response"]
			);
			*/

			$this->ContactEmail->set($this->data);
			if ($this->ContactEmail->validates()/*&& $isHuman*/) {
			}
		}

		// $this->set('recaptchaError', $this->Recaptcha->error());
	}

	public function site_email_template($send = 0, $locale = 'en') {
		if ($this->request->action == __FUNCTION__) {
			$this->_renderEmail(__FUNCTION__, array(), $send, $locale);
		}

		return true;
	}

	public function site_error_404() {
		if ($this->request->action == __FUNCTION__) {
			//throw new BadRequestException();
			throw new NotFoundException();
		}

		return false;
	}

	public function site_error_410() {
		if ($this->request->action == __FUNCTION__) {
			App::uses('GoneException', 'Error/Exception');
			throw new GoneException(NULL, array());
		}

		return false;
	}

	public function site_error_500() {
		if ($this->request->action == __FUNCTION__) {
			throw new InternalErrorException();
		}

		return false;
	}

	public function site_error_missing_controller() {
		if ($this->request->action == __FUNCTION__) {
			throw new MissingControllerException(array('class' => 'MonkeysController', 'plugin' => null));
		}

		return false;
	}

	public function site_error_maintenance() {
		if ($this->request->action == __FUNCTION__) {
			App::uses('MaintenanceException', 'Error/Exception');
			throw new MaintenanceException();
		}

		return false;
	}

	public function admin_index() {
		$this->set('templates', $this->_getTemplates('admin'));
	}

	public function admin_bootstrap() {
		return true;
	}

	public function admin_login() {
		if ($this->request->action != __FUNCTION__) {
			return true;
		}

		$this->layout = 'Admin/login';
	}

	public function admin_dashboard() {
		return true;
	}

	public function admin_add_article() {
		return true;
	}

	public function admin_add_user() {
		return true;
	}

	public function admin_tables() {
		return true;
	}

	private function _getTemplates($prefix = 'site') {
		$templates = array('pages' => array(), 'emails' => array(), 'errors' => array());
		$prefixes = $this->prefixes;

		if (!in_array($prefix, $prefixes)) {
			return $templates;
		}

		App::uses('Folder', 'Utility');

		// Methods
		$parentMethods = get_class_methods(get_parent_class($this));
		$objectMethods = get_class_methods($this);
		$methods = array_diff($objectMethods, $parentMethods);

		foreach ($methods as $method) {
			if (strpos($method, '_') !== 0 && // Discard private methods
				preg_match('/^' . $prefix . '_(.+)/', $method, $matches) // Any valid prefix
			) {
				$complete = true;
				$category = 'pages';
				$key = $matches[1];

				if ($key != 'index') {
					$complete = call_user_func(array($this, $method));
				}
				// Special templates
				if (preg_match('/^(email|error|service)_(.+)/', $key, $matches)) {
					$category = $matches[1] . 's';
					$key = $matches[2];
				}

				if ($category != 'service') {
					$templates[$category][] = array(
						'action' => $method,
						'name' => ucwords(str_replace('_', ' ', $key)),
						'complete' => $complete
					);
				}
			}
		}

		return $templates;
	}
/**
 * Render email template
 * @param type $template
 * @param type $viewVars
 * @param type $send
 * @param type $locale
 * @param type $render
 * @return type
 */
	public function _renderEmail($template, $viewVars = array(), $send = 0, $locale = 'en') {
		if (preg_match('/^([^_]+)_email_(.+)/', $template, $matches)) {
			$prefix = $matches[1];
			$key = $matches[2];
			$name = ucwords(str_replace('_', ' ', $key));
			$template = $prefix . '_' . $key;
			$view = 'Emails/html/' . $template;
			$viewVars = array_merge(array('locale' => $locale, 'config' => Configure::read()), $viewVars);
			$recipients = Configure::read('App.email.lists.templates');
			$sent = '';

			if (file_exists(APP . 'Plugin' . DS . 'Templates' . DS . 'View' . DS . $view . '.ctp')) {
				// Force language
				Configure::write('Config.language', $locale);

				if ($send) {// Render html template
					$sent = $this->Email->send(array(
						'template' => 'Templates./' . $view,
						'layout' => $prefix,
						'emailFormat' => 'both',
						'to' => $recipients,
						'subject' => $name . ' Email Template'
					), $viewVars);

					pr($sent);
					exit;
				} else {// Send email
					// Non inlined styles layout
					// $this->layout = 'Emails/html/src/' . $prefix;
					// Inlined styles layout
					$this->layout = 'Emails/html/' . $prefix;

					// Non inlined styles view
					$this->set($viewVars);
					$this->render('/' . $view);
					// Inlined styles view. Render default view
				}
			}
		}
	}
}
