<?php

/* @var $this \soft\web\SView */

use backend\modules\kursmanager\models\KursComment;
use backend\modules\usermanager\models\TeacherApplication;
use backend\modules\contactmanager\models\Contact;
use soft\adminty\Menu;

$newAppliesCount = TeacherApplication::newAppliesCount();
$newMessagesCount = Contact::newMessagesCount();
$newCommentsCount = KursComment::newCommentsCount();

$menuItems = [

    [
        'label' => 'Sozlamalar',
        'icon' => 'settings,feather',
        'items' => [
            ['label' => "Asosiy ma'lumotlar", 'url' => ['/settings/manager']],
            ['label' => 'OCTO UZ', 'url' => ['/octouz/setting/index']],
            ['label' => 'OCTO Transactions', 'url' => ['/octouz/octo-transactions/index']],
            ['label' => 'Menu', 'url' => ['/menumanager']],
            ['label' => 'Tarjimalar', 'url' => ['/translate-manager']],
            ['label' => 'SMS sozlamalari', 'url' => ['/smsmanager/default/settings']],
            ['label' => 'Bizning jamoa', 'url' => ['/team']],
            ['label' => 'Socials', 'url' => ['/socialmanager']],
            ['label' => 'Mijozlar fikri', 'url' => ['/testimonial']],
            ['label' => 'Hamkorlar', 'url' => ['/partner']],
            ['label' => 'Imkoniyatlar', 'url' => ['/frontendmanager/index-info']],
            ['label' => "Ta'lim darajalari", 'url' => ['/education-level']],
        ]
    ],

    [
        'label' => 'Kurslar',
        'icon' => 'book,feather',
        'items' => [
            ['label' => 'Kategoriyalar', 'url' => ['/categorymanager/category']],
            ['label' => 'Kurslar', 'url' => ['/kursmanager/kurs']],
            ['label' => "A'zoliklar", 'url' => ['/kursmanager/enroll']],
            ['label' => 'Kurs slayder', 'url' => ['/frontendmanager/course-slider']],
            ['label' => 'Kurs help blok', 'url' => ['/frontendmanager/course-feature']],
        ]
    ],
    ['label' => 'Kurs comments', 'url' => ['/kursmanager/kurs-comment'], 'badgeLabel' => $newCommentsCount, 'badgeClass' => 'danger', 'icon' => 'message-circle,feather'],

    [
        'label' => 'Billing',
        'icon' => 'book,feather',
        'items' => [
            ['label' => 'Sotib olishlar', 'url' => ['/billing/purchases/index']],
            [
                'label' => "Offline to'lovlar",
                'icon' => 'book,feather',
                'items' => [
                    ['label' => "Ro'yhat", 'url' => ['/billing/offline-payments/index']],
                    ['label' => "Yangi qo'shish", 'url' => ['/billing/offline-payments/create']],
                ]
            ],
            [
                'label' => "O'qituvchi to'lovlari",
                'icon' => 'book,feather',
                'items' => [
                    ['label' => "Ro'yhat", 'url' => ['/billing/payouts/index']],
                    ['label' => "Yangi qo'shish", 'url' => ['/billing/payouts/create']],
                ]
            ],
        ]
    ],


    ['label' => 'Sahifalar', 'icon' => 'list,feather', 'url' => ['/pagemanager']],

    [
        'label' => 'Bizning blog',
        'icon' => 'edit,feather',
        'items' => [
            ['label' => 'Maqola kategoriyalari', 'url' => ['/postmanager/post-category']],
            ['label' => 'Maqolalar', 'url' => ['/postmanager/post']],
        ]
    ],

    [
        'label' => 'Arizalar',
        'icon' => 'edit,feather',
        'url' => ['/usermanager/teacher-application'],
        'badgeLabel' => $newAppliesCount,
        'badgeClass' => 'danger',
    ],

    ['label' => 'Foydalanuvchilar', 'icon' => 'user,feather', 'url' => ['/usermanager/user']],
    ['label' => 'Foyd. tarixi', 'icon' => 'users,feather', 'url' => ['/usermanager/user-history']],

    [
        'label' => 'FAQ',
        'icon' => 'help-circle,feather',
        'items' => [
            ['label' => 'FAQ kategoriyalari', 'url' => ['/faqmanager/faq-category']],
            ['label' => 'FAQ savollar', 'url' => ['/faqmanager/faq']],
        ]
    ],


    ['label' => 'Buyurtmalar', 'icon' => 'edit,feather', 'url' => ['/ordermanager/order']],
    ['label' => 'Fikrlar', 'icon' => 'message-circle,feather', 'url' => ['/contactmanager'], 'badgeLabel' => $newMessagesCount,],
//    ['label' => 'Gii', 'icon' => 'grid,feather', 'url' => ['/gii']],


    [
        'label' => "Advanced Custom Fields",
        'icon' => 'acquisitions-incorporated,fab',
        'items' => [
            ['label' => "ACF Category", 'url' => ['/acf/field-type']],
            ['label' => "ACF fields", 'url' => ['/acf/field']],
        ]
    ],
    [
        'label' => 'Bot',
        'icon' => 'settings,feather',
        'items' => [
            ['label' => "Ro'yhatdan o'tganlar", 'url' => ['/botmanager/bot-user']],
            ['label' => 'Xabar yuborish', 'url' => ['/botmanager/bot-user/send']],
            ['label' => 'Zakazlar', 'url' => ['/botmanager/bot-user-action']],

        ]
    ],


    ['label' => 'Clear cache', 'icon' => 'umbrella,feather', 'url' => ['/site/cache-flush']],

];


?>
<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigatio-lavel">Profile menu</div>
        <?= Menu::widget([
            'items' => $menuItems
        ]); ?>
    </div>
</nav>
