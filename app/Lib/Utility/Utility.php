<?php
class Utility {
	function translate($key, $library = NULL, $secondarylLibrary = NULL, $args = NULL) {
		if (!empty($args) && !is_array($args)) {
			$args = array_slice(func_get_args(), 3);
		}

		if (!empty($library)) {
			$translation = __d($library, $key, $args);
		}

		if (empty($library) || $translation == $key) {
			if (empty($secondarylLibrary)) {
				$translation = __($key, $args);
			} else {
				$translation = __d($secondarylLibrary, $key, $args);
			}
		}

		return $translation;
	}

	function config($module, $path = NULL) {
		try {
			$reader = new PhpReader(APP . 'Config' . DS . 'Module' . DS);
			$config = $reader->read($module);
		} catch (Exception $e) {}

		if (empty($config)) {
			return NULL;
		} else if ($path !== NULL) {
			$config = Hash::get($config, $path);
		}

		return $config;
	}

	function redirect($redirect, $modelData = null) {
		if (!empty($redirect['redirect'])) {
			$CakeRequest = new CakeRequest();
			$redirect['?']['redirectURL'] = $CakeRequest->here();
			unset($redirect['redirect']);
		} else if (isset($redirect['redirect'])) {
			unset($redirect['redirect']);
		}

		if (!empty($redirect['params']) && !empty($modelData)) {
			foreach ($redirect['params'] as $redirectParam) {
				$redirectParam = Hash::get($modelData, $redirectParam);
				$redirect[] = is_string($redirectParam) ? Utility::slug($redirectParam) : $redirectParam;
			}
			unset($redirect['params']);
		}

		if (!empty($redirect['query']) && !empty($modelData)) {
			foreach ($redirect['query'] as $param => $redirectParam) {
				$redirectParam = Hash::get($modelData, $redirectParam);
				$redirect['?'][$param] = $redirectParam;
			}
			unset($redirect['query']);
		}

		return $redirect;
	}

	function slug($string = null) {
		return Inflector::slug(Inflector::underscore(mb_strtolower($string)), '-');
	}

	function isProsimian() {
		return Utility::is('prosimian');
	}

	public static function is($roles = array()) {
		$valid = false;
		$userRole = CakeSession::read('Auth.User.Role.key');

		if (is_string($roles)) {
			$roles = array($roles);
		}

		return in_array($userRole, $roles);
	}

	function isDark($hex) {
  		$hex = str_replace('#', '', $hex);
  		$c_r = hexdec(substr($hex, 0, 2));
  		$c_g = hexdec(substr($hex, 2, 2));
  		$c_b = hexdec(substr($hex, 4, 2));

  		return ((($c_r * 299) + ($c_g * 587) + ($c_b * 114)) / 1000) < 130 ? true : false;
	}
}
?>
