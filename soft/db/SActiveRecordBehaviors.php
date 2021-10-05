<?php

namespace soft\db;
use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class SActiveRecordBehaviors extends Behavior{



    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
        ];
    }

    public function beforeValidate($event)
    {
        // ...
    }


}