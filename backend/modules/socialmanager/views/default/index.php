<?php

use soft\helpers\SHtml;
use soft\grid\SKGridView;

$this->title = t('Socials');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="social-index">


    <?= \soft\adminty\GridView::widget([
        'dataProvider' => $dataProvider,
        'panel' => [
            'after' => false,
        ],
        'cols' => [
            'name',
            'iconField:raw',
            'url:url',
            'status',
            'actionColumn' => [
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>
</div>
