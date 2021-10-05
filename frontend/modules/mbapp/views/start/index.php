<?php



/* @var $this \yii\web\View */
/* @var $data array */
/* @var $response array */

dd($response);

foreach ($data['sections'] as $section){
    echo count($section->activeLessons) . BR;
}

?>