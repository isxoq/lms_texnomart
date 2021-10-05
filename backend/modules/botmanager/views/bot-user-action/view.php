<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\botmanager\models\BotUserAction */
?>
<div class="bot-user-action-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'bot_user_id',
            'kurs_id',
        ],
    ]) ?>

</div>
