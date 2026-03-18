<?php
$opts = isset($params) ? $params : [];
$opts['message'] = $message;
$opts['type'] = 'danger';

echo $this->element('alert', $opts);
?>
