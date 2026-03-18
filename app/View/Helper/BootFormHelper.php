<?php
App::uses('FormHelper', 'View/Helper');
class BootFormHelper extends FormHelper {
	private $sizes = array('mini', 'small', 'medium', 'large', 'xlarge', 'xxlarge');
	public $helpers = array('Package', 'Html');

	public function create($model = null, $options = array()) {

		$options['class'] = empty($options['class']) ? '' : $options['class'];

		if (!empty($options['horizontal'])) {
			$options['class'] .= ' form-horizontal';
		}
		unset($options['horizontal']);

		if (empty($options['role'])) {
			$options['role'] = 'form';
		}

		$this->loadPackage('vendor.chosen.chosen-jquery', 'vendor', 'js');
		$this->loadPackage('component.chosen', 'component', 'js');

		if (!isset($options['async']) || $options['async'] !== FALSE) {
			$this->loadPackage('vendor.jquery-form.form', 'view', 'js');
			$this->loadPackage('widget.form', 'view', 'js');

			$options['data-async'] = TRUE;
		}

		$options['novalidate'] = isset($options['novalidate']) ? $options['novalidate'] : true;

		unset($options['async']);


		return parent::create($model, $options);
	}

	private function loadPackage($name = '', $set = '', $type= '') {
		$packages = $this->Package->fetch($set, $type);

		if (
			empty($packages) ||
			!in_array($name, $packages)
		) {
			$this->Package->append($set, $type, array($name));
		}
	}

	public function input($fieldName, $options = array()) {
		$this->setEntity($fieldName);
		$options = $this->_parseOptions($options);
		$this->options = $options;
		unset($options['div']);
		$beforeContent = '';
		$afterContent = '';


		//Removes Unnecesary Stuff when the input is checkbox or radio button
		if (
			(!empty($options['type']) && in_array($options['type'], array('radio', 'checkbox'))) ||
			(!empty($options['multiple']) && $options['multiple'] == 'checkbox')
		) {
			unset($options['prepend']);
			unset($options['append']);
			unset($options['size']);
		}

		//When is append or prepend adds necesary markup for before and after
		if (isset($options['prepend']) || isset($options['append'])) {
			$beforeContent = "<div class='input-group'>";
			$afterContent = '</div>';
		}

		//Adds Markup on before and after to align the checkboxes when multiple
		if (!empty($options['multiple']) && $options['multiple'] === 'checkbox') {
			$beforeContent = '<div>';
			$afterContent = '</div>';
		}

		$options['before'] = empty($options['before']) ?  $beforeContent : ($options['before'] . $beforeContent);
		$options['after'] = empty($options['after']) ?  $afterContent : ($afterContent . $options['after']);

		// $options = $this->_inputAddOn($options);
		$options = $this->_setHint($options);

		if (!empty($options['type'])) {
			// Prepares the calendar and size when input is 'type' => 'date'
			if ($options['type'] == 'date') {
				$options = $this->_sizeInput($options, '3');
				$options = $this->_setCalendar($options);
			} else if (in_array($options['type'], array('radio', 'checkbox'))) {

				//Parses the legend (title of the input) on radio and checkboxes
				if (!isset($options['legend']) || $options['legend'] !== FALSE) {

					if (isset($options['legend']) && is_array($options['legend'])) {
						$legend = empty($options['legend']['text']) ? __(Inflector::humanize($this->field())) : $options['legend']['text'];
						$legendClass = empty($options['legend']['class']) ? '' : $options['legend']['class'];
					} else {
						$legend = empty($options['legend']) ? __(Inflector::humanize($this->field())) : $options['legend'];
						$legendClass = '';
					}

					$modelKey = Inflector::underscore($this->model());
					$legendKey = empty($legend) ? Inflector::slug($this->field(), '-') : $legend;
					$legend = Utility::translate($legendKey, $modelKey, 'fields');

					$options['after'] = empty($options['after']) ? '</div>' : '</div>' . $options['after'];
					$options['before'] = '<div>' . $options['before'];
					$options['before'] = $this->label($fieldName, $legend, array('for' => $this->field() .'-legend', 'class' => 'control-label ' . $legendClass)) . $options['before'];
					$options['legend'] = FALSE;
				}

			} else if ($options['type'] == 'select') {
				if (!isset($options['data-component'])) {
					// Add chosen component to options when type is select, whether
					// is single or multiple
					$options['data-component'] = 'chosen';
				}

				if ($options['data-component'] === 'chosen') {
					if (empty($options['multiple'])) {
						if (
							isset($options['empty']) &&
							(
								$options['empty'] === true ||
								(is_string($options['empty']) && trim($options['empty']) === '')
							)
						) {
							$options['empty'] = __d('error', 'in-list');
						}
					} elseif ($options['multiple'] !== 'checkbox') {
						if (empty($options['data-placeholder'])) {
							$options['data-placeholder'] = __d('error', 'in-list');
						}
					}
				}
			} else if (in_array($options['type'], array('editor', 'ckeditor'))) {
				$validOpts = array('config', 'language');

				$options['type'] = 'textarea';
				$options['data-component'] = 'editor';

				foreach ($validOpts as $opt) {
					if (isset($options[$opt])) {
						$options['data-' . $opt] = $options[$opt];
						unset($options[$opt]);
					}
				}
			}
		}

		if (!empty($options['prepend'])) {
			$options['before'] .= $this->_getAddOn($options['prepend'], 'left');
			unset($options['prepend']);
		}

		if (!empty($options['append'])) {
			$options['after'] = $this->_getAddOn($options['append']) . $options['after'];
			unset($options['append']);
		}

		// When multiple checkbox, parses the label, then returns parent::select instead of parent::input
		if (isset($options['multiple']) && $options['multiple'] == 'checkbox') {
			$selectOptions = $options['options'];
			unset($options['options']);
			$beforeOptions = !empty($options['before']) ? $options['before'] : '';
			$afterOptions = !empty($options['after']) ? $options['after'] : '';
			unset($options['before'], $options['after']);

			// Label
			$label = '';
			$labelText = null;
			$labelOptions = [];

			if (!isset($options['label']) || $options['label'] !== false) {
				if (!empty($options['label'])) {
					$labelText = $options['label'];

					if (is_array($options['label'])) {
						$labelText = !empty($options['label']['text']) ? $options['label']['text'] : null;
						$labelOptions = $options['label'];

						unset($labelOptions['text']);
					}
				}

				$labelOptions['class'] = 'control-label' . (!empty($labelOptions['class']) ? ' ' . $labelOptions['class'] : '');
				$label = $this->label($fieldName, $labelText, $labelOptions);
			}

			unset($options['label']);

			// Return Hack because using parent::select its not possible to recreate Bootstrap 3.0 markup
			return '<div class="input multiple-checkbox form-group">' .
						$label .
						$beforeOptions .
						parent::select($fieldName, $selectOptions, $options) .
						$afterOptions .
					'</div>';
		}

		$options['class'] = empty($options['class']) ? 'form-control' : $options['class'] . ' form-control';
		return parent::input($fieldName, $options);
	}

