<?php
class PackageHelper extends AppHelper {
/**
 * Append resources
 *
 * @constant APPEND
 */
	const APPEND = 'append';

/**
 * Prepend resources
 *
 * @constant PREPEND
 */
	const PREPEND = 'prepend';
/**
 * Prepend resources
 *
 * @constant PREPEND
 */
	public static $PATHS = array('src', 'build');
/**
 * Resources sets
 * 
 * @var array
 */
	protected $_sets = array(
		'js' => array(),
		'css' => array()
	);
/**
 * Helpers
 * 
 * @var array
 */
	public $helpers = array('Html', 'Javascript');
/**
 * Constructor
 * 
 * @param type View $View 
 * @param array $settings 
 * @return void
 */
	public function __construct(View $View, $settings = array()) {
		parent::__construct($View, $settings);
		
		$this->_config = Configure::read('App.assets');
		$this->_options = array('compressed' => false, 'cached' => true, 'inline' => true, 'expand' => false);
	}
/**
 * Returns a link to the CSS packager.
 * 
 * @param array	$resources 	File names formatted using notation folder.subfolder.file-name. 
 * 							Ex. File core/administration.css should be written 
 * 							core.administration  
 * @param boolean $compressed	If compressed is set to true, find resources in build folder,
 * 								otherwise find in src
 * @param  boolean $inline If set to false, the generated tag appears in the head tag of the layout.
 * @return string CSS link
 */		
	public function css($resources, $options = array()) {
		$out = '';
		$debug = Configure::read('debug');
		$resources = $this->combine($resources, 'css');
		$options = array_merge($this->_options, $options);
		$type = self::$PATHS[$options['compressed']];

		if ($debug === 0) {
			$options['expand'] = false;
		} elseif ($debug === 2) {
			$options['expand'] = true;
		}
		
		if ($options['expand']) {
			foreach ($resources as $resource) {
				$out .= $this->Html->css('/css/' . $type . '/' . str_replace('.', '/', $resource), array('inline' => $options['inline']));
			}	
		} else {
			$out = $this->Html->css($this->buildURL($resources, 'css', $options['compressed'], $options['cached']), array('inline' => $options['inline']));
		}
		
		return $out;
	}
/**
 * Returns a JavaScript include tag (SCRIPT element) with a link to the JS packager.
 * 
 * @param array	$resources 	File names formatted using notation folder.subfolder.file-name. 
 * 							Ex. File lib/scriptaculous/scriptaculous.js should be written 
 * 							lib.scriptaculous.scriptaculous  
 * @param boolean $compressed	If compressed is set to true, find resources in build folder,
 * 								otherwise find in src
 * @param  boolean $inline If true, the <script /> tag will be printed inline,
 *                         otherwise it will be printed in the <head />, using $scripts_for_layout
 * @return string JavaScript link 
 */	
	public function js($resources, $options = array()) {
		$out = '';
		$debug = Configure::read('debug');
		$resources = $this->combine($resources, 'js');
		$options = array_merge($this->_options, $options);
		$type = self::$PATHS[$options['compressed']];

		if ($debug === 0) {
			$options['expand'] = false;
		} elseif ($debug === 2) {
			$options['expand'] = true;
		}
		
		if ($options['expand']) {
			foreach ($resources as $resource) {
				$out .= $this->Html->script('/js/' . $type . '/' . str_replace('.', '/', $resource), array('inline' => $options['inline']));
			}	
		} else {
			$out = $this->Html->script($this->buildURL($resources, 'js', $options['compressed'], $options['cached']), array('inline' => $options['inline']));
		}
		
		return $out;
	}
/**
 * Returns well formed package URL
 * 
 * @param array $resources See PackageHelper::js() or PackageHelper::css()
 * @param string $type	Package type. Valid types are: js and css
 * @param boolean $compressed See PackageHelper::js() or PackageHelper::css()
 * @return string URL
 */
	public function buildURL($resources, $type = 'js', $compressed = false, $cached = true) {
		$url  = '/' . $type . '.php?';
		$url .= 'resources=' . implode(',', $resources) . '&';
		$url .= 'compressed=' . (integer)$compressed . '&';
		$url .= 'cache=' . (integer)$cached . '&';
		$url .= 'v=' . $this->_config[$type]['version'];

		return $url;
	}

	public function assign($name = '', $type = '', $resources = array()) {
		$this->add($name, $type, $resources);
	}

	public function prepend($name = '', $type = '', $resources = array()) {
		$this->add($name, $type, $resources, self::PREPEND);
	}

	public function append($name = '', $type = '', $resources = array()) {
		$this->add($name, $type, $resources, self::APPEND);
	}

	public function combine($name = '', $type = '') {
		$mix = array();
		$resources = is_string($name) ? $this->fetch($name, $type) : $name;

		if (is_array($resources)) {
			foreach ($resources as $resource) {
				if (preg_match("/^\[([^\]]+)\]$/", $resource, $matches)) {
					$mix = array_merge($mix, $this->combine($matches[1], $type));
				} else {
					$mix[] = $resource;
				}
			}
		}

		return $mix;
	}

	public function fetch($name = '', $type = '') {
		if (isset($this->_sets[$type][$name])) {
			return $this->_sets[$type][$name];
		}

		return null;
	}

	protected function add($name = '', $type = '', $resources = array(), $mode = null) {
		if (!empty($name) && isset($this->_sets[$type]) && is_array($resources)) {
			if (!is_string($name)) {
				throw new CakeException('$name must be a string.');
			}

			$items = $this->filter($resources);
			if (isset($this->_sets[$type][$name])) {
				if ($mode == self::PREPEND) {
					$this->_sets[$type][$name] = array_merge($items, $this->_sets[$type][$name]);
				} elseif ($mode == self::APPEND) {
					$this->_sets[$type][$name] = array_merge($this->_sets[$type][$name], $items);
				}
			} else {
				$this->_sets[$type][$name] = $items;
			}
		}
	}

	protected function filter($resources = array()) {
		$items = array();

		foreach ($resources as $resource) {
			if (is_string($resource)) {
				$items[] = $resource;
			}
		}

		return $items;
	}
}
?>