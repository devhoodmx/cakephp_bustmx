<?php

App::uses('ModelBehavior', 'Model');
App::uses('CakeTime', 'Utility');

class DateBehavior extends ModelBehavior {

	protected $_defaults = array(
		'format' => '%d/%m/%Y'
	);

	protected $dateComponents = array(
		'month' => 'm',
		'year' => 'Y',
		'day' => 'd',
		'hour' => 'H',
		'minute' => 'i',

	);

	public function setup(Model $Model, $config = array()) {
		foreach ($config as $field => $configuration) {
			$settings[$field] = array_merge($this->_defaults, $configuration);
		}

		$this->settings[$Model->alias] = $settings;
	}

	public function beforeSave(Model $Model, $options = array()) {
		$config = Configure::read();
		$config = $config['App'];

		foreach ($this->settings[$Model->alias] as $field => $settings) {
			if (isset($Model->data[$Model->alias][$field]) && (!empty($Model->data[$Model->alias][$field]) || empty($settings['empty']))) {
				$unformattedDate = $this->_parseDateFromFormat($Model->data[$Model->alias][$field], $settings['format']);
				$Model->data[$Model->alias][$field] = CakeTime::toServer(
					$unformattedDate,
					new DateTimeZone($config['timezone'])
				);
				$fieldSufix = explode('_', $field);
				$fieldPrefix = str_replace('_' . $fieldSufix[sizeof($fieldSufix) - 1], '', $field);
				$timeStamp = strtotime($Model->data[$Model->alias][$field]);

				foreach ($this->dateComponents as $component => $format) {
					$Model->data[$Model->alias][$fieldPrefix . '_' . $component] = empty($Model->data[$Model->alias][$fieldPrefix . '_' . $component]) ? date($format, $timeStamp) : $Model->data[$Model->alias][$fieldPrefix . '_' . $component];
				}
			}
		}

		return true;
	}

	protected function _parseDateFromFormat($field, $format) {
		$date = date_parse_from_format(str_replace('%', '', $format), $field);

		if (!empty($date)) {
			return mktime(
				$date['hour'], 
				$date['minute'], 
				$date['second'], 
				$date['month'], 
				$date['day'], 
				$date['year']
			);
		}
	}

	public function transformDate(Model $Model, $field, $format, $newFormat = 'Y-m-d H:i:s') {
		return date($newFormat, $this->_parseDateFromFormat($field, $format));
	}

	public function afterFind(Model $Model, $results, $primary = FALSE) {
		$config = Configure::read();
		$config = $config['App'];

		foreach ($results as $key => $result) {
			if (!empty($result[$Model->alias])) {
				foreach ($this->settings[$Model->alias] as $field => $configuration) {
					if (isset($result[$Model->alias][$field])) {
						$dateValue = CakeTime::convert(strtotime($result[$Model->alias][$field]), new DateTimeZone($config['timezone']));
						$fieldSufix = explode('_', $field);
						$fieldPrefix = str_replace('_' . $fieldSufix[sizeof($fieldSufix) - 1], '', $field);
						$dateFormat = str_replace('%', '', $configuration['format']);
						$results[$key][$Model->alias][$field] = date($dateFormat, $dateValue);
						$results[$key][$Model->alias][$field . '_format'] = $dateFormat;
						$results[$key][$Model->alias][$field . '_php_format'] = $configuration['format'];
					}
				}
			}
		}

		return $results;
	}

	public function formatContainData($Model, $data) {
		$config = Configure::read();
		$config = $config['App'];

		$data = !empty($data[$Model->alias]) ? $data[$Model->alias] : $data;

		foreach ($data as $key => $result) {
			foreach ($this->settings[$Model->alias] as $field => $configuration) {
				if (isset($result[$field])) {
					$dateValue = CakeTime::convert(strtotime($result[$field]), new DateTimeZone($config['timezone']));
					$fieldSufix = explode('_', $field);
					$fieldPrefix = str_replace('_' . $fieldSufix[sizeof($fieldSufix) - 1], '', $field);
					$dateFormat = str_replace('%', '', $configuration['format']);
					$data[$key][$field] = date($dateFormat, $dateValue);
					$data[$key][$field . '_format'] = $dateFormat;
					$data[$key][$field . '_php_format'] = $configuration['format'];
				}
			}
		}

		return $data;
	}

	public function getDateConfig(Model $Model) {
		foreach ($this->settings[$Model->alias] as $key => $configuration) {
			$fields[$Model->alias][$key . '_format'] = empty($configuration['format']) ? $this->_defaults['format'] : $configuration['format'];
			$fields[$Model->alias][$key . '_format'] = str_replace('%', '', $fields[$Model->alias][$key . '_format']);
		}

		return $fields;
	}
}
