<?php

namespace backend\modules\kursmanager\behaviors;

use backend\modules\kursmanager\models\Enroll;
use yii\db\ActiveRecord;

/**
 * Kurs modeli uchun Behavior
 * @property Enroll $owner
 */
class EnrollBehavior extends \yii\base\Behavior
{

    public function events()
    {
        return [
          ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
        ];
    }



    public function beforeInsert()
    {
        $kurs = $this->owner->kurs;
        if ( $kurs != null ){
            $kurs->incEnrollsCount();
        }
    }

}