	public function submit($caption = null, $options = array()) {

		if (!isset($options['div']) || $options['div'] !== FALSE) {
			if (empty($options['div'])){
				$options['div'] = 'submit form-group';
			} else {
				$options['div'] = is_string($options['div']) ? ($options['div'] . ' submit controls') : (empty($options['div']['class']) ? 'submit controls' : ($options['div']['class'] . ' submit controls'));
			}
		}

		$options['class'] = empty($options['class']) ? 'btn' : ($options['class'] . ' btn');

		if (!empty($options['buttonType'])) {
			$options['class'] .= ' btn-' . $options['buttonType'];
			unset($options['buttonType']);
		}

		return parent::submit($caption, $options);
	}

	public function label($fieldName = NULL, $text = NULL, $options = array()) {
		if (
			((empty($this->options['multiple']) || $this->options['multiple'] !== 'checkbox') &&
			(empty($this->options['type']) || !in_array($this->options['type'], array('checkbox', 'radio')))) ||
			(!empty($this->options['multiple']) && !empty($options['for']) && $options['for'] == $this->field())
		) {
			if (empty($options)){
				$options['class'] = 'control-label';
			} else {
				$options['class'] = is_string($options) ? ($options . ' control-label') : (empty($options['class']) ? 'control-label' : ($options['class'] . ' control-label'));
			}
		}

		$modelKey = Inflector::underscore($this->model());
		$labelKey = empty($text) ? Inflector::slug($this->field(), '-') : $text;
		$text = Utility::translate($labelKey, $modelKey, 'fields');

		return parent::label($fieldName, $text, $options);
	}

	public function hint($options) {
		$hintAttributes = array(
			'escape' => false,
			'data-toggle' => 'popover',
			'data-content' => is_string($options['hint']) ? $options['hint'] : (empty($options['hint']['message']) ? ' ' : $options['hint']['message']),
			'class' => 'toggle-popover help-inline'
		);

		if (is_array($options['hint'])) {
			if (!empty($options['hint']['title'])) {
				$hintAttributes['title'] = $options['hint']['title'];
				$hintAttributes['data-original-title'] = $options['hint']['title'];
			}

			if (!empty($options['hint']['placement'])) {
				$hintAttributes['data-placement'] = $options['hint']['placement'];
			}
		}

		$hint = $this->Html->link(
			'<i class="fas fa-question-circle"></i>',
			'#',
			$hintAttributes
		);

		return $hint;
	}

