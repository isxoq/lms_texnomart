<?php


namespace frontend\modules\mbapp\models;


class Lesson extends \frontend\modules\teacher\models\Lesson
{

    public function fields()
    {
        return [

            'title',
            'description',
            'sort',
            'formattedDuration',
            'type',
            'is_open',
            'openStreamSrc' => function($model){
                /** @var Lesson $model */
                return $model->is_open ? $model->media_stream_src : null;
            }

        ];
    }

}