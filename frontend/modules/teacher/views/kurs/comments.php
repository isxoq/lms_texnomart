<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 06.05.2021, 14:06
 */

use backend\modules\kursmanager\models\KursComment;
use yii\widgets\Pjax;

/* @var $this \yii\web\View */
/* @var $model \frontend\modules\teacher\models\Kurs|null */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $searchModel \backend\modules\kursmanager\models\search\KursCommentSearch */


$this->title = $model->title;

$this->params['breadcrumbs'][] = ['label' => 'Kurs boshqaruvchisi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Fikrlar';
?>


<?php Pjax::begin(['id' => 'kurs-view-pjax']) ?>

<?= $this->render('_kursMenu', ['model' => $model]); ?>

<?= \soft\adminty\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'panel' => [
        'heading' => $model->title,
    ],
    'bulkButtons' => false,
    'toolbarTemplate' => "{refresh}",
    'cols' => [

        [
            'attribute' => 'text',
            'format' => 'raw',
            'value' => function ($model) {
                /** @var KursComment $model */
                return a($model->text, ['kurs-comment/view', 'id' => $model->id], ['data-pjax' => 0, 'class' => 'text-primary']);
            },
        ],

        [
            'label' => 'Foydalanuvchi',
            'format' => 'raw',
            'value' => function ($model) {
                /** @var KursComment $model */
                return $model->user->fullname;
            }
        ],

        [
            'label' => 'Foyd.<br>bahosi',
            'encodeLabel' => false,
            'attribute' => 'userRating',
        ],
        [
            'label' => "Javob.<br>soni",
            'encodeLabel' => false,
            'attribute' => 'repliesCount',
            'width' => '5%'
        ],
        [
            'attribute' => 'created_at',
            'format' => 'datetime',
            'width' => '12%',
            'filter' => false,
        ],
        'actionColumn' => [
            'controller' => 'kurs-comment',
            'template' => '{view}{reply}',
            'buttons' => [
                'reply' => function ($url, $model) {
                    return a('Javob yozish', ['kurs-comment/create-reply', 'id' => $model->id], ['class' => 'dropdown-item', 'role' => 'modal-remote'], 'reply,fas');
                }
            ]
        ]
    ],
]); ?>

<?php Pjax::end() ?>
