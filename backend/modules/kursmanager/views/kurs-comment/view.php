<?php


/* @var $this \soft\web\SView */

/* @var $model backend\modules\kursmanager\models\KursComment */

use soft\adminty\GridView;

$this->title = 'Comment №' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Kurs Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$this->registerAjaxCrudAssets();

$dataProvider = new \yii\data\ActiveDataProvider([

    'query' => $model->getReplies()
])

?>

<?= \soft\adminty\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'user.fullname',
        'kurs.title',
        'text:ntext',
        'created_at:datetime',
        'updated_at:datetime',
        'status:status',
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
            'url' => to(['reply', 'id' => $model->id]),
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
            'updateOptions' => [
                'role' => 'modal-remote'
            ],
        ]
    ],
]); ?>
