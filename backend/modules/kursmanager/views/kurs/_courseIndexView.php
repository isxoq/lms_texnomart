<?php

/** @var frontend\modules\teacher\models\Kurs $model */

?>


<div class="card">

    <div class="card-body">

        <div class="row">
            <div class="col-md-4">
                <img width="100%" src="<?= $model->kursImage ?>" alt="" class="thumbnail">
            </div>
            <div class="col-md-8">
                <table class="table  table-hover">
                    <tbody>
                    <tr>
                        <th>Kurs nomi</th>
                        <td><?= e($model->title) ?></td>
                    </tr>

                    <tr>
                        <th>Kategoriya</th>
                        <td><label for="" class="badge badge-default"><?= e($model->category->title) ?></label></td>
                    </tr>

                    <tr>
                        <th>Dars va bo'lim</th>
                        <td class="text-muted">

                            <b>Jami bo'limlar: </b> <?= $model->getSections()->count() ?>;
                            (<b>Faol bo'limlar: </b> <?= $model->getActiveSections()->count() ?>)
                            <br>
                            <b>Jami mavzular: </b> <?= $model->getLessons()->count() ?>;
                            (<b>Faol mavzular: </b> <?= $model->getActiveLessons()->count() ?>)

                        </td>

                    </tr>
                    <tr>
                        <th>
                            Videolar
                        </th>
                        <td class="text-muted">
                            <b>Videolar soni: </b> <?= $model->videosCount ?> <br>
                            <b>Davomiyligi: </b> <?= $model->formattedVideosDuration ?>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>