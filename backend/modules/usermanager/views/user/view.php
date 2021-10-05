<?php

use soft\helpers\SHtml;
use soft\kartik\SDetailView;
use soft\widget\SButton;
use yii\widgets\Pjax;

/* @var $this backend\components\BackendView */
/* @var $model backend\modules\usermanager\models\User */

$this->title = $model->fullname;
$this->params['breadcrumbs'][] = ['label' => "Foydalanuvchilar", 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?php Pjax::begin(['id' => 'user_view'])  ?>
<?= $this->render('_userMenu', ['model' => $model]) ?>

<?= \soft\adminty\DetailView::widget([
    'model' => $model,
    'toolbar' => [
      'template' => "{enroll}{update}{delete}",
      'buttons' => [
          'enroll' => [
              'label' => "A'zo qilish",
              'url' => ['/billing/offline-payments/create', 'user_id' => $model->id],
              'style' => '',
              'outline' => SButton::OUTLINE['primary'],
              'icon' => 'user-plus,fas',
              'title' => "Kursga a'zo qilish",
          ]
      ]
    ],
    'attributes' => [
        'firstname',
        'lastname',
        'phone',
        'email:email',
        'typeName',
        'age',
        'bio:raw',
        'address',
        'educationLevelName',
        'position',
        'genderName:raw:Jinsi',
        'statusLabel:raw:Status',
        'percentageLabel:raw',
        'avatar:littleImage:Rasm',
        'created_at',
        'updated_at',


    ],
]) ?>


<?php Pjax::end()  ?>