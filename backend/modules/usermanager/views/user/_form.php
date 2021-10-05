<?php

use backend\models\EducationLevel;
use common\models\User;
use soft\kartik\SActiveForm;
use soft\form\SForm;
use yii\helpers\ArrayHelper;


/* @var $this backend\components\BackendView */
/* @var $model backend\modules\usermanager\models\User */
/* @var $form soft\kartik\SActiveForm */

?>

<?php $form = SActiveForm::begin(); ?>


<?= SForm::widget([

    'form' => $form,
    'model' => $model,
    'columns' => 2,
    'attributes' => [
        'firstname',
        'lastname',
        'phone' => [
            'hint' => "Telefon raqamni to'liq kiriting. Masalan: 998911234567"
        ],
        'email',
        'password' => [
            'options' => [
                'type' => 'text'
            ],
            'label' => $model->isNewRecord ? 'Parolni kiriting' : 'Yangi parol',
            'hint' => $model->isNewRecord ? '' : "Agar bo'sh qoldirsangiz parol o'zgarmaydi",
        ],
        'type:dropdownList' => [
            'items' => User::types()
        ],
        'revenue_percentage' => [
            'visible' => $model->isTeacher,
        ],
        'status:dropdownList' => [
          'items' => [
              User::STATUS_ACTIVE => "Faol",
              User::STATUS_INACTIVE => "Nofaol",
          ]
        ],
    ]

]) ?>

<?= \soft\helpers\SHtml::submitButton() ?>

<?php SActiveForm::end() ?>

