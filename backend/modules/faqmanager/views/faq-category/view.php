<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\faqmanager\models\FaqCategory */
?>
<div class="faq-category-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'sort',
            'status',
        ],
    ]) ?>

</div>
