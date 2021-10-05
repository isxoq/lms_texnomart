<?php

use common\components\virtualdars\VideojsWidget;

/* @var $this frontend\components\FrontendView */
/* @var $lesson backend\modules\kursmanager\models\Lesson */
/* @var $nextIsOpen bool */

\frontend\assets\ToastrMinAsset::register($this);

$percent = Yii::$app->site->percentForCompleteLesson;

?>


<?= VideojsWidget::widget([
    'model' => $lesson,
    'registerEvents' => true,
    'currentTime' => $lesson->startTime
]);
?>





