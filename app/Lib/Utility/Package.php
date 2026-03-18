<?php
App::uses('File', 'Utility');

class Package {
/**
 * Cache expiration time in seconds
 *
 * @constant CACHE_EXPIRATION
 */
	const CACHE_EXPIRATION = 5184000; // 2 months
/**
 * Accepted MIME media types
 *
 * @var array
 */
	private $mimeTypes = array(
		'js' => 'application/javascript',
		'css' => 'text/css'
	);
/**
 * Constructor
 *
 * @param array	$resources 	File names formatted using notation folder.subfolder.file-name. 
 * 							Ex. File lib/scriptaculous/scriptaculous.js should be written 
 * 							lib.scriptaculous.scriptaculous  
 * @param string $type	Package type. Valid types are: js and css
 * @param boolean $compressed	If compressed is set to true, find resources in build folder,
 * 								otherwise find in src
 * @param boolean $cached	Read content from cache if $cached is set to true  
 */	
	public function __construct($resources = null, $type = 'js', $compressed = false, $cached = true) {
		$this->output = '';
		$this->resources = is_array($resources) ? array_unique($resources) : array();
		$this->type = isset($this->mimeTypes[strtolower($type)]) ? strtolower($type) : 'js';
		$this->compressed = $compressed;
		$this->cached = $cached;
		$this->version = $compressed ? 'build' : 'src';

		// Construct cache file
		$basePath = CACHE . $this->type . DS;
		$filePath = $basePath . $this->version . DS . implode('-', $this->resources) . '.' . $this->type;
		$this->file = new File($filePath);

		if (!$this->isCached() || !$this->cached) {
			$this->create();
		}
		
		// Read content from cache only if output has not been assigned on create method 		
		if (empty($this->output) && $this->file->exists()) {
			$this->output = $this->file->read();
		}
	}
/**
 * Returns true if the package is cached.
 *
 * @return boolean True if package is cached
 */	
	public function isCached() {		
		return $this->file->exists();
	}
/**
 * Creates package by grouping the resources in a file. It saves the result on disk 
 * only if all resources exists
 *
 * @return True on success
 */	
	private function create() {
		$content = '';
		$allFilesExist = true;		
		$basePath = constant(strtoupper($this->type)) . $this->version . DS;

		foreach ($this->resources as $resource) {			
			$filePath = $basePath . str_replace('.', '/', $resource) . '.' . $this->type;
			$file = new File($filePath);			
			
			if ($file->exists()) {
				$content .= $file->read() . "\n";
			} else {
				$allFilesExist = false;
			}
		}

		if (!empty($content)) {
			//Caches only when all the files exist and cache is activated
			if ($allFilesExist && $this->cached) {
				if ($this->file->create()) {
					$content = $this->file->prepare($content);			
					
					//Saves the cache on disk
					$this->file->write($content);				
				}				
			}
			
			$this->output = $content;
			return true;
		}
		
		return false;
	}
/**
 * Render the package
 *
 * @return string Output
 */	
	public function render() {			
		header("Date: " . date("D, j M Y G:i:s ", $this->file->lastChange()) . 'GMT');
		header("Content-Type: " . $this->mimeTypes[$this->type]);
		header("Expires: " . gmdate("D, j M Y H:i:s", time() + self::CACHE_EXPIRATION) . " GMT");
		header("Cache-Control: public,max-age=" . self::CACHE_EXPIRATION);
		
		print($this->output);
	}
/**
 * Returns the package as a string
 *
 * @return string Output
 */	
	public function toString() {		
		return $this->output;
	}
}
?>