<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 29.05.2021, 9:22
 */

use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $model \backend\modules\kursmanager\models\KursComment|\frontend\models\Kurs */


$ratings = $model->validRatings;
$query = $model->getActiveComments()
    ->latest()
    ->with(['replies' => function ($query) {
        return $query->with(['user' => function ($query) {
            return $query->select('id,firstname,lastname,avatar');
        }]);
    }])
    ->with(['user' => function ($query) {
        return $query->select('id,firstname,lastname,avatar');
    }])
    ->with('rating')
    ->asArray();

$dataProvider = new \yii\data\ActiveDataProvider([
    'query' => $query,
]);

$comments = $dataProvider->models;


?>
<div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="review-tab">

    <?php if (!empty($ratings)): ?>
        <?= $this->render('_ratings', ['ratings' => $ratings]) ?>
    <?php endif ?>

    <?php if (!empty($comments)): ?>
        <?= $this->render('_comments', ['comments' => $comments]) ?>
    <?php endif ?>

    <?php if (is_guest()): ?>

    <div class="cs_row_seven csv2">
        <div class="sfeedbacks">
            <div class="mbp_comment_form style2 pb0">
                <h4 class="text-muted"><i>Fikr bildirish uchun saytga kirishingiz kerak</i></h4>
                <a href="<?= to(['site/login', 'return_url' => Url::current()]) ?>" class="btn btn-primary" role="modal-remote"><?= t('Login to the site') ?></a>
            </div>
        </div>
    </div>

    <?php else: ?>
        <?= $this->render('_leave_comment', ['model' => $model]) ?>

    <?php endif ?>
</div>