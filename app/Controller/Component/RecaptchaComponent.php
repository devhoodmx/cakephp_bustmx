<?php
class RecaptchaComponent extends Component {
/**
 * Holds last error code
 *
 * @var array
 * @access protected
 */
	protected $_error = null;

/**
 * Returns true if the answer solves the reCAPTCHA challenge
 *
 * @param string $remoteIp The user's IP address, in the format 192.168.0.1
 * @param string $challenge The value of the form field recaptcha_challenge_field
 * @param string $response The value of the form field recaptcha_response_field
 * @param string $apiKey reCAPTCHA private API Key
 * @return boolean Success
 */
	public function checkAnswer($remoteIp, $response, $apiKey = null) {
		if ($apiKey === null) {
			$apiKey = Configure::read('App.services.recaptcha.private-key');
		}
		$reCaptcha = new \ReCaptcha\ReCaptcha($apiKey);

		$response = $reCaptcha->verify($response, $remoteIp);
		if (!$response->isSuccess()) {
			$this->_error = $response->getErrorCodes();
		}
		return $response->isSuccess();
	}
/**
 * Get last error from RecaptchaComponent::checkAnswer
 *
 * @return string Error code
 * @access public
 */
	public function error() {
		return $this->_error;
	}
}
?>
