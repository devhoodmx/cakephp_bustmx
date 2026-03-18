<?php
/**
 * AppException handler
 *
 * Provides Exception Capturing for Framework exceptions.
 *
 */
App::uses('ErrorHandler', 'Error');

class AppExceptionHandler extends ErrorHandler {
	// PHP 5 and 7 compatible
	public static function handle($exception) {
		$exceptionClass = get_class($exception);

		self::handleException($exception);
	}
}
