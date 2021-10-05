<?php

use soft\widget\SButton;
/* @var $this frontend\components\frontendView */
/* @var $model frontend\modules\profile\models\PersonalDataForm */

$this->title = t('Personal cabinet');
//$this->params['breadcrumbs'][] = ['label' => "Profile", 'url' => '/profile'];
$this->params['breadcrumbs'][] = $this->title;

$phoneButtonLabel = user()->hasPhone ? "Tel. raqamni o'zg." : "Tel. raqamni kiritish";
$phoneButtonTitle = user()->hasPhone ? "Telefon raqamni o'zgartirish" : "Telefon raqamni kiritish";

Yii::$app->formatter->nullDisplay = '';

?>

<?= \soft\adminty\DetailView::widget([
    'model' => $model,

    'toolbar' => [
        'template' => "{update}{change-phone}{change-password}",
        'buttons' => [
            'update' => [
                'label' => 'Tahrirlash',
                'title' => "Shaxsiy ma'lumotlarni tahrirlash",
                'url' => '/profile/cabinet/update',
            ],
            'change-password' => [
                'icon' => 'key',
                'url' => '/profile/cabinet/change-password',
                'style' => '',
                'outline' => SButton::OUTLINE['danger'],
                'label' => "Parolni o'zgartirish",
                'title' => "Parolni o'zgartirish",
            ],
            'change-phone' => [
                'icon' => 'phone',
                'url' => '/profile/cabinet/enter-phone-number',
                'style' => '',
                'outline' => SButton::OUTLINE['info'],
                'label' => $phoneButtonLabel,
                'title' => $phoneButtonTitle,
            ]
        ]
    ],
    'attributes' => [
        'lastname',
        'firstname',
        'phone:raw:Telefon raqam',
        'email:email',
        'position',
        'age',
        'genderName:raw:Jins',
        'educationLevelName',
        'address',
        'bio:raw',
        'image:littleImage'
    ]
]); ?>

