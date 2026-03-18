<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.View.Emails.html
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
?>

<div>
    <h1>Tienes un nuevo mensaje de cotización</h1>
    <br />
    <br />
    <label>
        <strong>Nombre:&nbsp;</strong> <span><?= $data['Quote']['name'] ?></span>
    </label>
    <br>
    <label>
        <strong>Correo electrónico:&nbsp;</strong> <span><?= $data['Quote']['email'] ?></span>
    </label>
    <br>
    <label>
        <strong>Número telefónico:&nbsp;</strong> <span><?= $data['Quote']['phone'] ?></span>
    </label>
    <br>
    <label>
        <strong>Presupuesto:&nbsp;</strong> <span><?= $data['Quote']['budget'] ?></span>
    </label>
    <br>
    <label>
        <strong>Mensaje:&nbsp;</strong>
        <p><?= $data['Quote']['message'] ?></p>
    </label>
</div>