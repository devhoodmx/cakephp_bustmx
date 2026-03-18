<?php
App::uses('JsonView', 'View');
class ResponseJsonView extends JsonView {

	private $__debug = TRUE;

	public $body = array(
		'api_version' => 1
	);

	private $restrictedVars = array(
		'config',
		'assets',
		'_serialize'
	);

	private $params = array(
		'redirect'
	);

	public function __construct(Controller $controller = null) {
		parent::__construct($controller);

    	if (isset($this->viewVars['context'])) {
			$this->body['context'] = $this->viewVars['context'];
    	}

		$this->body['id'] = CakeText::uuid();
	}

	public function buildResponse() {
		$data = array();

		if ($this->name == 'CakeError') {
			$data['error'] = $this->__processError($this->viewVars);
		} else if (!empty($this->validationErrors)) {
			$fieldsError = $this->__processValidationErrors($this->validationErrors);
			$data['error'] = empty($fieldsError) ? array() : array('fields' => $fieldsError);
		}

		if (empty($data['error'])) {
			$data['data'] = $this->__processData($this->viewVars);
			unset($data['error']);
		} else {
			if (!empty($this->viewVars['forceData'])) {
				$data['data'] = $this->__processData($this->viewVars);
			}
			$this->response->statusCode(400);
		}

		return $data;
	}

    public function render($view = null, $layout = null) {
		$this->body = Set::merge($this->body, $this->buildResponse());

		if (Configure::read('debug') > 0) {
			$debug = $this->__getDebug();
			$this->body['debug'] = $debug;
		}

		$this->body['view'] = $view;
		$this->body['layout'] = $layout;

		$content = json_encode($this->body);
		$this->Blocks->set('content', $content);
		return $content;
    }

    private function __processData($data) {
    	$info = array('items' => array(), 'element' => array(), 'params' => array());

    	foreach ($data as $var => $content) {
    		if (!in_array($var, $this->restrictedVars)) {
	    		if (is_array($content) && !empty($content['viewElement'])) {
	    			$values = $content['viewElement'];
	    			$info['element'][$var] = $this->_render($this->_getViewFileName('/Elements/' . $values['url']), empty($values['params']) ? array() : $values['params']);
	    		} else if (in_array($var, $this->params)) {
	    			$info['params'][$var] = $content;
	    		} else {
	    			$info['items'][$var] = $content;
	    		}
	    	}
    	}

    	return $info;
    }

    private function __processError($error) {
    	$messageKey = Utility::slug(Inflector::underscore($error['type']));

    	$response = array(
    		'code' => $error['code'],
			'reason' => $error['type'],
			'message' => Utility::translate($messageKey, 'error')
    	);

    	if (Configure::read('debug') > 0) {
    		$response['name'] = $error['name'];
    	}

    	return $response;
    }

    private function __processValidationErrors($error) {
     	$errors = array();

    	if (!empty($error)) {
     		foreach ($error as $model => $fields) {
     			foreach ($fields as $field => $rules) {
     				foreach ($rules as $key => $rule) {
     					$rule = is_array($rule) && !empty($rule[0]) ? $rule[0] : $rule;

     					if (!is_array($rule)) {
	     					$reasonKey = Utility::slug(Inflector::underscore($rule));
	     					$modelKey = Inflector::underscore($model);
	     					$messageKey = Utility::slug(Inflector::underscore($field)) . '-' . $reasonKey;
	     					$message = Utility::translate($messageKey, $modelKey);

	     					if ($message == $messageKey) {
	     						$message = Utility::translate($reasonKey, $modelKey, 'error');

	     						if ($message == $reasonKey) {
	     							$message = $rule;
	     						}
	     					}

	     					$errors[] = array(
	     						'key' => $model . Inflector::camelize($field) . (is_integer($key) ? '' : Inflector::camelize($key)),
			     				'domain' => $model,
			     				'reason' => $rule,
			     				'location' => $field,
			     				'message' => $message
			     			);
			     		}
     				}
     			}
     		}
     	}

     	return $errors;
     }

     private function __getDebug() {
   		$debug = array();
     	if (class_exists('ConnectionManager') && Configure::read('debug') >= 2) {

			$noLogs = !isset($sqlLogs);
			if ($noLogs) {
				$sources = ConnectionManager::sourceList();

				$sqlLogs = array();
				foreach ($sources as $source) {
					$db = ConnectionManager::getDataSource($source);
					if (method_exists($db, 'getLog')) {
						$sqlLogs[$source] = $db->getLog();
					}
				}

				$debug['sql'] = $sqlLogs;
			}
		}

		return $debug;
     }
}
