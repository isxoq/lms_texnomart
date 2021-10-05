<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

use kartik\select2\Select2;
use common\models\User;
use soft\helpers\SHtml;
use yii\helpers\Url;

/* @var $this \yii\web\View */

$this->title = "Boshqa foydalanuvchi nomidan kirish";

$type = $this->request->get('type');

$all = $type == 'all';

$query =  User::find();
if (!$all){
    $query = $query->where(['type' => User::TYPE_TEACHER]);
}
$data =  map($query->asArray()->all(), 'id', function($model){

    return $model['firstname'] .' '.$model['lastname'] ." (".$model['email']." ,  ".$model['phone'] .")";

});

?>

<div class="bg_color_1">
    <div class="container margin_120_95">
        <div class="row justify-content-between">

            <div class="col-lg-6">
                <h4>
                    Boshqa foydalanuvchi nomidan kirish
                    <p class="text-info">
                        <?php if ($all): ?>
                            Barcha foydalanuvchilar ro'yxati <br>
                        <?php else: ?>
                            O'qituvchilar ro'yxati <br>

                        <?php endif ?>
                    </p>
                </h4>
                <?= SHtml::beginForm() ?>

                <?= Select2::widget([
                    'name' => 'user_id',
                    'data' => $data,
                ]) ?>
                <br>

                <p>
                    <?= SHtml::submitButton('Kirish') ?>
                </p>

                <?= SHtml::endForm() ?>


                <p>
                    <?php if ($all): ?>
                        <a class="btn btn-info" href="<?= Url::current(['type' => null]) ?>">Faqat o'qituvchilar ro'yxatini chiqarish</a>
                    <?php else: ?>
                        <a class="btn btn-info" href="<?= Url::current(['type' => 'all']) ?>">Barcha foydalanuvchilar ro'yxatini chiqarish</a>
                    <?php endif ?>
                </p>

            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>