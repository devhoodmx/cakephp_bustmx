<?php
class Video extends AppModel {
	var $name = 'Video';
	var $useTable = 'default_videos';
	var $actsAs = array(
		'Containable'
	);

	var $validate = array(
		'url' => array(
			'notBlank' => array(
				'rule' 		=> 'notBlank'
			),
			'url' => array(
				'rule' => array('url', true)
			)
		)
	);

	public function beforeSave($options = []) {
		if (!empty($this->data['Video']['url'])) {
			$this->data['Video']['url'] = trim($this->data['Video']['url']);
		}
	}

	public function afterFind($results, $primary = false) {
		if (!$primary) {
			if (!empty($results['id'])) {
				foreach ($results as $key => $value) {

					if ($key == 'url') {

						if (strpos($value, 'youtube.com') !== false) {
							$params = explode('&', parse_url($value, PHP_URL_QUERY));
							$results['service'] = 'youtube';

							if (!empty($params)) {
								foreach ($params as $param) {
									if (preg_match('/^v=/', $param)) {
										$results['key'] = str_replace('v=', '', $param);
									}
								}
							}
						}

						if (strpos($value, 'vimeo.com') !== false) {
							$params = explode('/', parse_url($value, PHP_URL_PATH));
							$results['service'] = 'vimeo';

							if (!empty($params[1])) {
								$results['key'] = $params[1];
							}
						}

						if (strpos($value, 'facebook.com') !== false) {
							$results['service'] = 'facebook';
						}
					}
				}
			}
		}

		return $results;
	}
}
?>
