<?php

use backend\modules\usermanager\models\UserHistory;
use soft\helpers\SHtml;

/* @var $this backend\components\BackendView */
/* @var $searchModel backend\modules\usermanager\models\search\UserHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Histories';
$this->params['breadcrumbs'][] = $this->title;

$this->registerAjaxCrudAssets();

?>

<?= \soft\adminty\GridView::widget([

    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'bulkButtonsTemplate' => '{delete}',
    'cols' => [

        'checkboxColumn',

        [
            'attribute' => 'userFullname',
            'value' => function ($model) {
                return tag('small', $model->user->fullname);
            },
            'format' => 'raw',
        ],

        [
            'attribute' => 'phoneOrEmail',
            'format' => 'raw',
            'label' => "Contact",
            'width' => '200px',
            'value' => function ($model) {

                /** @var UserHistory $model */

                $user = $model->user;

                if (!$user) {
                    return null;
                }

                $phone = empty($user->phone) ? '' : SHtml::withIcon($user->phone, 'phone-alt') . "<br>";
                $email = empty($user->email) ? '' : SHtml::withIcon($user->email, 'envelope,far');

                return tag('small', $phone . $email, ['class' => 'text-muted']);
            }

        ],

        [
            'attribute' => 'date',
            'format' => 'small',
            'width' => '130px',
            'value' => function($model){
                /** @var UserHistory $model */
                return $model->formattedDate;
            }
        ],
        [
            'attribute' => 'ip',
            'format' => 'small',
            'width' => '100px',
        ],
        [
            'attribute' => 'url',
            'width' => '150px',
            'format' => 'raw',
            'value' => function ($model) {
                /** @var UserHistory $model */
                $label = $model->page_title ?? $model->url;
                return a($label, $model->url, ['data-pjax' => 0, 'target' => '_blank']);
            }
        ],
        [
            'attribute' => 'device_type',
            'width' => '50px',
            'format'=> 'small',
            'value' => function ($model) {
                /** @var UserHistory $model */
                return $model->deviceTypeName;
            },
            'filter' => UserHistory::deviceTypes(),
        ],

        [
            'attribute' => 'device',
            'width' => '200px',
            'format' => 'small'
        ],

        'actionColumn' => [
            'viewOptions' => [
                'role' => 'modal-remote'
            ],
            'updateOptions' => [
                'role' => 'modal-remote'
            ],
        ],


    ],

]) ?>

