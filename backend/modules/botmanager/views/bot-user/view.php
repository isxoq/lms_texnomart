<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\botmanager\models\BotUser */
?>
<div class="bot-user-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'fio',
            'phone',
            'step',
            'temp_kurs_id',
        ],
    ]) ?>

</div>
