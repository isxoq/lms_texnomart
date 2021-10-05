<?php

/* @var $this \yii\web\View */

$menuItems = [
    ['label' => 'Kurs boshqaruvchisi', 'icon' => 'list', 'url' => ['/teacher/kurs']],
    ['label' => 'Gii', 'icon' => 'grid', 'url' => ['/gii']],
];


?>
<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigatio-lavel">Navigation</div>
        <ul class="pcoded-item pcoded-left-item">

            <li class="">
                <a href="<?= to(['/teacher/kurs']) ?>">
                    <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                    <span class="pcoded-mtext">Kurs boshqaruvchisi</span>
                </a>
            </li>

        </ul>

    </div>
</nav>