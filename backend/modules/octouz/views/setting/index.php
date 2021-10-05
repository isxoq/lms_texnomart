<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
?>
<h1><?= Yii::t('app', 'OCTOUZ SETTINGS') ?></h1>

<?php

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'shop_id',              
        'secret',              
        'test:status',              
        'auto_capture:status',              
        'return_url',              
        'notify_url',              
        'ttl',              
        'currency',
        'status:status',
    ],
]);

?>
<?= yii\helpers\Html::a('Update', ['/octouz/setting/update'], ['class' => 'btn btn-primary']) ?>
