<?php

use yii\helpers\Html;
/* @var $this frontend\components\FrontendView */
/* @var $enroll backend\modules\kursmanager\models\Enroll */
/* @var $kurs backend\modules\kursmanager\models\Kurs */

$kurs = $this->params['kurs'];
$lessons = $kurs->activeLessons;

echo Html::ul($lessons, [
    'item' => function($item){
        return Html::tag('li', $item->section->title ." - ".$item->title);
    }
]);

?>


