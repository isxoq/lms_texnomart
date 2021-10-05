
<?php
    $this->title = "Sms manager";



?>
<div class="smsmanager-default-index">
    <h1><?= $this->title ?></h1>
   <p>
       <?= \yii\helpers\Html::a(Yii::t('app','Settings'), ['settings'], ['class' => 'btn btn-info']) ?>
   </p>
</div>
