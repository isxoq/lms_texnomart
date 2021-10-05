<?php

use soft\helpers\SHtml;
use soft\grid\SKGridView;

/* @var $this backend\components\BackendView */
/* @var $searchModel backend\modules\frontendmanager\models\search\CourseSliderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kurs slayder';
$this->params['breadcrumbs'][] = $this->title;
?>



<?= \soft\adminty\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'pjax' => true,
    'toolbarTemplate' => '{create}{sort}{refresh}',
    'toolbarButtons' => [
        'sort' => [
            'icon' => 'sort,fas',
            'url' => ['sorting'],
            'outline' => \soft\widget\SButton::OUTLINE['success'],
            'title' => 'Saralash',
            'label' => 'Saralash',
            'pjax' => false,
        ]

    ],
    'cols' => [
        'course.title',
        'title',
        'icon',
        'text',
        'image',
        'status',
        'actionColumn',
    ],
]); ?>
