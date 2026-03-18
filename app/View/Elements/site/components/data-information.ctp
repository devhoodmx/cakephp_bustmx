<div class="container-data-information">
    <div class="item-nav">
    <div class="item-nav__text item-nav__bold"> www.bust.mx</div>
    </div>
    <div class="item-nav">
        <?php
        echo $this->element('components/phone', [
            'id' => 'contact-phone',
            'class' => 'item-nav__text',
            'icon' => false,
            'title' => $config['App']['configurations']['contact-phone']
        ]);
        ?>
        <div class="item-nav__text item-nav__bold">Marketing Digital</div>
    </div>
</div>
