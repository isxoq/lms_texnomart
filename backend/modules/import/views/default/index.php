<?php

use yii\helpers\Html;
use soft\helpers\SHtml;
$this->title = 'Import';
/* @var $this \yii\web\View */
?>

<p>
    <?= a(SHtml::withBadge("Import users",  \common\models\User::find()->count() ), ['import-user'], ['class' => 'btn btn-success'], 'user') ?>
    <?= a(SHtml::withBadge("Import courses",  \backend\modules\kursmanager\models\Kurs::find()->count() ), ['import-course'], ['class' => 'btn btn-info'], 'list') ?>
    <?= a(SHtml::withBadge("Import sections",  \backend\modules\kursmanager\models\Section::find()->count() ), ['import-section'], ['class' => 'btn btn-warning'], 'edit') ?>
    <?= a(SHtml::withBadge("Import lessons",  \backend\modules\kursmanager\models\Lesson::find()->count() ), ['import-lesson'], ['class' => 'btn btn-primary'], 'edit') ?>
    <?= a(SHtml::withBadge("Import enrolls",  \backend\modules\kursmanager\models\Enroll::find()->count() ), ['import-enroll'], ['class' => 'btn btn-danger'], 'users') ?>
</p>

<p>
    <?= a("Open lessons" , ['open-lessons'], ['class' => 'btn btn-danger'], 'list') ?>

    <?= a("Update enroll counts", ['update-kurs-enrolls-count'], ['class' => 'btn btn-primary'], 'list-ol,fas') ?>
</p>

<p>
    <?= a("Normalize sections", ['normalize-sections'], ['class' => 'btn btn-primary'], 'list-ol,fas') ?>
    <?= a("Normalize lessons", ['normalize-lessons'], ['class' => 'btn btn-primary'], 'list-ol,fas') ?>
</p>

<p>
    <?= a("Delete all learned lessons", ['delete-learned-lessons'], ['class' => 'btn btn-danger'], 'trash-alt,fas') ?>
</p>




