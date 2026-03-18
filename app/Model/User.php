<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 */
class User extends AppModel {
	public $name = 'User';

	public $validate = array(
		'username' => array(
			'notBlank' => array(
				'rule' => 'notBlank'
			),
			'unique' => array(
				'rule' => 'isUnique',
				'message' => 'unique-username'
			)
		),
		'email' => array(
			'email' => array(
				'rule' => 'email',
				'allowEmpty' => false,
				'message' => 'email-error'
			),
			'unique' => array(
				'rule' => 'isUnique',
				'message' => 'unique-email'
			)
		),
		'_password'    => array(
			'minLength' => array(
				'rule' => array('minLength', 8),
				'on' => 'create',
				'message' => '8-characters-length'
			),
			'minLengthOnUpdate' => array(
				'rule' => array('minLength', 8),
				'on' => 'update',
				'message' => '8-characters-length',
				'allowEmpty' => true
			)

		),
		'_password_confirmation' => array(
			'isEqualToField' => array('rule' => array('isEqualToField', '_password'))
		),
		'_current_password' => array(
			'requiredIfNotEmpty' => array(
				'rule'    => array('onlyIf', '_password', 'notBlank', 'notBlank'),
				'message' => 'not-blank'
			),
			'isCurrentPassword' => array(
				'rule' => 'isCurrentPassword',
				'message' => 'password-incorrect',
				'allowEmpty' => true
			)
		),
		'role_id' => array(
			'notBlank' => array(
				'rule' => 'notBlank'
			)
		)
	);

	public $actsAs = array(
		'Containable',
		'Loggable',
		'Media' => array(
			'profile' => array(
				'private' => false,
				'not-empty' => false,
				'multiple' => false,
				'max-size' => '3MB',
				'files' => array('image' => array()),
				'services' => false
			)
		)
	);

	public $belongsTo = array(
		'Role'
	);

	protected $_passwordHasher;

	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		// Virtual fields
		$this->virtualFields['full_name'] = str_replace(
			'{{ alias }}',
			$this->alias,
			"CONCAT_WS(' ', IF ({{ alias }}.name = '', NULL, {{ alias }}.name), IF ({{ alias }}.last_name = '', NULL, {{ alias }}.last_name))"
		);
	}

	public function isCurrentPassword($check) {
		if (AuthComponent::user()) {
			$password = array_shift($check);
			$hashedPassword = $this->field('password', array('id' => AuthComponent::user('id')));

			return $this->passwordHasher()->check($password, $hashedPassword);
		}

		return false;
	}

	public function beforeSave($options = []) {
		if (!empty($this->data[$this->alias]['_password'])) {
			$this->data[$this->alias]['password'] = $this->passwordHasher()->hash($this->data[$this->alias]['_password_confirmation']);
		}

		return true;
	}

	public function afterSave($created, $options = []) {
		if (!$created) {
			if (AuthComponent::user('id') == $this->id) {
				$user = $this->find('first', array(
					'conditions' => array(
						'User.id' => $this->id
					),
					'contain' => array(
						'Role',
						'Media'
					)
				));

				$session = $user[$this->alias];
				unset($user[$this->alias]);
				$session = array_merge($session, $user);

				SessionComponent::write('Auth.User', $session);
			}
		}
	}

	public function getMenuItems($id = null) {
		$options = [];
		$modules = [];

		if (!$id) {
			return $options;
		}

		$options['home'] = [
			'text' => __('dashboard'),
			'class' => 'home',
			'url' => ['controller' => 'pages', 'action' => 'home', 'admin' => true]
		];

		$roleId = $this->field('role_id', ['User.id' => $id]);

		if ($roleId) {
			$this->Role->id = $roleId;

			$aro = $this->Role->node();
			$aroId = $aro[0]['Aro']['id'];

			App::uses('Module', 'Model');
			$Module = new Module();

			$joins = [
				[
					'table' => 'aros_acos',
					'alias' => 'Permission',
					'type' => 'LEFT',
					'conditions' => [
						'Permission.aco_id = Module.id',
						'Permission.aro_id' => $aroId
					]
				],
				[
					'table' => 'categories',
					'alias' => 'Category',
					'type' => 'LEFT',
					'conditions' => [
						'Category.id = Module.category_id'
					]
				]
			];
			$fields = [
				'Module.*',
				'Permission._read',
				'Category.name',
				'Category.class',
				'Category.key'
			];

			$modules = $Module->find('all', [
				'fields' => $fields,
				'joins' => $joins,
				'conditions' => [
					'Permission._read' => 1,
					'Module.parent_id' => null
				],
				'order' => [
					'Category.order ASC',
					'Module.order ASC'
				],
				'contain' => false
			]);
		}

		foreach ($modules as $key => $module) {
			$url = $module['Module']['url'];

			if (!isset($options[$module['Category']['key']])) {
				$options[$module['Category']['key']] = [
					'text' => $module['Category']['name'],
					'class' => $module['Category']['class'],
					'url' => '#',
					'submenu' => []
				];
			}

			if (empty($url)) {
				$url = str_replace('.', '/', $module['Module']['alias']);
			}

			$options[$module['Category']['key']]['submenu'][$module['Module']['key']] = [
				'text' => $module['Module']['name'],
				'url' => $url,
				'notifications' => false
			];
		}

		return $options;
	}

	public function passwordHasher() {
		if ($this->_passwordHasher) {
			return $this->_passwordHasher;
		}

		$config = [];
		$class = Configure::read('simian.auth.passwordHasher');
		$className = $class . 'PasswordHasher';
		App::uses($className, 'Controller/Component/Auth');

		$this->_passwordHasher = new $className($config);

		return $this->_passwordHasher;
	}
}
?>
