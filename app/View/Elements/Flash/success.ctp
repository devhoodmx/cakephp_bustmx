<?php
$opts = isset($params) ? $params : [];
$opts['message'] = $message;
$opts['type'] = 'success';

echo $this->element('alert', $opts);
?>
