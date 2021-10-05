<?php

use soft\helpers\SHtml;
use backend\modules\usermanager\models\User;

/* @var $this backend\components\BackendView */
/* @var $searchModel backend\modules\usermanager\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Foydalanuvchilar";
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
?>

    <?= \soft\adminty\GridView::widget([
        'id' => 'crud-datatable',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'bulkButtonsTemplate' => "{delete}",
        'cols' => [
            'checkboxColumn',
            [
                'attribute' => 'image',
                'filter' => false,
                'format' => ['littleImage', '50px']
            ],
            [
                'attribute' => 'firstnameOrLastname',
                'format' => 'raw',
                'label' => "FIO",
                'value' => function($model){
                    /** @var User $model */
                    $label = $model->firstname ."<br>".$model->lastname;
                    return a($label, ['user/view', 'id' => $model->id], ['class' => 'text-primary', 'data-pjax' => 0]);
                }

            ],
            [
                'attribute' => 'phoneOrEmail',
                'format' => 'raw',
                'label' => "Contact",
                'width' => '250px',
                'value' => function($model){

                    /** @var User $model */
                    $phone = empty($model->phone) ? '' : SHtml::withIcon($model->phone, 'phone-alt') ."<br>";
                    $email = empty($model->email) ? '' : SHtml::withIcon($model->email, 'envelope,far');

                    return tag('small', $phone.$email, ['class' => 'text-muted']);
                }

            ],
            [

                'label' => "Kurs",
                'format' => 'raw',

                'width' => '100px',
                'value' => function($model){

                    /** @var User $model */
                    $coursesCount = intval($model->getCourses()->count());
                    $enrollsCount = intval($model->getEnrolls()->count());
                    return tag('small', "Kurslar: ".$coursesCount ."<br>"."A'zoliklar: ".$enrollsCount);

                }


],
            [
                'attribute' => 'type',
                'label' => "Foy. roli",
                'format' => 'raw',
                'filter' => User::types(),
                'value' => function ($model) {

                    /** @var User $model */

                    $message = $model->isTeacher ? "Ushbu foydalanuvchidan o'qituvchilikni bekor qilishni xoxlaysizmi?" : "Ushbu foydalanuvchini o'qituvchi qilib  tayinlashni xoxlaysizmi?";
                    $class = $model->isTeacher ? 'text-danger' : 'text-primary';
                    return a($model->typeName, ['change-type', 'id' => $model->id], [
                        'role' => 'modal-remote',
                        'class' => $class,
                        'data' => [
                            'pjax' => 0,
                            'toggle' => 'tooltip',
                            'method' => false,
                            'confirm' => false,
                            'request-method' => 'post',
                            'confirm-title' => $model->fullname,
                            'confirm-message' => $message,
                        ],
                    ]);
                },
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {

                    /** @var User $model */

                    if ($model->id == $this->user->identity->id) {
                        return SHtml::tag('span', t('You'), ['class' => 'badge badge-warning']);
                    }

                    $message = $model->status == User::STATUS_ACTIVE ? "Nofaol holatga o'tkazishni xoxlaysizmi?" : "Faollashitirishni xoxlaysizmi?";
                    $message = "Ushbu foydalanuvchini " . $message;
                    return a($model->statusLabel, ['change-status', 'id' => $model->id], [
                        'role' => 'modal-remote',
                        'data' => [
                            'pjax' => 0,
                            'toggle' => 'tooltip',
                            'method' => false,
                            'confirm' => false,
                            'request-method' => 'post',
                            'confirm-title' => $model->fullname,
                            'confirm-message' => $message,
                        ],
                    ]);
                },
                'format' => 'raw',
                'filter' => [
                    9 => t('Inactive'),
                    10 => t('Active'),
                ],

            ],

            'created_at' => [
                'width' => '120px'
            ],

            'actionColumn' => [
                'template' => "{view}{update}{enroll}{delete}",
                'buttons' => [
                    'enroll' => function ($url, $model, $key) {
                        return a("Kursga a'zo qilish", ['/billing/offline-payments/create', 'user_id' => $key], ['class' => 'dropdown-item', 'data-pjax' => 0], 'user-plus,fas');
                    },


                ]
            ],
        ],
    ]); ?>
