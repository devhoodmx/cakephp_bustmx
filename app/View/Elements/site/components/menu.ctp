<?php
$urlHome = Router::url(['controller' => 'pages', 'action' => 'home']);
$urlProductos = Router::url(['controller' => 'pages', 'action' => 'projects']);
$urlAbout = Router::url(['controller' => 'pages', 'action' => 'about']);
$urlContact = Router::url(['controller' => 'pages', 'action' => 'contact']);

?>
<?php
$pageLocation = $this->params['action'];

?>
<!-- section menu footer -->
<div class="container">
    <div class="menu-page d-flex flex-column justify-content-center align-items-center">
        <a href="<?= $urlHome ?>" class="h2 menu-page__title home text-uppercase <?= ($pageLocation == 'home') ? 'active-spand-letter' : ''?>">H<span class="spand-letter">o</span>me</a>
        <a href="<?= $urlAbout ?>" class="h2 menu-page__title home text-uppercase <?= ($pageLocation == 'about') ? 'active-spand-letter' : ''?>">Nos<span class="spand-letter">o</span>tros</a>
        <a href="<?= $urlProductos ?>" class="h2 menu-page__title home text-uppercase <?= ($pageLocation == 'projects' || $pageLocation == 'project') ? 'active-spand-letter' : ''?>">PORTAF<span class="spand-letter">o</span>LIO</a>
        <a href="<?= $urlContact ?>" class="h2 menu-page__title home text-uppercase <?= ($pageLocation == 'contact') ? 'active-spand-letter' : ''?>" data-tab="pills-contact">C<span class="spand-letter">o</span>ntacto</a>
    </div>
</div>

