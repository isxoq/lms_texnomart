<?php


/* @var $this \soft\web\SView */

/* @var $model backend\modules\kursmanager\models\KursComment */

use soft\adminty\GridView;

$kurs = $model->kurs;

$this->title = 'Comment №' . $model->id;

$this->params['breadcrumbs'][] = ['label' => 'Kurs boshqaruvchisi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $kurs->title, 'url' => ['/teacher/kurs/view', 'id' => $kurs->id]];
$this->params['breadcrumbs'][] = ['label' => 'Fikrlar', 'url' => ['/teacher/kurs/comments', 'id' => $kurs->id]];
$this->params['breadcrumbs'][] = $this->title;


\yii\web\YiiAsset::register($this);
$this->registerAjaxCrudAssets();

$dataProvider = new \yii\data\ActiveDataProvider([

    'query' => $model->getReplies()
])

?>

<?= \soft\adminty\DetailView::widget([
    'model' => $model,
    'toolbar' => false,
    'attributes' => [
        'user.fullname',
        'kurs.title',
        'text:ntext',
        'created_at:datetime',
        'updated_at:datetime',
    ],
]) ?>

<h4 style="display: block; margin-bottom: 0; font-weight: 600; color: #303548; font-size: 20px; text-transform: capitalize;">
    Javoblar
</h4>
<br>
<?= GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,

    'toolbarButtons' => [
        'create' => [
            'modal' => true,
            'url' => to(['create-reply', 'id' => $model->id]),
        ]
    ],

    'cols' => [
        [
            'label' => 'Javob matni',
            'attribute' => 'text',
            'width' => '50%'
        ],
        [
            'attribute' => 'user.fullname',
            'label' => 'Javob beruvchi',
        ],

        [

            'attribute' => 'created_at',
            'format' => 'datetime',
        ],
        [

            'attribute' => 'updated_at',
            'format' => 'datetime',
        ],

        'actionColumn' => [
            'template' => '{update} {delete}',
            'updateOptions' => [
                'role' => 'modal-remote'
            ],
        ]
    ],
]); ?>
