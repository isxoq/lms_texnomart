<?php

/* @var $this \yii\web\View */

use common\models\User;
use soft\adminty\Menu;

$menuItems = [
    ['label' => 'Mening kurslarim', 'icon' => 'book,feather', 'url' => ['/profile/default/my-courses']],
    ['label' => 'Barcha kurslar', 'icon' => 'list,feather', 'url' => ['/course/all']],
    ['label' => 'Sertifikatlar', 'icon' => 'file,feather',  'url' => ['/profile/certificate/index'] ],
    ['label' => 'Shaxsiy profil', 'icon' => 'user,feather', 'url' => ['/profile/cabinet'], ],
//    ['label' => "O'qituvchi bo'lish", 'icon' => 'edit,feather', 'url' => ['/site/become-teacher'], 'visible' => user('isSimpleUser') ],

];


?>
<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
        <?php if (user('type') == User::TYPE_TEACHER): ?>
            <div class="pcoded-navigatio-lavel">O'qituvchi menyusi</div>
            <?= Menu::widget([
                'items' => [
                    ['label' => 'Asosiy sahifa', 'icon' => 'edit,feather', 'url' => ['/teacher/default/info']],
                    ['label' => 'Kurs boshqaruvchisi', 'icon' => 'edit,feather', 'url' => ['/teacher/kurs/index']],
                ]
            ]); ?>
        <?php endif ?>
        <div class="pcoded-navigatio-lavel">Profile menu</div>
        <?= Menu::widget([
            'items' => $menuItems
        ]); ?>
    </div>
</nav>