<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 07.06.2021, 10:34
 */

/* @var $this \frontend\components\FrontendView */
/* @var $dataProvider \yii\data\ActiveDataProvider */
$this->title = t('Teachers');
$this->params['breadcrumbs'][] = $this->title;

?>


<section class="our-team pb40">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <?php if (false): // must do teachers search ?>
                    <div class="row">
                        <div class="col-sm-5 col-lg-5 col-xl-6">
                            <div class="instructor_search_result">
                                <p class="mt10 fz15"><span class="color-dark">85</span> Instructors</p>
                            </div>
                        </div>
                        <div class="col-sm-7 col-lg-7 col-xl-6">
                            <div class="candidate_revew_search_box mb30 float-right fn-520">
                                <form class="form-inline my-2 my-lg-0">
                                    <input class="form-control mr-sm-2" type="search"
                                           placeholder="Search our instructors"
                                           aria-label="Search">
                                    <button class="btn my-2 my-sm-0" type="submit"><span
                                                class="flaticon-magnifying-glass"></span></button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endif ?>

                <div class="row">
                    <?php foreach ($dataProvider->models as $model): ?>
                        <?php
                        /** @var \common\models\User $model */
                        $coursesCount = $model->getCourses()->active()->count();
                        ?>

                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="team_member style3 text-center mb30">
                                <a href="<?= to(['instructor/single', 'id' => $model->id]) ?>">
                                    <div class="instructor_col">
                                        <div class="thumb">
                                            <img class="img-fluid img-rounded-circle" src="<?= $model->image ?>"
                                                 alt="user image" style="border-radius: 100%">
                                        </div>
                                        <div class="details">
                                            <h4><?= e($model->fullname) ?></h4>
                                            <p>
                                                <?= e($model->findOrCreateTeacherInfo()->skill) ?>
                                            </p>

                                        </div>
                                    </div>
                                </a>
                                <div class="">
                                    <ul>
                                        <li class="list-inline-item">
                                            <a href="#">
                                                Kurslar soni: <?= $coursesCount ?>
                                            </a>
                                        </li>
                                        <br>
                                        <li class="list-inline-item">
                                            <a href="#">
                                                Talabalar
                                                soni: <?= intval($model->getCourses()->sum('enrolls_count')) ?>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>


                    <?php endforeach; ?>
                    <div class="col-lg-12">
                        <div class="mbp_pagination">
                            <?= \frontend\components\edumy\LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
