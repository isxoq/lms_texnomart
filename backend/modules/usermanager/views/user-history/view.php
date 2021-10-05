<?php


/* @var $this yii\web\View */
/* @var $model backend\modules\usermanager\models\UserHistory */
?>
<div class="user-history-view">
 
    <?=  \soft\adminty\DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user.fullname',
            'user.email',
            'user.phone',
            'url:ntext',
            'page_title:ntext',
            'prev_url:ntext',
            'date:datetime',
            'ip',
            'device:ntext',
            'deviceTypeName',
        ],
    ]) ?>

</div>
