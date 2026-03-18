<?php

$this->Package->assign('view', 'css', array(
	'view.pages.thanks',
));


// Page properties
$this->assign('title', $config['App']['configurations']['website-title']);
// $this->assign('pageDescription', '');
$this->assign('navItemKey', 'home');
?>
<div class="thanks-section">
    <div class="container vh-100 w-100 d-flex justify-content-center align-items-center">
       <div class="wrapper-title">
            <div class="h1 text-uppercase title">Muchas <strong>gracias</strong> p<span class="letter-spinning-star">o</span>r contactarn<span class="letter-circle">o</span>s</div>
            <div class="text-uppercase subtitle font-29">En unos momentos <strong> nos pondremos en contacto contigo.</strong></div>
       </div>
    </div>
</div>
<?php
App::uses('Debugger', 'Utility');
?>