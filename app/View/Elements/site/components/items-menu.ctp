<?php
$classCircleBtn = isset($classButton) ? 'img-fluid menu-circle' . ' ' . $classButton : "img-fluid menu-circle";
?>
<div class="wrapper-menu container" >

    <a class="modal-btn" type="button" data-toggle="modal" data-target="#menuModal"></a>

   
    <a href='/#inicio' class="menu-btn rounded-pill">BUST</a>

    <?php echo $this->Html->image('/img/site/icons/black-Star.svg', ['class' => 'img-fluid menu-star', 'id' => 'star-header']); ?>
</div>
