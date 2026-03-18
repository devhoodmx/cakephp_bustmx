<?php
App::uses('Component', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class EmailComponent extends Component {

	public function initialize(Controller $controller) {
		$this->controller = $controller;
		$this->options = array(
			'config' => 'default',
			'to' => '',
			'subject' => '',
			'layout' => 'site',
			'template' => '',
			'locale' => '',
			'emailFormat' => 'html'
		);
	}

	public function config($key = null, $value = null) {
		$options = array();

		if ($key === null) {
			return $this->options;
		}

		if ($key) {
			if (is_array($key)) {
				$options = $key;
			} else {
				$options[$key] = $value;
			}

			$this->options = array_merge($this->options, $options);
		}
	}

	public function send($options = array(), $viewVars = array()) {
		$this->options['locale'] = $this->controller->locale;

		$options = array_merge($this->options, $options);
		$viewVars = array_merge(array(
			'locale' => $options['locale'],
			'config' => Configure::read()),
		$viewVars);

		Configure::write('Config.language', $options['locale']);

		// Setup CakeEmail
		$email = new CakeEmail($options['config']);
		$email->template($options['template'], $options['layout'])
			->emailFormat($options['emailFormat'])
			->to($options['to'])
			->subject($options['subject'])
			->viewVars($viewVars);

		if (!empty($options['headers'])) {
			$email->addHeaders($options['headers']);
		}

		if (!empty($options['attachment'])) {
			$email->addAttachments($options['attachment']);
		}

		$headers = array('from', 'replyTo', 'cc', 'bcc');
		foreach ($headers as $key => $header) {
			if (!empty($options[$header])) {
				if (is_array($options[$header]) && sizeof($options[$header]) == 2) {
					$email->$header($options[$header][0], $options[$header][1]);
				} else {
					$email->$header($options[$header]);
				}
			}
		}

		// Send email
		$sent = $email->send();

		Configure::write('Config.language', $this->controller->locale);

		return $sent;
	}
}
