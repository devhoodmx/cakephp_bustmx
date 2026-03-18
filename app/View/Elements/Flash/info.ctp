<?php
$opts = isset($params) ? $params : [];
$opts['message'] = $message;
$opts['type'] = 'info';

echo $this->element('alert', $opts);
?>