	protected function _divOptions($options) {
		$divOptions = parent::_divOptions($options);

		if (!empty($divOptions)) {
			$divOptions = $this->addClass($divOptions, 'form-group');
		}

		if (!empty($options['type']) && $options['type'] == 'password') {
			$divOptions = $this->addClass($divOptions, 'text');
		}

		if (!empty($this->options['div']) && is_string($this->options['div'])) {
			$divOptions = $this->addClass($divOptions, $this->options['div']);
		} else if (!empty($this->options['div']['class'])) {
			$divOptions = $this->addClass($divOptions, $this->options['div']['class']);
		}

		return $divOptions;
	}

	protected function _sizeInput($options, $default = '12') {
		$selectSize = empty($options['size']) ? $default : $options['size'];
		$beforeText = sprintf('<div class= "row"><div class="col-sm-%s">', $selectSize);
		$afterText = '</div></div>';
		$options['before'] = empty($options['before']) ? $beforeText : $options['before'] . $beforeText;
		$options['after'] = empty($options['after']) ? $afterText : $afterText . $options['after'];

		unset($options['size']);

		return $options;
	}

	protected function _setHint($options) {
		if (!empty($options['hint']) && (is_string($options['hint']) || !empty($options['hint']['message']))) {
			$hint = $this->hint($options);
			$options['after'] = empty($options['after']) ? $hint : ($hint . $options['after']);
		}

		unset($options['hint']);

		return $options;

	}

	protected function _setCalendar($options) {
		$attributes = array();

		$phpFormat = empty($options['format']) ? 'd/m/Y' : $options['format'];
		$language = empty($options['language']) ? 'en' : $options['language'];

		$format = str_replace(
			array('d', 'j', 'm', 'n', 'y', 'Y'),
			array('dd', 'd', 'mm', 'm', 'yy', 'yyyy'),
			$phpFormat
		);

		$minViewMode = 'years';
		$viewMode = 'years';

		$startDate = !empty($options['startDate']) ? $options['startDate'] : null;
		$endDate = !empty($options['endDate']) ? $options['endDate'] : null;
		$calendarWeeks = !empty($options['calendarWeeks']) ? $options['calendarWeeks'] : null;

		if (in_array('d', str_split($format))) {
			$minViewMode = 'days';
			$viewMode = empty($options['mode']) || !in_array($options['mode'], array('month', 'year', 'decade')) ? 'month' : $options['mode'];
		} else if (in_array('m', str_split($format))) {
			$minViewMode = 'months';
			$viewMode = empty($options['mode']) || !in_array($options['mode'], array('year', 'decade')) ? 'year' : $options['mode'];
		}

		if (!empty($options['disabled'])) {
			$attributes[] = "class='form-control'";
		} else {
			$attributes[] = "class='input-group date bootstrap-datepicker-component'";
			$attributes[] = "data-component='bootstrap-datepicker'";
			$attributes[] = "data-date-start-date='" . $startDate . "'";
			$attributes[] = "data-date-end-date='" . $endDate . "'";
			$attributes[] = "data-date-format='" . $format . "'";
			$attributes[] = "data-date-start-view='" . $viewMode . "'";
			$attributes[] = "data-date-min-view-mode='" . $minViewMode . "'";
			$attributes[] = "data-date-language='" . $language . "'";
			$attributes[] = "data-date-calendar-weeks='" . $calendarWeeks . "'";
		}

		$calendarDiv = "<div " . implode($attributes, ' ')  . ">";
		$calendarButton = (!isset($options['icon']) || !empty($icon) ? $this->_getAddOn("<i class='far fa-calendar-alt'></i>", true) : '') . "</div>";

		$options['before'] = empty($options['before']) ? $calendarDiv : ($options['before'] . $calendarDiv);
		$options['after'] = empty($options['after']) ? $calendarButton : ($calendarButton . $options['after']);

		$options['type'] = 'text';
		$options['readOnly'] = 'readOnly';
		unset($options['date']);
		unset($options['format']);
		unset($options['mode']);
		unset($options['language']);

		return $options;
	}

	protected function _getAddOn($html, $calendar = FALSE) {
		$calendarClass =  $calendar ? "" : "";
		return "<span class='input-group-addon" . $calendarClass . "'>" . $html . "</span>";
	}

	protected function _getFormat($options) {
		if ($options['type'] === 'hidden') {
			return array('input');
		}
		if (is_array($options['format']) && in_array('input', $options['format'])) {
			return $options['format'];
		}
		if ($options['type'] === 'checkbox') {
			return array('before', 'input', 'between', 'label', 'after', 'error');
		}
		return array('label', 'before', 'between', 'input', 'after', 'error');
	}
}
