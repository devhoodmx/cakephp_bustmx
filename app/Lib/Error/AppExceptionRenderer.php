<?php
/**
 * App Exception Renderer.
 */
class AppExceptionRenderer extends ExceptionRenderer {
/**
 * Generate the response using the controller object.
 *
 * @param string $template The template to render.
 * @return void
 */
	protected function _outputMessage($_template) {
		$attr = $this->getMessageAttributes();
		$prefix = $attr['prefix'];
		$path = $this->getViewsPath();
		$template = 'error';
		$templateKey = Inflector::underscore($_template);
		$templates = [$templateKey];

		// Create list of templates
		if (!empty($prefix)) {
			$templates[] = $prefix . '_error';
			$templates[] = $prefix . '_' . $templateKey;
		}

		// Look up available templates
		$templates = array_reverse($templates);
		foreach ($templates as $key => $value) {
			if (file_exists($path . $value . '.ctp')) {
				$template = $value;
				break;
			}
		}

		$this->controller->set($attr);

		parent::_outputMessage($template);
	}

	public function maintenance($error) {
		// $this->controller->layout = 'maintenance';
		$this->controller->response->statusCode($error->getCode());

		$this->_outputMessage('maintenance');
	}

	public function gone($error) {
		$this->controller->response->statusCode($error->getCode());

		$this->_outputMessage('gone');
	}

	public function getMessageAttributes() {
		$code = $this->error->getCode();
		$message = $this->error->getMessage();
		$name = $message;
		$prefix = isset($this->controller->request->params['prefix']) ? $this->controller->request->params['prefix'] : '';
		$attr = array(
			'code' => $code,
			'message' => $message,
			'name' => $name,
			'prefix' => $prefix,
			'error' => $this->error,
			'type' => str_replace('Exception', '', get_class($this->error))
		);

		return $attr;
	}

	protected function getViewsPath() {
		$path = 'View' . DS . 'Errors' . DS;
		if (empty($this->controller->plugin)) {
			$path = APP . $path;
		} else {
			$path = APP . 'Plugin' . DS . $this->controller->plugin . DS . $path;
		}

		return $path;
	}
}
